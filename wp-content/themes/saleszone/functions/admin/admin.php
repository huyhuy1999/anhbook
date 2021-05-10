<?php

require dirname( __FILE__ ) . '/customizer/config.php';
/**
 * Customzier options required kirki plugin
 */

if ( saleszone_is_plugin_active( 'kirki/kirki.php' ) ) {
    // Define image path
    $image_url = get_template_directory_uri() . '/functions/admin/assets/img/';
    // Set default transport
    $transport = 'postMessage';
    if ( !isset( $wp_customize->selective_refresh ) ) {
        $transport = 'refresh';
    }
    // kirki helper class
    require get_template_directory() . '/functions/admin/classes/class-saleszone-kirki.php';
    
    if ( is_customize_preview() ) {
        require dirname( __FILE__ ) . '/options/panels.php';
        /**
         * Customizer options
         */
        require dirname( __FILE__ ) . '/options/header/header.php';
        require dirname( __FILE__ ) . '/options/colors/colors.php';
        require dirname( __FILE__ ) . '/options/shop/shop.php';
        require dirname( __FILE__ ) . '/options/social-icons/social-icons.php';
        require dirname( __FILE__ ) . '/options/footer/footer.php';
        require dirname( __FILE__ ) . '/options/title-tagline/title-tagline.php';
    }

}


if ( is_admin() ) {
    /**
     *  include tgm-plugin-activation class
     */
    require dirname( __FILE__ ) . '/classes/class-tgm-plugin-activation.php';
    /**
     *  include tgm-plugin-activation config
     */
    require dirname( __FILE__ ) . '/tgm-plugin-config.php';
    /**
     * Demo data installer
     */
    require dirname( __FILE__ ) . '/classes/class-saleszone-import-tool.php';
    /**
     * Theme admin page
     */
    require dirname( __FILE__ ) . '/classes/class-saleszone-admin-page.php';
}
