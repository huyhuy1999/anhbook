<?php
if (!defined('ABSPATH')) {
	exit;
}

$modules        = tfwc_tools_get_modules();
$modules_optins = get_option('woocommerce_tools_module_options');
foreach ($modules as $keu => $module) {
	$file_name   = TFWCTOOL_DIR . 'modules/' . $module['slug'] . '/' . $module['slug'] . '-init.php';
	$option_name = $module['id'];
	if (!isset($modules_optins[$option_name]) || (isset($modules_optins[$option_name]) && $modules_optins[$option_name] != false)) {
		// if (file_exists($file_name)) {
			require_once $file_name;
		// }
	}
}

/*require_once TFWCTOOL_DIR.'modules/wishlist/wishlist-init.php';
require_once TFWCTOOL_DIR.'modules/quick-view/quick-view-init.php';
require_once TFWCTOOL_DIR.'modules/compare/compare-init.php';
require_once TFWCTOOL_DIR.'modules/ajax-search/ajax-search-init.php';
require_once TFWCTOOL_DIR.'modules/floating-cart/floating-init.php';
require_once TFWCTOOL_DIR.'modules/smart-variation-swatches/smart-variation-swatches-init.php';
require_once TFWCTOOL_DIR.'modules/checkout-field-manager/checkout-field-manager-init.php';*/
