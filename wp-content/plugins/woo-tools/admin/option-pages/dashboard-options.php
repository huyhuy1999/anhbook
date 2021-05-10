<?php

 $modules_optins = get_option('woocommerce_tools_module_options');
 $modules = array(
 	array(
 		'id' => 'wishlist',
 		'icon' => TFWCTOOL_ADMIN_URI.'assets/images/wishlist-icon.png',
 		'name' => esc_html__('Wishlist', 'woocommerce-tools'),
 		'description' => esc_html__('Wishlist for WooCommerce', 'woocommerce-tools'),
 	),
 	array(
 		'id' => 'quickview',
 		'icon' => TFWCTOOL_ADMIN_URI.'assets/images/quickview-icon.png',
 		'name' => esc_html__('Quick View', 'woocommerce-tools'),
 		'description' => esc_html__('Quick View for WooCommerce Products', 'woocommerce-tools'),
 	),
 	array(
 		'id' => 'compare',
 		'icon' => TFWCTOOL_ADMIN_URI.'assets/images/compare-icon.png',
 		'name' => esc_html__('Compare', 'woocommerce-tools'),
 		'description' => esc_html__('Compare for WooCommerce Products', 'woocommerce-tools'),
 	)
 );
 
 $modules        = tfwc_tools_get_modules();

?><div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e('WooCommerce Toos Dashboard', 'woocommerce-tools') ?></h1>
	<div class="all-tools">
		<?php foreach ($modules as $key => $module): ?>
		<?php $checked = (isset($modules_optins[$module['id']]) && $modules_optins[$module['id']] == false)?false:true; ?>
		<div class="wctool-item">
			<div class="wctool-icon"><img src="<?php echo esc_url($module['icon']); ?>"></div>
			<label class="switch">
				<input type="checkbox" value="1" class="tfwctool-module-switch" id="<?php echo esc_attr($module['id']); ?>" <?php checked(true, $checked, true); ?>>
			 	<span class="slider"></span>
			</label>
			<h3 class="wctool-name"><?php echo esc_html($module['name']); ?></h3>
			<div class="clear"></div>
			<div class="wctool-desc"><?php echo esc_html($module['description']); ?></div>
		</div>
		<?php endforeach; ?>
	</div>
</div>