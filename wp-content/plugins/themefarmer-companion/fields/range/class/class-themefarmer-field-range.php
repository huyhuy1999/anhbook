<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_Customize_Control')) {
	return;
}

if (class_exists('ThemeFarmer_Field_Range')) {
	return;
}

class ThemeFarmer_Field_Range extends WP_Customize_Control {

	public $type    = 'themefarmer-range';
	public $min = 1;
	public $max = 20;
	public $step = 0.1;
	public $responsive = false;


	/**
	 * Class constructor
	 */
	public function __construct($manager, $id, $args = array()) {
		parent::__construct($manager, $id, $args);	
		if(!empty($args['responsive'])){
			$this->responsive = (boolean) $args['responsive'];
		}

	}

	public function enqueue() {

		wp_enqueue_style('themefarmer-range-slider', THEMEFARMER_FIELDS_URI . 'range/css/themefarmer-range.css');
		wp_enqueue_script('themefarmer-range-slider', THEMEFARMER_FIELDS_URI . 'range/js/themefarmer-range.js', array('jquery'), null, true);
	}
	
	public function json() {
		$json = parent::json();
		$json['responsive'] = $this->responsive;
		$json['min'] = $this->min;
		$json['max'] = $this->max;
		$json['step'] = $this->step;
		return $json;
	}

	protected function render_content() {
		$data = $this->value();
		$values = array();
		$default = 10;
		if(isset($this->setting->default) && absint($this->setting->default) > 0){
			$default = $this->setting->default;
		}

		if(is_array($data)){
			$values['desktop']  = $data['desktop'];
			$values['mobile']  = $data['mobile'];
			$values['tablet']  = $data['tablet'];
		}else{
			$values['desktop']  = $data;
			$values['mobile']  	= $data;
			$values['tablet']  	= $data;
		}

		?>
		<div class="themefarmer-range-slider-container <?php echo ($this->responsive)?'themefarmer-responsive-range':''; ?>">
			<?php if (!empty($this->label)): ?>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
			<?php endif;?>

			<?php if (!empty($this->description)): ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif;?>
			<?php if($this->responsive): ?>
			<span class="themefarmer-device-controls">
				<button type="button" class="preview-desktop active" data-device="desktop" title="<?php esc_attr_e('Click to set font for desktop devices', 'themefarmer-companion'); ?>">
					<i class="dashicons dashicons-desktop"></i>
				</button>
				<button type="button" class="preview-tablet" data-device="tablet" title="<?php esc_attr_e('Click to set font for tablet devices', 'themefarmer-companion'); ?>">
					<i class="dashicons dashicons-tablet"></i>
				</button>
				<button type="button" class="preview-mobile" data-device="mobile" title="<?php esc_attr_e('Click to set font for mobile devices', 'themefarmer-companion'); ?>">
					<i class="dashicons dashicons-smartphone"></i>
				</button>
			</span>
			<?php endif; ?>
			<div class="themefarmer-range-slider-controls-con">
				<?php if ($this->responsive): ?>
				<div class="themefarmer-range-slider-controls range-slider-desktop active">
					<input class="themefarmer-range-slider" data-device="desktop" type="range"  min="<?php echo esc_attr($this->min); ?>" max="<?php echo esc_attr($this->max); ?>" step="<?php echo esc_attr($this->step); ?>" value="<?php echo esc_attr($values['desktop']); ?>">
					<input class="themefarmer-range-value" data-device="desktop" type="number" id="themefarmer-range-value-desktop-<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($values['desktop']); ?>">
					<span class="range-slider-reset" data-value="<?php echo esc_attr(absint($default)); ?>">
						<i class="dashicons dashicons-image-rotate"></i>
					</span>
				</div>
				<div class="themefarmer-range-slider-controls range-slider-tablet">
					<input class="themefarmer-range-slider" data-device="tablet" type="range"  min="<?php echo esc_attr($this->min); ?>" max="<?php echo esc_attr($this->max); ?>" step="<?php echo esc_attr($this->step); ?>" value="<?php echo esc_attr($values['tablet']); ?>">
					<input class="themefarmer-range-value" data-device="tablet" type="number" id="themefarmer-range-value-tablet-<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($values['tablet']); ?>">
					<span class="range-slider-reset" data-value="<?php echo esc_attr(absint($default)); ?>">
						<i class="dashicons dashicons-image-rotate"></i>
					</span>
				</div>	
				<div class="themefarmer-range-slider-controls range-slider-mobile">
					<input class="themefarmer-range-slider" data-device="mobile" type="range"  min="<?php echo esc_attr($this->min); ?>" max="<?php echo esc_attr($this->max); ?>" step="<?php echo esc_attr($this->step); ?>" value="<?php echo esc_attr($values['mobile']); ?>">
					<input class="themefarmer-range-value" data-device="mobile" type="number" id="themefarmer-range-value-mobile-<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($values['mobile']); ?>">
					<span class="range-slider-reset" data-value="<?php echo esc_attr(absint($default)); ?>">
						<i class="dashicons dashicons-image-rotate"></i>
					</span>
				</div>
				<?php else: ?>
				<div class="themefarmer-range-slider-controls range-slider-desktop active">
					<input class="themefarmer-range-slider" type="range"  min="<?php echo esc_attr($this->min); ?>" max="<?php echo esc_attr($this->max); ?>" step="<?php echo esc_attr($this->step); ?>" value="<?php echo esc_attr($values['desktop']); ?>">
					<input class="themefarmer-range-value" type="number" id="themefarmer-range-value-<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($values['desktop']); ?>">
					<span class="range-slider-reset" data-value="<?php echo esc_attr(absint($default)); ?>">
						<i class="dashicons dashicons-image-rotate"></i>
					</span>
				</div>
				<?php endif; ?>
				<input type="hidden" class="themefarmer-range-data" id="<?php echo esc_attr($this->id); ?>" <?php $this->link(); ?>>
			</div>
		</div>
		<?php
	}
}