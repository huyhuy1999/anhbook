<?php

$panel = 'colors';
$section = 'colors-body';
Saleszone_Kirki::add_section( $section, array(
    'title' => esc_html__( 'Body', 'saleszone' ),
    'panel' => $panel,
) );
Saleszone_Kirki::add_field( 'custom', array(
    'type'     => 'custom',
    'section'  => $section,
    'settings' => 'body_colors_link',
    'default'  => "<div class='custom-customize-control-title'>" . esc_html__( 'Links', 'saleszone' ) . "</div>",
) );
$variables = saleszone_default_options_css_variables( 'links' );
foreach ( $variables as $option ) {
    Saleszone_Kirki::add_field( 'option', array(
        'type'      => 'color',
        'settings'  => $option['name'],
        'label'     => esc_attr( $option['data']['label'] ),
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
    'settings' => 'body_colors_panels',
    'default'  => "<div class='custom-customize-control-title'>" . esc_html__( 'Panels', 'saleszone' ) . "</div>",
) );
$variables = saleszone_default_options_css_variables( 'panels' );
foreach ( $variables as $option ) {
    Saleszone_Kirki::add_field( 'option', array(
        'type'      => 'color',
        'settings'  => $option['name'],
        'label'     => esc_attr( $option['data']['label'] ),
        'section'   => $section,
        'default'   => $option['data']['default'],
        'transport' => $transport,
        'choices'   => array(
        'alpha' => true,
    ),
    ) );
}