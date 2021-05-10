<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package opstore
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function opstore_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	$opstore_site_layout = get_theme_mod('opstore_webpage_layout','opstore-fullwidth');
	$classes[] = $opstore_site_layout;

	if(function_exists( 'WC' )){
		$classes[] = 'woocommerce';
	}

	//Sticky Header
	$sticky_enable = get_theme_mod('opstore_sticky_menu','hide');
	if($sticky_enable == 'show'){
		$classes[] = 'sticky-header';
	}

	return $classes;
}
add_filter( 'body_class', 'opstore_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function opstore_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'opstore_pingback_header' );



function opstore_hide_the_archive_title( $title ) {
	
	if ( is_rtl() ) {
		return $title;
	}
	// Split the title into parts so we can wrap them with spans.
	$title_parts = explode( ': ', $title, 2 );
	// Glue it back together again.
	if ( ! empty( $title_parts[1] ) ) {
		$title = wp_kses(
			$title_parts[1],
			array(
				'span' => array(
					'class' => array(),
				),
			)
		);
		$title = '<span class="screen-reader-text">' . esc_html( $title_parts[0] ) . ': </span>' . $title;
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'opstore_hide_the_archive_title' );


/**
* Retrieve post meta and default value of metabox
* 
*/
function opstore_get_post_meta( $key, $defaults = '' ){
  global $post;

  if(! $post )
    return;
    
    $default = $defaults;
    $meta_val =  get_post_meta( $post->ID, $key , true ); 

    if( empty($meta_val) && ($defaults != '') ){
        $meta_val = $default;
    }

    return $meta_val;

}