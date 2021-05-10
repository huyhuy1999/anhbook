<?php

/**
 * Open file content on modal window
 */
if ( !function_exists( 'saleszone_modal' ) ) {
    function saleszone_modal()
    {
        
        if ( isset( $_REQUEST['template'] ) ) {
            $template = sanitize_text_field( wp_unslash( $_REQUEST['template'] ) );
            get_template_part( $template );
        }
        
        die;
    }

}
add_action( 'wp_ajax_saleszone_modal', 'saleszone_modal' );
add_action( 'wp_ajax_nopriv_saleszone_modal', 'saleszone_modal' );
add_action( 'wc_ajax_saleszone_modal', 'saleszone_modal' );
/**
 * Return comment reply form html
 */
if ( !function_exists( 'wp_ajax_saleszone_comment_reply_form' ) ) {
    function wp_ajax_saleszone_comment_reply_form()
    {
        get_template_part( 'parts/review/review-reply-form' );
        die;
    }

}
add_action( 'wp_ajax_saleszone_comment_reply_form', 'wp_ajax_saleszone_comment_reply_form' );
add_action( 'wp_ajax_nopriv_saleszone_comment_reply_form', 'wp_ajax_saleszone_comment_reply_form' );
/**
 * Get product video. Used in premmerce-woocommerce-toolkit plugin
 */
if ( !function_exists( 'saleszone_ajax_get_video' ) ) {
    function saleszone_ajax_get_video()
    {
        global  $wp_embed ;
        $src = ( isset( $_REQUEST['src'] ) ? esc_url_raw( wp_unslash( $_REQUEST['src'] ) ) : '' );
        echo  wp_kses( $wp_embed->run_shortcode( '[embed]' . esc_url( $src ) . '[/embed]' ), saleszone_get_allowed_html( 'iframe' ) ) ;
        die;
    }

}
add_action( 'wp_ajax_saleszone_ajax_get_video', 'saleszone_ajax_get_video' );
add_action( 'wp_ajax_nopriv_saleszone_ajax_get_video', 'saleszone_ajax_get_video' );