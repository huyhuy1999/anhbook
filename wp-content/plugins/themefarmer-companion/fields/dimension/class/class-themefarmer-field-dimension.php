<?php
if (!class_exists('WP_Customize_Section')) {
	return;
}

/**
 *
 */

if (!class_exists('ThemeFarmer_Field_Dimension')) {
	class ThemeFarmer_Field_Dimension extends WP_Customize_Control {
		public $type = 'themefarmer-dimension';
		public $left;
		public $right;
		public $top;
		public $bottom;
		public $linked = true;

		public function __construct($manager, $id, $args = array()) {
			parent::__construct($manager, $id, $args);
			// add_action('customize_controls_init', array($this, 'enqueue'));
			if (isset($args['left'])) {
				$this->left = $args['left'];
			}

			if (isset($args['right'])) {
				$this->right = $args['right'];
			}

			if (isset($args['top'])) {
				$this->top = $args['top'];
			}

			if (isset($args['bottom'])) {
				$this->bottom = $args['bottom'];
			}

			if (isset($args['linked'])) {
				$this->linked = $args['linked'];
			}

		}

		public function enqueue() {
			wp_enqueue_style('themefarmer-dimension', THEMEFARMER_FIELDS_URI . 'dimension/css/dimension.css');
			wp_enqueue_script('themefarmer-dimension', THEMEFARMER_FIELDS_URI . 'dimension/js/dimension.js', array('jquery'), null, true);
		}

		public function json() {
			$json           = parent::json();
			$json['top']    = $this->top;
			$json['right']  = $this->right;
			$json['bottom'] = $this->bottom;
			$json['left']   = $this->left;
			$json['linked'] = $this->linked;
			return $json;
		}

		protected function render_content() {
			$value = $this->value();
			if (is_array($value)) {
				$top    = $value['top'];
				$right  = $value['right'];
				$bottom = $value['bottom'];
				$left   = $value['left'];
				$linked = $value['linked'];
			}elseif(is_numeric($value)){
				$top  = $value;
				$right  = $value;
				$bottom  = $value;
				$left  = $value;
				$linked = $this->linked;
			}else{
				$top = '';
				$right = '';
				$bottom = '';
				$left = '';
				$linked = $this->linked;
			}
			?>
			<div class="themefarmer-field-dimension">
				<input type="number" id="themefarmer-dimension-top-<?php echo esc_attr($this->id); ?>" class="themefarmer-dimension-input themefarmer-dimension-top" value="<?php echo esc_attr($top); ?>">
				<input type="number" id="themefarmer-dimension-right-<?php echo esc_attr($this->id); ?>" class="themefarmer-dimension-input themefarmer-dimension-right" value="<?php echo esc_attr($right); ?>">
				<input type="number" id="themefarmer-dimension-bottom-<?php echo esc_attr($this->id); ?>" class="themefarmer-dimension-input themefarmer-dimension-bottom" value="<?php echo esc_attr($bottom); ?>">
				<input type="number" id="themefarmer-dimension-left-<?php echo esc_attr($this->id); ?>" class="themefarmer-dimension-input themefarmer-dimension-left" value="<?php echo esc_attr($left); ?>">
				<button id="themefarmer-dimension-button-linked-<?php echo esc_attr($this->id); ?>" class="themefarmer-dimension-button-linked <?php echo ($linked == true) ? 'linked' : ''; ?>" type="button"><i class="fa fa-link"></i></button>
				<input type="hidden" class="themefarmer-field-dimension-data" <?php $this->link();?>>
			</div>
		<?php
}
	}
}