<?php
/**
 * WooCommerce Tool
 *
 * @author ThemeFarmer
 * @version 1.0.0
 * @package WooCommerce Tool
 *
 */

if (!defined('ABSPATH')) {
	exit;
}

function woocommerce_tool_compare_list_shortcode($atts){
	TFWC_TOOL_Compare()->show_compare_list();
}
add_shortcode('tfwc_tool_compare_list', 'woocommerce_tool_compare_list_shortcode');