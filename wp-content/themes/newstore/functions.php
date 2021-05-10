<?php
/**
 * NewSrore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NewSrore
 */

require get_template_directory() . '/admin/admin-init.php';

if ( ! function_exists( 'newstore_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function newstore_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on NewSrore, use a find and replace
		 * to change 'newstore' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'newstore', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'newstore' ),
			'top_nav' => esc_html__( 'Top bar Navigation', 'newstore' ),
			'product_catalog' => esc_html__( 'Product Catalog', 'newstore' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'newstore_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		add_theme_support( 'starter-content', array(
			'posts' => array(
				'home' => array(
					'post_type' => 'page', 
					'post_title' => _x( 'Home', 'Theme starter content', 'newstore' ),
				),
				'blog' => array(
					'post_type' => 'page', 
					'post_title' => _x( 'Blog', 'Theme starter content', 'newstore' ),
				),
			),
			'options' => array(
				'show_on_front' => 'page',
				'page_on_front' => '{{home}}',
				'page_for_posts' => '{{blog}}',				
			),
			'nav_menus' => array(
				'primary' => array(
					'name' => __( 'Primary Menu', 'newstore' ),
					'items' => array(
						'page_home',
						'page_blog'
					),
				)
			),
 		));
 		add_image_size( 'newstore-thumb', '500', '250', true );
 		add_image_size( 'newstore_woocommerce_single_thumb', '600', '600', true );
	}
endif;
add_action( 'after_setup_theme', 'newstore_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function newstore_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'newstore_content_width', 1170 );
}
add_action( 'after_setup_theme', 'newstore_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function newstore_widgets_init() {
	register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'newstore'),
        'id'            => 'sidebar',
        'class'         => 'sidebar',
        'description'   => esc_html__('Sidebar Widget Area', 'newstore'),
        'before_widget' => '<div id="%1$s" class="sidebar-widget widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
        'after_title'   => '</h3></div>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('FrontPage Top Widget Area', 'newstore'),
        'id'            => 'front-page-top-widget-area',
        'class'         => 'front-page-top-widget-area',
        'description'   => esc_html__( 'FrontPage Top Widget Area', 'newstore' ),
        'before_widget' => '<div id="%1$s" class="front-page-widget front-page-top-widget widget %2$s"><div class="container"><div class="front-page-widget-inner">',
        'after_widget'  => '<div class="clearfix"></div></div></div></div>',
        'before_title'  => '<div class="section-heading"><h2 class="section-title">',
        'after_title'   => '</h2></div>',
    ));

    
    register_sidebar(array(
        'name'          => esc_html__('WooCommerce Sidebar', 'newstore'),
        'id'            => 'woocommerce-sidebar',
        'class'         => 'woocommerce-sidebar',
        'description'   => esc_html__( 'WooCommerce Widget Area', 'newstore' ),
        'before_widget' => '<div id="%1$s" class="woocommerce-widget sidebar-widget widget open %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
        'after_title'   => '</h3><div class="wc-sidebar-toggle"><i class="fa fa-wc-toggle"></i></div></div>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Product Sidebar', 'newstore'),
        'id'            => 'woocommerce-product-sidebar',
        'class'         => 'woocommerce-product-sidebar',
        'description'   => esc_html__( 'Product Widget Area', 'newstore' ),
        'before_widget' => '<div id="%1$s" class="woocommerce-product-sidebar sidebar-widget widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
        'after_title'   => '</h3></div>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('FrontPage Products Widget Area', 'newstore'),
        'id'            => 'front-page-products-widget-area',
        'class'         => 'front-page-products-widget-area',
        'description'   => esc_html__( 'FrontPage Products Widget Area Column', 'newstore' ),
        'before_widget' => '<div id="%1$s" class="front-page-widget front-page-product-widget widget %2$s"><div class="container"><div class="front-page-widget-inner">',
        'after_widget'  => '<div class="clearfix"></div></div></div></div>',
        'before_title'  => '<div class="section-heading"><h2 class="section-title">',
        'after_title'   => '</h2></div>',
    ));

    
    register_sidebar(array(
        'name'          => esc_html__('FrontPage Product Widget Area Column ', 'newstore'),
        'id'            => 'front-page-widget-area-column',
        'class'         => 'front-page-widget-area-column',
        'description'   => esc_html__( 'FrontPage Widget Area Column', 'newstore' ),
        'before_widget' => '<div id="%1$s" class="col-md-3 col-sm-6 front-page-widget-area-column widget %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<div class="section-heading"><h3 class="section-title">',
        'after_title'   => '</h3></div>',
	));
    

    for ($i=1; $i <= 4; $i++){
	    register_sidebar(array(
	        'name'          => sprintf(esc_html__('Footer Widget Area Column %s', 'newstore'), $i),
	        'id'            => 'footer-widget-area-col-'.$i,
	        'class'         => 'footer-widget-area-col-'.$i,
	        'description'   => sprintf(esc_html__('Footer Widget Area Column %s', 'newstore'), $i),
	        'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s"><div class="widget-inner">',
	        'after_widget'  => '</div></div>',
	        'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
	        'after_title'   => '</h3></div>',
	    ));
	}
}
add_action( 'widgets_init', 'newstore_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function newstore_scripts() {
	
	wp_enqueue_style( 'newstore-google-font','https://fonts.googleapis.com/css?family=Open+Sans' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . "/css/animate.min.css");
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . "/css/bootstrap.min.css");
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . "/css/owl.carousel.min.css");
    wp_enqueue_style( 'owl-theme', get_template_directory_uri() . "/css/owl.theme.default.min.css");
    wp_enqueue_style( 'simplelightbox',  get_template_directory_uri()."/css/simplelightbox.min.css");
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/css/font-awesome.min.css");
    wp_enqueue_style( 'newstore-main-nav', get_template_directory_uri() . "/css/main-nav.css");
    wp_enqueue_style( 'newstore-style', get_stylesheet_uri() );
    wp_enqueue_style( 'newstore-media-style', get_template_directory_uri() . "/css/media-style.css");

	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'));
	wp_enqueue_script( 'simple-lightbox', get_template_directory_uri() . '/js/simple-lightbox.min.js', array('jquery'));
    wp_enqueue_script( 'popper', get_template_directory_uri() . '/js/popper.min.js', array('jquery'));
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script( 'jquery-ez-plus', get_template_directory_uri() . '/js/jquery.ez-plus-custom.js', array('jquery'));
    wp_enqueue_script( 'jquery-sticky-sidebar', get_template_directory_uri() . '/js/jquery.sticky-sidebar.min.js', array('jquery'));
    wp_enqueue_script( 'newstore-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array());
    wp_enqueue_script( 'newstore-custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'));
    wp_localize_script( 'newstore-custom-script', 'newstore_script_obj', array(
    	'rtl' => is_rtl(),
    	'sticky_header' => get_theme_mod( 'newstore_sticky_header_enable', true ),
    ));

    wp_enqueue_script('respond', get_template_directory_uri() . '/js/respond.min.js');
    wp_script_add_data('respond', 'conditional', 'lt IE 9');

    wp_enqueue_script('html5shiv', get_template_directory_uri() . '/js/html5shiv.js');
    wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');
	
}
add_action( 'wp_enqueue_scripts', 'newstore_scripts' );

require get_template_directory() . '/inc/sanitize-cb.php';
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/themefarmer-functions.php';
require get_template_directory() . '/inc/menu-walker.php';
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/class-newstore-wc-widget-products.php';
	require get_template_directory() . '/inc/woocommerce.php';
}
