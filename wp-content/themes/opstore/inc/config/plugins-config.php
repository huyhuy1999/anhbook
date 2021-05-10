<?php

if( ! defined( 'ABSPATH' ) ) {
	exit; 	// exit if accessed directly
}

add_action( 'tgmpa_register', 'opstore_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */

function opstore_register_required_plugins() {	

	$plugins = array(
		
		/**
		 * Plugins from WordPress repository
		 */
		array(
            'name'             => esc_html__( 'Operation Demo Importer', 'opstore' ),
            'slug'             => 'operation-demo-importer',
            'source'           => 'https://wordpress.org/plugins/operation-demo-importer/',
            'required'         => false,
            'version'          => '1.0.4' 
        ),
		array(
            'name'             => esc_html__( 'Ultra Companion', 'opstore' ),
            'slug'             => 'ultra-companion',
            'source'           => 'https://wordpress.org/plugins/ultra-companion/',
            'required'         => true,
            'version'          => '1.0.3' 
        ),
        array(
            'name'             => esc_html__( 'Opstore Elementor Addons', 'opstore' ),
            'slug'             => 'wpop-elementor-addons',
            'required'         => true,
            'force_deactivation' => true,
            'version'          => '1.0.0'
        ),
        array(
			'name'      => esc_html__( 'Salert', 'opstore' ),
			'slug'      => 'salert',
			'required'  => true,
		),

		// Woocommerce
		array(
			'name'      => esc_html__( 'Woocommerce', 'opstore' ),
			'slug'      => 'woocommerce',
			'required'  => true,
		),
		//elementor
		array(
			'name'      => esc_html__( 'Elementor', 'opstore' ),
			'slug'      => 'elementor',
			'required'  => true,
		),
		// Contact form 7
		array(
			'name'      => esc_html__( 'Contact Form 7', 'opstore' ),
			'slug'      => 'contact-form-7',
			'required'  => false,
		),

		// login/Signup plugin
		array(
			'name'      => esc_html__( 'AJAX Login and Registration modal popup', 'opstore' ),
			'slug'      => 'ajax-login-and-registration-modal-popup',
			'required'  => false,
		),

		// YITH wishlist plugin
		array(
			'name'      => esc_html__( 'YITH WooCommerce Wishlist', 'opstore' ),
			'slug'      => 'yith-woocommerce-wishlist',
			'required'  => false,
		),

		// YITH Quick view plugin
		array(
			'name'      => esc_html__( 'YITH WooCommerce Quick View', 'opstore' ),
			'slug'      => 'yith-woocommerce-quick-view',
			'required'  => false,
		),

		array(
			'name'      => esc_html__( 'YITH WooCommerce Compare', 'opstore' ),
			'slug'      => 'yith-woocommerce-compare',
			'required'  => false,
		),

		// Mail Poet
		array(
			'name'      => esc_html__( 'Mailpoet', 'opstore' ),
			'slug'      => 'mailpoet',
			'required'  => false,
		),


		array(
			'name'      => esc_html__( 'Regenerate Thumbnails', 'opstore' ),
			'slug'      => 'regenerate-thumbnails',
			'required'  => false,
		),

		// Smart Slider
		array(
			'name'      => esc_html__( 'Smart Slider 3', 'opstore' ),
			'slug'      => 'smart-slider-3',
			'required'  => true,
		),
		
	);

	// Settings for plugin installation screen
	$config = array(
		'id'           => 'tgmpa-opstore',
		'default_path' => '',
		'menu'         => 'opstore-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',		
	);

	tgmpa( $plugins, $config );

}

/* PHP Closing tag is omitted */