<?php

if (!function_exists('saleszone_get_img_alt')) {
    function saleszone_get_img_alt($imgId , $alternative)
    {
        $image_alt = get_post_meta($imgId, '_wp_attachment_image_alt', true );

        return $image_alt ? $image_alt : $alternative;
    }
}

if (!function_exists('saleszone_get_logo_src')) {
    function saleszone_get_logo_src()
    {
        $logoId   = get_theme_mod( 'custom_logo' );
        $imageSrc = wp_get_attachment_image_src( $logoId, 'full' );

        return $imageSrc[0];
    }
}

if(!function_exists('saleszone_svg_allowed_html')){
    function saleszone_svg_allowed_html(){
        $allowed_html = array(
            'span' => array(
                'class' => true
            ),
            'svg' => array(
                'class' => true
            ),
            'use' => array(
                'xlink:href' => true
            )
        );

        return $allowed_html;
    }
}

if (!function_exists('saleszone_get_svg')) {
    function saleszone_get_svg($icon_name, $class = '')
    {
        return wp_kses(saleszone_svg($icon_name, $class), saleszone_svg_allowed_html());
    }
}

if(!function_exists('saleszone_the_svg')){
    function saleszone_the_svg($icon_name, $class = ''){
        echo wp_kses(saleszone_svg($icon_name, $class), saleszone_svg_allowed_html());
    }
}

if(!function_exists('saleszone_svg')){
    function saleszone_svg($icon_name, $class = ''){

        $icon = apply_filters('premmerce-svg-icon--' . $icon_name, array(
            'class' => $class,
            'html' => '<svg class="svg-icon '. $class .' "><use xlink:href="' . get_template_directory_uri() . '/public/svg/sprite.svg#svg-icon__'. $icon_name .'"></use></svg>'
        ), $icon_name);

        return $icon['html'];
    }
}

if (!function_exists('saleszone_get_modal_url')) {
    function saleszone_get_modal_url($template)
    {
        return site_url(WC_AJAX::get_endpoint('saleszone_modal') . '&template=' . $template);
    }
}

if (!function_exists('theme_is_ajax')) {
    function saleszone_is_ajax()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower(sanitize_text_field(wp_unslash($_SERVER['HTTP_X_REQUESTED_WITH']))) == 'xmlhttprequest'){
            return true;
        }

        return false;
    }
}