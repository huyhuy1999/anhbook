<?php

$section = 'header';
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'textarea',
    'settings' => 'shop-search-placeholder',
    'label'    => esc_html__( 'Search placeholder', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_option( 'shop-search-placeholder' ),
) );
Saleszone_Kirki::add_field( 'custom', array(
    'type'     => 'custom',
    'section'  => $section,
    'settings' => 'header_phone_title',
    'default'  => "<div class='custom-customize-control-title'>" . esc_html__( 'header phone', 'saleszone' ) . "</div>",
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'textarea',
    'settings' => 'header-phone-title',
    'label'    => esc_html__( 'Phone title', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'header-phone-title' ),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'        => 'textarea',
    'settings'    => 'header-phone',
    'description' => esc_html__( 'Write each of your numbers with a new line', 'saleszone' ),
    'label'       => esc_html__( 'Phone', 'saleszone' ),
    'section'     => $section,
    'default'     => saleszone_default_options( 'header-phone' ),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'select',
    'settings' => 'header-phone-display-type',
    'label'    => esc_html__( 'Phone type', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'header-phone-display-type' ),
    'multiple' => 1,
    'choices'  => array(
    'list'            => esc_html__( 'List', 'saleszone' ),
    'list-horizontal' => esc_html__( 'list horizontal', 'saleszone' ),
    'dropdown'        => esc_html__( 'dropdown', 'saleszone' ),
),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'checkbox',
    'settings' => 'header-phone-show-icon',
    'label'    => esc_html__( 'Show phone icon', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'header-phone-show-icon' ),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'radio-image',
    'settings' => 'header-phone-icon-style',
    'label'    => esc_html__( 'Icon style', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'header-phone-icon-style' ),
    'choices'  => array(
    'phone-big'          => $image_url . 'phone-icons/phone-big.svg',
    'phone-fill'         => $image_url . 'phone-icons/phone-fill.svg',
    'phone-small'        => $image_url . 'phone-icons/phone-small.svg',
    'phone-headset'      => $image_url . 'phone-icons/phone-headset.svg',
    'phone-headset-fill' => $image_url . 'phone-icons/phone-headset-fill.svg',
    'phone-telephone'    => $image_url . 'phone-icons/phone-telephone.svg',
),
) );
// icon size
Saleszone_Kirki::add_field( 'option', array(
    'type'      => 'slider',
    'settings'  => 'header-phone-icon-size',
    'label'     => esc_html__( 'Phone icon size', 'saleszone' ),
    'section'   => $section,
    'default'   => saleszone_default_options( 'header-phone-icon-size' ),
    'transport' => $transport,
    'choices'   => array(
    'min'  => '12',
    'max'  => '50',
    'step' => '1',
),
) );
// Title phone font size
Saleszone_Kirki::add_field( 'option', array(
    'type'      => 'slider',
    'settings'  => 'header-phone-title-font-size',
    'label'     => esc_html__( 'Phone title font size', 'saleszone' ),
    'section'   => $section,
    'default'   => saleszone_default_options( 'header-phone-title-font-size' ),
    'transport' => $transport,
    'choices'   => array(
    'min'  => '12',
    'max'  => '36',
    'step' => '1',
),
) );
// phone font size
Saleszone_Kirki::add_field( 'option', array(
    'type'      => 'slider',
    'settings'  => 'header-phone-font-size',
    'label'     => esc_html__( 'Phone font size', 'saleszone' ),
    'section'   => $section,
    'default'   => saleszone_default_options( 'header-phone-font-size' ),
    'transport' => $transport,
    'choices'   => array(
    'min'  => '12',
    'max'  => '36',
    'step' => '1',
),
) );
$variables = saleszone_default_options_css_variables( 'header-phone' );
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