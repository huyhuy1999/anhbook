<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_Customize_Control')) {
	return;
}

if (class_exists('ThemeFarmer_Field_Tabs')) {
	return;
}


class ThemeFarmer_Field_Tabs extends WP_Customize_Control {

	public $type    = 'themefarmer-tabs';
	public $controls = array();
	public $transport = 'postMessage';
	public $priority = -10;
	public $tabs;

	/**
	 * Class constructor
	 */
	public function __construct($manager, $id, $args = array()) {
		parent::__construct($manager, $id, $args);
	}

	public function enqueue() {

		
		wp_enqueue_style('themefarmer-tabs', THEMEFARMER_FIELDS_URI . 'tabs/css/themefarmer-tabs.css');
		wp_enqueue_script('themefarmer-tabs', THEMEFARMER_FIELDS_URI . 'tabs/js/themefarmer-tabs.js', array('jquery'), null, true);
	}
	

	protected function render_content() {
		$value = $this->value();
		$tabs = $this->tabs;
		$i = 0;
		$tab_cols = count($tabs);
		?>
		<div class="themefarmer-tabs themefarmer-tabs-col-<?php echo esc_attr($tab_cols); ?>" id="<?php echo esc_attr($this->id); ?>">
			<?php if(!empty($tabs)): foreach ($tabs as $key => $tab): ?>
				<?php 
					$tabs_controls = '';
					if(!empty($tab['controls'])){
						$tabs_controls = json_encode($tab['controls']);
					}
					$tab_active = '';
					if((empty($value) && $i ==0) || ($value == $key)){
						$tab_active = 'active';
					}
				?>
				<div class="themefarmer-tab-control <?php echo esc_attr($tab_active).' themefarmer-tab-control-'.esc_attr($this->id); ?> " id="themefarmer-tab-control-<?php echo esc_attr($this->id).'-'.esc_attr($key) ?>">
					<label>
					<input class="themefarmer-tab-radio" type="radio" id="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" data-controls="<?php echo esc_attr($tabs_controls); ?>" <?php checked($i, 0); ?> name="tftab-control-<?php echo esc_attr($this->id);?>" <?php $this->link(); ?>>
					<?php if(!empty($tab['icon'])): ?>
						<i class="themefarmer-tab-icon fa <?php echo esc_attr($tab['icon']); ?>"></i>
					<?php endif; ?>
					<?php if(!empty($tab['name'])): ?>
						<span><?php echo esc_html($tab['name']); ?></span>
					<?php endif; ?>
					</label>
				</div>
			<?php $i++; endforeach; endif; ?>
		</div>
		<?php
	}
}