<?php

if ( !function_exists( 'saleszone_default_options' ) ) {
    function saleszone_default_options( $option )
    {
        $default_options = apply_filters( 'saleszone_default_options', array(
            'content_width'                          => 1440,
            'header_layout'                          => 'layout_1',
            'shop-search-placeholder'                => __( 'Search products', 'saleszone' ),
            'general_layout'                         => 'fluid',
            'catalog-mode'                           => 0,
            'footer-before'                          => '',
            'footer-copyright'                       => 'Copyright ©2018, SalesZone – Demo Store, It is a premmerce demo store. Powered by <a href="https://premmerce.com/" target="_blank">Premmerce</a>',
            'footer-copyright-secondary'             => '',
            'payment-icons'                          => array(
            'amex',
            'liqpay',
            'mastercard',
            'paypal',
            'privatbank',
            'visa'
        ),
            'disabled_google_fonts'                  => 1,
            'footer_columns'                         => '4',
            'footer_1'                               => 1,
            'footer_2'                               => 1,
            'category-product-add-to-cart-btn'       => 'only-button',
            'category-product-view'                  => 'grid',
            'category-product-quick-view'            => 0,
            'category-product-action-counter'        => 0,
            'category-product-variations'            => 1,
            'category-product-short-description'     => 1,
            'category-product-attributes'            => 1,
            'category-product-flipper'               => 0,
            'category-product-flipper-animation'     => 'normal',
            'category-product-lazyload'              => 0,
            'category-product-lazyload-spinner'      => 1,
            'category-product-display-stock'         => 0,
            'category-product-ajax-change-variation' => 1,
            'category-load-more'                     => 0,
            'category-active-filter'                 => 1,
            'category-btn-add-to-cart-icon'          => 1,
            'category-show-description-on-top'       => 0,
            'category-show-hide-bth-for-description' => 0,
            'shop-category-per-page'                 => 12,
            'shop-category-per-row'                  => '4',
            'product-action-counter'                 => 0,
            'product-variation-custom-select'        => 0,
            'product-sidebar'                        => 1,
            'product-main-attributes'                => 0,
            'product-tabs-type'                      => 'no-tabs',
            'product-thumbnails-type'                => 'simple',
            'product-btn-add-to-cart-icon'           => 1,
            'checkout-billing-form-fields-list'      => 'full',
            'header-main-menu-type'                  => 'tree',
            'add-to-cart-icon'                       => 'cart',
            'header-phone'                           => '',
            'header-phone-title'                     => __( 'Call us', 'saleszone' ),
            'header-phone-display-type'              => 'list',
            'header-phone-show-icon'                 => 1,
            'header-phone-icon-style'                => 'phone-big',
            'header-phone-icon-size'                 => 32,
            'header-phone-attr-tel'                  => 1,
            'header-phone-font-size'                 => 14,
            'header-phone-title-font-size'           => 12,
            'logo-slogan'                            => 0,
            'logo-container-max-width'               => 300,
        ) );
        if ( !empty($default_options[$option]) ) {
            return $default_options[$option];
        }
    }

}