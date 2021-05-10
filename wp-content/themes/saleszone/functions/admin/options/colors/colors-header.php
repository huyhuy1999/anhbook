<?php

$panel = 'colors';
$section = 'colors-header';
Saleszone_Kirki::add_section( $section, array(
    'title' => esc_html__( 'Header', 'saleszone' ),
    'panel' => $panel,
) );
Saleszone_Kirki::add_field( 'custom', array(
    'type'     => 'custom',
    'section'  => $section,
    'settings' => 'header_colors_heading',
    'default'  => "<div class='custom-customize-control-title'>" . esc_html__( 'Header main', 'saleszone' ) . "</div>",
) );
$header_background_setting = saleszone_default_options_background( 'header_background_setting' );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'background',
    'settings' => 'header_background_setting',
    'label'    => esc_attr__( 'Footer background', 'saleszone' ),
    'section'  => $section,
    'default'  => $header_background_setting['default'],
) );
$variables = saleszone_default_options_css_variables( 'header-main' );
foreach ( $variables as $option ) {
    Saleszone_Kirki::add_field( 'option', array(
        'type'      => 'color',
        'settings'  => $option['name'],
        'label'     => $option['data']['label'],
        'section'   => $section,
        'default'   => $option['data']['default'],
        'transport' => $transport,
        'choices'   => array(
        'alpha' => true,
    ),
    ) );
}
Saleszone_Kirki::add_field( 'custom', array(
    'type'     => 'custom',
    'section'  => $section,
    'settings' => 'header_bottom_colors_heading',
    'default'  => "<div class='custom-customize-control-title'>" . esc_html__( 'Header bottom', 'saleszone' ) . "</div>",
) );
$variables = saleszone_default_options_css_variables( 'header-bottom' );
foreach ( $variables as $option ) {
    Saleszone_Kirki::add_field( 'option', array(
        'type'      => 'color',
        'settings'  => $option['name'],
        'label'     => $option['data']['label'],
        'section'   => $section,
        'default'   => $option['data']['default'],
        'transport' => $transport,
        'choices'   => array(
        'alpha' => true,
    ),
    ) );
}