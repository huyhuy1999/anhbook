<?php

if (!function_exists('saleszone_filter_the_content_more_link')) {
    function saleszone_filter_the_content_more_link()
    {
        return '<a class="more-link" href="' . get_permalink() . '">' . __('Read more', 'saleszone') . '</a>';
    }
}


if (!function_exists('saleszone_filter_woocommerce_add_to_cart_fragments')) {
    function saleszone_filter_woocommerce_add_to_cart_fragments($fragments)
    {

        /* Prevent unnecessary "update fragment" ajax request */
        $fragments['div.widget_shopping_cart_content'] = 'required';

        $new_fragments = array(
            '[data-cart-header-fragment]' => wc_get_template_html('cart/cart-header.php'),
            '[data-cart-modal-fragment]' => wc_get_template_html('cart/cart-modal.php'),
            '[data-cart-products-fragment]' => json_encode(saleszone_in_cart_items()),
            '[data-cart-frame-fragment]' => wc_get_template_html('cart/cart-frame.php'),
            '[data-wishlist-total-fragment]' => wc_get_template_html('../premmerce-woocommerce-wishlist/wishlist-total.php'),
            '[data-comparison-total-fragment]' => wc_get_template_html('../premmerce-product-comparison/comparison-total.php'),
            '[data-fragment-currency-switcher]' => wc_get_template_html('../parts/header/parts/header-woocommerce-currency-switcher.php'),
            '[data-premmerce-currency-switcher-fragment]' => wc_get_template_html('../parts/header/parts/header-premmerce-currency-switcher.php')
        );

        return array_merge($fragments, $new_fragments);
    }
}

if (!function_exists('saleszone_filter_woocommerce_update_order_review_fragments')) {
    function saleszone_filter_woocommerce_update_order_review_fragments($fragments)
    {
        $new_fragments = array(
            '[data-checkout-shipping-fragments]' => wc_get_template_html('checkout/shipping.php'),
        );

        return array_merge($fragments, $new_fragments);
    }
}

if (!function_exists('saleszone_filter_woocommerce_get_availability')) {
    function saleszone_filter_woocommerce_get_availability($result, $product)
    {
        if (get_option('woocommerce_manage_stock') == 'yes' && $result['availability'] == '') {
            $result['availability'] = __('In stock', 'saleszone');
        }
        return $result;
    }
}

if (!function_exists('saleszone_filter_woocommerce_output_related_products_args')) {
    function saleszone_filter_woocommerce_output_related_products_args()
    {
        return array(
            'posts_per_page' => 6,
            'orderby' => 'rand',
        );
    }
}

if (!function_exists('saleszone_filter_woocommerce_upsell_display_args')) {
    function saleszone_filter_woocommerce_upsell_display_args()
    {
        return array(
            'posts_per_page' => 6,
            'orderby' => 'rand',
        );
    }
}

if (!function_exists('saleszone_filter_woocommerce_available_variation')) {
    function saleszone_filter_woocommerce_available_variation($data, $product, $variation)
    {
        $data['in_cart'] = saleszone_in_cart($variation->get_ID());
        $data['variation_id'] = $variation->get_ID();
        $data['price_html'] = $variation->get_price_html();
        $data['image']['medium_src'] = wp_get_attachment_image_url($variation->get_image_id(), 'shop_catalog');
        $data['variation_name'] = $variation->get_name();
        $data['add_to_cart_text'] = __('Add to cart', 'saleszone');
        $data['add_to_cart_url'] = $variation->add_to_cart_url();
        $data['permalink'] = $variation->get_permalink();
        $data['end_date'] = wc_get_template_html('loop/sales-counter-loop.php', array(
            'id' => $variation->get_ID()
        ));
        $data['end_single_date'] = wc_get_template_html('single-product/sales-counter-single.php', array(
            'id' => $variation->get_ID()
        ));
        return $data;
    }
}

if (!function_exists('saleszone_filter_woocommerce_product_additional_information_tab_title')) {
    function saleszone_filter_woocommerce_product_additional_information_tab_title()
    {
        return __('Specifications', 'saleszone');
    }
}

if (!function_exists('saleszone_filter_woocommerce_product_tabs')) {
    function saleszone_filter_woocommerce_product_tabs($tabs)
    {
        global $product;

        $upsell_ids = $product->get_upsell_ids();

        if (!empty($upsell_ids)) {
            $tabs['accessories'] = array(
                'title' => __('Accessories', 'saleszone'),
                'priority' => 40,
                'callback' => 'woocommerce_upsell_display'
            );
        }
        return $tabs;
    }
}

if (!function_exists('saleszone_filter_woocommerce_checkout_must_be_logged_in_message')) {
    function saleszone_filter_woocommerce_checkout_must_be_logged_in_message($message)
    {
        return wc_get_template_html('notices/notice.php', array('messages' => array($message)));
    }
}

if (!function_exists('saleszone_filter_woocommerce_update_order_review_fragments')) {
    function saleszone_filter_woocommerce_update_order_review_fragments($fragments)
    {
        if (array_key_exists('form.woocommerce-checkout', $fragments)) {
            $fragments = array('form.woocommerce-checkout' => wc_get_template_html('cart/cart-empty.php'));
        }
        return $fragments;
    }
}

