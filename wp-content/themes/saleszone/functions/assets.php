<?php

if(!function_exists('saleszone_enqueue_theme_assets')){
    function saleszone_enqueue_theme_assets(){
        $uri = get_template_directory_uri();
        $theme = wp_get_theme(get_template());
        $version = $theme->get( 'Version' );
        $file_prefix = ( SCRIPT_DEBUG ) ? '' : '.min';

        wp_enqueue_style("font-awesome", $uri . "/public/css/font-awesome.min.css",  array(), $version);
        // Add minified version version of magnific-popup
        wp_deregister_style('magnific-popup');
        wp_enqueue_style("magnific-popup", $uri . "/public/css/magnific-popup.min.css",  array(), $version);
        wp_enqueue_style("slick", $uri . "/public/css/slick.min.css",  array(), $version);

        wp_enqueue_style("saleszone-styles", $uri . "/public/css/styles.min.css",  array(), $version);

        /**
         * Jquery core libs
         */
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('jquery-ui-autocomplete');

        /**
         * Vendor libs
         */
        wp_enqueue_script("doubletaptogo", $uri . "/public/js/jquery.doubletaptogo" . $file_prefix . ".js",  array('jquery'), $version, true);
        wp_enqueue_script("lazyload", $uri . "/public/js/jquery.lazyload.js",  array('jquery'), $version, true);
        wp_enqueue_script("magnific-popup", $uri . "/public/js/jquery.magnific-popup" . $file_prefix . ".js",  array('jquery'), $version, true);
        wp_enqueue_script("jquery-zoom", $uri . "/public/js/jquery.zoom" . $file_prefix . ".js",  array('jquery'), $version, true);
        wp_enqueue_script("slick", $uri . "/public/js/slick" . $file_prefix . ".js",  array('jquery'), $version, true);
        wp_enqueue_script("svg4everybody", $uri . "/public/js/svg4everybody" . $file_prefix . ".js",  array('jquery'), $version, true);

        /**
         * SalesZone scripts
         */
        wp_enqueue_script("saleszone-scripts", $uri . "/public/js/scripts" . $file_prefix . ".js",  array('jquery','jquery-ui-core','jquery-ui-slider','doubletaptogo','lazyload','magnific-popup','jquery-zoom','slick','svg4everybody'), $version, true);
        wp_localize_script('saleszone-scripts','saleszoneLocalize', array(
            'tClose' => __('Close (Esc)','saleszone'),
            'tLoading' => __('Loading...','saleszone'),
            'tPrevious' => __('Previous (Left arrow key)','saleszone'),
            'tNext' => __('Next (Right arrow key)','saleszone'),
            /* translators: %curr% current image %total% images*/
            'tOf' => __('%curr% of %total%','saleszone')
        ));

        //jQuery Form Styler
        if(saleszone_option('product-variation-custom-select')){
            wp_enqueue_script("jQueryFormStyler", $uri . "/public/js/jquery.formstyler" . $file_prefix . ".js",  array('jquery'), $version, true);
            wp_localize_script('jQueryFormStyler','jQueryFormStyler', array(
                'isMobile' => wp_is_mobile(),
            ));
            wp_enqueue_style("jQueryFormStyler", $uri . "/public/css/jquery.formstyler.min.css",  array(), $version);
        }

        /**
         * Clean premmerce wishlist
         */
        wp_deregister_style('wishlist-style');

        /**
         * Clean premmerce filter
         */
        wp_deregister_style('premmerce_filter_style');

        /**
         * Clean WPML redundant scripts
         */
        wp_deregister_style('woocommerce_admin_styles');

        /**
         * Premmerce price spy
         */
        wp_deregister_style('price-spy-style');

    }
}
add_action('wp_enqueue_scripts', 'saleszone_enqueue_theme_assets');

/**
 * Clean premmerce-woocommerce-brands
 */
if(!function_exists('saleszone_clean_saleszone_brands_stylesheet')){
    function saleszone_clean_saleszone_brands_stylesheet(){
        wp_deregister_style('premmerce-brands');
    }
}
add_action('wp_enqueue_scripts', 'saleszone_clean_saleszone_brands_stylesheet',30);


/**
 * Disable Woocommerce default styles
 */
add_filter("woocommerce_enqueue_styles", "__return_empty_array");


/**
 * Include theme options style
 */
add_action('wp_head', 'saleszone_custom_css');