<?php
/**
 * opstore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package opstore
 */

if ( ! function_exists( 'opstore_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function opstore_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on opstore, use a find and replace
		 * to change 'opstore' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'opstore', get_template_directory() . '/languages' );

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
		add_image_size( 'opstore-blog-list', 850, 650, true );
		add_image_size( 'opstore-blog-default', 370, 265, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'opstore' ),
			'top' => esc_html__( 'Top Menu', 'opstore' ),
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

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'audio',
			'video',
			'gallery',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'opstore_custom_background_args', array(
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
	}
endif;
add_action( 'after_setup_theme', 'opstore_setup' );

/** Adding Editor Styles **/
function opstore_add_editor_styles() {
    add_editor_style( get_template_directory_uri().'/assets/css/admin/custom-editor-style.css' );
}
add_action( 'admin_init', 'opstore_add_editor_styles' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function opstore_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'opstore_content_width', 640 );
}
add_action( 'after_setup_theme', 'opstore_content_width', 0 );


/* Require theme files*/
$file_paths = array(
	'/inc/core/opstore-enqueue.php',
	'/inc/core/opstore-constants.php',
	'/inc/custom-header.php',
	'/inc/template-tags.php',
	'/inc/template-functions.php',
	'/inc/customizer/opstore-sanitize.php',
	'/inc/customizer/customizer-default.php',
	'/inc/customizer/opstore-custom-controls.php',
	'/inc/customizer/customizer.php',
	'/inc/customizer/opstore-customizer.php',
	'/inc/extras/opstore-breadcrumb.php',
	'/inc/core/opstore-functions.php',
	'/inc/core/opstore-hooks.php',
    '/inc/widgets/widget-init.php',
    '/inc/extras/dynamic-styles.php',
    '/inc/config/plugins-config.php',
    '/inc/config/tgm-plugin-activation.php',
);

foreach ($file_paths as $file_path) {
	require get_parent_theme_file_path() . $file_path;
}

/**
 * Load welcome section to admin.
 */
if ( is_admin() ) {
    require get_template_directory().'/inc/welcome/class.info.php';
    require get_template_directory().'/inc/welcome/info.php';
}
	
/**
 * Load Woocommerce file.
 */
if( class_exists('woocommerce') ){
	require get_template_directory() . '/inc/woocommerce.php';
}


/**
 *  Load Jetpack compatibility file.
**/
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

