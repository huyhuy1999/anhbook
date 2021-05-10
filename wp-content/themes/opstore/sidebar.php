<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package opstore
 */
$sidebar = '';

if(is_archive() || is_tag() || is_home() || is_author()){
	$sidebar = get_theme_mod('archive_page_sidebars','right-sidebar');
}
if(is_single() || ( is_page() && !is_front_page() )){
	$page_sidebar_old = get_post_meta(get_the_ID(),'ultra_seven_page_sidebar',true);
	$page_sidebar = get_post_meta(get_the_ID(),'ultra_sidebar',true);
	$page_sidebar = !empty($page_sidebar) ? $page_sidebar : $page_sidebar_old;

	if($page_sidebar == 'default' || $page_sidebar == ''){
		$sidebar = get_theme_mod('post_page_sidebars','right-sidebar');
    }else{
    	$sidebar = $page_sidebar;
    }
} 
if(class_exists('woocommerce')){
	if(is_shop() || is_product() || is_product_category() ){
		$sidebar = get_theme_mod('opstore_shop_sidebar','shop-sidebar');
	}
}
if($sidebar == ''){
	return;
}

if( ! is_active_sidebar($sidebar)){
	return;
}

dynamic_sidebar( $sidebar ); 

