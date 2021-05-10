<?php
	/**
	 * Welcome Page Initiation
	*/

	include get_template_directory() . '/inc/welcome/welcome.php';

	/** Plugins **/
	$zigcy_plugins = array(
		// *** Companion Plugins
		'companion_plugins' => array(),

		// *** Required Plugins
		'required_plugins' => array(
			'ap-theme-utility-plugin' => array(
				'slug' => 'ap-theme-utility-plugin',
				'name' => esc_html__('AP Theme Utility', 'zigcy-lite'),
				'filename' =>'ap-theme-utility-plugin.php',
				'host_type' => 'wordpress', // Use either bundled, remote, wordpress
				'class' => 'APTU_Class',
				'location' => 'https://accesspressthemes.com/plugin-repo/ap-theme-utility-plugin/ap-theme-utility-plugin.zip', //get_template_directory().'/welcome/plugins/ap-theme-utility-plugin.zip',
				'info' => esc_html__('AP Theme Utility Plugin adds the feature to Import the Demo Content with a single click.', 'zigcy-lite'),
			),
		),

		// *** Recommended Plugins
		'recommended_plugins' => array(
			// Free Plugins
			'free_plugins' => array(

				'smart-slider-3' => array(
					'slug' 		=> 'smart-slider-3',
					'filename' 	=> 'smart-slider-3.php',
					'class' 	=> 'SmartSlider3'
				),

				'woocommerce' => array(
					'slug' 		=> 'woocommerce',
					'filename' 	=> 'woocommerce.php',
					'class' 	=> 'WooCommerce'
				),

				'yith-woocommerce-compare' => array(
					'slug' 		=> 'yith-woocommerce-compare',
					'filename' 	=> 'init.php',
					'class' 	=> 'YITH_Woocompare'
				),

				'yith-woocommerce-wishlist' => array(
					'slug' 		=> 'yith-woocommerce-wishlist',
					'filename' 	=> 'init.php',
					'class' 	=> 'YITH_WCWL'
				),

				'yith-woocommerce-quick-view' => array(
					'slug' 		=> 'yith-woocommerce-quick-view',
					'filename' 	=> 'init.php',
					'class' 	=> 'YITH_WCQV'
				),
				

			),

			// Pro Plugins
			'pro_plugins' => array(
			)
		),
	);

	$strings = array(
		// Welcome Page General Texts
		'welcome_menu_text' => esc_html__( 'Zigcy Setup', 'zigcy-lite' ),
		'theme_short_description' => esc_html__( 'Zigcy Lite is a customizer based WooCommerce Theme built to create stunning e-commerce or online stores. This theme that comes up with deep WooCommerce integration introduces all the WooCommerce features in the most brilliant way possible.', 'zigcy-lite' ),

		// Plugin Action Texts
		'install_n_activate' => esc_html__('Install and Activate', 'zigcy-lite'),
		'deactivate' => esc_html__('Deactivate', 'zigcy-lite'),
		'activate' => esc_html__('Activate', 'zigcy-lite'),

		// Getting Started Section
		'doc_heading' => esc_html__('Step 1 - Documentation', 'zigcy-lite'),
		'doc_description' => esc_html__('Read the Documentation and follow the instructions to manage the site , it helps you to set up the theme more easily and quickly. The Documentation is very easy with its pictorial  and well managed listed instructions. ', 'zigcy-lite'),
		'doc_read_now' => esc_html__( 'Read Now', 'zigcy-lite' ),
		'cus_heading' => esc_html__('Step 2 - Customizer Options Panel', 'zigcy-lite'),
		'cus_description' => esc_html__('Using the WordPress Customizer you can easily customize every aspect of the theme.', 'zigcy-lite'),
		'cus_read_now' => esc_html__( 'Go to Customizer Panels', 'zigcy-lite' ),

		// Recommended Plugins Section
		'pro_plugin_title' => esc_html__( 'Pro Plugins', 'zigcy-lite' ),
		'pro_plugin_description' => esc_html__( 'Take Advantage of some of our Premium Plugins.', 'zigcy-lite' ),
		'free_plugin_title' => esc_html__( 'Free Plugins', 'zigcy-lite' ),
		'free_plugin_description' => esc_html__( 'These Free Plugins might be handy for you.', 'zigcy-lite' ),

		// Demo Actions
		'activate_btn' => esc_html__('Activate', 'zigcy-lite'),
		'installed_btn' => esc_html__('Activated', 'zigcy-lite'),
		'demo_installing' => esc_html__('Installing Demo', 'zigcy-lite'),
		'demo_installed' => esc_html__('Demo Installed', 'zigcy-lite'),
		'demo_confirm' => esc_html__('Are you sure to import demo content ?', 'zigcy-lite'),

		// Actions Required
		'req_plugins_installed' => esc_html__( 'All Recommended action has been successfully completed.', 'zigcy-lite' ),
		'customize_theme_btn' => esc_html__( 'Customize Theme', 'zigcy-lite' ),
	);

	/**
	 * Initiating Welcome Page
	*/
	$my_theme_wc_page = new constructera_Welcome( $zigcy_plugins, $strings );


	/**
	 * Initiate Demo Importer if plugin Exists
	*/
	if(class_exists('APTU_Class')) :

		$demos = array(

			'fashion-demo' => array(
				'title' => esc_html__('Fashion Demo', 'zigcy-lite'),
				'name' => 'fashion-demo',
				'preview_url' => 'https://demo.accesspressthemes.com/zigcy-lite/demo-one/',
				'screenshot' => get_template_directory_uri().'/inc/welcome/demos/fashion-demo/screen.png',
				'home_page' => 'home',
				'menus' => array(
					'Menu 1' => 'menu-1',

				)
			),
            
            'furniture-demo' => array(
				'title' => esc_html__('Furniture Demo', 'zigcy-lite'),
				'name' => 'furniture-demo',
				'preview_url' => 'https://demo.accesspressthemes.com/zigcy-lite/demo-two/',
				'screenshot' => get_template_directory_uri().'/inc/welcome/demos/furniture-demo/screen.png',
				'home_page' => 'home',
				'menus' => array(
					'Menu 1' => 'menu-1',
				)
			),
            
            'electronics-demo' => array(
				'title' => esc_html__('Electronics Demo', 'zigcy-lite'),
				'name' => 'electronics-demo',
				'preview_url' => 'https://demo.accesspressthemes.com/zigcy-lite/demo-three/',
				'screenshot' => get_template_directory_uri().'/inc/welcome/demos/electronics-demo/screen.png',
				'home_page' => 'home',
				'menus' => array(
					'Menu 1' => 'menu-1',
				)
			),
            
		);

		$demoimporter = new APTU_Class( $demos, $demo_dir = get_template_directory().'/inc/welcome/demos/' );

	endif;