<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_Customize_Control')) {
	return;
}

if (class_exists('ThemeFarmer_Field_Info')) {
	return;
}

class ThemeFarmer_Field_Info extends WP_Customize_Control {
	
	public $type = 'themefarmer-info';
	/**
	 * Class constructor
	 */
	public function __construct($manager, $id, $args = array()) {
		parent::__construct($manager, $id, $args);
	}
	
	public function render_content() {
	 	if($this->label){ 
	    	echo '<span class="customize-control-title">';
			echo esc_html($this->label);
			echo '</span>';
		} 

		if ($this->description){
			echo '<span class="description customize-control-description">';
			echo wp_kses_post($this->description);
			echo '</span>';
		}
	}
	
	

}