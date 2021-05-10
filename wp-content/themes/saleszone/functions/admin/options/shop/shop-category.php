<?php

$panel = 'shop';
$section = 'shop-category';
Saleszone_Kirki::add_section( $section, array(
    'title' => esc_html__( 'Category', 'saleszone' ),
    'panel' => $panel,
) );
Saleszone_Kirki::add_field( 'custom', array(
    'type'     => 'custom',
    'section'  => $section,
    'settings' => 'category-options-heading',
    'default'  => "<div class='custom-customize-control-title'>" . esc_html__( 'Options', 'saleszone' ) . "</div>",
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'radio-buttonset',
    'settings' => 'shop-category-per-row',
    'label'    => esc_html__( 'Products grid per row', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'shop-category-per-row' ),
    'choices'  => array(
    '2' => '2',
    '3' => '3',
    '4' => '4',
    '5' => '5',
    '6' => '6',
),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'number',
    'settings' => 'shop-category-per-page',
    'label'    => esc_html__( 'Products per page', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'shop-category-per-page' ),
    'choices'  => array(
    'min'  => 1,
    'max'  => 48,
    'step' => 1,
),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'checkbox',
    'settings' => 'category-show-hide-bth-for-description',
    'label'    => esc_html__( 'Display show/hide button for catalog description', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'category-show-hide-bth-for-description' ),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'checkbox',
    'settings' => 'category-show-description-on-top',
    'label'    => esc_html__( 'Show description below category heading', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'category-show-description-on-top' ),
) );
Saleszone_Kirki::add_field( 'custom', array(
    'type'     => 'custom',
    'section'  => $section,
    'settings' => 'category-product-heading',
    'default'  => "<div class='custom-customize-control-title'>" . esc_html__( 'Product', 'saleszone' ) . "</div>",
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'checkbox',
    'settings' => 'category-product-short-description',
    'label'    => esc_html__( 'Show short description', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'category-product-short-description' ),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'checkbox',
    'settings' => 'category-product-attributes',
    'label'    => esc_html__( 'Show attributes', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'category-product-attributes' ),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'checkbox',
    'settings' => 'category-product-display-stock',
    'label'    => esc_html__( 'Display stock status', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'category-product-display-stock' ),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'checkbox',
    'settings' => 'category-btn-add-to-cart-icon',
    'label'    => esc_html__( 'Button add to cart show icon', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'category-btn-add-to-cart-icon' ),
) );
Saleszone_Kirki::add_field( 'option', array(
    'type'     => 'checkbox',
    'settings' => 'category-active-filter',
    'label'    => esc_html__( 'Show active filter', 'saleszone' ),
    'section'  => $section,
    'default'  => saleszone_default_options( 'category-active-filter' ),
) );