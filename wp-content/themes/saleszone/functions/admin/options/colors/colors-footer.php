<?php

$panel = 'colors';
$section = 'colors-footer';
Saleszone_Kirki::add_section( $section, array(
    'title' => esc_html__( 'Footer', 'saleszone' ),
    'panel' => $panel,
) );
Saleszone_Kirki::add_field( 'custom', array(
    'type'     => 'custom',
    'section'  => $section,
    'settings' => 'footer_colors_heading',
    'default'  => "<div class='custom-customize-control-title'>" . esc_html__( 'Footer', 'saleszone' ) . "</div>",
) );
$footer_background_setting = saleszone_default_options_background( 'footer_background_setting' );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'background',
    'settings' => 'footer_background_setting',
    'label'    => esc_attr__( 'Footer background', 'saleszone' ),
    'section'  => $section,
    'default'  => $footer_background_setting['default'],
) );