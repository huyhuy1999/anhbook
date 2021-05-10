<?php

/**
 * Insert custom and third party styles and scripts into index page
 */

/**
 * Assign textdomain for theme localization
 */
load_theme_textdomain( 'goodlook', get_stylesheet_directory() . '/languages' );

$theme_functions_dir = get_stylesheet_directory() . "/functions/";

require $theme_functions_dir . "assets.php";
require $theme_functions_dir . "utilities.php";

require $theme_functions_dir . "default-options.php";
require $theme_functions_dir . "hooks-functions.php";
require $theme_functions_dir . "hooks.php";
require $theme_functions_dir . "filters.php";
require $theme_functions_dir . "filters-function.php";
require $theme_functions_dir . "register-sidebar.php";