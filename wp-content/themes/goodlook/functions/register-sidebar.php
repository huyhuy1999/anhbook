<?php

/**
 * Override SalesZone widgets area
 */

add_action('widgets_init', 'goodlook_widgets_init');

if(!function_exists('goodlook_widgets_init')){
    function goodlook_widgets_init(){
        register_sidebar(array(
            'name' => esc_html__('Front Page widgets','goodlook'),
            'id' => 'homepage_widgets',
            'description' => esc_html__('Widgets bar on Front page','goodlook'),
            'before_widget' => '<div class="start-page__row" id="%1$s"><div class="pc-section-secondary typo">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="pc-section-secondary__header">',
            'after_title' => '</div>'
        ));
    }
}