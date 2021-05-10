<?php
/**
 * Info setup
 *
 * @package Opstore
 */

if ( ! function_exists( 'opstore_details_setup' ) ) :

    /**
     * Info setup.
     *
     * @since 1.0.0
     */
    function opstore_details_setup() {

        $config = array(

            // Welcome content.
            /* translators: %1$s: blog info */
            'welcome-texts' => sprintf( esc_html__( 'Howdy %1$s, we would like to thank you for installing and activating %2$s theme for your precious site. All of the features provided by the theme are now ready to use. Here, we have gathered all of the essential details and helpful links for you and your better experience with %2$s. Once again, Thanks for using our theme!', 'opstore' ), get_bloginfo('name'), 'opstore' ),

            // Tabs.
            'tabs' => array(
                'getting-started' => esc_html__( 'Getting Started', 'opstore' ),
                'support'         => esc_html__( 'Support', 'opstore' ),
                'useful-plugins'  => esc_html__( 'Useful Plugins', 'opstore' ),
                'demo-content'    => esc_html__( 'Demo Content', 'opstore' ),
                'free-vs-pro'    => esc_html__( 'Free vs Pro', 'opstore' ),
                'upgrade-to-pro'  => esc_html__( 'Upgrade to Pro', 'opstore' ),
                
            ),

            // Quick links.
            'quick_links' => array(
                'theme_url' => array(
                    'text' => esc_html__( 'Theme Details', 'opstore' ),
                    'url'  => 'https://wpoperation.com/themes/opstore/',
                ),
                'demo_url' => array(
                    'text' => esc_html__( 'View Demo', 'opstore' ),
                    'url'  => 'http://demo.wpoperation.com/opstore',
                ),
                'documentation_url' => array(
                    'text' => esc_html__( 'View Documentation', 'opstore' ),
                    'url'  => 'https://wpoperation.com/wp-documentation/opstore/',
                ),
                'rating_url' => array(
                    'text' => esc_html__( 'Rate This Theme','opstore' ),
                    'url'  => 'https://wordpress.org/support/theme/opstore/reviews/#new-post',
                ),
            ),

            // Getting started.
            'getting_started' => array(
                'one' => array(
                    'title'       => esc_html__( 'Theme Documentation', 'opstore' ),
                    'icon'        => 'dashicons dashicons-format-aside',
                    'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'opstore' ),
                    'button_text' => esc_html__( 'View Documentation', 'opstore' ),
                    'button_url'  => 'https://wpoperation.com/documentations/opstore/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
                'two' => array(
                    'title'       => esc_html__( 'Static Front Page', 'opstore' ),
                    'icon'        => 'dashicons dashicons-admin-generic',
                    'description' => esc_html__( 'To achieve custom home page other than blog listing, you need to create and set static front page & assign "Home" template from page attributes.', 'opstore' ),
                    'button_text' => esc_html__( 'Static Front Page', 'opstore' ),
                    'button_url'  => admin_url( 'customize.php?autofocus[section]=static_front_page' ),
                    'button_type' => 'primary',
                ),
                'three' => array(
                    'title'       => esc_html__( 'Theme Options', 'opstore' ),
                    'icon'        => 'dashicons dashicons-admin-customizer',
                    'description' => esc_html__( 'Theme uses Customizer API for theme options. Using the Customizer you can easily customize different aspects of the theme.', 'opstore' ),
                    'button_text' => esc_html__( 'Customize', 'opstore' ),
                    'button_url'  => wp_customize_url(),
                    'button_type' => 'primary',
                ),
                'four' => array(
                    'title'       => esc_html__( 'Widgets', 'opstore' ),
                    'icon'        => 'dashicons dashicons-welcome-widgets-menus',
                    'description' => esc_html__( 'Theme uses Wedgets API for widget options. Using the Widgets you can easily customize different aspects of the theme.', 'opstore' ),
                    'button_text' => esc_html__( 'Widgets', 'opstore' ),
                    'button_url'  => admin_url('widgets.php'),
                    'button_type' => 'primary',
                ),
                'five' => array(
                    'title'       => esc_html__( 'Demo Content', 'opstore' ),
                    'icon'        => 'dashicons dashicons-layout',
                    /* translators: %1$s: demo importer name */
                    'description' => sprintf( esc_html__( 'To import sample demo content, %1$s plugin should be installed and activated. After plugin is activated, visit WPOp Demo Importer menu under Appearance.', 'opstore' ), esc_html__( 'Operation Demo Importer', 'opstore' ) ),
                    'button_text' => esc_html__( 'Demo Content', 'opstore' ),
                    'button_url'  => admin_url( 'themes.php?page=opstore-details&tab=demo-content' ),
                    'button_type' => 'secondary',
                ),
                'six' => array(
                    'title'       => esc_html__( 'Fix Image Sizes', 'opstore' ),
                    'icon'        => 'dashicons dashicons-format-gallery',
                    'description' => esc_html__( 'If you have already images on your site then all image might not align as expected, to fix this there is handy plugin which will help you', 'opstore' ),
                    'button_text' => esc_html__( 'Fix Images Now', 'opstore' ),
                    'button_url'  => 'https://wordpress.org/plugins/regenerate-thumbnails/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
            ),

            // Support.
            'support' => array(
                'one' => array(
                    'title'       => esc_html__( 'Contact Support', 'opstore' ),
                    'icon'        => 'dashicons dashicons-sos',
                    'description' => esc_html__( 'Got theme support question or found bug or got some feedbacks? Best place to ask your query is the dedicated Support forum for the theme.', 'opstore' ),
                    'button_text' => esc_html__( 'Contact Support', 'opstore' ),
                    'button_url'  => 'https://wpoperation.com/support/support/free-themes/opstore/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
                'two' => array(
                    'title'       => esc_html__( 'Theme Documentation', 'opstore' ),
                    'icon'        => 'dashicons dashicons-format-aside',
                    'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'opstore' ),
                    'button_text' => esc_html__( 'View Documentation', 'opstore' ),
                    'button_url'  => 'https://wpoperation.com/documentations/opstore/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
                'three' => array(
                    'title'       => esc_html__( 'Child Theme', 'opstore' ),
                    'icon'        => 'dashicons dashicons-admin-tools',
                    'description' => esc_html__( 'For advanced theme customization, it is recommended to use child theme rather than modifying the theme file itself. Using this approach, you wont lose the customization after theme update.', 'opstore' ),
                    'button_text' => esc_html__( 'Learn More', 'opstore' ),
                    'button_url'  => 'https://developer.wordpress.org/themes/advanced-topics/child-themes/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
            ),

            //Useful plugins.
            'useful_plugins' => array(
                'description' => esc_html__( 'Theme supports some helpful WordPress plugins to enhance your site. But, please enable only those plugins which you need in your site. For example, enable WooCommerce only if you are using e-commerce.', 'opstore' ),
            ),

            //Demo content.
            'demo_content' => array(
                /* translators: %1$s: demo importer name */
                'description' => sprintf( esc_html__( 'To import demo content for this theme, %1$s plugin is needed. Please make sure plugin is installed and activated. After plugin is activated, you will see WPop Demo Importer menu under Appearance.', 'opstore' ), '<a href="https://wordpress.org/plugins/operation-demo-importer/" target="_blank">' . esc_html__( 'Operation Demo Importer', 'opstore' ) . '</a>' ),
            ),


           
            //Free vs Pro.
            'free_vs_pro' => array(

                'features' => array(
                    'Preloader Options' => array('Simple','18+ Customizable'),
                    'Live AJAX search' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Infinite Product Load with AJAX'=> array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Theme Option Panel'=> array('Customizer Based','Powerful Theme Panel'),
                    'Custom Elementor Addons'=> array('5+','20+'),
                    'Typography Style & Colors' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Unlimited Header and Footer Builder' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Lazy Load Images' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Newsletter Popup' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Maintenance Mode' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Unlimited Product Tabs' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'WooCommerce Compatibility' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
                    'Social Sharings' => array('yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
                    'Hide Theme Credit Link' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Responsive Layout' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
                    'Translations Ready' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
                    'SEO' => array('Optimized', 'Optimized'),
                    'Support' => array('Yes', 'High Priority Dedicated Support')
                ),
            ),

            // Upgrade content.
            'upgrade_to_pro' => array(
                'description' => esc_html__( 'If you want more advanced features then you can upgrade to the premium version of the theme.', 'opstore' ),
                'button_text' => esc_html__( 'Upgrade Now', 'opstore' ),
                'button_url'  => 'https://wpoperation.com/themes/opstore-pro/',
                'button_type' => 'primary',
                'is_new_tab'  => true,
            ),
           
        );

        Opstore_Welcome_Info::init( $config );
    }

endif;

add_action( 'after_setup_theme', 'opstore_details_setup' );