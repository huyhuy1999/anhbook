<?php

/**
 * Remove and add theme hooks
 */
add_action('init', 'goodlook_Init');
function goodlook_Init(){

    /**
     * Loop product. Grid view
     */

    /** Removes rating and adds brand link */
    remove_action('premmerce_loop_product_cut_before_title', 'woocommerce_template_loop_rating', 20);
    add_action('premmerce_loop_product_cut_title', 'goodlook_get_brand_link', 5);

    if(function_exists('saleszone_quick_view_button')){
        remove_action('premmerce_loop_product_cut_before_title_right',  'saleszone_quick_view_button', 20);
        add_action('premmerce_loop_product_cut_before_title',  'saleszone_quick_view_button', 5);
    }

    /** Moves wishlist move link*/
    global $premmerce_wishlist_frontend;
    remove_action('premmerce_loop_product_cut_after_title', array($premmerce_wishlist_frontend, 'renderWishListMoveBtn'), 10);
    add_action('premmerce_loop_product_cut_action_row', array($premmerce_wishlist_frontend, 'renderWishListMoveBtn'), 10);

    /** List view */

    /** Moves wishlist link*/
    remove_action('premmerce_loop_product_snippet_action_row', 'saleszone_render_wishlist_catalog_button_snippet', 50);
    add_action('premmerce_loop_product_snippet_action_row', 'saleszone_render_wishlist_catalog_button', 10);

    /**
     * Catalog
     */

    /** Changes layou */
    add_action('woocommerce_before_template_part','goodlook_catalog_title');

    /**
     * Category and brand custom header and footer
     */

    remove_action('premmerce_catalog_sidebar', 'saleszone_brand_sidebar_image', 10);
    remove_action('premmerce-archive-products-container-end','saleszone_render_archive_products_description');
    add_action('premmerce-archive-products-layout-body-after-header','goodlook_render_catalog_header_brand', 10);
    //adds custom description
    add_action('premmerce-archive-products-layout-body-end','goodlook_catalog_footer');


    /**
     * Product page
     */

    /** Adds brand link before title and remove from meta tags */
    add_action('premmerce_single_product_summary_header', 'goodlook_get_brand_link', 1);


    /** Moves price from buy button */
    remove_action('premmerce_add_to_cart_button','woocommerce_template_single_price', 5);
    add_action('woocommerce_before_add_to_cart_form', 'woocommerce_template_single_price', 5);

    /** Removes exerpt */
    remove_action('premmerce_single_product_summary_footer', 'woocommerce_template_single_excerpt', 10);

    /** Move wishlist and compare into after buy button*/
    remove_action('woocommerce_after_add_to_cart_button','saleszone_render_wishlist_product_button', 10);
    add_action('premmerce_add_to_cart_button', 'saleszone_render_wishlist_product_button', 15);

    /**
     * Compare
     */
    global $premmerce_comparison_frontend;
    if(isset($premmerce_comparison_frontend)){
        remove_action('woocommerce_after_add_to_cart_button', 'saleszone_render_compare_product_button', 10);
        add_action('premmerce_add_to_cart_button', 'saleszone_render_compare_catalog_button', 15);
    }

    /** Move tabs after product summary*/
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 20);
    add_action('premmerce_single_product_summary_footer', 'woocommerce_output_product_data_tabs', 30);

    /**
     * Display up sells "Accessories" after product summary
     */
    add_action('woocommerce_after_single_product_summary','goodlook_upsell_display');

    /**
     * Quick view actions
     */

    /** Shows product attributes instead of exerpt */
    remove_action('premmerce_single_product_summary_popup_footer', 'woocommerce_template_single_excerpt', 10);
    add_action('premmerce_single_product_summary_popup_footer', 'goodlook_single_product_add_info', 10);

    /** Removes meta tags and adds only brand link and sku */
    remove_action('premmerce_single_product_summary_popup_meta', 'woocommerce_template_single_meta', 10);
    add_action('premmerce_single_product_summary_popup_meta', 'goodlook_get_brand_link', 10);
    add_action('premmerce_single_product_summary_popup_meta', 'goodlook_single_product_get_sku', 10);


    /**
     * Cart product brand option item
     */

    add_action('premmerce_cart_product_info_end', 'goodlook_cart_get_brand_link');
}