<?php

if(!function_exists('saleszone_tgmpa_config')){
    function saleszone_tgmpa_config(){
        $plugins = array(
            array(
                'name'     				=> 'WooCommerce',
                'slug'     				=> 'woocommerce',
                'required'              => false
            ),
            array(
                'name'     				=> 'Kirki Toolkit',
                'slug'     				=> 'kirki',
                'required'              => false
            ),
            array(
                'name'     				=> 'MetaSlider',
                'slug'     				=> 'ml-slider',
                'required'              => false
            ),
            array(
                'name'     				=> 'Premmerce WooCommerce Brands',
                'slug'     				=> 'premmerce-woocommerce-brands',
                'required'              => false
            ),
            array(
                'name'     				=> 'Woocommerce Frequently Bought Together',
                'slug'     				=> 'premmerce-woocommerce-product-bundles',
                'required'              => false
            ),
            array(
                'name'     				=> 'Premmerce WooCommerce Wishlist',
                'slug'     				=> 'premmerce-woocommerce-wishlist',
                'required'              => false
            ),
        );

        if(!saleszone_is_plugin_active('premmerce-premium/premmerce.php')){
            $plugins[] = array(
                'name'     				=> 'Premmerce',
                'slug'     				=> 'premmerce',
                'required'              => false
            );
        }

        if(!saleszone_is_plugin_active('premmerce-woocommerce-product-filter-premium/premmerce-filter.php')){
            $plugins[] = array(
                'name'     				=> 'Premmerce WooCommerce Product Filter',
                'slug'     				=> 'premmerce-woocommerce-product-filter',
                'required'              => false
            );
        }

        if(!saleszone_is_plugin_active('premmerce-search-premium/premmerce-search.php')){
            $plugins[] =             array(
                'name'     				=> 'Premmerce WooCommerce Product Search',
                'slug'     				=> 'premmerce-search',
                'required'              => false
            );
        }

        if(!saleszone_is_plugin_active('premmerce-woocommerce-variation-swatches-premium/premmerce-advanced-attributes.php')){
            $plugins[] =             array(
                'name'     				=> 'Premmerce WooCommerce Variation Swatches',
                'slug'     				=> 'premmerce-woocommerce-variation-swatches',
                'required'              => false
            );
        }
        
        $config = array(
            'is_automatic' => true,
            'parent_slug' => 'saleszone'
        );

        tgmpa( $plugins, $config );
    }
}
add_action('tgmpa_register', 'saleszone_tgmpa_config');