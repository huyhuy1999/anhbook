<?php

/**
 * Return svg icon from child theme
 */
if (!function_exists('goodlook_theme_get_svg')) {
    function goodlook_theme_get_svg($icon_name, $class = '')
    {
        return '<svg class="svg-icon '. $class .' "><use xlink:href="' . get_stylesheet_directory_uri() . '/public/svg/sprite.svg#svg-icon__'. $icon_name .'"></use></svg>';
    }
}