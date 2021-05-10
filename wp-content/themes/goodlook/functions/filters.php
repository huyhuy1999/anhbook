<?php

/**
 * Replace parent theme svg icons
 */
$replaced_icons = array(
    'heart',
    'star',
    'angle-left',
    'angle-right',
    'arrow-down',
    'arrow-big-right',
    'arrow-big-left',
    'calendar',
    'comment',
    'compare',
    'delete',
    'user',
    'move'
);

foreach ($replaced_icons as $icon_name){
    add_filter('premmerce-svg-icon--'. $icon_name, 'goodlook_add_svg_icon_filter' ,10,2);
}

/**
 * Removes seo text in footer
 */
add_filter('premmerce-homepage-footer-seo-text', 'goodlook_filter_premmerce_homepage_footer_seo_text');

/**
 * Remove product labels svg
 */

add_filter('premmerce-svg-icon--new', 'goodlook_filter_premmerce_svg_icon_new');

/**
 * Turns quantity input into number input
 */
add_filter('saleszone_quantity_input_type', 'goodlook_filter_saleszone_quantity_input_type');

add_filter('product-photo-data-slider-slides', 'goodlook_filter_product_photo_data_slider_slides');

/**
 * Remove tab accessories
 */
add_filter('woocommerce_product_tabs', 'goodlook_filter_woocommerce_product_tabs', 30);

add_filter('premmerce_demo_data_presets', 'goodlook_filter_premmerce_demo_data_presets', 10);


add_filter('premmerce_demo_site_url','goodlook_filter_premmerce_demo_site_url', 10);

add_filter('premmerce_rate_theme_url', 'goodlook_filter_premmerce_rate_theme_url', 10);