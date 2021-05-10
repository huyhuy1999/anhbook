<?php

add_filter('amazica_home_page_default_sections', function(){
	return array('slider', 'services', 'about', 'products-latest', 'team', 'callout', 'testimonials', 'subscribe', 'blog',  'brands');
});

function themefarmer_companion_amazica_customize_register($wp_customize){
	$wp_customize->add_panel('themefarmer_blog_options_panel', array(
		'priority' => 50,
		'title'    => esc_html__('Blog Options', 'themefarmer-companion'),
	));

	$wp_customize->add_panel('themefarmer_blog_slider_section', array(
		'priority' => 50,
		'title'    => esc_html__('Blog Slider', 'themefarmer-companion'),
	));

	$wp_customize->add_panel('themefarmer_blog_meta_section', array(
		'priority' => 50,
		'title'    => esc_html__('Blog Meta', 'themefarmer-companion'),
	));



/*About start*/
	$wp_customize->add_setting('themefarmer_home_about_heading', array(
		'default'           => esc_html__('About Us', 'themefarmer-companion'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control('themefarmer_home_about_heading', array(
		'type'    => 'text',
		'label'   => esc_html__('Heading', 'themefarmer-companion'),
		'section' => 'themefarmer_home_about_section',
	));
	$wp_customize->add_setting('themefarmer_home_about_desc', array(
		'default'           => esc_html__('About Us Description', 'themefarmer-companion'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control('themefarmer_home_about_desc', array(
		'type'    => 'textarea',
		'label'   => esc_html__('Description', 'themefarmer-companion'),
		'section' => 'themefarmer_home_about_section',
	));

	$wp_customize->add_setting('themefarmer_home_about_image', array(
		'sanitize_callback' => 'esc_url_raw',
		'default' => esc_url(get_template_directory_uri() . '/images/about-us.jpg'),
		// 'transport'         => 'postMessage',
	));

	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'themefarmer_home_about_image', array(
		'label'   => esc_html__('Image', 'themefarmer-companion'),
		'section' => 'themefarmer_home_about_section',
	)));

/*About end*/

}
add_action('customize_register', 'themefarmer_companion_amazica_customize_register');


add_filter('themefarmer_home_slider_heading', function(){
	return __('Welcome to <span> Amazica </span>', 'amazica');
});
add_filter('themefarmer_home_slider_description', function(){
	return esc_html__('Lorem ipsum dolor sit amet elit do, consectetur adipiscing, sed eiusmod tempor', 'amazica');
});
add_filter('themefarmer_home_slider_btn1_label', function(){
	return esc_html__('See More', 'amazica');
});
add_filter('themefarmer_home_slider_btn2_label', function(){
	return esc_html__('Get Started', 'amazica');
});

add_filter('themefarmer_is_theme_using_social_logins', '__return_true');