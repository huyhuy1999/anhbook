<?php

$section = 'social-icons';

Saleszone_Kirki::add_field( 'custom', array(
    'type'        => 'custom',
    'section'     => $section,
    'settings'    => 'social_follow_heading',
    'default'     => "<div class='custom-customize-control-title'>" . esc_html__('Follow Icons', 'saleszone' ) . "</div>"
));

Saleszone_Kirki::add_field( 'custom', array(
    'type'        => 'custom',
    'section'     => $section,
    'settings'    => 'social_follow_description',
    'default'     => '<div class="">' . esc_html__('This is the default settings for the [follow] shortcode.', 'saleszone' ) . '</div>'
));

$follow_icons = saleszone_default_options_social_follow();

foreach ($follow_icons as $icon){
    Saleszone_Kirki::add_field( 'option',  array(
        'type'        => 'link',
        'settings'    => 'follow-'.$icon['name'],
        'label'       => $icon['label'],
        'section'     => $section,
        'default'     => '',
    ));
}

Saleszone_Kirki::add_field( 'custom', array(
    'type'        => 'custom',
    'section'     => $section,
    'settings'    => 'social_share_heading',
    'default'     => "<div class='custom-customize-control-title'>" . esc_html__('Share Icons', 'saleszone' ) . "</div>"
));

$share_icons = saleszone_default_options_social_share();

foreach ($share_icons as $icon){
    Saleszone_Kirki::add_field( 'option', array(
        'type'        => 'checkbox',
        'settings'    => 'share-'.$icon['name'],
        'label'       => $icon['label'],
        'section'     => $section,
        'default'     => true,
    ));
}