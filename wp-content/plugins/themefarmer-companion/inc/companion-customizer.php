<?php
function themefarmer_companion_customize_register($wp_customize) {

	/*Panels Start*/
	$wp_customize->add_panel('themefarmer_fontpage_panel', array(
		'priority' => 20,
		'title'    => esc_html__('Frontpage Options', 'themefarmer-companion'),
	));
	/*Panel End*/

/* Sections Start */
	$wp_customize->add_section('themefarmer_home_slider_section', array(
		'title'      => esc_html__('Slider', 'themefarmer-companion'),
		'panel'      => 'themefarmer_fontpage_panel',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_section('themefarmer_home_services_section', array(
		'title'      => esc_html__('Services', 'themefarmer-companion'),
		'panel'      => 'themefarmer_fontpage_panel',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_section('themefarmer_home_about_section', array(
		'title'      => esc_html__('About', 'themefarmer-companion'),
		'panel'      => 'themefarmer_fontpage_panel',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_section('themefarmer_home_team_section', array(
		'title' => esc_html__('Team', 'themefarmer-companion'),
		'panel' => 'themefarmer_fontpage_panel',
	));

	$wp_customize->add_section('themefarmer_home_testimonials_section', array(
		'title' => esc_html__('Testimonials', 'themefarmer-companion'),
		'panel' => 'themefarmer_fontpage_panel',
	));

	$wp_customize->add_section('themefarmer_home_brands_section', array(
		'title' => esc_html__('Brands', 'themefarmer-companion'),
		'panel' => 'themefarmer_fontpage_panel',
	));

	$wp_customize->add_section('themefarmer_home_contact_section', array(
		'title' => esc_html__('Contact Us', 'themefarmer-companion'),
		'panel' => 'themefarmer_fontpage_panel',
	));

	$wp_customize->add_section('themefarmer_socials_section', array(
		'title'    => esc_html__('Social Links', 'themefarmer-companion'),
		'priority' => 50,
	));
	

	$wp_customize->get_section('themefarmer_home_slider_section')->priority       = 20;
	$wp_customize->get_section('themefarmer_home_services_section')->priority     = 20;
	$wp_customize->get_section('themefarmer_home_about_section')->priority        = 30;
	$wp_customize->get_section('themefarmer_home_team_section')->priority         = 50;
	$wp_customize->get_section('themefarmer_home_testimonials_section')->priority = 70;
	$wp_customize->get_section('themefarmer_home_brands_section')->priority       = 80;
	$wp_customize->get_section('themefarmer_home_contact_section')->priority      = 110;
/* Sections End */

/*Slider start*/
	$slide_heading     = apply_filters('themefarmer_home_slider_heading', esc_html__('Super Perfect Business Theme', 'themefarmer-companion'));
	$slide_description = apply_filters('themefarmer_home_slider_description', esc_html__('Super Flexible to customize, Super Fast, Quickly build your site.', 'themefarmer-companion'));
	$slide_btn1_label = apply_filters('themefarmer_home_slider_btn1_label', esc_html__('Vew Details', 'themefarmer-companion'));
	$slide_btn2_label = apply_filters('themefarmer_home_slider_btn2_label', esc_html__('Buy Now', 'themefarmer-companion'));

	$wp_customize->add_setting('themefarmer_home_slider', array(
		'sanitize_callback' => 'themefarmer_field_repeater_sanitize',
		'transport'         => 'postMessage',
		'default'           => array(
			array(
				'heading'      => $slide_heading,
				'description'  => $slide_description,
				'image'        => get_template_directory_uri() . '/images/slide1.jpg',
				'button1_text' => $slide_btn1_label,
				'button1_url'  => '#',
				'button2_text' => $slide_btn2_label,
				'button2_url'  => '#',
			),
			array(
				'heading'      => $slide_heading,
				'description'  => $slide_description,
				'image'        => get_template_directory_uri() . '/images/slide2.jpg',
				'button1_text' => $slide_btn1_label,
				'button1_url'  => '#',
				'button2_text' => $slide_btn2_label,
				'button2_url'  => '#',
			),
			array(
				'heading'      => $slide_heading,
				'description'  => $slide_description,
				'image'        => get_template_directory_uri() . '/images/slide3.jpg',
				'button1_text' => $slide_btn1_label,
				'button1_url'  => '#',
				'button2_text' => $slide_btn2_label,
				'button2_url'  => '#',
			),
			array(
				'heading'      => $slide_heading,
				'description'  => $slide_description,
				'image'        => get_template_directory_uri() . '/images/slide4.jpg',
				'button1_text' => $slide_btn1_label,
				'button1_url'  => '#',
				'button2_text' => $slide_btn2_label,
				'button2_url'  => '#',
			),
		),
	));

	$wp_customize->add_control(new ThemeFarmer_Field_Repeater($wp_customize, 'themefarmer_home_slider', array(
		'label'     => esc_html__('Slide', 'themefarmer-companion'),
		'section'   => 'themefarmer_home_slider_section',
		'priority'  => 30,
		'row_label' => esc_html__('Slide', 'themefarmer-companion'),
		'max_items' => 4,
		'fields'    => array(
			'heading'      => array(
				'type'    => 'text',
				'label'   => esc_attr__('Title', 'themefarmer-companion'),
				'default' => esc_attr('Slide Heading', 'themefarmer-companion'),
			),
			'description'  => array(
				'type'    => 'textarea',
				'label'   => esc_attr__('Description', 'themefarmer-companion'),
				'default' => esc_attr('Awesome Slide Description', 'themefarmer-companion'),
			),
			'image'        => array(
				'type'    => 'image',
				'label'   => esc_attr__('Image', 'themefarmer-companion'),
				'default' => esc_url(get_template_directory_uri() . '/images/slide3.jpg'),
			),
			'button1_text' => array(
				'type'    => 'text',
				'label'   => esc_attr__('Button Text', 'themefarmer-companion'),
				'default' => esc_attr__('Read More', 'themefarmer-companion'),
			),
			'button1_url'  => array(
				'type'    => 'text',
				'label'   => esc_attr__('Button URL', 'themefarmer-companion'),
				'default' => esc_url('#'),
			),
			'button2_text' => array(
				'type'    => 'text',
				'label'   => esc_attr__('Button Text', 'themefarmer-companion'),
				'default' => esc_attr__('Buy Now', 'themefarmer-companion'),
			),
			'button2_url'  => array(
				'type'    => 'text',
				'label'   => esc_attr__('Button URL', 'themefarmer-companion'),
				'default' => esc_url('#'),
			),

		),
	)));

	$wp_customize->selective_refresh->add_partial('themefarmer_home_slider', array(
		'selector'         => '.home-carousel .carousel-caption',
		'fallback_refresh' => false,
	));
/*Slider end*/

/*Services start*/

	$wp_customize->add_setting('themefarmer_home_services_heading', array(
		'default'           => esc_html__('Services', 'themefarmer-companion'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control('themefarmer_home_services_heading', array(
		'type'    => 'text',
		'label'   => esc_html__('Heading', 'themefarmer-companion'),
		'section' => 'themefarmer_home_services_section',
	));

	$wp_customize->add_setting('themefarmer_home_services_desc', array(
		'default'           => esc_html__('Services Description', 'themefarmer-companion'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control('themefarmer_home_services_desc', array(
		'type'    => 'textarea',
		'label'   => esc_html__('Description', 'themefarmer-companion'),
		'section' => 'themefarmer_home_services_section',
	));

	$wp_customize->add_setting('themefarmer_home_services', array(
		'sanitize_callback' => 'themefarmer_field_repeater_sanitize',
		'transport'         => 'postMessage',
		'default'           => array(
			array(
				'heading'     => esc_attr__('Awesome Design', 'themefarmer-companion'),
				'description' => esc_attr__('Lorem ipsum dolor sit amet elit do, consectetur adipiscing, sed eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'themefarmer-companion'),
				'icon'        => 'fa-flash',
				'button_text' => esc_attr__('Read More', 'themefarmer-companion'),
				'button_url'  => '#',
				'page_id'     => 0,
			),
			array(
				'heading'     => esc_attr__('Responsive Design', 'themefarmer-companion'),
				'description' => esc_attr__('Lorem ipsum dolor sit amet elit do, consectetur adipiscing, sed eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'themefarmer-companion'),
				'icon'        => 'fa-star',
				'button_text' => esc_attr__('Read More', 'themefarmer-companion'),
				'button_url'  => '#',
				'page_id'     => 0,
			),
			array(
				'heading'     => esc_attr__('Drag & Drop', 'themefarmer-companion'),
				'description' => esc_attr__('Lorem ipsum dolor sit amet elit do, consectetur adipiscing, sed eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'themefarmer-companion'),
				'icon'        => 'fa-star',
				'button_text' => esc_attr__('Read More', 'themefarmer-companion'),
				'button_url'  => '#',
				'page_id'     => 0,
			),
		),
	));

	$wp_customize->add_control(new ThemeFarmer_Field_Repeater($wp_customize, 'themefarmer_home_services', array(
		'label'     => esc_html__('Services', 'themefarmer-companion'),
		'section'   => 'themefarmer_home_services_section',
		'priority'  => 30,
		'row_label' => esc_html__('Service', 'themefarmer-companion'),
		'max_items' => 6,
		'fields'    => array(

			'heading'     => array(
				'type'    => 'text',
				'label'   => esc_attr__('Title', 'themefarmer-companion'),
				'default' => esc_attr('Service Heading', 'themefarmer-companion'),
			),
			'description' => array(
				'type'    => 'textarea',
				'label'   => esc_attr__('Description', 'themefarmer-companion'),
				'default' => esc_attr('Service Description', 'themefarmer-companion'),
			),
			'color'       => array(
				'type'  => 'color',
				'label' => esc_attr__('Color', 'themefarmer-companion'),
			),
			'icon'        => array(
				'type'    => 'icon',
				'label'   => esc_attr__('Icon', 'themefarmer-companion'),
				'default' => 'fa-star',
			),
			'button_text' => array(
				'type'    => 'text',
				'label'   => esc_attr__('Button Text', 'themefarmer-companion'),
				'default' => esc_attr__('Read More', 'themefarmer-companion'),
			),
			'page_id'     => array(
				'type'        => 'dropdown-pages',
				'label'       => esc_attr__('Select Feature Detail Page', 'themefarmer-companion'),
				'description' => esc_html__('Leave it unselected if you want to enter custom link', 'themefarmer-companion'),
			),
			'button_url'  => array(
				'type'        => 'text',
				'label'       => esc_attr__('Details page  URL', 'themefarmer-companion'),
				'description' => esc_html__('Leave it blank if you have to selected Details page above', 'themefarmer-companion'),
			),
		),
	)));

	$wp_customize->selective_refresh->add_partial('themefarmer_home_services', array(
		'selector'         => '.section-services .service-item',
		'fallback_refresh' => false,
	));
/*Services end*/

/* team start*/
	$wp_customize->add_setting('themefarmer_home_team_heading', array(
		'default'           => esc_html__('Team', 'themefarmer-companion'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control('themefarmer_home_team_heading', array(
		'type'    => 'text',
		'label'   => esc_html__('Heading', 'themefarmer-companion'),
		'section' => 'themefarmer_home_team_section',
	));

	$wp_customize->add_setting('themefarmer_home_team_desc', array(
		'default'           => esc_html__('Team Description', 'themefarmer-companion'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control('themefarmer_home_team_desc', array(
		'type'    => 'textarea',
		'label'   => esc_html__('Description', 'themefarmer-companion'),
		'section' => 'themefarmer_home_team_section',
	));

	$wp_customize->add_setting('themefarmer_home_team', array(
		'sanitize_callback' => 'themefarmer_field_repeater_sanitize',
		'transport'         => 'postMessage',
		'default'           => array(
			array(
				'image'       => get_template_directory_uri() . '/images/slide1.jpg',
				'name'        => esc_attr__('Jhon Doe', 'themefarmer-companion'),
				'description' => 'Fusce eu turpis ipsum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus scelerisque mauris eu neque interdum sagittis.',
				'designation' => esc_attr__('Software Developer', 'themefarmer-companion'),
				'button_text' => esc_attr__('Read More', 'themefarmer-companion'),
				'button_url'  => '#btn-url1',
				'socials'     => array(
					array('icon' => 'fa-facebook', 'link' => '#'),
					array('icon' => 'fa-instagram', 'link' => '#'),
				),
			),
			array(
				'image'       => get_template_directory_uri() . '/images/slide2.jpg',
				'name'        => esc_attr__('Jene Doe', 'themefarmer-companion'),
				'description' => 'Fusce eu turpis ipsum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus scelerisque mauris eu neque interdum sagittis.',
				'designation' => esc_attr__('Website Designer', 'themefarmer-companion'),
				'button_text' => esc_attr__('Read More', 'themefarmer-companion'),
				'button_url'  => '#btn-url1',
				'socials'     => array(
					array('icon' => 'fa-facebook', 'link' => '#'),
					array('icon' => 'fa-instagram', 'link' => '#'),
				),
			),
			array(
				'image'       => get_template_directory_uri() . '/images/slide3.jpg',
				'name'        => esc_attr__('Jhon Doe', 'themefarmer-companion'),
				'description' => 'Fusce eu turpis ipsum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus scelerisque mauris eu neque interdum sagittis.',
				'designation' => esc_attr__('Software Developer', 'themefarmer-companion'),
				'button_text' => esc_attr__('Read More', 'themefarmer-companion'),
				'button_url'  => '#btn-url1',
				'socials'     => array(
					array('icon' => 'fa-facebook', 'link' => '#'),
					array('icon' => 'fa-instagram', 'link' => '#'),
				),
			),
			array(
				'image'       => get_template_directory_uri() . '/images/slide4.jpg',
				'name'        => esc_attr__('Jene Doe', 'themefarmer-companion'),
				'description' => 'Fusce eu turpis ipsum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus scelerisque mauris eu neque interdum sagittis.',
				'designation' => esc_attr__('Website Designer', 'themefarmer-companion'),
				'button_text' => esc_attr__('Read More', 'themefarmer-companion'),
				'button_url'  => '#btn-url1',
				'socials'     => array(
					array('icon' => 'fa-facebook', 'link' => '#'),
					array('icon' => 'fa-instagram', 'link' => '#'),
				),
			),
		),
	));

	$wp_customize->add_control(new ThemeFarmer_Field_Repeater($wp_customize, 'themefarmer_home_team', array(
		'label'     => esc_html__('Members', 'themefarmer-companion'),
		'section'   => 'themefarmer_home_team_section',
		'priority'  => 30,
		'max_items' => 4,
		'row_label' => esc_html__('Member', 'themefarmer-companion'),
		'fields'    => array(

			'image'       => array(
				'type'  => 'image',
				'label' => esc_attr__('Image', 'themefarmer-companion'),
			),

			'name'        => array(
				'type'  => 'text',
				'label' => esc_attr__('Title', 'themefarmer-companion'),
			),
			'designation' => array(
				'type'  => 'text',
				'label' => esc_attr__('Designation', 'themefarmer-companion'),
			),
			'description' => array(
				'type'  => 'textarea',
				'label' => esc_attr__('Description', 'themefarmer-companion'),
			),

			'button_url'  => array(
				'type'    => 'text',
				'label'   => esc_attr__('Button URL', 'themefarmer-companion'),
				'default' => esc_url('#url-link'),
			),
			'socials'     => array(
				'type'         => 'repeater',
				'label'        => esc_attr__('Social Items', 'themefarmer-companion'),
				'button_label' => esc_attr__('Add Icon', 'themefarmer-companion'),
				'default'      => array(
					array('icon' => 'fa-facebook', 'link' => '#'),
					array('icon' => 'fa-instagram', 'link' => '#'),
				),
				'fields'       => array(
					'icon' => array('type' => 'icon'),
					'link' => array('type' => 'text'),
				),
			),
		),
	)));
/*team end*/

/*Testimonials start*/

	$wp_customize->add_setting('themefarmer_home_testimonials_heading', array(
		'default'           => esc_html__('Testimonials', 'themefarmer-companion'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control('themefarmer_home_testimonials_heading', array(
		'type'    => 'text',
		'label'   => esc_html__('Heading', 'themefarmer-companion'),
		'section' => 'themefarmer_home_testimonials_section',
	));

	$wp_customize->add_setting('themefarmer_home_testimonials_desc', array(
		'default'           => esc_html__('Testimonials Description', 'themefarmer-companion'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control('themefarmer_home_testimonials_desc', array(
		'type'    => 'textarea',
		'label'   => esc_html__('Description', 'themefarmer-companion'),
		'section' => 'themefarmer_home_testimonials_section',
	));

	$wp_customize->add_setting('themefarmer_home_testimonials', array(
		'sanitize_callback' => 'themefarmer_field_repeater_sanitize',
		'transport'         => 'postMessage',
		'default'           => array(
			array(
				'image'       => get_template_directory_uri() . '/images/slide1.jpg',
				'title'       => esc_attr__('Testimonial Heading', 'themefarmer-companion'),
				'subtitle'    => esc_attr__('Designation', 'themefarmer-companion'),
				'description' => esc_attr__('Testimonial Description', 'themefarmer-companion'),
				'link'        => '#example.com',
			),
			array(
				'image'       => get_template_directory_uri() . '/images/slide2.jpg',
				'title'       => esc_attr__('Testimonial Heading', 'themefarmer-companion'),
				'subtitle'    => esc_attr__('Designation', 'themefarmer-companion'),
				'description' => esc_attr__('Testimonial Description', 'themefarmer-companion'),
				'link'        => '#example.com',
			),
		),
	));

	$wp_customize->add_control(new ThemeFarmer_Field_Repeater($wp_customize, 'themefarmer_home_testimonials', array(
		'label'     => esc_html__('Testimonials', 'themefarmer-companion'),
		'section'   => 'themefarmer_home_testimonials_section',
		'priority'  => 30,
		'max_items' => 2,
		'row_label' => esc_html__('Testimonial', 'themefarmer-companion'),
		'fields'    => array(
			'image'       => array(
				'type'    => 'image',
				'label'   => esc_attr__('Image', 'themefarmer-companion'),
				'default' => esc_url(get_template_directory_uri() . '/images/slide1.jpg'),
			),
			'title'       => array(
				'type'  => 'text',
				'label' => esc_attr__('Title', 'themefarmer-companion'),
			),
			'subtitle'    => array(
				'type'  => 'text',
				'label' => esc_attr__('Subtitle', 'themefarmer-companion'),
			),
			'description' => array(
				'type'  => 'textarea',
				'label' => esc_attr__('Description', 'themefarmer-companion'),
			),
			'link'        => array(
				'type'  => 'text',
				'label' => esc_attr__('Link', 'themefarmer-companion'),
			),
		),
	)));

	$wp_customize->selective_refresh->add_partial('themefarmer_home_testimonials', array(
		'selector'         => '.section-testimonials .feature-item',
		'fallback_refresh' => false,
	));
/*Testimonials end*/

/*Brands start*/
	$wp_customize->add_setting('themefarmer_home_brands_heading', array(
		'default'           => esc_html__('Brands', 'themefarmer-companion'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control('themefarmer_home_brands_heading', array(
		'type'    => 'text',
		'label'   => esc_html__('Heading', 'themefarmer-companion'),
		'section' => 'themefarmer_home_brands_section',
	));

	$wp_customize->add_setting('themefarmer_home_brands_desc', array(
		'default'           => esc_html__('Brands Description', 'themefarmer-companion'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control('themefarmer_home_brands_desc', array(
		'type'    => 'textarea',
		'label'   => esc_html__('Description', 'themefarmer-companion'),
		'section' => 'themefarmer_home_brands_section',
	));

	$wp_customize->add_setting('themefarmer_home_brands', array(
		'sanitize_callback' => 'themefarmer_field_repeater_sanitize',
		'transport'         => 'postMessage',
		'default'           => array(
			array(
				'image' => get_template_directory_uri() . '/images/brand-logo.png',
			),
			array(
				'image' => get_template_directory_uri() . '/images/brand-logo.png',
			),
			array(
				'image' => get_template_directory_uri() . '/images/brand-logo.png',
			),
			array(
				'image' => get_template_directory_uri() . '/images/brand-logo.png',
			),
			array(
				'image' => get_template_directory_uri() . '/images/brand-logo.png',
			),
		),
	));

	$wp_customize->add_control(new ThemeFarmer_Field_Repeater($wp_customize, 'themefarmer_home_brands', array(
		'label'     => esc_html__('Brands', 'themefarmer-companion'),
		'section'   => 'themefarmer_home_brands_section',
		'priority'  => 30,
		'max_items' => 5,
		'row_label' => esc_html__('Brand', 'themefarmer-companion'),
		'fields'    => array(
			'image'      => array(
				'type'  => 'image',
				'label' => esc_attr__('Image', 'themefarmer-companion'),
			),
			'brand_link' => array(
				'type'  => 'text',
				'label' => esc_attr__('Brand URL', 'themefarmer-companion'),
			),
		),
	)));
/*Brands end*/

/*Social Links*/
	if(apply_filters('themefarmer_is_theme_using_social_logins', false )){

		$wp_customize->add_setting('themefarmer_socials', array(
			'sanitize_callback' => 'themefarmer_field_repeater_sanitize',
			'transport'         => 'postMessage',
			'default'           => array(
				array(
					'icon' => 'fa-facebook',
					'link' => '#',
				),
				array(
					'icon' => 'fa-youtube',
					'link' => '#',
				),
				array(
					'icon' => 'fa-instagram',
					'link' => '#',
				),
				array(
					'icon' => 'fa-google-plus',
					'link' => '#',
				),
				array(
					'icon' => 'fa-linkedin',
					'link' => '#',
				),
			),
		));

		$wp_customize->add_control(new ThemeFarmer_Field_Repeater($wp_customize, 'themefarmer_socials', array(
			'label'     => esc_html__('Social Links', 'themefarmer-companion'),
			'section'   => 'themefarmer_socials_section',
			'priority'  => 30,
			'max_items' => 5,
			'row_label' => esc_html__('Social Site', 'themefarmer-companion'),
			'fields'    => array(
				'icon' => array(
					'type'    => 'icon',
					'label'   => esc_attr__('Icon', 'themefarmer-companion'),
					'default' => 'fa-star',
				),
				'link' => array(
					'type'  => 'text',
					'label' => esc_attr__('Social Link', 'themefarmer-companion'),
				),
			),
		)));
	}
	
/*social Links*/


	/*$home_sectionss = array('services', 'about', 'products-latest', 'team', 'callout', 'testimonials', 'brands', 'subscribe', 'blog', 'contact');
	foreach ($home_sectionss as $key => $section) {
		$section_name = str_replace('-', '_', $section);
		$section_name = str_replace(' ', '_', $section_name);

		$wp_customize->add_setting('scope_is_enable_section_' . $section_name, array(
			'default'           => true,
			'sanitize_callback' => 'scope_sanitize_checkbox',
		));

		$wp_customize->add_control(new ThemeFarmer_Field_Switch($wp_customize, 'scope_is_enable_section_' . $section_name, array(
			'label'    => __('Enable/Disable Section', 'scope'),
			'section'  => 'themefarmer_home_' . $section_name . '_section',
			'priority' => 5,
		)));
	}*/


// themefarmer_home_subscribe_heading
	$sections = array('services', 'about', 'team', 'testimonials', 'brands', 'contact', 'subscribe');
	foreach ($sections as $key => $section) {
		$section_id = 'themefarmer_home_'.$section.'_section';
		$section_head_id = 'themefarmer_home_'.$section.'_heading';
		$section_desc_id = 'themefarmer_home_'.$section.'_desc';


		$wp_customize->selective_refresh->add_partial($section_head_id, array(
			'selector'         => '.section-'.$section.' .section-title',
			'fallback_refresh' => false,
		));

		$wp_customize->selective_refresh->add_partial($section_desc_id, array(
			'selector'         => '.section-'.$section.' .section-description',
			'fallback_refresh' => false,
		));
		
		$desc_control = $wp_customize->get_control($section_desc_id);
		if($desc_control){
			$desc_control->type = 'textarea';
		}
	}

}
add_action('customize_register', 'themefarmer_companion_customize_register', 99);

function themefarmer_companion_live_customizer() {
	wp_enqueue_script('themefarmer-companion-customizer', THEMEFARMER_COMPANION_URI . 'assets/js/themefarmer-companion-customizer.js', array('jquery'), THEMEFARMER_COMPANION_VAR, true);
}
add_action('customize_preview_init', 'themefarmer_companion_live_customizer');

function themefarmer_customize_control_enqueue(){
	$is_theme_init = get_theme_mod('tf_comp_is_first_setup_done', false);
	$is_theme_init = !$is_theme_init;
	wp_enqueue_script('themefarmer-companion-customize-control', THEMEFARMER_COMPANION_URI . 'assets/js/companion-customizer-controls.js', array('jquery'), THEMEFARMER_COMPANION_VAR, true);
	wp_localize_script('themefarmer-companion-customize-control', 'tf_comp_controls', array(
		'is_theme_init' => $is_theme_init,
	));
}
add_action('customize_controls_enqueue_scripts', 'themefarmer_customize_control_enqueue');

function themefarmer_comp_set_first_default_options() {
	$is_theme_init = get_theme_mod('tf_comp_is_first_setup_done', false);
	if (!$is_theme_init) {
		set_theme_mod('tf_comp_is_first_setup_done', true);
	}
}
add_action('customize_save_after', 'themefarmer_comp_set_first_default_options');
