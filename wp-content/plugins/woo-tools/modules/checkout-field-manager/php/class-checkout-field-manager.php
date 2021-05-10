<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * TFWC_Tool_Checkout_Field_Manager
 */

class TFWC_Tool_Checkout_Field_Manager {
	

	protected static $instance;

	public static function get_instance() {

		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function __construct() {

		//add_filter('woocommerce_checkout_fields', array($this, 'override_checkout_fields'));

		add_action('wp_enqueue_scripts', array($this, 'enqueue'));
	}

	public function enqueue() {
		// wp_enqueue_style('tfwc-tool-checkout-field-manager-style', TFWCTOOL_URI . 'modules/checkout-field-manager/css/checkout-field-manager.css');
		// wp_enqueue_script('tfwc-tool-checkout-field-manager-script', TFWCTOOL_URI . 'modules/checkout-field-manager/js/checkout-field-manager.js', array('jquery), null, true);
	}	

	public function override_checkout_fields($fields){
		/*echo "<script>";
		echo 'console.log('.json_encode($fields).');';
		echo "</script>";*/
	}

}

function TFWC_Tool_Checkout_Field_Manager() {
	return TFWC_Tool_Checkout_Field_Manager::get_instance();
}