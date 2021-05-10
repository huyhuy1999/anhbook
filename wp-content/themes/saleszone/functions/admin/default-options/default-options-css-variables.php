<?php

if (!function_exists('saleszone_default_options_css_variables')) {
    function saleszone_default_options_css_variables($type = false)
    {
        $css_variables = apply_filters('saleszone_default_options_css_variables',array(
            // FOOTER
            array(
                'name' => 'footer-text-color',
                'data' => array(
                    'default' => '#9aa1ab',
                    'type'  => 'footer',
                    'label' => __('Text color','saleszone')
               )
           ),
            array(
                'name' => 'footer-title-color',
                'data' => array(
                    'default' => '#000000',
                    'type'  => 'footer',
                    'label' => __('Heading color','saleszone')
               )
           ),
            array(
                'name' => 'footer-link-color',
                'data' => array(
                    'default' => '#666666',
                    'type'  => 'footer',
                    'label' => __('Links color','saleszone')
               )
           ),
            array(
                'name' => 'footer-link-color-hover',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'footer',
                    'label' => __('Links hover color','saleszone')
               )
           ),
            array(
                'name' => 'footer-border-color',
                'data' => array(
                    'default' => '#dfe4eb',
                    'type'  => 'footer',
                    'label' => __('Border color','saleszone')
               )
           ),
            array(
                'name' => 'footer-social-links-color',
                'data' => array(
                    'default' => '#487ebb',
                    'type'  => 'footer',
                    'label' => __('Social icons color','saleszone')
               )
           ),
            array(
                'name' => 'footer-social-links-color-hover',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'footer',
                    'label' => __('Social icons hover color','saleszone')
               )
           ),

            //Basement
            array(
                'name' => 'basement-text-color',
                'data' => array(
                    'default' => '#9aa1ab',
                    'type'  => 'basement',
                    'label' => __('Text color','saleszone')
               )
           ),
            array(
                'name' => 'basement-link-color',
                'data' => array(
                    'default' => '#666666',
                    'type'  => 'basement',
                    'label' => __('Link color','saleszone')
               )
           ),
            array(
                'name' => 'basement-link-color-hover',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'basement',
                    'label' => __('Link hover color','saleszone')
               )
           ),
            array(
                'name' => 'basement-bg-color',
                'data' => array(
                    'default' => '#f2f6f9',
                    'type'  => 'basement',
                    'label' => __('Background color','saleszone')
               )
           ),
            array(
                'name' => 'basement-border-color',
                'data' => array(
                    'default' => '#dfe4eb',
                    'type'  => 'basement',
                    'label' => __('Border color','saleszone')
               )
           ),

            //Headline
            array(
                'name' => 'headline-text-color',
                'data' => array(
                    'default' => '#9aa1ab',
                    'type'  => 'headline',
                    'label' => __('Text color','saleszone')

               )
           ),
            array(
                'name' => 'headline-link-color',
                'data' => array(
                    'default' => '#487ebb',
                    'type'  => 'headline',
                    'label' => __('Link color','saleszone')
               )
           ),
            array(
                'name' => 'headline-link-color-hover',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'headline',
                    'label' => __('Link hover color','saleszone')
               )
           ),
            array(
                'name' => 'headline-bg-color',
                'data' => array(
                    'default' => '#f2f6f9',
                    'type'  => 'headline',
                    'label' => __('Background color','saleszone')
               )
           ),
            array(
                'name' => 'headline-border-top-color',
                'data' => array(
                    'default' => '#5280b2',
                    'type'  => 'headline',
                    'label' => __('Border top color','saleszone')
               )
           ),
            array(
                'name' => 'headline-border-color',
                'data' => array(
                    'default' => '#dfe4eb',
                    'type'  => 'headline',
                    'label' => __('Border color','saleszone')
               )
           ),
            array(
                'name' => 'headline-icon-color',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'headline',
                    'label' => __('Icons color','saleszone')
               )
           ),
            array(
                'name' => 'headline-panel-item-bg',
                'data' => array(
                    'default' => '#f2f6f9',
                    'type'  => 'headline',
                    'label' => __('Headline panel item background','saleszone')
               )
           ),
            array(
                'name' => 'headline-panel-item-bg-hover',
                'data' => array(
                    'default' => '#ffffff',
                    'type'  => 'headline',
                    'label' => __('Headline panel item background hover','saleszone')
               )
           ),

            //Header phone
            array(
                'name' => 'header-phone-color',
                'data' => array(
                    'default' => '#000000',
                    'type'  => 'header-phone',
                    'label' => __('Phone number color','saleszone')
               )
           ),
            array(
                'name' => 'header-phone-icon-color',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'header-phone',
                    'label' => __('Phone icon color','saleszone')
               )
           ),

            //Header
            array(
                'name' => 'header-border-bottom-color',
                'data' => array(
                    'default' => '#dfe4eb',
                    'type'  => 'header-main',
                    'label' => __('Border bottom color','saleszone')
               )
           ),
            array(
                'name' => 'header-icon-color',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'header-main',
                    'label' => __('Icons color','saleszone')
               )
           ),
            array(
                'name' => 'header-text-color',
                'data' => array(
                    'default' => '#666666',
                    'type'  => 'header-main',
                    'label' => __('Text color','saleszone')
               )
           ),
            array(
                'name' => 'header-link-color',
                'data' => array(
                    'default' => '#487ebb',
                    'type'  => 'header-main',
                    'label' => __('Link color','saleszone')
               )
           ),
            array(
                'name' => 'header-link-color-hover',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'header-main',
                    'label' => __('Link hover color','saleszone')
               )
           ),
            array(
                'name' => 'header-bottom-bg-color',
                'data' => array(
                    'default' => 'rgba(0,0,0, 0.0)',
                    'type'  => 'header-bottom',
                    'label' => __('Header bottom background color','saleszone')
               )
           ),



            //Main navigation
            array(
                'name' => 'main-nav-bg-color',
                'data' => array(
                    'default' => '#5280b2',
                    'type'  => 'main-navigation',
                    'label' => __('Background color','saleszone')
               )
           ),
            array(
                'name' => 'main-nav-bg-color-hover',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'main-navigation',
                    'label' => __('Background hover color','saleszone')
               )
           ),
            array(
                'name' => 'main-nav-bg-color-active',
                'data' => array(
                    'default' => '#5b90ce',
                    'type'  => 'main-navigation',
                    'label' => __('Background active color','saleszone')
               )
           ),
            array(
                'name' => 'main-nav-text-color',
                'data' => array(
                    'default' => '#ffffff',
                    'type'  => 'main-navigation',
                    'label' => __('Text color','saleszone')
               )
           ),
            array(
                'name' => 'main-nav-text-color-hover',
                'data' => array(
                    'default' => '#ffffff',
                    'type'  => 'main-navigation',
                    'label' => __('Text hover color','saleszone')
               )
           ),
            array(
                'name' => 'header-catalog-btn',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'main-navigation',
                    'label' => __('Catalog button color','saleszone')
               )
           ),

            //Off-Canvas Menu
            array(
                'name' => 'off-canvas-hamburger-color',
                'data' => array(
                    'default' => '#000000',
                    'type'  => 'off-canvas',
                    'label' => __('Hamburger icon color','saleszone')
               )
           ),
            array(
                'name' => 'off-canvas-bg-color',
                'data' => array(
                    'default' => '#5280b2',
                    'type'  => 'off-canvas',
                    'label' => __('Menu background color','saleszone')
               )
           ),
            array(
                'name' => 'off-canvas-border-color',
                'data' => array(
                    'default' => '#6996c7',
                    'type'  => 'off-canvas',
                    'label' => __('Menu item border color','saleszone')
               )
           ),
            array(
                'name' => 'off-canvas-link-color',
                'data' => array(
                    'default' => '#ffffff',
                    'type'  => 'off-canvas',
                    'label' => __('Menu item text color','saleszone')
               )
           ),
            array(
                'name' => 'off-canvas-link-hover-bg',
                'data' => array(
                    'default' => '#4A6796',
                    'type'  => 'off-canvas',
                    'label' => __('Background hover color','saleszone')
               )
           ),
            array(
                'name' => 'off-canvas-heading-bg',
                'data' => array(
                    'default' => '#406791',
                    'type'  => 'off-canvas',
                    'label' => __('Heading background color','saleszone')
               )
           ),
            array(
                'name' => 'off-canvas-heading-color',
                'data' => array(
                    'default' => '#ffffff',
                    'type'  => 'off-canvas',
                    'label' => __('Heading text color','saleszone')
               )
           ),


            // Body links
            array(
                'name' => 'base-main-link-color',
                'data' => array(
                    'default' => '#487ebb;',
                    'type'  => 'links',
                    'label' => __('Theme link color','saleszone')
               )
           ),
            array(
                'name' => 'base-main-link-hover-color',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'links',
                    'label' => __('Theme link hover color','saleszone')
               )
           ),
            // Body buttons
            array(
                'name' => 'btn-primary-color',
                'data' => array(
                    'default' => '#ffffff',
                    'type'  => 'buttons',
                    'label' => __('Primary button color','saleszone')
               )
           ),
            array(
                'name' => 'btn-primary-hover-color',
                'data' => array(
                    'default' => '#ffffff',
                    'type'  => 'buttons',
                    'label' => __('Primary button hover color','saleszone')
               )
           ),
            array(
                'name' => 'btn-primary-bg',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'buttons',
                    'label' => __('Primary button background','saleszone')
               )
           ),
            array(
                'name' => 'btn-primary-hover-bg',
                'data' => array(
                    'default' => '#ff8810',
                    'type'  => 'buttons',
                    'label' => __('Primary button hover background','saleszone')
               )
           ),
            array(
                'name' => 'btn-primary-border',
                'data' => array(
                    'default' => '#e77300',
                    'type'  => 'buttons',
                    'label' => __('Primary button border','saleszone')
               )
           ),
            array(
                'name' => 'btn-primary-hover-border',
                'data' => array(
                    'default' => '#ff8810',
                    'type'  => 'buttons',
                    'label' => __('Primary button hover border','saleszone')
               )
           ),
            array(
                'name' => 'btn-default-color',
                'data' => array(
                    'default' => '#333333',
                    'type'  => 'buttons',
                    'label' => __('Default button color','saleszone')
               )
           ),
            array(
                'name' => 'btn-default-hover-color',
                'data' => array(
                    'default' => '#333333',
                    'type'  => 'buttons',
                    'label' => __('Default button hover color','saleszone')
               )
           ),
            array(
                'name' => 'btn-default-bg',
                'data' => array(
                    'default' => '#ecf1f6',
                    'type'  => 'buttons',
                    'label' => __('Default button background','saleszone')
               )
           ),
            array(
                'name' => 'btn-default-hover-bg',
                'data' => array(
                    'default' => '#ecf1f6',
                    'type'  => 'buttons',
                    'label' => __('Default button hover background','saleszone')
               )
           ),
            array(
                'name' => 'btn-default-border',
                'data' => array(
                    'default' => '#c8cfd9',
                    'type'  => 'buttons',
                    'label' => __('Default button border','saleszone')
               )
           ),
            array(
                'name' => 'btn-default-hover-border',
                'data' => array(
                    'default' => '#c8cfd9',
                    'type'  => 'buttons',
                    'label' => __('Default button hover border','saleszone')
               )
           ),
            array(
                'name' => 'btn-light-color',
                'data' => array(
                    'default' => '#ba9659',
                    'type'  => 'buttons',
                    'label' => __('Light button color','saleszone')
               )
           ),
            array(
                'name' => 'btn-light-hover-color',
                'data' => array(
                    'default' => '#ba9659',
                    'type'  => 'buttons',
                    'label' => __('Light button hover color','saleszone')
               )
           ),
            array(
                'name' => 'btn-light-bg',
                'data' => array(
                    'default' => '#fff8dd',
                    'type'  => 'buttons',
                    'label' => __('Light button background','saleszone')
               )
           ),
            array(
                'name' => 'btn-light-hover-bg',
                'data' => array(
                    'default' => '#fff8dd',
                    'type'  => 'buttons',
                    'label' => __('Light button hover background','saleszone')
               )
           ),
            array(
                'name' => 'btn-light-border',
                'data' => array(
                    'default' => '#eedbb2',
                    'type'  => 'buttons',
                    'label' => __('Light button border','saleszone')
               )
           ),

            // Panels
            array(
                'name' => 'panels-bg-color',
                'data' => array(
                    'default' => '#f2f6f9',
                    'type'  => 'panels',
                    'label' => __('Panels background color','saleszone')
               )
           ),
            array(
                'name' => 'panels-heading-color',
                'data' => array(
                    'default' => '#000000',
                    'type'  => 'panels',
                    'label' => __('Panels heading color','saleszone')
               )
           ),
            array(
                'name' => 'panels-text-color',
                'data' => array(
                    'default' => '#666666',
                    'type'  => 'panels',
                    'label' => __('Panel text color','saleszone')
               )
           ),

            // Message
            array(
                'name' => 'message-success-color',
                'data' => array(
                    'default' => '#dff0d8',
                    'type'  => 'message',
                    'label' => __('Message success color','saleszone')
               )
           ),
            array(
                'name' => 'message-success-border',
                'data' => array(
                    'default' => '#a3d48e',
                    'type'  => 'message',
                    'label' => __('Message success border color','saleszone')
               )
           ),
            array(
                'name' => 'message-error-color',
                'data' => array(
                    'default' => '#ffefe8',
                    'type'  => 'message',
                    'label' => __('Message error color','saleszone')
               )
           ),
            array(
                'name' => 'message-error-border',
                'data' => array(
                    'default' => '#e89b88',
                    'type'  => 'message',
                    'label' => __('Message error border color','saleszone')
               )
           ),
            array(
                'name' => 'message-info-color',
                'data' => array(
                    'default' => '#fcf8e3',
                    'type'  => 'message',
                    'label' => __('Message info color','saleszone')
               )
           ),
            array(
                'name' => 'message-info-border',
                'data' => array(
                    'default' => '#efe4ae',
                    'type'  => 'message',
                    'label' => __('Message info border color','saleszone')
               )
           ),

            // Other
            array(
                'name' => 'theme-main-color',
                'data' => array(
                    'default' => '#5280b2',
                    'type'  => 'other',
                    'label' => __('Theme main color','saleszone')
               )
           ),
            array(
                'name' => 'theme-secondary-color',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'other',
                    'label' => __('Theme secondary color','saleszone')
               )
           ),
            array(
                'name' => 'base-font-color',
                'data' => array(
                    'default' => '#666666',
                    'type'  => 'other',
                    'label' => __('Base site font color','saleszone')
               )
           ),
            array(
                'name' => 'base-font-color-secondary',
                'data' => array(
                    'default' => '#9aa1ab',
                    'type'  => 'other',
                    'label' => __('Secondary font color','saleszone')
               )
           ),
            array(
                'name' => 'base-border-color',
                'data' => array(
                    'default' => '#dfe4eb',
                    'type'  => 'other',
                    'label' => __('Base border color','saleszone')
               )
           ),
            array(
                'name' => 'star-rating-color',
                'data' => array(
                    'default' => '#ffb300',
                    'type'  => 'other',
                    'label' => __('Star rating color','saleszone')
               )
           ),
            array(
                'name' => 'star-empty-color',
                'data' => array(
                    'default' => 'rgba(255, 179, 0, 0.3)',
                    'type'  => 'other',
                    'label' => __('Star rating empty color','saleszone')
               )
           ),

            // Form controls
            array(
                'name' => 'form-conrols-border-color',
                'data' => array(
                    'default' => '#c8cfd9',
                    'type'  => 'form-controls',
                    'label' => __('Form controls border color','saleszone')
               )
           ),
            array(
                'name' => 'form-conrols-box-shadow',
                'data' => array(
                    'default' => 'rgba(102,175,233,.6)',
                    'type'  => 'form-controls',
                    'label' => __('Form controls focused border color','saleszone')
               )
           ),

            // Shop
            array(
                'name' => 'product-price-bg-color',
                'data' => array(
                    'default' => '#fff4c7',
                    'type'  => 'shop',
                    'label' => __('Product price background color','saleszone')
               )
           ),
            array(
                'name' => 'product-price-color',
                'data' => array(
                    'default' => '#000000',
                    'type'  => 'shop',
                    'label' => 'Product price color'
               )
           ),
            array(
                'name' => 'product-old-price-color',
                'data' => array(
                    'default' => '#ff8001',
                    'type'  => 'shop',
                    'label' => __('Product old price color','saleszone')
               )
           ),

            // hidden for user
            array(
                'name' => 'base-box-shadow-color',
                'data' => array(
                    'default' => 'rgba(0, 0, 0, 0.15)',
                    'type'  => 'hidden',
                    'label' => __('Product old price color','saleszone')
               )
           ),

       ));

        if($type != false){

            $result = array();

            foreach ($css_variables as $var){
                if($var['data']['type'] == $type){
                    $result[] = $var;
                }
            }

            return $result;

        } else {
            return $css_variables;
        }
    }
}