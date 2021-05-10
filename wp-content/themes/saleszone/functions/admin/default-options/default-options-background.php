<?php

if (!function_exists('saleszone_default_options_background')) {
    function saleszone_default_options_background($option_name = false)
    {

        $background_settings = apply_filters('saleszone_default_options_background',array(
            array(
                'name' => 'body_background_setting',
                'default' => array(
                    'background-color'      => '#fdfdfd',
                    'background-image'      => '',
                    'background-repeat'     => 'repeat',
                    'background-position'   => 'center center',
                    'background-size'       => 'cover',
                    'background-attachment' => 'scroll',
                )
            ),
            array(
                'name' => 'footer_background_setting',
                'default' => array(
                    'background-color'      => '#f2f6f9',
                    'background-image'      => '',
                    'background-repeat'     => 'repeat',
                    'background-position'   => 'center center',
                    'background-size'       => 'cover',
                    'background-attachment' => 'scroll',
                )
            ),
            array(
                'name' => 'header_background_setting',
                'default' => array(
                    'background-color'      => '#f2f6f9',
                    'background-image'      => '',
                    'background-repeat'     => 'repeat',
                    'background-position'   => 'center center',
                    'background-size'       => 'cover',
                    'background-attachment' => 'scroll',
                )
            )
        ));

        if($option_name != false) {
            foreach ($background_settings as $setting){
                if($setting['name'] == $option_name){
                    return $setting;
                }
            }
        }

    }
}