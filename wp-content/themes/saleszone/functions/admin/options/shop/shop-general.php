<?php

$panel = 'shop';
$section = 'shop-general';
Saleszone_Kirki::add_section( $section, array(
    'title' => esc_html__( 'General', 'saleszone' ),
    'panel' => $panel,
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'      => 'text',
    'settings'  => 'site-page-width',
    'label'     => esc_html__( 'Header and Footer width', 'saleszone' ),
    'section'   => $section,
    'transport' => $transport,
    'default'   => '',
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'      => 'text',
    'settings'  => 'site-content-width',
    'label'     => esc_html__( 'Content width', 'saleszone' ),
    'section'   => $section,
    'transport' => $transport,
    'default'   => '',
) );