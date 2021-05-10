<?php

if (!function_exists('goodlook_filter_premmerce_homepage_footer_seo_text')) {
    function goodlook_filter_premmerce_homepage_footer_seo_text()
    {
        return false;
    }
}

if (!function_exists('goodlook_filter_premmerce_svg_icon_new')) {
    function goodlook_filter_premmerce_svg_icon_new()
    {
        return array(
            'html' => ''
        );
    }
}

if (!function_exists('goodlook_add_svg_icon_filter')) {
    function goodlook_add_svg_icon_filter($data, $icon_name){
        return array(
            'html' => goodlook_theme_get_svg($icon_name, $data['class']),
            'class' => $data['class']
        );
    }
}

if (!function_exists('goodlook_filter_saleszone_quantity_input_type')) {
    function goodlook_filter_saleszone_quantity_input_type()
    {
        return 'number';
    }
}

if (!function_exists('goodlook_filter_product_photo_data_slider_slides')) {
    function goodlook_filter_product_photo_data_slider_slides()
    {
        return '4,3,3,4';
    }
}

if (!function_exists('goodlook_filter_woocommerce_product_tabs')) {
    function goodlook_filter_woocommerce_product_tabs($tabs)
    {
        unset($tabs['accessories']);

        return $tabs;
    }
}

if (!function_exists('goodlook_filter_premmerce_demo_data_presets')) {
    function goodlook_filter_premmerce_demo_data_presets()
    {
        return array('Demo en'  => 'https://goodlook-free.premmerce.com/wp-content/uploads/demodata.json');
    }
}

if (!function_exists('goodlook_filter_premmerce_demo_site_url')) {
    function goodlook_filter_premmerce_demo_site_url()
    {
        return 'https://goodlook-free.premmerce.com/';
    }
}

if (!function_exists('goodlook_filter_premmerce_rate_theme_url')) {
    function goodlook_filter_premmerce_rate_theme_url()
    {
        return 'https://wordpress.org/themes/goodlook/';
    }
}