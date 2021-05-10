<?php 
define('TFWCTOOL_ADMIN_DIR', trailingslashit(plugin_dir_path(__FILE__)));
define('TFWCTOOL_ADMIN_URI', trailingslashit(plugin_dir_url(__FILE__)));

require_once TFWCTOOL_ADMIN_DIR . 'includes/admin-functions.php';

function tfwctool_admin_scripts($hook) {
    wp_enqueue_style('tfwctool-admin-style', plugin_dir_url(__FILE__) . 'assets/css/tfwctool-admin-style.css');
    wp_enqueue_style('select2', plugin_dir_url(__FILE__) . 'assets/css/select2.min.css');
    wp_enqueue_script('select2', plugin_dir_url(__FILE__) . 'assets/js/select2.min.js', array('jquery'));
    wp_enqueue_script('tfwctool-admin-script', plugin_dir_url(__FILE__) . 'assets/js/tfwctool-admin-script.js', array('jquery', 'wp-color-picker'));
    wp_localize_script('tfwctool-admin-script', 'woocommerce_tools_js_opt',
        array(
            'ajax_url' => esc_url(admin_url('admin-ajax.php')),
        )
    );
}
add_action('admin_enqueue_scripts', 'tfwctool_admin_scripts');


function tfwctool_options_menu(){
    $modules_optins = get_option('woocommerce_tools_module_options');
    add_menu_page(
        __('WooCommerce Tools','tfwctool'), 
        __('WooCommerce Tools','tfwctool'), 
        'manage_options', 
        'tfwctool', 
        'tfwctool_dashboard_page', 
        'dashicons-hammer', 
        61
    );
    add_submenu_page( 'tfwctool', esc_html__('Dashboard', 'storeone'), esc_html__('Dashboard', 'storeone'), 'manage_options', 'tfwctool', 'tfwctool_dashboard_page' );
    
    if(!isset($modules_optins['compare']) || (isset($modules_optins['compare']) && $modules_optins['compare'] != false)){
        add_submenu_page( 'tfwctool', 'Compare - WooCommerce Tool', 'Compare', 'manage_options', 'tfwctool-compare', 'tfwctool_compare_page' );
    }
    
    if(!isset($modules_optins['quickview']) || (isset($modules_optins['quickview']) && $modules_optins['quickview'] != false)){
        add_submenu_page( 'tfwctool', 'Quick View - WooCommerce Tool', 'Quick View', 'manage_options', 'tfwctool-quick-view', 'tfwctool_quickview_page' );
    }

    if(!isset($modules_optins['wishlist']) || (isset($modules_optins['wishlist']) && $modules_optins['wishlist'] != false)){
        add_submenu_page( 'tfwctool', 'Wishlist - WooCommerce Tool', 'Wishlist', 'manage_options', 'tfwctool-wishlist', 'tfwctool_wishlist_page' );
    }
}


if ( is_admin() ){ // admin actions
 
    add_action( 'admin_menu', 'tfwctool_options_menu' );
    add_action( 'admin_init', 'tfwctool_register_options' );
}

function tfwctool_register_options(){
    register_setting( 'tfwctool-options-compare', 'tfwctool_compare' );
    register_setting( 'tfwctool-options-wishlist', 'tfwctool_wishlist' );
    register_setting( 'tfwctool-options-wishlist', 'tfwctool_wishlist_page_id' );
    register_setting( 'tfwctool-options-quickview', 'tfwctool_quickview' );
}

function tfwctool_woocommerce_tool_toggle_module(){
    $modules_optins = get_option('woocommerce_tools_module_options');
    $module_id = sanitize_text_field($_POST['id']);
    $module_val = sanitize_text_field($_POST['value']);
    $modules_optins[$module_id] = ($module_val == 'on')?true:false;
    update_option('woocommerce_tools_module_options', $modules_optins);
    echo json_encode(get_option('woocommerce_tools_module_options'));
    wp_die();
}
add_action('wp_ajax_woocommerce_tool_toggle_module', 'tfwctool_woocommerce_tool_toggle_module');

function tfwctool_dashboard_page(){
	if (!current_user_can('manage_options')) {
        return;
    }
    include_once TFWCTOOL_ADMIN_DIR . 'option-pages/dashboard-options.php';
}

function tfwctool_compare_page(){
 if (!current_user_can('manage_options')) {
        return;
    }
    include_once TFWCTOOL_ADMIN_DIR . 'option-pages/compare-options.php';   
}

function tfwctool_quickview_page(){
    if (!current_user_can('manage_options')) {
        return;
    }
    include_once TFWCTOOL_ADMIN_DIR . 'option-pages/quickview-options.php';
}
function tfwctool_wishlist_page(){
    if (!current_user_can('manage_options')) {
        return;
    }
    include_once TFWCTOOL_ADMIN_DIR . 'option-pages/wishlist-options.php';
}