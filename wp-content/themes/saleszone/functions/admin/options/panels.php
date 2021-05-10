<?php

/**
 * Define customizer panels
 */
Saleszone_Kirki::add_section( 'header', array(
    'priority' => 10,
    'title'    => esc_html__( 'Header', 'saleszone' ),
) );
Saleszone_Kirki::add_panel( 'colors', array(
    'priority' => 11,
    'title'    => esc_html__( 'Colors', 'saleszone' ),
) );
Saleszone_Kirki::add_panel( 'shop', array(
    'priority' => 12,
    'title'    => esc_html__( 'Shop', 'saleszone' ),
) );
Saleszone_Kirki::add_section( 'footer', array(
    'priority' => 15,
    'title'    => esc_html__( 'Footer', 'saleszone' ),
) );