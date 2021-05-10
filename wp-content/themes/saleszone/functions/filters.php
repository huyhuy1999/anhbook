<?php
/**
 * Theme filters
 */

add_filter('the_content_more_link', 'saleszone_filter_the_content_more_link');


add_filter('woocommerce_add_to_cart_fragments', 'saleszone_filter_woocommerce_add_to_cart_fragments');

add_filter('woocommerce_update_order_review_fragments', 'saleszone_filter_woocommerce_update_order_review_fragments');

/**
 * Do not output empty stock availability if "woocommerce_manage_stock" option is true
 */
add_filter('woocommerce_get_availability', 'saleszone_filter_woocommerce_get_availability', 80, 2);

add_filter('woocommerce_output_related_products_args', 'saleszone_filter_woocommerce_output_related_products_args', 80);

add_filter('woocommerce_upsell_display_args', 'saleszone_filter_woocommerce_upsell_display_args', 80);

/**
 * Add product cart status to get_available_variation data
 */
add_filter('woocommerce_available_variation', 'saleszone_filter_woocommerce_available_variation', 80, 3);

/**
 * Trim zeros in price
 */
add_filter('woocommerce_price_trim_zeros', '__return_true');

/**
 * Remove Clear link in product variations
 */
add_filter('woocommerce_reset_variations_link', '__return_false');

/**
 * Single product tabs titles
 */
add_filter('woocommerce_product_additional_information_tab_title', 'saleszone_filter_woocommerce_product_additional_information_tab_title');

add_filter('woocommerce_product_tabs', 'saleszone_filter_woocommerce_product_tabs');

/**
 * Checkout
 */

add_filter('woocommerce_checkout_must_be_logged_in_message', 'saleszone_filter_woocommerce_checkout_must_be_logged_in_message');

add_filter('woocommerce_update_order_review_fragments', 'saleszone_filter_woocommerce_update_order_review_fragments');

add_filter('woocommerce_form_field_args', 'saleszone_filter_woocommerce_form_field_args_checkout', 10, 2);

/**
 * Ability to add custom attributes to variation select element
 */
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'saleszone_filter_woocommerce_dropdown_variation_attribute_options_html', 10, 2);

/**
 * Running shortcode on html widget
 */
add_filter('widget_text', 'do_shortcode');


/**
 * Setting for excerpt in premmerce recent post widget
 */
add_filter('excerpt_length', 'saleszone_filter_excerpt_length');
add_filter('excerpt_more', 'saleszone_filter_excerpt_more');


/**
 * Shortcodes
 * Adding custom attributes to product shortcodes
 */
add_filter('shortcode_atts_products','saleszone_filter_shortcode_products_attrs', 10, 3);
add_filter('shortcode_atts_sale_products','saleszone_filter_shortcode_products_attrs', 10, 3);
add_filter('shortcode_atts_best_selling_products','saleszone_filter_shortcode_products_attrs', 10, 3);
add_filter('shortcode_atts_top_rated_products','saleszone_filter_shortcode_products_attrs', 10, 3);
add_filter('shortcode_atts_featured_products','saleszone_filter_shortcode_products_attrs', 10, 3);
add_filter('shortcode_atts_recent_products','saleszone_filter_shortcode_products_attrs', 10, 3);
add_filter('shortcode_atts_product_attribute','saleszone_filter_shortcode_products_attrs', 10, 3);


/**
 * Products per page
 */
add_filter('loop_shop_per_page', 'saleszone_filter_loop_shop_per_page');

/**
 * Remove unnecessary billing form filed.
 * Working only if woo checkout manager is disabled
 */
add_filter('woocommerce_checkout_fields', 'saleszone_filter_woocommerce_checkout_fields', 30);


/**
 * Prevent unexpected product categories appearance. Subcategories are handling in archive-product.page
 */
remove_filter('woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories');

/**
 * Catalog mode , remove my account orders and downloads link
 */

add_filter('woocommerce_account_menu_items', 'saleszone_filter_woocommerce_account_menu_items');

/**
 * Transform link pages link html
 */
add_filter('wp_link_pages_link', 'saleszone_filter_wp_link_pages_link');

/**
 * Hide after header section if using header-layout_5
 */
add_filter('saleszone_display_after_header', 'saleszone_filter_saleszone_display_after_header', 10);

add_filter('premmerce_catalog_btn_drop', 'saleszone_filter_saleszone_catalog_btn_drop', 10);

/**
 * Change woocommerce currency symbol
 */
add_filter('woocommerce_currency_symbol', 'saleszone_filter_woocommerce_currency_symbol', 10, 2);

/**
 * Loop product button add to cart add class single_add_to_cart_button
 */
add_filter('woocommerce_loop_add_to_cart_args', 'saleszone_filter_woocommerce_loop_add_to_cart_args');

/**
 * Woocommerce variations
 */
add_filter('woocommerce_dropdown_variation_attribute_options_args', 'saleszone_filter_woocommerce_variations_args');

/**
 * Product gallery
 * Use main image for variation
 */
add_filter('woocommerce_gallery_image_size', 'saleszone_woocommerce_gallery_image_size');

add_filter('woocommerce_form_field_args', 'saleszone_add_form_fields_class', 10);

// Force show one click button in modal
add_filter('premmerce_buy_now_catalog_show_button', '__return_true');

//Remove kirki telemetry admin notice
add_filter( 'kirki_telemetry', '__return_false' );