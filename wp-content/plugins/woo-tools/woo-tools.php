<?php
/*
Plugin Name: WooCommerce Tools
Description: Advance tools for WooCommerce by ThemeFarmer, this tool can be used to add Quick View, WishList, Compare functionality in your theme without any code change.
Author: ThemeFarmer
Author URI: https://www.themefarmer.com/
Domain Path: /language/
Version: 1.2
Text Domain: woocommerce-tools
WC requires at least: 3.0
WC tested up to: 3.7

StoreOne Extension is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

StoreOne Extension is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with StoreOne Extension. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

define('TFWCTOOL_DIR', trailingslashit(plugin_dir_path(__FILE__)));
define('TFWCTOOL_URI', trailingslashit(plugin_dir_url(__FILE__)));
define('TFWCTOOL_TEMPLATE_DEBUG', false);

function tfwc_tools_get_modules() {
	$modules = array(
		array(
			'id'          => 'wishlist',
			'slug'		  => 'wishlist',
			'icon'        => TFWCTOOL_URI . 'admin/assets/images/wishlist-icon.png',
			'name'        => esc_html__('Wishlist', 'woocommerce-tools'),
			'description' => esc_html__('Wishlist for WooCommerce', 'woocommerce-tools'),
		),
		array(
			'id'          => 'quick_view',
			'slug'		  => 'quick-view',
			'icon'        => TFWCTOOL_URI . 'admin/assets/images/quick-view-icon.png',
			'name'        => esc_html__('Quick View', 'woocommerce-tools'),
			'description' => esc_html__('Quick View for WooCommerce Products', 'woocommerce-tools'),
		),
		array(
			'id'          => 'compare',
			'slug'		  => 'compare',
			'icon'        => TFWCTOOL_URI . 'admin/assets/images/compare-icon.png',
			'name'        => esc_html__('Compare', 'woocommerce-tools'),
			'description' => esc_html__('Compare for WooCommerce Products', 'woocommerce-tools'),
		),
		array(
			'id'          => 'ajax_search',
			'slug'		  => 'ajax-search',
			'icon'        => TFWCTOOL_URI . 'admin/assets/images/ajax-search-icon.png',
			'name'        => esc_html__('Ajax Search', 'woocommerce-tools'),
			'description' => esc_html__('Ajax Search for WooCommerce', 'woocommerce-tools'),
		),
		array(
			'id'          => 'floating_cart',
			'slug'		  => 'floating-cart',
			'icon'        => TFWCTOOL_URI . 'admin/assets/images/placeholder_plugin.png',
			'name'        => esc_html__('Floating Cart', 'woocommerce-tools'),
			'description' => esc_html__('Floating Cart for WooCommerce', 'woocommerce-tools'),
		),
		array(
			'id'          => 'smart_variation_swatches',
			'slug'		  => 'smart-variation-swatches',
			'icon'        => TFWCTOOL_URI . 'admin/assets/images/placeholder_plugin.png',
			'name'        => esc_html__('Smart Variation Swatches', 'woocommerce-tools'),
			'description' => esc_html__('Smart Variation Swatches for WooCommerce', 'woocommerce-tools'),
		),
		/*array(
			'id'          => 'checkout_field_manager',
			'slug'		  => 'checkout-field-manager',
			'icon'        => TFWCTOOL_URI . 'admin/assets/images/placeholder_plugin.png',
			'name'        => esc_html__('Checkout Field Manager', 'woocommerce-tools'),
			'description' => esc_html__('Checkout Field Manager for WooCommerce', 'woocommerce-tools'),
		),*/
	);
	return $modules;
}

if (is_admin()) {
	require_once TFWCTOOL_DIR . 'admin/admin-init.php';
}

require_once TFWCTOOL_DIR . 'includes/core-functions.php';
require_once TFWCTOOL_DIR . 'modules/modules-init.php';
require_once TFWCTOOL_DIR . 'includes/tfwctools-template-functions.php';

class TFWC_TOOL {

	protected static $instance;
	public $wishlist;
	public $quick_view;
	public $compare;

	public static function get_instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function __construct() {
		$modules_optins = get_option('woocommerce_tools_module_options');
		if (function_exists('TFWC_TOOL_Compare')) {
			$this->compare = TFWC_TOOL_Compare();
		}

		if (function_exists('TFWC_Tool_Quick_View')) {
			$this->quick_view = TFWC_Tool_Quick_View();
		}

		if (function_exists('TFWC_TOOL_Wishilst')) {
			$this->wishlist = TFWC_TOOL_Wishilst();
		}

		if (function_exists('TFWC_Tool_Ajax_Search')) {
			$this->ajax_search = TFWC_Tool_Ajax_Search();
		}

		if (function_exists('TFWC_Tool_Floating_Cart')) {
			$this->Floating_Cart = TFWC_Tool_Floating_Cart();
		}

		if (function_exists('TFWC_Tool_Variation_Swatches_Admin')) {
			if (is_admin()) {
				$this->variation_swatches_admin = TFWC_Tool_Variation_Swatches_Admin();
			}
		}

		/*if (!isset($modules_optins['checkout_field_manager']) || (isset($modules_optins['checkout_field_manager']) && $modules_optins['checkout_field_manager'] != false)) {
			$this->checkout_field_manager =  TFWC_Tool_Checkout_Field_Manager();
		}*/

	}

