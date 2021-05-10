<?php

/**
 * Customizer assets
 */
if ( !function_exists( 'saleszone_enqueue_customizer_scripts' ) ) {
    function saleszone_enqueue_customizer_scripts()
    {
        $theme = wp_get_theme( 'saleszone-premium' );
        $version = $theme['Version'];
        $kirki_install_link = esc_url( add_query_arg( array(
            'page'          => 'tgmpa-install-plugins',
            'plugin'        => 'kirki',
            'tgmpa-install' => 'install-plugin',
            'tgmpa-nonce'   => wp_create_nonce( 'tgmpa-install' ),
        ), site_url( 'wp-admin/admin.php' ) ) );
        if ( file_exists( WP_PLUGIN_DIR . '/kirki/kirki.php' ) ) {
            $kirki_install_link = esc_url( add_query_arg( array(
                'page'           => 'tgmpa-install-plugins',
                'plugin'         => 'kirki',
                'tgmpa-activate' => 'activate-plugin',
                'tgmpa-nonce'    => wp_create_nonce( 'tgmpa-activate' ),
            ), site_url( 'wp-admin/admin.php' ) ) );
        }
        wp_enqueue_script(
            'premmerce-customizer-js',
            get_template_directory_uri() . '/functions/admin/assets/js/customizer.js',
            NULL,
            $version,
            'all'
        );
        wp_localize_script( 'premmerce-customizer-js', 'customzierLocalize', array(
            'kirkiMessage' => sprintf( __( 'To display options for customizing the theme, install and activated the <a href="%1$s">Kirki plugin</a>', 'saleszone' ), $kirki_install_link ),
            'kirkiActive'  => saleszone_is_plugin_active( 'kirki/kirki.php' ),
        ) );
    }

}
add_action( 'customize_preview_init', 'saleszone_enqueue_customizer_scripts' );
if ( !function_exists( 'saleszone_enqueue_customizer_stylesheet' ) ) {
    function saleszone_enqueue_customizer_stylesheet()
    {
        $theme = wp_get_theme( 'saleszone-premium' );
        $version = $theme['Version'];
        wp_enqueue_style(
            'premmerce-customizer-css',
            get_template_directory_uri() . '/functions/admin/assets/css/customizer.css',
            NULL,
            $version,
            'all'
        );
    }

}
add_action( 'customize_controls_print_styles', 'saleszone_enqueue_customizer_stylesheet' );
/**
 * Hot replace for options who used custom css template
 * @param WP_Customize_Manager $wp_customize
 */
if ( !function_exists( 'register_selective_refresh_partials' ) ) {
    function register_selective_refresh_partials( WP_Customize_Manager $wp_customize )
    {
        if ( !isset( $wp_customize->selective_refresh ) ) {
            return;
        }
        foreach ( saleszone_default_options_css_variables() as $variable ) {
            $exclude_types = array(
                'buttons',
                'header-phone',
                'message',
                'form-controls',
                'other',
                'shop',
                'footer',
                'basement',
                'headline',
                'off-canvas',
                'hidden'
            );
            if ( !in_array( $variable['data']['type'], $exclude_types ) ) {
                $css_variables[] = $variable['name'];
            }
        }
        $wp_customize->selective_refresh->add_partial( 'refresh_custom_css', array(
            'selector'            => '[data-customizer-css-required]',
            'container_inclusive' => true,
            'settings'            => $css_variables,
            'render_callback'     => 'saleszone_custom_css_render_callback',
        ) );
    }

}
add_action( 'customize_register', 'register_selective_refresh_partials' );