if (!function_exists('saleszone_filter_woocommerce_dropdown_variation_attribute_options_html')) {
    function saleszone_filter_woocommerce_dropdown_variation_attribute_options_html($html, $args)
    {

        if (empty($args['attributes'])) {
            return $html;
        }

        $attributes = '';
        foreach ($args['attributes'] as $key => $value) {
            $attributes .= ' ' . $key . '="' . $value . '"';
        }
        $html = str_replace('<select', '<select ' . trim($attributes) . ' ', $html);
        return $html;
    }
}

if (!function_exists('saleszone_filter_excerpt_length')) {
    function saleszone_filter_excerpt_length()
    {
        return 15;
    }
}

if (!function_exists('saleszone_filter_excerpt_more')) {
    function saleszone_filter_excerpt_more()
    {
        return '...';
    }
}

if (!function_exists('saleszone_filter_loop_shop_per_page')) {
    function saleszone_filter_loop_shop_per_page($items)
    {
        return (int) saleszone_option('shop-category-per-page');
    }
}

if (!function_exists('saleszone_filter_woocommerce_checkout_fields')) {
    function saleszone_filter_woocommerce_checkout_fields($fields)
    {

        if(saleszone_option('checkout-billing-form-fields-list') == 'short' && !function_exists('wooccm_get_woo_version')){
            unset($fields['billing']['billing_company']);
            unset($fields['billing']['billing_address_2']);
            unset($fields['billing']['billing_postcode']);
            unset($fields['billing']['billing_state']);
        }

        return $fields;
    }
}

if (!function_exists('saleszone_filter_woocommerce_account_menu_items')) {
    function saleszone_filter_woocommerce_account_menu_items($items)
    {
        if(saleszone_option('catalog-mode')){
            unset($items['orders']);
            unset($items['downloads']);
            unset($items['edit-address']);
        }

        return $items;

    }
}

if (!function_exists('saleszone_filter_wp_link_pages_link')) {
    function saleszone_filter_wp_link_pages_link($link)
    {
        if(strpos($link,'<a') !== false){
            $link = str_replace('<a','<a class="page-numbers"',$link);
        } else {
            $link = '<span class="page-numbers current">'. $link .'</span>';
        }

        return '<div class="pagination__item">' . $link . '</div>';
    }
}

if (!function_exists('saleszone_filter_saleszone_display_after_header')) {
    function saleszone_filter_saleszone_display_after_header()
    {
        if(saleszone_option('header_layout') == 'layout_5'){
            return false;
        }

        return true;
    }
}

if (!function_exists('saleszone_filter_saleszone_catalog_btn_drop')) {
    function saleszone_filter_saleszone_catalog_btn_drop()
    {
        if(saleszone_option('header_layout') == 'layout_5' && is_front_page()){
            return false;
        }

        return true;

    }
}

if (!function_exists('saleszone_filter_woocommerce_currency_symbol')) {
    function saleszone_filter_woocommerce_currency_symbol($currency_symbol, $currency)
    {
        switch ($currency) {

            case 'UAH':
                $currency_symbol = 'грн';
                break;
            case 'RUB':
                $currency_symbol = 'руб';
                break;
        }

        return $currency_symbol;
    }
}

if(!function_exists('saleszone_filter_woocommerce_loop_add_to_cart_args')){
    function saleszone_filter_woocommerce_loop_add_to_cart_args($args){
        $args['class'] .= ' single_add_to_cart_button';

        return $args;
    }
}

if(!function_exists('saleszone_filter_woocommerce_variations_args')){
    function saleszone_filter_woocommerce_variations_args($args){

        if(saleszone_option('product-variation-custom-select')){
            $args['attributes']['data-select-styler'] = '';
        }

        return $args;
    }
}

if(!function_exists('saleszone_filter_woocommerce_form_field_args_checkout')){
    function saleszone_filter_woocommerce_form_field_args_checkout($args, $key){

        if(is_checkout()){
            $args['class'][] = apply_filters('premmerce-checkout-filed-class', 'form__field--hor form__field--hor-lg');

            // Hide country field
            $shipping_countries  = WC()->countries->get_shipping_countries();
            if ( $key == 'billing_country' && saleszone_option('checkout-billing-form-fields-list') == 'short' && !function_exists('wooccm_get_woo_version') && count($shipping_countries) == 1){
                $args['class'][] = 'hidden';
            }

            if ( isset( $args['country_field'], $args[ $args['country_field'] ] ) ) {
                $args['country'] = $args->get_value( $args['country_field'] );
            }
        }

        return $args;
    }
}


if(!function_exists('saleszone_woocommerce_gallery_image_size')){
    function saleszone_woocommerce_gallery_image_size(){
        return true;
    }
}

if(!function_exists('saleszone_add_form_fields_class')){
    function saleszone_add_form_fields_class($args){
        $args['class'][] = 'form__field';
        $args['input_class'][] = 'form-control';

        // Fix php fatal error,  Uncaught Error: [] operator not supported for strings
        if(is_array($args['label_class'])){
            $args['label_class'][] = 'form__label';
        } elseif (is_string($args['label_class'])) {
            $args['label_class'] = 'form__label' . '' . $args['label_class'];
        }

        return $args;
    }
}