	public function template_path() {
		return apply_filters('tfwc_tool_template_path', 'woocommerce-tools/');
	}

}

function TFWC_TOOL() {
	return TFWC_TOOL::get_instance();
}

function woocommerce_tools_init() {
	if (class_exists('WooCommerce')) {
		$TFWC_TOOL = TFWC_TOOL();
	}
	load_plugin_textdomain('woocommerce-tools', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'woocommerce_tools_init');

function tfwctool_get_localize_data() {
	$localize = array(
		'ajax_url'                    => admin_url('admin-ajax.php'),
		'add_to_wishlist_action'      => 'tfwctool_add_to_wishlist',
		'remove_from_wishlist_action' => 'tfwctool_remove_from_wishlist',
		'compare_cookie_name'         => 'tfwc_tool_compare',
		'wishlist_cookie_name'        => 'tfwc_tool_wishilst',
		'compare_cookie_expiration'   => time() + apply_filters('tfwc_tool_compare_cookie_expiration', 60 * 60 * 24 * 30),
	);
	return $localize;
}

function tfwctool_scripts() {
	wp_enqueue_style('tfwctool-admin-style', plugin_dir_url(__FILE__) . 'assets/css/tfwctool-style.css');

	wp_enqueue_script('tfwctool-script', plugin_dir_url(__FILE__) . 'assets/js/tfwctool-script.js', array('jquery', 'jquery-cookie'));
	$localize = tfwctool_get_localize_data();
	wp_localize_script('tfwctool-script', 'TFWC_TOOL', $localize);
}
add_action('wp_enqueue_scripts', 'tfwctool_scripts');

function tfwctool__install() {
	global $wpdb;
	$wishlist_item_table = $wpdb->prefix . 'tfwctool_wishlist_items';
	$wishlist_list_table = $wpdb->prefix . 'tfwctool_wishlist_lists';

	$charset_collate = '';
	if ($wpdb->has_cap('collation')) {
		if (!empty($wpdb->charset)) {
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		}
		if (!empty($wpdb->collate)) {
			$charset_collate .= " COLLATE $wpdb->collate";
		}
	}

	if ($wpdb->get_var("SHOW TABLES LIKE '$wishlist_item_table'") != $wishlist_item_table) {

		$create_wishlist_item_table_sql = "CREATE TABLE  $wishlist_item_table (
				`ID` int(11)  NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  	`user_id` int(11) NOT NULL,
			  	`wishlist_id` int(11) NOT NULL,
			  	`product_id` int(11) NOT NULL,
			  	`quantity` int(11) NOT NULL,
			  	`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP )
			  	$charset_collate;";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta($create_wishlist_item_table_sql);
	}

	if ($wpdb->get_var("SHOW TABLES LIKE '$wishlist_list_table'") != $wishlist_list_table) {
		$create_wishlist_list_table_sql = "CREATE TABLE $wishlist_list_table (
			`ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  	`user_id` int(11) NOT NULL,
		  	`name` varchar(255) NOT NULL,
		  	`slug` varchar(255) NOT NULL,
		  	`token` varchar(20) NOT NULL,
		  	`is_private` tinyint(1) NOT NULL,
		  	`is_default` tinyint(1) NOT NULL )
			$charset_collate;";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta($create_wishlist_list_table_sql);
	}

	$page_id = $wpdb->get_var("SELECT `ID` FROM `{$wpdb->posts}` WHERE `post_name` = 'wishlist' LIMIT 1;");
	if ($page_id) {
		$wishlist_page = get_post($page_id);
		if (strpos($wishlist_page->post_content, '[tfwc_tool_wishilst]') === false) {
			$wishlist_page_args = array(
				'ID'           => $page_id,
				'post_content' => '[tfwc_tool_wishilst] ' . $wishlist_page->post_content,
			);
			wp_update_post($wishlist_page_args);
			update_option('tfwctool_wishlist_page_id', $page_id);
		}
	} else {
		$wishlist_page_args = array(
			'post_status'    => 'publish',
			'post_type'      => 'page',
			'post_author'    => 1,
			'post_name'      => esc_sql(_x('wishlist', 'page_slug', 'woocommerce-tools')),
			'post_title'     => esc_html__('Wishlist', 'woocommerce-tools'),
			'post_content'   => '[tfwc_tool_wishilst]',
			'post_parent'    => 0,
			'comment_status' => 'closed',
		);
		$page_id = wp_insert_post($wishlist_page_args);
		update_option('tfwctool_wishlist_page_id', $page_id);
	}

	add_option('tfwctool_compare', array('button_label' => esc_html__('Compare', 'woocommerce-tools'), 'button_icon' => 'fa fa-refresh', 'show_in_prodict_list' => true, 'show_in_single_product' => true, 'show_button_icon' => true));
	add_option('tfwctool_wishlist', array('button_label' => esc_html__('Add To Wishlist', 'woocommerce-tools'), 'button_icon' => 'fa fa-heart', 'show_in_prodict_list' => true, 'show_in_single_product' => true, 'show_button_icon' => true));
	add_option('tfwctool_quickview', array('button_label' => esc_html__('Quick View', 'woocommerce-tools'), 'button_icon' => 'fa fa-eye', 'show_in_prodict_list' => true, 'show_button_icon' => true));

	flush_rewrite_rules();

}

register_activation_hook(__FILE__, 'tfwctool__install');
