<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

/**
 * after_setup_theme
 */
add_action( 'after_setup_theme', 'saleszone_content_width' );
/**
 * Add editor styles
 */
add_action( 'current_screen', 'saleszone_add_editor_styles' );
/**
 * After body tab open
 */
add_action( 'premmerce_after_body_open', 'saleszone_render_css_variable_polifil' );
/**
 * Header
 */
add_action( 'premmerce_catalog_btn_menu', 'saleszone_render_catalog_btn_menu', 10 );
add_action( 'premmerce_after_header', 'saleszone_render_breadcrumb', 10 );
add_action( 'premmerce_header_search', 'saleszone_render_header_search', 10 );
/**
 * Archive sidebar
 */
add_action( 'premmerce_catalog_sidebar', 'saleszone_brand_sidebar_image', 10 );
add_action( 'premmerce_catalog_sidebar', 'saleszone_dynamic_catalog_sidebar', 20 );
/**
 * Archive sidebar
 */
add_action( 'premmerce-archive-products-layout-body-after-header', 'saleszone_render_premmerce_active_filters_widget' );
add_action( 'premmerce-archive-products-container-end', 'saleszone_render_archive_products_description_in_footer' );
/**
 * Subcategories sidebar
 */
add_action( 'premmerce_subcategories_sidebar', 'saleszone_dynamic_subcategories_sidebar' );
/**
 * Single product sidebar
 */
add_action( 'premmerce_product_sidebar', 'saleszone_dynamic_product_sidebar', 10 );
/**
 * Loop product
 */
require get_template_directory() . "/functions/hooks/loop-product.php";
/**
 * Wishlist
 */
global  $premmerce_wishlist_frontend ;

if ( isset( $premmerce_wishlist_frontend ) ) {
    remove_action( 'woocommerce_single_product_summary', array( $premmerce_wishlist_frontend, 'renderWishlistBtn' ), 35 );
    remove_action( 'woocommerce_after_shop_loop_item', array( $premmerce_wishlist_frontend, 'renderWishlistBtn' ) );
    remove_action( 'woocommerce_after_shop_loop_item', array( $premmerce_wishlist_frontend, 'renderWishListMoveBtn' ) );
    remove_action( 'woocommerce_before_shop_loop_item', array( $premmerce_wishlist_frontend, 'renderWishListDeleteBtn' ) );
    add_action( 'woocommerce_after_add_to_cart_button', 'saleszone_render_wishlist_product_button', 10 );
    add_action( 'premmerce_loop_product_cut_after_title', array( $premmerce_wishlist_frontend, 'renderWishListMoveBtn' ), 10 );
    add_action( 'premmerce_loop_product_cut_before_title_right', array( $premmerce_wishlist_frontend, 'renderWishListDeleteBtn' ), 10 );
}

/**
 * One click order
 */
global  $premmerce_oneclickorder_frontend ;

if ( isset( $premmerce_oneclickorder_frontend ) ) {
    remove_action( 'woocommerce_single_product_summary', array( $premmerce_oneclickorder_frontend, 'renderOneClickOrderBtn' ), 35 );
    remove_action( 'woocommerce_after_shop_loop_item', array( $premmerce_oneclickorder_frontend, 'renderOneClickOrderBtn' ), 35 );
    add_action( 'woocommerce_after_add_to_cart_button', array( $premmerce_oneclickorder_frontend, 'renderOneClickOrderBtn' ), 35 );
}

/**
 * Price spy
 */
global  $premmerce_price_spy ;

if ( isset( $premmerce_price_spy ) ) {
    remove_action( 'woocommerce_before_add_to_cart_form', array( $premmerce_price_spy, 'renderAddPriceSpy' ) );
    add_action( 'woocommerce_after_add_to_cart_button', array( $premmerce_price_spy, 'renderAddPriceSpy' ), 35 );
}

/**
 * Compare
 */
global  $premmerce_comparison_frontend ;

if ( isset( $premmerce_comparison_frontend ) ) {
    //Remove action from product
    remove_action( 'woocommerce_single_product_summary', array( $premmerce_comparison_frontend, 'renderComparisonBtn' ), 36 );
    //Remove action from archive product
    remove_action( 'woocommerce_after_shop_loop_item', array( $premmerce_comparison_frontend, 'renderComparisonBtn' ), 5 );
    add_action( 'woocommerce_after_add_to_cart_button', 'saleszone_render_compare_product_button', 10 );
}

/**
 * Found cheaper
 */
global  $premmerce_foundcheaper_frontend ;

if ( isset( $premmerce_foundcheaper_frontend ) ) {
    remove_action( 'woocommerce_before_add_to_cart_form', array( $premmerce_foundcheaper_frontend, 'renderFoundCheaperButton' ) );
    add_action( 'woocommerce_after_add_to_cart_button', array( $premmerce_foundcheaper_frontend, 'renderFoundCheaperButton' ) );
}

