<?php

$section = 'title_tagline';

Saleszone_Kirki::add_field( 'option', array(
    'type'        => 'checkbox',
    'settings'    => 'logo-slogan',
    'label'       => esc_html__('Display site tagline', 'saleszone' ),
    'section'     => $section,
    'default'     => saleszone_default_options('logo-slogan'),
));

Saleszone_Kirki::add_field( 'option',  array(
    'type'        => 'slider',
    'settings'    => 'logo-padding',
    'label'       => __( 'Logo Padding', 'saleszone' ),
    'section'     => $section,
    'default'     => 0,
    'choices'     => array(
        'min'  => 0,
        'max'  => 30,
        'step' => 1
    ),
    'transport' => 'postMessage',
));

Saleszone_Kirki::add_field( 'option', array(
    'type'        => 'slider',
    'settings'    => 'logo-container-max-width',
    'label'       => esc_html__( 'Logo container max width', 'saleszone' ),
    'section'     => $section,
    'transport'   => $transport,
    'default'     => saleszone_default_options('logo-container-max-width'),
    'choices'     => array(
        'min'  => 200,
        'max'  => 400,
        'step' => 1
    ),
));