<?php

if(!function_exists('saleszone_custom_css')){
    function saleszone_custom_css()
    {
        ob_start();

        ?>
        <?php
        /*
         * Fix bug with disabled style block
         */
        if(is_customize_preview()) :?>
        <style data-customizer-css-required></style>
        <?php endif; ?>
        <style data-customizer-css type="text/css">

        :root {
            <?php saleszone_render_css_variables(); ?>
        }

        body {

            <?php if(!saleszone_option('disabled_google_fonts')):
            $font_config = get_theme_mod('typo_global', array('font-family'=> 'Open Sans','variant' => '700'))
            ?>
            font-family: <?php echo esc_html($font_config['font-family']); ?>  , sans-serif;
            <?php endif; ?>
        }

        <?php saleszone_render_bg_image_setting('footer_background_setting','.page__fgroup'); ?>
        <?php saleszone_render_bg_image_setting('header_background_setting','.page__hgroup'); ?>
        <?php saleszone_render_bg_image_setting('body_background_setting','.page'); ?>


        <?php if(get_theme_mod('site-page-width')) :?>
            .page__container{max-width: calc(<?php echo esc_html(get_theme_mod('site-page-width')); ?>px + 30px);}
        <?php endif;?>

        <?php if(get_theme_mod('site-content-width')) :?>
            .content__container,
            .start-page__container{max-width: calc(<?php echo esc_html(get_theme_mod('site-content-width')); ?>px + 30px);}
        <?php endif;?>

        <?php if(get_theme_mod('site-boxed-width')) :?>
            .page__boxed-layout{max-width: <?php echo esc_html(get_theme_mod('site-boxed-width')); ?>px;}
        <?php endif;?>

        .pc-header-phones__phone-title,
        .pc-header-phones-drop__phone-title{font-size:<?php echo esc_html(saleszone_option('header-phone-title-font-size')); ?>px;}

        <?php if(saleszone_option('logo-container-max-width')) :?>
        .site-logo{max-width: <?php echo esc_html(saleszone_option('logo-container-max-width')); ?>px;}
        <?php endif;?>

        <?php if(get_theme_mod('logo-padding')) :?>
        .site-logo__image{padding: <?php echo esc_html(get_theme_mod('logo-padding')); ?>px 0;}
        <?php endif;?>


        </style>
        <?php
        echo wp_kses(saleszone_minify_css(ob_get_clean()), array('style' => array('data-customizer-css-required' => true, 'data-customizer-css' => true , 'type' => true)));
    }
}