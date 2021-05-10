<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}


if (!defined('THEMEFARMER_FIELDS_DIR')) {
	define('THEMEFARMER_FIELDS_DIR', plugin_dir_path(__FILE__));
}


if (!defined('THEMEFARMER_FIELDS_URI')) {
	define('THEMEFARMER_FIELDS_URI', plugin_dir_url(__FILE__));
}

// require_once THEMEFARMER_FIELDS_DIR.'themefarmer-fields.php';

class ThemeFarmer_Load_Fields{
	
	function __construct(){
		add_action('init', array($this, 'init_fields'));
	}

	public function init_fields(){
		require_once THEMEFARMER_FIELDS_DIR.'tabs/class/class-themefarmer-field-tabs.php';
		require_once THEMEFARMER_FIELDS_DIR.'switch/class/class-themefarmer-field-switch.php';
		require_once THEMEFARMER_FIELDS_DIR.'sortable/class/class-themefarmer-field-sortable.php';
		require_once THEMEFARMER_FIELDS_DIR.'repeater/class/class-themefarmer-field-repeater.php';
		require_once THEMEFARMER_FIELDS_DIR.'range/class/class-themefarmer-field-range.php';
		require_once THEMEFARMER_FIELDS_DIR.'info/class/class-themefarmer-field-info.php';
		require_once THEMEFARMER_FIELDS_DIR.'image-select/class/class-themefarmer-field-image-select.php';
		require_once THEMEFARMER_FIELDS_DIR.'icon/class/class-themefarmer-field-icon.php';
		require_once THEMEFARMER_FIELDS_DIR.'font-selector/class/class-themefarmer-field-font-selector.php';
		require_once THEMEFARMER_FIELDS_DIR.'divider/class/class-themefarmer-field-divider.php';
		require_once THEMEFARMER_FIELDS_DIR.'button-select/class/class-themefarmer-field-button-select.php';
		require_once THEMEFARMER_FIELDS_DIR.'button-section/class/class-themefarmer-field-button-section.php';
		require_once THEMEFARMER_FIELDS_DIR.'dimension/class/class-themefarmer-field-dimension.php';
	}

}

new ThemeFarmer_Load_Fields();

if (!function_exists('themefarmer_field_repeater_sanitize')) {
	function themefarmer_field_repeater_sanitize($input) {
		return $input;
		$output = array();
		if (!empty($input)) {
			foreach ($input as $boxk => $box) {
				foreach ($box as $key => $value) {
					if (is_array($value)) {
						foreach ($value as $skey => $svalue) {
							foreach ($svalue as $sikey => $sivalue) {
								$output[$boxk][$key][$skey][$sikey] = wp_kses_post(force_balance_tags($sivalue));
							}
						}
					} else {
						$output[$boxk][$key] = wp_kses_post(force_balance_tags($value));
					}

				}
			}
			return $output;
		}
		
	}
}

if (!function_exists('themefarmer_field_sortable_sanitize')) {
	function themefarmer_field_sortable_sanitize($input) {
		$output = array();
		if (!empty($input)) {
			foreach ($input as $key => $value) {
				$output[] = sanitize_text_field($value);
			}
			$output;
		}
		return $output;
	}
}

if (!function_exists('themefarmer_field_range_sanitize')) {
	function themefarmer_field_range_sanitize($input) {
		$output = array();
		if (!empty($input)) {
			foreach ($input as $key => $value) {
				$output[$key] = absint($value);
			}
			$output;
		}
		return $output;
	}
}

if (!function_exists('themefarmer_field_dimension_sanitize')) {
	function themefarmer_field_dimension_sanitize($input) {
		$output = array();
		if (!empty($input)) {
			if(is_array($input)){
				$output['top'] = intval($input['top']);
				$output['right'] = intval($input['right']);
				$output['bottom'] = intval($input['bottom']);
				$output['left'] = intval($input['left']);
				$output['linked'] = (isset($input['linked']) && $input['linked'] == true)?true:false;
				return $output;
			}
		}
		return '';
	}
}

