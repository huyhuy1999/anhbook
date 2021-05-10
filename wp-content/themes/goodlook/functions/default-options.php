<?php

/**
 * Set theme default options
 * Override SalesZone default options
 */
add_filter('saleszone_default_options', 'goodlook_filter_default_options');

function goodlook_filter_default_options($default_options){

    $theme_options = array(
        'content_width' => 1230,
        'header_layout' => 'layout_4',
        'footer_columns' => '4',
        'shop-category-per-row' => '3',
        'category-product-add-to-cart-btn' => 'only-button',
        'category-product-short-description' => false,
        'category-product-attributes' => false,
        'product-tabs-type' => 'tabs',
        'product-sidebar' => 0,
        'product-thumbnails-type' => 'slides',
        'add-to-cart-icon' => 'shopping-cart',
        'category-btn-add-to-cart-icon' => 1,
        'product-btn-add-to-cart-icon' => 1,
        'header-phone-title'     => '',
        'header-phone-icon-style'     => 'phone-fill',
        'header-phone-display-type' => 'list-horizontal',
        'header-phone-icon-size' => '13'
    );

    return array_merge($default_options,$theme_options);
}

/**
 * Override theme backgounds
 *
 */

add_filter('saleszone_default_options_background', 'goodlook_filter_default_options_background');

function goodlook_filter_default_options_background($background_settings){
    $theme_background_settings = array();

    foreach ($background_settings as $background_setting){
        switch ($background_setting['name']){
            case 'body_background_setting':
                $background_setting['default']['background-color'] = '#ffffff';
                break;
            case 'footer_background_setting':
                $background_setting['default']['background-color'] = '#272727';
                break;
            case 'header_background_setting':
                $background_setting['default']['background-color'] = '#ffffff';
                break;
        }
        $theme_background_settings[] = $background_setting;
    }
    return $theme_background_settings;
}

/**
 * Override theme colors
 */
add_filter('saleszone_default_options_css_variables', 'filter_saleszone_default_options_css_variables' , 10);

function filter_saleszone_default_options_css_variables($saleszone_css_variables){
    $override_variables = array(
        // FOOTER
        'footer-aside-bg-color' => '#272727', // original
        'footer-text-color' => '#9a9a9a',
        'footer-title-color' => '#ffffff',
        'footer-link-color' => '#9a9a9a',
        'footer-link-color-hover' => '#c89347',
        'footer-border-color' => '#272727',
        'footer-social-links-color' => '#9a9a9a',
        'footer-social-links-color-hover' => '#474747',

        //Basement
        'basement-text-color' => '#9a9a9a',
        'basement-link-color' => '#9a9a9a',
        'basement-link-color-hover' => '#e8ba78',
        'basement-bg-color' => '#272727',
        'basement-border-color' => '#3c3c3c',

        //Headline
        'headline-text-color' => '#9a9a9a',
        'headline-link-color' => '#ffffff',
        'headline-link-color-hover' => '#C89347',
        'headline-bg-color' => '#272727',
        'headline-border-top-color' => '#272727',
        'headline-border-color' => '#272727',
        'headline-icon-color' => '#ffffff',
        'headline-panel-item-bg' => '#272727',
        'headline-panel-item-bg-hover' => '#272727',

        //Header phone
        'header-phone-color' => '#000000',
        'header-phone-icon-color' => '#000000',

        //Header
        'header-border-bottom-color' => '#D9D9D9',
        'header-icon-color' => '#272727',
        'header-text-color' => '#888888',
        'header-link-color' => '#C89347',
        'header-link-color-hover' => '#885A19',
        'header-search-btn-bg' => '#ffffff',
        'header-bottom-bg-color' => '#ffffff',

        //Main navigation
        'main-nav-bg-color' => '#ffffff',
        'main-nav-bg-color-hover' => '#272727',
        'main-nav-bg-color-active' => '#ffffff',
        'main-nav-text-color' => '#000000',
        'main-nav-text-color-hover' => '#ffffff',
        'header-catalog-btn' => '#C89347',

        //Off-Canvas Menu
        'off-canvas-hamburger-color' => '#272727',
        'off-canvas-bg-color' => '#272727',
        'off-canvas-border-color' => '#3C3C3C',
        'off-canvas-link-color' => '#ffffff',
        'off-canvas-link-hover-bg' => '#C89347',
        'off-canvas-heading-bg' => '#C89347',
        'off-canvas-heading-color' => '#ffffff',

        // Body links
        'base-main-link-color' => '#C89347',
        'base-main-link-hover-color' => '#885A19',

        // Body buttons
        'btn-primary-color' => '#ffffff',
        'btn-primary-hover-color' => '#ffffff',
        'btn-primary-bg' => '#c89347',
        'btn-primary-hover-bg' => '#a97933',
        'btn-primary-border' => '#c89347',
        'btn-primary-hover-border' => '#a27330',
        'btn-default-color' => '#ffffff',
        'btn-default-hover-color' => '#ffffff',
        'btn-default-bg' => '#272727',
        'btn-default-hover-bg' => '#808080',
        'btn-default-border' => '#272727',
        'btn-default-hover-border' => '#272727',

        // Panels
        'panels-bg-color' => '#efefef',
        'panels-heading-color' => '#000000',
        'panels-text-color' => '#888888',

        // Message
        'message-success-color' => '#dff0d8',
        'message-success-border' => '#dff0d8',
        'message-error-color' => '#ffefe8',
        'message-error-border' => '#e89b88',
        'message-info-color' => '#fcf8e3',
        'message-info-border' => '#efe4ae',

        // Other
        'theme-main-color' => '#272727',
        'theme-secondary-color' => '#c89347',
        'base-font-color' => '#888888',
        'base-font-color-secondary' => '#9a9a9a',
        'base-border-color' => '#d9d9d9',
        'second-border-color' => '#d9d9d9',
        'star-rating-color' => '#ffb300',
        'star-empty-color' => '#ffb300',
        'theme-main-bg-color' => '#fff',


        // Form controls
        'form-conrols-border-color' => '#d9d9d9',
        'form-conrols-box-shadow' => 'rgba(200,147,71,.6)',

        // Shop
        'product-price-color' => '#272727',
        'product-old-price-color' => '#d52b1e',
        'product-price-bg-color' => 'transparent',

        // hidden for user
        'base-box-shadow-color' => 'rgba(0, 0, 0, 0.15)',

    );

    $new_variables = array(
        array(
            'name' => 'theme-main-bg-color',
            'data' => array(
                'default' => '#fff',
                'type'  => 'other',
                'label' => __('Main background color','goodlook')
            )
        )
    );

    $goodlook_css_variable = array();

    foreach ($saleszone_css_variables as $variable_config){
        $current_variable = $variable_config;

        $variable_name = $current_variable['name'];

        if(array_key_exists($variable_name, $override_variables)){
            $current_variable['data']['default'] = $override_variables[$variable_name];
        }

        $goodlook_css_variable[] = $current_variable;
    }


    return array_merge($goodlook_css_variable, $new_variables);
}