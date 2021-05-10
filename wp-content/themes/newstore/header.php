<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NewSrore
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'newstore' ); ?></a>

	<?php 
		$header_type = get_theme_mod( 'newstore_header_type', 'two');
		$header_type = ($header_type == 'one' || $header_type == 'two')?$header_type:'two';
		get_template_part( 'template-parts/header', esc_attr($header_type));
	?>

	<div id="content" class="site-content">