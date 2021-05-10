<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_Customize_Control')) {
	return;
}

if (class_exists('ThemeFarmer_Field_Repeater')) {
	return;
}

class ThemeFarmer_Field_Repeater extends WP_Customize_Control {

	public $type            = 'themefarmer-repeater';
	public $fields          = array();
	public $max_items      	= 999;
	public $default         = array();
	public $row_label       = '';
	private $icon_container = '';
	public $pro_link = '';

	/**
	 * Class constructor
	 */
	public function __construct($manager, $id, $args = array()) {
		parent::__construct($manager, $id, $args);
		$theme = wp_get_theme();
		$theme_slug = $theme->get('Name');
		$this->pro_link = THEMEFARMER_COMPANION_PRO_LINK;
		$this->icon_container = trailingslashit(THEMEFARMER_FIELDS_DIR) . 'repeater/inc/icons.php';
	}

	public function enqueue() {
		wp_enqueue_style('font-awesome', THEMEFARMER_FIELDS_URI . 'repeater/css/font-awesome.min.css');
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style('themefarmer-iconpicker', THEMEFARMER_FIELDS_URI . 'repeater/css/themefarmer-iconpicker.css');
		wp_enqueue_style('themefarmer-repeater', THEMEFARMER_FIELDS_URI . 'repeater/css/themefarmer-repeater.css');

		wp_enqueue_script('themefarmer-iconpicker', THEMEFARMER_FIELDS_URI . 'repeater/js/themefarmer-iconpicker.js', array('jquery'), null, true);
		wp_enqueue_script('themefarmer-field-repeater', THEMEFARMER_FIELDS_URI . 'repeater/js/themefarmer-field-repeater.js', array('jquery', 'jquery-ui-sortable', 'jquery-ui-draggable', 'wp-color-picker'), null, true);
	}

	public function json() {
		$json = parent::json();
		$json['max_items'] = $this->max_items;
		$json['row_label'] = $this->row_label;
		$json['pro_link'] = $this->pro_link;
		return $json;
	}

	public function render_content() {
		if (empty($this->fields)) {
			return;
		}

		$fields  = $this->fields;
		$default = $this->default;
		$values  = $this->value();
		$fields  = $this->fields;
		if (empty($values)) {
			$values = $default;
		}

		?>

		<?php if (!empty($this->label)): ?>
			<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
		<?php endif;?>

		<?php if (!empty($this->description)): ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php endif;?>
		<ul class="themefarmer-repeater-copy" style="display: none !important;">
			<li class="themefarmer-repeater-item-copy">
				<div class="themefarmer-repeater-contaier">
					<div class="repeater-head">
						<i class="dashicons dashicons-menu"></i>
						<label class="repeater-label"><span class="lable"><?php echo esc_html($this->row_label); ?></span> <span class="index"></span> </label>
						<i class="dashicons dashicons-arrow-right"></i>
					</div>
					<div class="repeater-body">
						<?php foreach ($fields as $key => $field): ?>
						<div class="repeater-element">
							<?php if (isset($field['label'])): ?>
							<label><?php echo esc_html($field['label']); ?></label>
							<?php endif;?>
							<?php $this->get_field($field, $key);?>
							<?php if(isset($field['description'])): ?>
								<span class="description"><?php echo esc_html($field['description']); ?></span>
							<?php endif; ?>
						</div>
						<?php endforeach;?>
						<button type="button" class="tf-remove-button themefarmer-repeater-remove-item"><?php esc_html_e('Remove Field', 'themefarmer-companion');?></button>
					</div>
				</div>
			</li>
		</ul>
		<ul class="themefarmer-repeater">
			<?php $i = 1;?>
			<input class="themefarmer-repeater-data" id="themefarmer-shortable-data-<?php echo esc_attr($this->id); ?>" type="hidden"  value <?php $this->link();?>>
			<?php if ($values): foreach ($values as $key => $value): ?>
					<li class="themefarmer-repeater-item">
						<div class="themefarmer-repeater-contaier">
							<div class="repeater-head">
								<i class="dashicons dashicons-menu"></i>
								<label class="repeater-label"><span class="lable"><?php echo esc_html($this->row_label); ?></span> <span class="index"><?php echo esc_html($i); ?></span> </label>
								<i class="dashicons dashicons-arrow-right"></i>
							</div>
							<div class="repeater-body">
								<?php foreach ($fields as $key => $field): ?>
								<div class="repeater-element">
									<?php if (isset($field['label'])): ?>
									<label><?php echo esc_html($field['label']); ?></label>
									<?php endif;?>
									<?php
										$field_value = isset($value[$key]) ? $value[$key] : '';
										$this->get_field($field, $key, $field_value);
									?>
									<?php if(isset($field['description'])): ?>
										<span class="description"><?php echo esc_html($field['description']); ?></span>
									<?php endif; ?>
								</div>
								<?php endforeach;?>
								<button type="button" class="tf-remove-button themefarmer-repeater-remove-item"><?php esc_html_e('Remove Field', 'themefarmer-companion');?></button>
							</div>
						</div>
					</li>
			<?php $i++;endforeach;endif;?>
		</ul>
		<button type="button" class="button button-secondary themefarmer-repeater-add-new"><i class="fa fa-plus"></i> <?php printf("%s %s", esc_html_e("Add New", 'themefarmer-companion'), $this->row_label);?></button>
		<?php

	}

