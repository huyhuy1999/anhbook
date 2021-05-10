<?php

if(!function_exists('saleszone_add_theme_support')){
    function saleszone_add_theme_support(){
        /**
         * Allows to add images to posts
         */
        add_theme_support('post-thumbnails');

        /**
         * Output theme logo
         */
        add_theme_support('custom-logo');

        /**
         * Declare support for title theme feature
         */
        add_theme_support( 'title-tag' );

        add_theme_support( 'automatic-feed-links' );

        /**
         * Navigation
         */
        register_nav_menu('header_nav', 'Header');
        if(saleszone_option('header_layout') == 'layout_3'){
            register_nav_menu('header_navbar', 'Header navbar');
        }
        register_nav_menu('mobile_nav', 'Mobile');
        register_nav_menu('mobile_nav_info', 'Mobile info');
        register_nav_menu('main_catalog_nav', 'Main Catalog');
        register_nav_menu('premmerce-catalog', 'Premmerce catalog shortcode');

        /**
         * Add support for HTML5
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'widgets',
        ));

        /**
         * Woocommerce
         */
        add_theme_support( 'woocommerce' );

        /**
         * Yoast SEO
         */
        add_theme_support('yoast-seo-breadcrumbs');
    }
}
add_action('after_setup_theme', 'saleszone_add_theme_support');