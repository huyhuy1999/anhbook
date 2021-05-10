<?php
/**
 * Opstore Theme Customizer
 *
 * @package Opstore
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function opstore_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'opstore_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'opstore_customize_partial_blogdescription',
		) );
	}

// Register custom section types.
	$wp_customize->register_section_type( 'Opstore_Customize_Section_Pro' );

	// Register sections.
	$wp_customize->add_section(
	    new Opstore_Customize_Section_Pro(
	        $wp_customize,
	        'opstore-pro',
	        array(
	            'title'    => esc_html__( 'Upgrade To Premium', 'opstore' ),
	            'pro_text' => esc_html__( 'Buy Now','opstore' ),
	            'pro_text1' => esc_html__( 'Compare','opstore' ),
	            'pro_url'  => 'https://wpoperation.com/themes/opstore-pro/',
	            'priority' => 0,
	        )
	    )
	);
	$wp_customize->add_setting(
		'opstore_pro_upbuton',
		array(
			'section' => 'opstore-pro',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		'opstore_pro_upbuton',
		array(
			'section' => 'opstore-pro'
		)
	);



}
add_action( 'customize_register', 'opstore_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function opstore_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function opstore_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function opstore_customize_preview_js() {
	wp_enqueue_script( 'opstore-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'opstore_customize_preview_js' );