	// return html
	private function get_field($field = array(), $key = '', $value = '') {
		if (empty($field)) {
			return;
		}
		$type = '';

		if (isset($field['type'])) {
			$type = $field['type'];
		}
		if (empty($value) && isset($field['default'])) {
			$value = $field['default'];
		}

		switch ($type) {
		case 'text':
			?> <input type="text" class="widefat themefarmer-repeater-field" data-tf-index="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>"> <?php
			break;
		
		case 'color':
			?> <input type="text" class="widefat themefarmer-repeater-field tf-color-field" data-tf-index="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>"> <?php
			break;
			
		case 'textarea':
			?><textarea class="widefat themefarmer-repeater-field" data-tf-index="<?php echo esc_attr($key); ?>"><?php echo wp_kses_post($value); ?></textarea><?php
			break;

		case 'select':
			?>
			<?php if(!empty($field['choices'])): ?>
			<select class="widefat themefarmer-repeater-field" data-tf-index="<?php echo esc_attr($key); ?>">
				<?php foreach ($field['choices'] as $key => $choice): ?>
					<option value="<?php echo esc_attr($key); ?>" <?php selected($key, $value) ?>><?php echo esc_html($choice); ?></option>
				<?php endforeach; ?>
			</select>
			<?php endif;  
			break;

		case 'image':
			?>
				<input type="text" class="widefat image-select-field themefarmer-repeater-field" data-tf-index="<?php echo esc_attr($key); ?>" value="<?php echo esc_url($value); ?>">
				<button type="button" class="button button-secondary cimage-select-button"><i class="fa fa-image"></i> <?php esc_html_e('Select Image', 'themefarmer-companion')?></button>
				<?php
			break;

		case 'icon':
			?>
				<div class="icon-field-group">
					<span class="tf-rep-icon">
						<span class="icon-show"><i class="fa <?php echo esc_attr($value); ?>"></i></span>
						<input type="text" class="widefat icon-select-field themefarmer-repeater-field" data-tf-index="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>">
					</span>
					<?php
						if (file_exists($this->icon_container)) {
							include $this->icon_container;
						}
					?>
				</div>
				<?php
					break;

		case 'dropdown-pages':

			$pages = get_pages(array('hide_empty' => false));
			if (!empty($pages)): ?>
	              	<select class="widefat themefarmer-repeater-field" data-tf-index="<?php echo esc_attr($key); ?>">
		                <option value="0"><?php esc_html_e('Select Page', 'themefarmer-companion');?></option>
		              	<?php
							foreach ($pages as $page):
								printf('<option value="%s" %s>%s</option>',
									$page->ID,
									selected($value, $page->ID, false),
									$page->post_title
								);
							endforeach;
						?>
	              	</select>
	            <?php endif;
			break;

		case 'repeater':
			?>
				<div class="themefarmer-repeater-repeater-copy" style="display: none !important;" data-tf-index="<?php echo esc_attr($key); ?>">
					<div class="themefarmer-repeater-repeater-group-copy">
						<?php
							if(isset( $field['fields']) && !empty($field['fields'])):
						 		foreach ($field['fields'] as $rkey => $rfield):
						 			$this->get_repeater_field($rfield, $rkey);
						 		endforeach;
						 	endif; 
						?>
						<button type="button" class="tf-remove-button themefarmer-repeater-remove-repeater"><?php esc_html_e('Remove Icon', 'themefarmer-companion');?></button>
					</div>
				</div>
				<div class="themefarmer-repeater-repeater" data-tf-index="<?php echo esc_attr($key); ?>">
					<?php if (!empty($value)): foreach ($value as $ikey => $item): ?>
						<div class="themefarmer-repeater-repeater-group"> 
						<?php
							if(isset( $field['fields']) && !empty($field['fields'])):
						 		foreach ($field['fields'] as $rkey => $rfield):
						 			$this->get_repeater_field($rfield, $rkey, $item[$rkey]);
						 		endforeach;
						 	endif;  	 
						?>
						<button type="button" class="tf-remove-button themefarmer-repeater-remove-repeater"><?php esc_html_e('Remove', 'themefarmer-companion');?></button>
						</div>
					<?php endforeach;endif;?>
					<?php $button_label = (isset($field['button_label'])) ? $field['button_label'] : __('Add Item', 'themefarmer-companion');?>
					<button type="button" class="button button-secondary themefarmer-repeater-add-repeater"><i class="fa fa-plus"></i>  <?php echo esc_html($button_label); ?></button>
				</div>
				<?php
				break;

		default:
			?> <input type="text" class="widefat themefarmer-repeater-field" data-tf-index="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>"> <?php
		break;
		}
	}

