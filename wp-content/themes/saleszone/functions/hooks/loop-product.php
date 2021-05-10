<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

global  $premmerce_oneclickorder_frontend ;
/**
 * Removed default actions
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'premmerce_loop_product_cut_after', 'saleszone_render_loop_variations', 10 );
add_action( 'premmerce_loop_product_cut_before_title', 'saleszone_render_loop_product_image', 10 );
add_action( 'premmerce_loop_product_cut_before_title', 'saleszone_render_product_labels', 10 );
add_action( 'premmerce_loop_product_cut_before_title', 'woocommerce_template_loop_rating', 20 );
add_action( 'premmerce_loop_product_cut_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'premmerce_loop_product_cut_after_title', 'woocommerce_template_loop_price', 10 );
add_action( 'premmerce_loop_product_cut_after', 'saleszone_render_archive_stock', 8 );
add_action( 'premmerce_loop_product_cut_after', 'woocommerce_template_loop_add_to_cart', 20 );
add_action( 'premmerce_loop_product_cut_after', 'saleszone_render_product_actions', 25 );
add_action( 'premmerce_loop_product_cut_after', 'saleszone_template_loop_single_excerpt', 30 );
add_action( 'premmerce_loop_product_cut_after', 'saleszone_catalog_render_main_attributes', 40 );
add_action( 'premmerce_loop_product_cut_action_row', 'saleszone_render_wishlist_catalog_button', 10 );
add_action( 'premmerce_loop_product_cut_action_row', 'saleszone_render_compare_catalog_button', 10 );
if ( isset( $premmerce_oneclickorder_frontend ) ) {
    if ( has_action( 'woocommerce_after_shop_loop_item', array( $premmerce_oneclickorder_frontend, 'renderOneClickOrderBtn' ) ) ) {
        add_action( 'premmerce_loop_product_cut_action_row', array( $premmerce_oneclickorder_frontend, 'renderOneClickOrderBtn' ), 15 );
    }
}
/**
 * Snippet view
 */
add_action( 'premmerce_loop_product_snippet_left_col', 'saleszone_render_loop_product_image', 10 );
add_action( 'premmerce_loop_product_snippet_left_col', 'saleszone_render_product_labels', 10 );
add_action( 'premmerce_loop_product_snippet_center_col', 'woocommerce_template_loop_product_title', 10 );
add_action( 'premmerce_loop_product_snippet_center_col', 'woocommerce_template_single_meta', 20 );
add_action( 'premmerce_loop_product_snippet_center_col', 'saleszone_template_loop_single_excerpt', 30 );
add_action( 'premmerce_loop_product_snippet_center_col', 'saleszone_catalog_render_main_attributes', 40 );
add_action( 'premmerce_loop_product_snippet_right_col', 'saleszone_render_archive_stock', 10 );
add_action( 'premmerce_loop_product_snippet_right_col', 'woocommerce_template_loop_price', 20 );
add_action( 'premmerce_loop_product_snippet_right_col', 'saleszone_render_loop_variations', 30 );
add_action( 'premmerce_loop_product_snippet_right_col', 'woocommerce_template_loop_add_to_cart', 40 );
add_action( 'premmerce_loop_product_snippet_action_row', 'saleszone_render_wishlist_catalog_button_snippet', 50 );
add_action( 'premmerce_loop_product_snippet_action_row', 'saleszone_render_compare_catalog_button_snippet', 50 );
if ( isset( $premmerce_oneclickorder_frontend ) ) {
    if ( has_action( 'woocommerce_after_shop_loop_item', array( $premmerce_oneclickorder_frontend, 'renderOneClickOrderBtn' ) ) ) {
        add_action( 'premmerce_loop_product_snippet_action_row', array( $premmerce_oneclickorder_frontend, 'renderOneClickOrderBtn' ), 15 );
    }
}