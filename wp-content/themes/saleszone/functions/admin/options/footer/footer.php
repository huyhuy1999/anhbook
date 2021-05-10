<?php

$section = 'footer';
Saleszone_Kirki::add_field( 'custom', array(
    'type'     => 'custom',
    'section'  => $section,
    'settings' => 'footer_heading_1',
    'default'  => "<div class='custom-customize-control-title'>" . esc_html__( 'Footer main', 'saleszone' ) . "</div>",
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'checkbox',
    'settings' => 'footer_1',
    'label'    => esc_html__( 'Enabled footer main', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'footer_1' ),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'radio-buttonset',
    'settings' => 'footer_columns',
    'label'    => esc_html__( 'Columns', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'footer_columns' ),
    'choices'  => array(
    '6' => '6',
    '5' => '5',
    '4' => '4',
    '3' => '3',
    '2' => '2',
),
) );