	private function get_repeater_field($field = array(), $key = '', $value = '') {

		/*if (empty($field)) {
			return;
		}*/
		$type = 'social';

		if (isset($field['type'])) {
			$type = $field['type'];
		}
		if (empty($value) && isset($field['default']) && $type !== 'repeater') {
			$value = $field['default'];
		}
		switch ($type) {
			case 'text':
				?>
				 
					<div class="themefarmer-repeater-repeater-element">
						<input type="text" class="widefat themefarmer-repeater-repeater-field" data-tf-index="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>"> 
					</div>
					
				
				<?php
				break;

			case 'textarea':
				?>
				
					<div class="themefarmer-repeater-repeater-element">
						<textarea class="widefat themefarmer-repeater-repeater-field" data-tf-index="<?php echo esc_attr($key); ?>"><?php echo wp_kses_post($value); ?></textarea>
					</div>
					
				
				<?php
				break;

			case 'image':
				?>
				
					<div class="themefarmer-repeater-repeater-element">
						<input type="text" class="widefat image-select-field themefarmer-repeater-repeater-field" data-tf-index="<?php echo esc_attr($key); ?>" value="<?php echo esc_url($value); ?>">
						<button type="button" class="button button-secondary cimage-select-button"><?php esc_html_e('Select Image', 'themefarmer-companion')?></button>
					</div>
					
				
				<?php
			break;
			case 'icon':
				?>
				<div class="themefarmer-repeater-repeater-element">
					<div class="icon-field-group">
						<span>
							<span class="icon-show"><i class="fa <?php echo esc_attr($value); ?>"></i></span>
							<input type="text" class="widefat icon-select-field themefarmer-repeater-repeater-field" data-tf-index="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>">
						</span>
						<?php
							if (file_exists($this->icon_container)) {
								include $this->icon_container;
							}
						?>
					</div>
				</div>
				<?php
				break;
			case 'social':
			default:
				?>
				
					<div class="themefarmer-repeater-repeater-element">
						<div class="icon-field-group">
							<span>
								<span class="icon-show"><i class="fa <?php echo esc_attr($item['icon']); ?>"></i></span>
								<input type="text" class="widefat icon-select-field themefarmer-repeater-repeater-field" data-tf-index="icon" value="<?php echo esc_attr(isset($value['icon'])?$value['icon']:''); ?>">
							</span>
							<?php
								if (file_exists($this->icon_container)) {
									include $this->icon_container;
								}
							?>
						</div>
					</div>
					<div class="themefarmer-repeater-repeater-element">
						<input type="text" class="widefat themefarmer-repeater-repeater-field" data-tf-index="link" value="<?php echo esc_attr(isset($value['link'])?$value['link']:''); ?>">
					</div>
				
				<?php
			break;
		}	
	}
}