<?php

$panel = 'colors';
$section = 'colors-menu';
Saleszone_Kirki::add_section( $section, array(
    'title' => esc_html__( 'Navigation', 'saleszone' ),
    'panel' => $panel,
) );
Saleszone_Kirki::add_field( 'custom', array(
    'type'     => 'custom',
    'section'  => $section,
    'settings' => 'navigation_colors_heading_main',
    'default'  => "<div class='custom-customize-control-title'>" . esc_html__( 'Main navigation', 'saleszone' ) . "</div>",
) );
$variables = saleszone_default_options_css_variables( 'main-navigation' );
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