<?php

add_action("wp_enqueue_scripts", 'goodlook_enqueue_scripts');
function goodlook_enqueue_scripts(){
    $uri = get_stylesheet_directory_uri();
    $theme = wp_get_theme();
    $version = $theme->get('Version');

    wp_enqueue_style("saleszone-child-styles", $uri . "/public/css/styles.min.css", array('saleszone-styles'), $version);
}