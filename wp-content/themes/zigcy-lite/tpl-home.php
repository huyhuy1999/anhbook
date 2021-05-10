<?php 

/**
*Template Name: Home Page
*
**/
get_header();
// do_action('zigcy_lite_slider_promo_section');
// do_action('zigcy_lite_prod_cat_slider_section');

$home_sections =   zigcy_lite_get_parallax_sections();

    foreach( $home_sections as $home_section){
        $sections =  $home_section['function'];        
         do_action($sections);
    }

get_footer(); 
