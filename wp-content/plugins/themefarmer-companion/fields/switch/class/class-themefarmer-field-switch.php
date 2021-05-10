<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_Customize_Control')) {
	return;
}

if (class_exists('ThemeFarmer_Field_Switch')) {
	return;
}

class ThemeFarmer_Field_Switch extends WP_Customize_Control {

	public $type    = 'themefarmer-switch';
	

	/**
	 * Class constructor
	 */
	public function __construct($manager, $id, $args = array()) {
		parent::__construct($manager, $id, $args);
	}

	public function enqueue() {
		wp_enqueue_style('themefarmer-field-switch', THEMEFARMER_FIELDS_URI . 'switch/css/themefarmer-field-switch.css');
		wp_enqueue_script('themefarmer-field-switch', THEMEFARMER_FIELDS_URI . 'switch/js/themefarmer-field-switch.js', array('jquery'), null, true);
	}
	

	public function render_content() {
		
		?>

		<?php if (!empty($this->label)): ?>
			<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
		<?php endif;?>

		<?php if (!empty($this->description)): ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php endif;?>

		<div class="themefarmer-switch">
			<label class="switch">
			  <input type="checkbox" value="1" id="<?php echo esc_attr($this->id); ?>" <?php $this->link();?>>
			  <span class="slider"></span>
			</label>
		</div>
		<?php

	}
}