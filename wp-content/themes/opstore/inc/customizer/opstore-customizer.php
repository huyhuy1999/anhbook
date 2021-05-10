<?php

function opstore_custom_customize_register( $wp_customize ) {

  $default = opstore_get_default_theme_options();

    /**
     * Add General Settings panel
     */

    $wp_customize->add_panel( 'general_settings', array(
        'priority'         =>    1,
        'capability'       =>    'edit_theme_options',
        'theme_supports'   =>    '',
        'title'            =>    esc_html__( 'General Settings', 'opstore' ),
        'description'      =>    esc_html__( 'This allows to edit general theme settings', 'opstore' ),
    ));

    $wp_customize->get_section('title_tagline')->panel = 'general_settings';
    $wp_customize->remove_section('header_image');
    $wp_customize->get_section('background_image')->panel = 'general_settings';
    $wp_customize->get_section('static_front_page')->panel = 'general_settings';
    $wp_customize->get_section('colors')->panel = 'general_settings'; 
    $wp_customize->get_control('background_color')->section = 'background_image';

    /* Color Option */
    $wp_customize->add_setting( 'opstore_skincolor_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_skincolor_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Theme Skin Color', 'opstore' ),
      'section'   => 'colors',
      'priority'  => 1
    ) ) ); 

    $wp_customize->add_setting(
        'opstore_theme_color', array(
            'default' => $default['opstore_theme_color'],
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'opstore_theme_color', 
            array(
            'label' => esc_html__('Theme Color','opstore'), 
            'section' => 'colors',
            'settings' => 'opstore_theme_color',
            'priority' => 2
            )
        )
    );

    /* Additional Section */

    $wp_customize->add_section( 'opstore_additional_section', array(
        'title'           =>      esc_html__('Additional Settings', 'opstore'),
        'priority'        =>      45,
        'panel'           => 'general_settings'
    ));
     
    //Animation option 
    $wp_customize->add_setting( 'opstore_additional_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_additional_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Homepage Animations', 'opstore' ),
      'section'   => 'opstore_additional_section',
      'priority'  => 1
    ) ) ); 

    $wp_customize->add_setting( 'opstore_smooth_scroll_option', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_smooth_scroll_option',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Enable/Disable Smooth Scroll', 'opstore' ),
      'section'   => 'opstore_additional_section',
      'choices'   => array(
            'show'  => esc_html__( 'Enable', 'opstore' ),
            'hide'  => esc_html__( 'Disable', 'opstore' )
          ),
      'priority'  => 2
    ) ) ); 


    $wp_customize->add_setting( 'opstore_preloader_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    //preloader option
    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_preloader_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Preloader option', 'opstore' ),
      'section'   => 'opstore_additional_section',
    ) ) ); 

    $wp_customize->add_setting( 'opstore_preloader_option', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_preloader_option',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Enable/Disable Preloader', 'opstore' ),
      'section'   => 'opstore_additional_section',
      'choices'   => array(
            'show'  => esc_html__( 'Enable', 'opstore' ),
            'hide'  => esc_html__( 'Disable', 'opstore' )
          ),
    ) ) );       
   
    /* Webpage Layout */
    $wp_customize->add_section( 'opstore_webpage_section', array(
        'title'           =>      esc_html__('Webpage Layout', 'opstore'),
        'priority'        =>      35,
        'panel'           => 'general_settings'
    ));

    $wp_customize->add_setting( 'opstore_webpage_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_webpage_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Webpage Layout', 'opstore' ),
      'section'   => 'opstore_webpage_section',
      'priority'  => 1
    ) ) ); 

    $wp_customize->add_setting( 'opstore_webpage_layout', array(
              'default'           =>     $default['opstore_webpage_layout'],
              'sanitize_callback' => 'opstore_sanitize_radio'
          )
    );

    $wp_customize->add_control( new Opstore_Customize_Radioimage_Control(
          $wp_customize,
          'opstore_webpage_layout',
          array(
              'section'       =>      'opstore_webpage_section',
              'label'         =>      esc_html__('Choose Webpage Layout','opstore'),
              'type'          =>      'radioimage',
              'choices'       =>  array( 
                  'opstore-boxed'       => OPSTORE_IMAGES.'boxed-all.png',
                  'opstore-fullwidth'   => OPSTORE_IMAGES.'full.png',
                ),
              'priority'  => 2
              )
          )
    );  

    /*===========================================================================================================
     * Header Pannel
    */

    $wp_customize->add_panel(
        'opstore_header_settings_panel', 
            array(
                'priority'       => 2,
                'capability'     => 'edit_theme_options',
                'theme_supports' => '',
                'title'          => esc_html__( 'Header Settings', 'opstore' ),
            ) 
    );

    /* Header Layouts ==========================================================*/

    $wp_customize->add_section( 'opstore_header_layouts_section', array(
        'title'           =>     esc_html__('Header Layouts', 'opstore'),
        'priority'        =>      '1',
        'panel'           => 'opstore_header_settings_panel'
    ));

    $wp_customize->add_setting( 'opstore_headerl_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_headerl_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Header Layouts', 'opstore' ),
      'section'   => 'opstore_header_layouts_section',
      'priority'  => 1
    ) ) );

    $wp_customize->add_setting( 'opstore_header_layouts', array(
              'default'       =>      $default['opstore_header_layouts'],
              'sanitize_callback' => 'opstore_sanitize_header_layouts'
          )
    );

    $wp_customize->add_control( new Opstore_Customize_Radioimage_Control(
          $wp_customize,
          'opstore_header_layouts',
          array(
              'section'       =>      'opstore_header_layouts_section',
              'label'         =>      esc_html__('Choose Header Layout','opstore'),
              'type'          =>      'radioimage',
              'choices'       =>      array( 
                'style1'    => OPSTORE_IMAGES.'header2.png',
                'Style2'    => OPSTORE_IMAGES.'header1.png',
                ),
              'priority'  => 2
              )
          )
    );

   /* Bottom header============================================= */
    $wp_customize->add_setting( 'opstore_bheader_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_bheader_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Bottom Header Options', 'opstore' ),
      'section'   => 'opstore_header_layouts_section',
      'priority'  => 6
    ) ) ); 

    $wp_customize->add_setting( 'opstore_sticky_menu', array(
      'default' => $default['opstore_sticky_menu'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_sticky_menu',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Sticky Menu', 'opstore' ),
      'section'   => 'opstore_header_layouts_section',
      'choices'   => array(
            'show'  => esc_html__( 'Enable', 'opstore' ),
            'hide'  => esc_html__( 'Disable', 'opstore' )
          ),
      'priority'  => 8
    ) ) ); 

    $wp_customize->add_setting( 'opstore_search_enable', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
          ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_search_enable',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Search Icon', 'opstore' ),
      'section'   => 'opstore_header_layouts_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'opstore' ),
            'hide'  => esc_html__( 'Hide', 'opstore' )
          ),
      'priority'  => 9
    ) ) ); 

    if(class_exists('woocommerce')){    
    $wp_customize->add_setting( 'opstore_cart_enable', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
      'transport'         => 'postMessage'
          ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_cart_enable',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Cart Icon', 'opstore' ),
      'section'   => 'opstore_header_layouts_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'opstore' ),
            'hide'  => esc_html__( 'Hide', 'opstore' )
          ),
      'priority'  => 10
    ) ) );  

    $wp_customize->add_setting( 'opstore_wishlist_enable', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
      'transport'         => 'postMessage'
          ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_wishlist_enable',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Wishlist Icon', 'opstore' ),
      'section'   => 'opstore_header_layouts_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'opstore' ),
            'hide'  => esc_html__( 'Hide', 'opstore' )
          ),
      'priority'  => 11
    ) ) ); 

    $wp_customize->add_setting( 'opstore_login_enable', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
      'transport'         => 'postMessage'
          ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_login_enable',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'User Login', 'opstore' ),
      'section'   => 'opstore_header_layouts_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'opstore' ),
            'hide'  => esc_html__( 'Hide', 'opstore' )
          ),
      'priority'  => 12
    ) ) ); 
    }

    /* Top Header Options =========================================*/
    $wp_customize->add_section( 'opstore_topheader_section', array(
        'title'           =>     esc_html__('Top Header settings', 'opstore'),
        'priority'        =>      2,
        'panel'           => 'opstore_header_settings_panel'
    )); 
    $wp_customize->add_setting( 'opstore_topheader_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_topheader_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Top Header Settings', 'opstore' ),
      'section'   => 'opstore_topheader_section',
      'priority'  => 1
    ) ) );

    $wp_customize->add_setting( 'opstore_top_header_show', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
      'transport'         => 'postMessage'
    ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_top_header_show',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Hide / Show Top header', 'opstore' ),
      'section'   => 'opstore_topheader_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'opstore' ),
            'hide'  => esc_html__( 'Hide', 'opstore' )
          ),
      'priority'  => 2
    ) ) ); 

    $wp_customize->add_setting(
        'top_header_bg_color', array(
            'default' => '#000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'top_header_bg_color', 
            array(
            'label' => esc_html__('Background Color','opstore'), 
            'section' => 'opstore_topheader_section',
            'priority' => 2
            )
        )
    );
    $wp_customize->add_setting(
        'top_header_text_color', array(
            'default' => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'top_header_text_color', 
            array(
            'label' => esc_html__('Text Color','opstore'), 
            'section' => 'opstore_topheader_section',
            'priority' => 2
            )
        )
    );

    $wp_customize->add_setting( 'opstore_topheader_type', array(
      'capability' => 'edit_theme_options',
      'default' => 'info',
      'sanitize_callback' => 'opstore_sanitize_radio',
    ) );

    $wp_customize->add_control(
        'opstore_topheader_type',
        array(
            'type'      => 'radio',
            'choices'   => array(
                              'info' => esc_html__('Info','opstore'),
                              'notification' => esc_html__('Notification','opstore'),
                           ),
            'label'     => esc_html__( 'Content Type', 'opstore' ),
            'section'   => 'opstore_topheader_section',
            'priority'  => 3
        )
    );
    $wp_customize->add_setting( 'top_notification_text', array(
            'sanitize_callback' => 'wp_kses_post',         
        )
    );    
    $wp_customize->add_control( 'top_notification_text', array(
            'type'      => 'textarea',
            'label'     => esc_html__( 'Notification Text', 'opstore' ),
            'section'   => 'opstore_topheader_section',
            'active_callback' => 'top_header_notification' 
        )
    );

    $wp_customize->add_setting( 'top_phone', array(
            'sanitize_callback' => 'wp_kses_post',            
        )
    );    
    $wp_customize->add_control( 'top_phone', array(
            'type'      => 'text',
            'label'     => esc_html__( 'Phone No.', 'opstore' ),
            'section'   => 'opstore_topheader_section',
            'active_callback' => 'top_header_info' 
        )
    );

    $wp_customize->add_setting( 'top_email', array(
            'sanitize_callback' => 'wp_kses_post',          
        )
    );    
    $wp_customize->add_control( 'top_email', array(
            'type'      => 'text',
            'label'     => esc_html__( 'Email Address', 'opstore' ),
            'section'   => 'opstore_topheader_section',
            'active_callback' => 'top_header_info' 
        )
    );   

    /* social Icons============================================ */

    $wp_customize->add_section( 'opstore_social_section', array(
        'title' => esc_html__( 'Social Settings', 'opstore' ),
        'priority'        =>      32
    ));

    $wp_customize->add_setting( 'opstore_social_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_social_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Social Icons Settings', 'opstore' ),
      'section'   => 'opstore_social_section',
      'priority'  => 1
    ) ) ); 

    $socials = array('Facebook','Twitter','Linkedin','Instagram','Pinterest');
    foreach($socials as $social){

    $wp_customize->add_setting('opstore_'.$social,
            array(
              'sanitize_callback' => 'esc_url_raw',
              'transport'=>'postMessage'
              )
            );

    $wp_customize->add_control( 'opstore_'.$social,
        array(
            'label'  => esc_html($social),
             /* translators: %s: social media names */ 
            'description'=>sprintf(esc_html__( 'Enter URL for %s', 'opstore' ),$social),
            'section' => 'opstore_social_section',
            'type' => 'url',
            'priority'=> 6
        )
    ); 

   $wp_customize->selective_refresh->add_partial( 'opstore_'.$social, array(
      'selector'        => '.social-icons',
      'container_inclusive' => true,
      'render_callback' => 'opstore_social_icons',
    ) ); 

    }//end foreach;

    /*------------Inner Page settings---------------------------------*/

    $wp_customize->add_panel(
     'opstore_pagepost_settings',
      array(
         'priority' => 32,
         'capability' => 'edit_theme_options',
         'theme_supports' => '',
         'title' => esc_html__( 'Inner Page Settings', 'opstore' ),
      )
    );

    $wp_customize -> add_section(
          'opstore_page_banner',
          array(
              'title' => esc_html__('Page Banner Settings','opstore'),
              'priority' => 30,
              'panel' => 'opstore_pagepost_settings'
          )
    );
    
    //Banner Settings

    $wp_customize->add_setting( 'opstore_banner_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_banner_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Banner Settings', 'opstore' ),
      'section'   => 'opstore_page_banner',
    ) ) );

    $wp_customize->add_setting( 'opstore_page_banner_show', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_page_banner_show',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Enable/Disable Banner', 'opstore' ),
      'section'   => 'opstore_page_banner',
      'choices'   => array(
            'show'  => esc_html__( 'Enable', 'opstore' ),
            'hide'  => esc_html__( 'Disable', 'opstore' )
          ),
    ) ) ); 

    $wp_customize->add_setting('opstore_banner_title_position',array(
         'default' => $default['opstore_banner_title_position'],
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'sanitize_text_field',
         )
    );
    $wp_customize->add_control( 'opstore_banner_title_position',
         array(
             'label'  => esc_html__( 'Title Position', 'opstore' ),
             'section' => 'opstore_page_banner',
             'type' => 'select',
             'choices' => array(
                'left'  => esc_html__( 'Left', 'opstore' ),
                'right'  => esc_html__( 'Right', 'opstore' ),
                'center'  => esc_html__( 'Center', 'opstore' ),

              ),
         )
    );

    $wp_customize->add_setting( 'opstore_banner_height', array(
            'sanitize_callback' => 'wp_kses_post',
            'default' => $default['opstore_banner_height']          
        )
    );    
    $wp_customize->add_control( 'opstore_banner_height', array(
            'type'      => 'number',
            'label'     => esc_html__( 'Banner Height', 'opstore' ),
            'description' => esc_html__( 'Height of banner in px.', 'opstore' ),
            'section'   => 'opstore_page_banner',
        )
    ); 

    $wp_customize->add_setting(
      'opstore_banner_image',
      array(
          'default' => '',
          'sanitize_callback'=>'esc_url_raw'
          )
    );
    $wp_customize->add_control(
     new wp_customize_Image_Control(
         $wp_customize,
         'opstore_banner_image',
         array(
             'label'      => esc_html__( 'Upload Banner Image', 'opstore' ),
             'description'=> esc_html__('Suggested Dimensions for Banner:1920x325','opstore'),
             'section'    => 'opstore_page_banner',
         )
      )
    );

  /**
  *Breadcrumb Settings */
    $wp_customize->add_setting( 'opstore_breadcrumb_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_breadcrumb_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Breadcrumb Settings', 'opstore' ),
      'section'   => 'opstore_page_banner',
    ) ) ); 

    $wp_customize->add_setting( 'opstore_breadcrumb_enable', array(
        'default' => $default['opstore_show_hide_option'],
        'sanitize_callback' => 'opstore_sanitize_switch_option',
    ) );

    $wp_customize->add_control( new Opstore_customize_Switch_Control( $wp_customize, 
      'opstore_breadcrumb_enable',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Enable / Disable Option', 'opstore' ),
        'section'   => 'opstore_page_banner',
        'choices'   => array(
              'show'  => esc_html__( 'Enable', 'opstore' ),
              'hide'  => esc_html__( 'Disable', 'opstore' )
            )
    ) ) ); 

    $wp_customize->add_setting( 'opstore_breadcrumb_delimiter', array(
      'default' => $default['opstore_breadcrumb_delimiter'],
      'sanitize_callback' => 'sanitize_text_field',
    ) );



    $wp_customize->add_control( 'opstore_breadcrumb_delimiter',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Delimitor', 'opstore' ),
      'section'   => 'opstore_page_banner',
    ) ); 


    //Sidebar Options
    $wp_customize -> add_section(
          'opstore_sidebar_section',
          array(
              'title' => esc_html__('Sidebar Settings','opstore'),
              'priority' => 30,
              'panel' => 'opstore_pagepost_settings'
          )
    );

    //Sticky Sidebar option
    $wp_customize->add_setting( 'opstore_sticky_sidebar_option', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_sticky_sidebar_option',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Enable/Disable Sticky Sidebar', 'opstore' ),
      'section'   => 'opstore_sidebar_section',
      'choices'   => array(
            'show'  => esc_html__( 'Enable', 'opstore' ),
            'hide'  => esc_html__( 'Disable', 'opstore' )
          ),
      'priority'  => 3
    ) ) ); 

    //Archive page sidebars
    $wp_customize->add_setting( 'opstore_archivesidebar_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_archivesidebar_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Archive Page Sidebar', 'opstore' ),
      'section'   => 'opstore_sidebar_section',
    ) ) ); 

    $wp_customize->add_setting( 'archive_page_sidebars_layout', array(
              'default'           => $default['archive_page_sidebars_layout'],
              'sanitize_callback' => 'opstore_sanitize_radio'
          )
    );

    $wp_customize->add_control( new Opstore_Customize_Radioimage_Control( $wp_customize, 'archive_page_sidebars_layout',
          array(
              'section'       =>      'opstore_sidebar_section',
              'label'         =>      esc_html__('Choose Archive Page Sidebar', 'opstore'),
              'type'          =>      'radioimage',
              'choices'       =>      array( 
                'leftsidebar' => OPSTORE_IMAGES.'sidebar-left.png',  
                'rightsidebar' => OPSTORE_IMAGES.'sidebar-right.png', 
                )
              )
          )
    );

    $wp_customize->add_setting('archive_page_sidebars',array(
         'default' => $default['archive_page_sidebars'],
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'sanitize_text_field',
         )
    );
    $get_sidebars = opstore_get_sidebars();
    $wp_customize->add_control( 'archive_page_sidebars',
         array(
             'label'  => esc_html__( 'Choose Widget Area ', 'opstore' ),
             'section' => 'opstore_sidebar_section',
             'type' => 'select',
             'choices' => $get_sidebars,
         )
    );

    $wp_customize->add_setting( 'opstore_archivesidebar_help', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Help_Control( $wp_customize, 'opstore_archivesidebar_help',  array( 
      'label'     => esc_html__( 'This will include all the Archive Pages like Category Page,Search Page, Author Page and Tag Page.', 'opstore' ),
      'section'   => 'opstore_sidebar_section',
    ) ) ); 

    //Page Post sidebars
    $wp_customize->add_setting( 'opstore_postsidebar_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_postsidebar_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Page / Post Sidebar', 'opstore' ),
      'section'   => 'opstore_sidebar_section',
    ) ) ); 

    $wp_customize->add_setting('post_page_sidebars_layout', array(
              'default'           => $default['archive_page_sidebars_layout'],
              'sanitize_callback' => 'opstore_sanitize_radio'
          )
    );

    $wp_customize->add_control( new Opstore_Customize_Radioimage_Control(
          $wp_customize,
          'post_page_sidebars_layout',
          array(
              'section'       =>      'opstore_sidebar_section',
              'label'         =>      esc_html__('Choose Default Sidebar', 'opstore'),
              'type'          =>      'radioimage',
              'choices'       =>      array( 
                'leftsidebar' => OPSTORE_IMAGES.'sidebar-left.png',  
                'rightsidebar' => OPSTORE_IMAGES.'sidebar-right.png', 
                'nosidebar' => OPSTORE_IMAGES.'sidebar-no.png',
                )
              )
          )
    );

    $wp_customize->add_setting('post_page_sidebars',array(
         'default' => $default['archive_page_sidebars'],
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'sanitize_text_field',
         )
    );
    $get_sidebars = opstore_get_sidebars();
    $wp_customize->add_control( 'post_page_sidebars',
         array(
             'label'  => esc_html__( 'Choose Widget Area ', 'opstore' ),
             'section' => 'opstore_sidebar_section',
             'type' => 'select',
             'choices' => $get_sidebars,
         )
    );

    $wp_customize->add_setting( 'opstore_postsidebar_help', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Help_Control( $wp_customize, 'opstore_postsidebar_help',  array(                  
      'label'     => esc_html__( 'This option will work if Default Sidebar is choosed from Pages or Posts Metabox, otherwise this option will be override by metabox option.', 'opstore' ),
      'section'   => 'opstore_sidebar_section',
    ) ) ); 

    //Archive Page Settings
    $wp_customize -> add_section(
          'opstore_archive_section',
          array(
              'title' => esc_html__('Archive Settings','opstore'),
              'priority' => 31,
              'panel' => 'opstore_pagepost_settings'
          )
    );

    $wp_customize->add_setting( 'opstore_archive_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_archive_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Archive Settings', 'opstore' ),
      'section'   => 'opstore_archive_section',
    ) ) ); 

    $wp_customize->add_setting( 'opstore_archive_page_excerpts', array(
              'default'           => $default['opstore_archive_page_excerpts'],
              'sanitize_callback' => 'absint'
              ));

    $wp_customize -> add_control( 'opstore_archive_page_excerpts', array(
              'label' => esc_html__('Archive Post Excerpt Length', 'opstore'),
              'section' => 'opstore_archive_section',
              'type' => 'number',
          )
    ); 

    $wp_customize->add_setting( 'opstore_archive_read_more', array(
              'default'           => $default['opstore_archive_read_more'],
              'sanitize_callback' => 'sanitize_text_field'
              ));
    $wp_customize -> add_control(
          'opstore_archive_read_more',
          array(
              'label' => esc_html__('Read More Text', 'opstore'),
              'section' => 'opstore_archive_section',
              'type' => 'text',
          )
    ); 


    /*===========================================================================================================
     * Footer Pannel
    */
    $wp_customize->add_section( 'opstore_footer_section', array(
        'title'           =>     esc_html__('Footer Settings', 'opstore'),
        'priority'       => 40,
    ));

    $wp_customize->add_setting( 'opstore_topfooter_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_topfooter_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Top Footer Settings', 'opstore' ),
      'section'   => 'opstore_footer_section',
    ) ) ); 

    $wp_customize->add_setting( 'opstore_topfooter_show', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
          ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_topfooter_show',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Hide / Show Top Footer', 'opstore' ),
      'section'   => 'opstore_footer_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'opstore' ),
            'hide'  => esc_html__( 'Hide', 'opstore' )
          ),
    ) ) );  

    $wp_customize->add_setting( 'opstore_topfooter_col', array(
            'default'   => $default['opstore_topfooter_col'],
            'sanitize_callback' => 'opstore_sanitize_number'                   
        )
    );    
    $wp_customize->add_control( 'opstore_topfooter_col', array(
            'type'      => 'number',
            'label'     => esc_html__( 'Column no.', 'opstore' ),
            'section'   => 'opstore_footer_section',
        )
    ); 

    $wp_customize->add_setting( 'opstore_bottomfooter_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_bottomfooter_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Bottom Footer Settings', 'opstore' ),
      'section'   => 'opstore_footer_section',
    ) ) ); 

    $wp_customize->add_setting( 'opstore_footer_icons', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
          ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_footer_icons',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Hide / Show Footer Icons', 'opstore' ),
      'section'   => 'opstore_footer_section',
      'choices'   => array(
            'show'  => esc_html__( 'Show', 'opstore' ),
            'hide'  => esc_html__( 'Hide', 'opstore' )
          ),
    ) ) );

    $wp_customize->add_setting( 'opstore_footer_text', array(
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'            
        )
    );    
    $wp_customize->add_control( 'opstore_footer_text', array(
            'type'      => 'textarea',
            'label'     => esc_html__( 'Copyright Text', 'opstore' ),
            'section'   => 'opstore_footer_section',
        )
    ); 
    $wp_customize->selective_refresh->add_partial( 'opstore_footer_text', array(
      'selector'        => '.footer-left',
      'render_callback' => 'opstore_bottom_footer',
    ) );  

    /* For Woocommerce */
    if( class_exists('woocommerce') ){

    $wp_customize->add_section( 'opstore_woo_section', array(
        'title'           =>     esc_html__('Woo Page Settings', 'opstore'),
        'panel'           => 'woocommerce'
    ));

    $wp_customize->add_setting( 'opstore_woo_seperator', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_woo_seperator',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Woocommerce Settings', 'opstore' ),
      'section'   => 'opstore_woo_section',
    ) ) ); 

    $wp_customize->add_setting( 'opstore_shop_sidebar_layout', array(
              'default'           => $default['archive_page_sidebars_layout'],
              'sanitize_callback' => 'opstore_sanitize_radio'
          )
    );

    $wp_customize->add_control( new Opstore_Customize_Radioimage_Control(
          $wp_customize,
          'opstore_shop_sidebar_layout',
          array(
              'section'       =>      'opstore_woo_section',
              'label'         =>      esc_html__('Choose Archive Page Sidebar', 'opstore'),
              'type'          =>      'radioimage',
              'choices'       =>      array( 
                'leftsidebar' => OPSTORE_IMAGES.'sidebar-left.png',  
                'rightsidebar' => OPSTORE_IMAGES.'sidebar-right.png', 
                'nosidebar' => OPSTORE_IMAGES.'sidebar-no.png',
                )
              )
          )
    );

    $wp_customize->add_setting('opstore_shop_sidebar',array(
         'default' => 'shop-sidebar',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'sanitize_text_field',
         )
    );
    $get_sidebars = opstore_get_sidebars();
    $wp_customize->add_control( 'opstore_shop_sidebar',
         array(
             'label'  => esc_html__( 'Choose Widget Area ', 'opstore' ),
             'section' => 'opstore_woo_section',
             'type' => 'select',
             'choices' => $get_sidebars,
         )
    );
    $wp_customize->add_setting( 'opstore_saletag_type', array(
      'capability' => 'edit_theme_options',
      'default' => 'circle',
      'sanitize_callback' => 'opstore_sanitize_radio',
    ) );

    $wp_customize->add_control(
        'opstore_saletag_type',
        array(
            'type'      => 'radio',
            'choices'   => array(
                              'circle' => esc_html__('Circle','opstore'),
                              'ribbon' => esc_html__('Ribbon','opstore'),
                           ),
            'label'     => esc_html__( 'Sale Tag Type', 'opstore' ),
            'section'   => 'opstore_woo_section',
        )
    );
    $wp_customize->add_setting( 'opstore_saletag_label', array(
      'capability' => 'edit_theme_options',
      'default' => 'discount',
      'sanitize_callback' => 'opstore_sanitize_radio',
    ) );

    $wp_customize->add_control(
        'opstore_saletag_label',
        array(
            'type'      => 'radio',
            'choices'   => array(
                              'discount' => esc_html__('Discount','opstore'),
                              'text' => esc_html__('Text','opstore'),
                           ),
            'label'     => esc_html__( 'Sale Tag Label', 'opstore' ),
            'section'   => 'opstore_woo_section',
        )
    );
    $wp_customize->add_setting( 'opstore_saletag_text', array(
            'default'   => 'Sale',
            'sanitize_callback' => 'sanitize_text_field'                   
        )
    );    
    $wp_customize->add_control( 'opstore_saletag_text', array(
            'type'      => 'text',
            'label'     => esc_html__( 'Sale Tag Text', 'opstore' ),
            'section'   => 'opstore_woo_section',
        )
    );
    $wp_customize->add_setting( 'opstore_woo_column', array(
            'default'   => $default['opstore_woo_column'],
            'sanitize_callback' => 'opstore_sanitize_number'                   
        )
    );    
    $wp_customize->add_control( 'opstore_woo_column', array(
            'type'      => 'number',
            'label'     => esc_html__( 'Product Column', 'opstore' ),
            'section'   => 'opstore_woo_section',
        )
    ); 

    $wp_customize->add_setting( 'opstore_product_perpage', array(
            'default'           => $default['opstore_product_perpage'],
            'sanitize_callback' => 'opstore_sanitize_number'                   
        )
    );    
    $wp_customize->add_control( 'opstore_product_perpage', array(
            'type'      => 'number',
            'label'     => esc_html__( 'Product Per page', 'opstore' ),
            'section'   => 'opstore_woo_section',
        )
    );

    $wp_customize->add_setting( 'opstore_woo_seperator_single', array(
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Opstore_Customize_Seperator_Control( $wp_customize, 'opstore_woo_seperator_single',  array(
      'type'      => 'text',                    
      'label'     => esc_html__( 'Product Single', 'opstore' ),
      'section'   => 'opstore_woo_section',
    ) ) ); 
    
    $wp_customize->add_setting( 'opstore_sticky_cart', array(
      'default' => $default['opstore_show_hide_option'],
      'sanitize_callback' => 'opstore_sanitize_switch_option',
          ) );

    $wp_customize->add_control( new Opstore_Customize_Switch_Control( $wp_customize, 'opstore_sticky_cart',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Enable / Disable Sticky Cart', 'opstore' ),
      'section'   => 'opstore_woo_section',
      'choices'   => array(
            'show'  => esc_html__( 'Enable', 'opstore' ),
            'hide'  => esc_html__( 'Disable', 'opstore' )
          ),
    ) ) ); 

    }     
}
add_action( 'customize_register', 'opstore_custom_customize_register' );