/**
 * Advanced attribute
 */
global  $premmerce_advanced_attributes_frontend ;

if ( isset( $premmerce_advanced_attributes_frontend ) ) {
    // remove from product meta
    remove_action( 'woocommerce_product_meta_start', array( $premmerce_advanced_attributes_frontend, 'registerSingleMainAttributes' ) );
    // remove from product loop
    remove_action( 'premmerce_render_main_loop_attributes', array( $premmerce_advanced_attributes_frontend, 'renderLoopMainAttributes' ) );
}

/**
 * Single product
 */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
add_action( 'woocommerce_before_single_product_summary', 'saleszone_render_product_labels', 15 );
add_action( 'premmerce_single_product_summary_popup_title', 'woocommerce_template_single_title', 5 );
add_action( 'premmerce_single_product_summary_popup_meta', 'woocommerce_template_single_meta', 10 );
add_action( 'premmerce_single_product_summary_header', 'woocommerce_template_single_title', 5 );
add_action( 'premmerce_single_product_summary_header', 'woocommerce_template_single_meta', 10 );
add_action( 'premmerce_single_product_summary_footer', 'saleszone_single_product_render_main_attributes', 5 );
add_action( 'premmerce_single_product_summary_footer', 'woocommerce_template_single_excerpt', 10 );
add_action( 'premmerce_single_product_summary_footer', 'woocommerce_template_single_sharing', 20 );
add_action( 'premmerce_single_product_summary_popup_footer', 'saleszone_single_product_render_main_attributes', 5 );
add_action( 'premmerce_single_product_summary_popup_footer', 'woocommerce_template_single_excerpt', 10 );
add_action( 'premmerce_single_product_summary_popup_footer', 'saleszone_template_single_more_link', 15 );
add_action( 'premmerce_single_product_summary_popup_footer', 'woocommerce_template_single_sharing', 20 );
add_action( 'woocommerce_product_meta_start', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 20 );
add_action( 'woocommerce_after_add_to_cart_button', 'saleszone_render_stock', 5 );
add_action( 'premmerce_add_to_cart_button', 'woocommerce_template_single_price', 5 );
add_action( 'premmerce_add_to_cart_button', 'woocommerce_single_variation_add_to_cart_button', 10 );
add_action( 'woocommerce_single_variation', 'saleszone_render_variation_info', 10 );
/**
 * Cart & Checkout
 */
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
add_action( 'woocommerce_after_shipping_rate', 'saleszone_render_shipping_method_description', 10 );
/**
 * Blog
 */
add_action( 'premmerce_blog_sidebar', 'saleszone_dynamic_blog_sidebar', 10 );
/**
 * Shordcodes products
 */
add_action( 'woocommerce_shortcode_before_products_loop', 'saleszone_render_before_product_shortcode', 10 );
add_action( 'woocommerce_shortcode_after_products_loop', 'saleszone_render_after_product_shortcode', 10 );
// on_sale
add_action( 'woocommerce_shortcode_before_sale_products_loop', 'saleszone_render_before_product_shortcode', 10 );
add_action( 'woocommerce_shortcode_after_sale_products_loop', 'saleszone_render_after_product_shortcode', 10 );
//best_selling
add_action( 'woocommerce_shortcode_before_best_selling_products_loop', 'saleszone_render_before_product_shortcode', 10 );
add_action( 'woocommerce_shortcode_after_best_selling_products_loop', 'saleszone_render_after_product_shortcode', 10 );
//top_rated
add_action( 'woocommerce_shortcode_before_top_rated_products_loop', 'saleszone_render_before_product_shortcode', 10 );
add_action( 'woocommerce_shortcode_after_top_rated_products_loop', 'saleszone_render_after_product_shortcode', 10 );
//featured_products
add_action( 'woocommerce_shortcode_before_featured_products_loop', 'saleszone_render_before_product_shortcode', 10 );
add_action( 'woocommerce_shortcode_after_featured_products_loop', 'saleszone_render_after_product_shortcode', 10 );
//recent_products
add_action( 'woocommerce_shortcode_before_recent_products_loop', 'saleszone_render_before_product_shortcode', 10 );
add_action( 'woocommerce_shortcode_after_recent_products_loop', 'saleszone_render_after_product_shortcode', 10 );
//product_attribute
add_action( 'woocommerce_shortcode_before_product_attribute_loop', 'saleszone_render_before_product_shortcode', 10 );
add_action( 'woocommerce_shortcode_after_product_attribute_loop', 'saleszone_render_after_product_shortcode', 10 );
/**
* Breadcrumbs.
*
* @see woocommerce_breadcrumb()
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
/**
 * Woocommerce checkout manager Fix broken favicon
 */

if ( function_exists( 'wooccm_photo_editor_content' ) ) {
    remove_action( 'wp_head', 'wooccm_photo_editor_content' );
    add_action( 'wp_footer', 'wooccm_photo_editor_content' );
}
