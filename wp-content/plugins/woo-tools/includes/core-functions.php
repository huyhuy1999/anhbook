<?php
/**
 * WooCommerce Tool Core Functions
 *
 * @author ThemeFarmer
 * @version 1.0.0
 *
 */

if (!defined('ABSPATH')) {
	exit;
}

function tfwctool_get_rendom_string($length = 10) {
	return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyz', ceil($length / strlen($x)))), 1, $length);
}

function tfwctool_get_wishlist_url() {
	$wishlist_page = get_option('tfwctool_wishlist_page_id');
	if (absint($wishlist_page) > 0) {
		return get_permalink($wishlist_page);
	}

	return false;
}

function tfwctool_get_template($template_name, $args = array(), $return = false, $template_path = '', $default_path = '') {

	if (!empty($args) && is_array($args)) {
		extract($args); // @codingStandardsIgnoreLine
	}

	$located = tfwctool_locate_template($template_name, $template_path, $default_path);

	if (!file_exists($located)) {
		return;
	}

	$located = apply_filters('tfwctool_get_template', $located, $template_name, $args, $template_path, $default_path);

	if ($return) {
		ob_start();
	}

	include $located;

	if ($return) {
		return ob_get_clean();
	}

}

function tfwctool_locate_template($template_name, $template_path = '', $default_path = '') {

	if (!$template_path) {
		$template_path = TFWC_TOOL()->template_path();
	}

	if (!$default_path) {
		$default_path = TFWCTOOL_DIR . 'templates/';
	}

	$wc_template_path = WC()->template_path();
	$path             = $template_path;

	// Look within passed path within the theme - this is priority.
	$template = locate_template(
		array(
			trailingslashit($template_path) . $template_name,
			trailingslashit($wc_template_path) . $template_name,
			$template_name,
		)
	);

	// Get default template/.
	if (!$template || TFWCTOOL_TEMPLATE_DEBUG) {
		$template = $default_path . $template_name;
		$path     = $default_path;
	}

	return apply_filters('tfwctool_locate_template', $template, $template_name, $path);
}
