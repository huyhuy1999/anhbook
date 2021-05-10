<?php
/**
 * Opstore Constants definition file
 *
 * @package  Opstore
 */
// get theme data
$theme = wp_get_theme();

// theme core directory path & uri
$dir = get_template_directory();
$uri = get_template_directory_uri();

/**
 * Theme constants
 */
define( 'OPSTORE_THEME', $theme->get( 'Name' ) );
define( 'OPSTORE_VERSION', $theme->get( 'Version' ) );

/**
 * Template directory & uri
 */
define( 'OPSTORE_DIR', wp_normalize_path( $dir ) );
define( 'OPSTORE_URI', trailingslashit( $uri ) );

/**
 * Theme assets URI & DIR
 */
define( 'OPSTORE_ASSETS', OPSTORE_DIR . '/assets/' );
define( 'OPSTORE_ASSETS_URI', OPSTORE_URI . 'assets/' );
define( 'OPSTORE_CSS', OPSTORE_ASSETS_URI . 'css/' );
define( 'OPSTORE_JS', OPSTORE_ASSETS_URI . 'js/' );
define( 'OPSTORE_IMAGES', OPSTORE_ASSETS_URI . 'images/' );


/* PHP Closing tag is omitted */