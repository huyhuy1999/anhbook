<?php
function themefarmer_companion_newstore_customize_register($wp_customize) {

	$wp_customize->add_section('themefarmer_home_slider_section', array(
		'title'      => esc_html__('Slider', 'themefarmer-companion'),
		'panel'      => 'themefarmer_fontpage_panel',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_section('themefarmer_home_brands_section', array(
		'title' => esc_html__('Brands', 'themefarmer-companion'),
		'panel' => 'themefarmer_fontpage_panel',
	));

/*Slider start*/
	$wp_customize->add_setting('themefarmer_home_slider', array(
		'sanitize_callback' => 'themefarmer_field_repeater_sanitize',
		'transport'         => 'postMessage',
	));

	$wp_customize->add_control(new ThemeFarmer_Field_Repeater($wp_customize, 'themefarmer_home_slider', array(
		'label'     => esc_html__('Slide', 'themefarmer-companion'),
		'section'   => 'themefarmer_home_slider_section',
		'priority'  => 30,
		'row_label' => esc_html__('Slide', 'themefarmer-companion'),
		'max_items' => 3,
		'fields'    => array(
			'heading'     => array(
				'type'    => 'text',
				'label'   => esc_attr__('Title', 'themefarmer-companion'),
				'default' => esc_attr('Slide Heading', 'themefarmer-companion'),
			),
			'description' => array(
				'type'    => 'textarea',
				'label'   => esc_attr__('Description', 'themefarmer-companion'),
				'default' => esc_attr('Awesome Slide Description', 'themefarmer-companion'),
			),
			'image'       => array(
				'type'    => 'image',
				'label'   => esc_attr__('Image', 'themefarmer-companion'),
				'default' => esc_url(get_template_directory_uri() . '/images/slide3.jpg'),
			),
			'button_text' => array(
				'type'    => 'text',
				'label'   => esc_attr__('Button Text', 'themefarmer-companion'),
				'default' => esc_attr__('Learn More', 'themefarmer-companion'),
			),
			'button_url'  => array(
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
	// if (apply_filters('themefarmer_is_theme_using_social_logins', false)) {

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
		'section'   => 'newstore_topbar_section',
		'priority'  => 300,
		'max_items' => 5,
		'row_label' => esc_html__('Social Link', 'themefarmer-companion'),
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
	// }

/*social Links*/
}
add_action('customize_register', 'themefarmer_companion_newstore_customize_register', 99);

function themefarmer_companion_newstore_ocdi_import_files() {
	return array(
		array(
			'import_file_name'             => 'Demo 1',
			'categories'                   => array('Customizer'),
			'local_import_file'            => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-wordpress.xml',
			'local_import_widget_file'     => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-widgets.wie',
			'local_import_customizer_file' => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-customizer.dat',
			'import_preview_image_url'     => esc_url(THEMEFARMER_COMPANION_URI . '/theme-files/demos/newstore/newstore-demo-1.png'),
			'preview_url'                  => esc_url('https://demo.themefarmer.com/newstore/'),
		),
		array(
			'import_file_name'             => 'Demo 2',
			'categories'                   => array('Elementor'),
			'local_import_file'            => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-wordpress.xml',
			'local_import_widget_file'     => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-widgets.wie',
			'local_import_customizer_file' => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-customizer.dat',
			'import_preview_image_url'     => esc_url(THEMEFARMER_COMPANION_URI . '/theme-files/demos/newstore/newstore-demo-2.png'),
			'preview_url'                  => esc_url('https://demo.themefarmer.com/newstore/demo-2'),
		),
		array(
			'import_file_name'             => 'Demo 3',
			'categories'                   => array('Elementor'),
			'local_import_file'            => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-wordpress.xml',
			'local_import_widget_file'     => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-widgets.wie',
			'local_import_customizer_file' => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-customizer.dat',
			'import_preview_image_url'     => esc_url(THEMEFARMER_COMPANION_URI . '/theme-files/demos/newstore/newstore-demo-3.jpg'),
			'preview_url'                  => esc_url('https://demo.themefarmer.com/newstore/demo-3'),
		),
		array(
			'import_file_name'             => 'Demo 4',
			'categories'                   => array('Elementor'),
			'local_import_file'            => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-wordpress.xml',
			'local_import_widget_file'     => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-widgets.wie',
			'local_import_customizer_file' => trailingslashit(THEMEFARMER_COMPANION_DIR) . 'theme-files/demos/newstore/newstore-customizer.dat',
			'import_preview_image_url'     => esc_url(THEMEFARMER_COMPANION_URI . '/theme-files/demos/newstore/newstore-demo-4.jpg'),
			'preview_url'                  => esc_url('https://demo.themefarmer.com/newstore/demo-4'),
		),
	);
}
add_filter('pt-ocdi/import_files', 'themefarmer_companion_newstore_ocdi_import_files');

function themefarmer_companion_newstore_ocdi_after_import($selected_import) {

	$top_menu        = get_term_by('name', 'Top Bar Menu', 'nav_menu');
	$primary_menu    = get_term_by('name', 'Primary Menu', 'nav_menu');
	$catlog_nav_menu = get_term_by('name', 'Catalog Menu', 'nav_menu');
	$cat_1           = get_term_by('name', 'Men', 'product_cat');
	$cat_2           = get_term_by('name', 'Toy Store', 'product_cat');
	$cat_3           = get_term_by('name', 'Decor', 'product_cat');
	$cat_4           = get_term_by('name', 'Accessories', 'product_cat');
	$cat_5           = get_term_by('name', 'Women', 'product_cat');

	set_theme_mod('nav_menu_locations', array(
		'top_nav'         => $top_menu->term_id,
		'primary'         => $primary_menu->term_id,
		'product_catalog' => $catlog_nav_menu->term_id,
	));

	if (absint($cat_1->term_id)) {
		set_theme_mod('newstore_frontpage_cat_id_1', absint($cat_1->term_id));
	}

	if (absint($cat_2->term_id)) {
		set_theme_mod('newstore_frontpage_cat_id_2', absint($cat_2->term_id));
	}

	if (absint($cat_3->term_id)) {
		set_theme_mod('newstore_frontpage_cat_id_3', absint($cat_3->term_id));
	}

	if (absint($cat_4->term_id)) {
		set_theme_mod('newstore_frontpage_cat_id_4', absint($cat_4->term_id));
	}

	if (absint($cat_5->term_id)) {
		set_theme_mod('newstore_frontpage_cat_id_5', absint($cat_5->term_id));
	}

	// Assign front page and posts page (blog page).

	$front_page_id = get_page_by_title('Home');

	if ('Demo 1' === $selected_import['import_file_name']) {
		$front_page_id = get_page_by_title('Home');
		update_post_meta( $front_page_id, '_wp_page_template', 'templates/frontpage.php' );
		esc_html_e('To make changes on Front Page go to Appearance -> Customize', 'themefarmer-companion');
	} elseif ('Demo 2' === $selected_import['import_file_name']) {
		$front_page_id = get_page_by_title('Demo 2');
		esc_html_e('To make changes on Front Page go to Pages -> All Pages -> Edit Page "Demo 2" with Elementor', 'themefarmer-companion');
	} elseif ('Demo 3' === $selected_import['import_file_name']) {
		$front_page_id = get_page_by_title('Demo 3');
		esc_html_e('To make changes on Front Page go to Pages -> All Pages -> Edit Page "Demo 3" with Elementor', 'themefarmer-companion');
	} elseif ('Demo 4' === $selected_import['import_file_name']) {
		$front_page_id = get_page_by_title('Demo 4');
		esc_html_e('To make changes on Front Page go to Pages -> All Pages -> Edit Page "Demo 4" with Elementor', 'themefarmer-companion');
	}

	$blog_page_id = get_page_by_title('Blog');
	update_option('show_on_front', 'page');
	update_option('page_on_front', $front_page_id->ID);
	update_option('page_for_posts', $blog_page_id->ID);
}
add_action('pt-ocdi/after_import', 'themefarmer_companion_newstore_ocdi_after_import');