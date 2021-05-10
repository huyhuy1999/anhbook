<?php
/**
 * Register widget area and call widget files
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @package Opstore
 */

/**
 * ===========================================================================================================
 * Register Widgets Area
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function opstore_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Right Sidebar', 'opstore' ),
        'id'            => 'right-sidebar',
        'description'   => esc_html__( 'Add widgets here.', 'opstore' ),
        'before_widget' => '<div id="%1$s" class="box mb-30 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Left Sidebar', 'opstore' ),
        'id'            => 'left-sidebar',
        'description'   => esc_html__( 'Add widgets here.', 'opstore' ),
        'before_widget' =>      '<div id="%1$s" class="box mb-30 widget %2$s">',
        'after_widget'  =>      '</div>',
        'before_title'  =>      '<h4 class="widget-title">',
        'after_title'   =>      '</h4>'
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Header widget Area', 'opstore' ),
        'id'            => 'header-area',
        'description'   => esc_html__( 'Add widgets here.', 'opstore' ),
        'before_widget' =>      '<div id="%1$s" class="widget %2$s">',
        'after_widget'  =>      '</div>',
        'before_title'  =>      '<h4 class="widget-title">',
        'after_title'   =>      '</h4>'
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Shop Sidebar', 'opstore' ),
        'id'            => 'shop-sidebar',
        'description'   => esc_html__( 'Add widgets here.', 'opstore' ),
        'before_widget' =>      '<div id="%1$s" class="box mb-30 widget %2$s">',
        'after_widget'  =>      '</div>',
        'before_title'  =>      '<h4 class="widget-title">',
        'after_title'   =>      '</h4>'
    ) );

    //Footer Widgets

    $footer_widget_regions = 4;
    for ( $i = 1; $i <= intval( $footer_widget_regions ); $i++ ) {
        register_sidebar(array(
            'id'            =>      sprintf( 'footer-%d', $i ),
            /* translators: %d: counter */
            'name'          =>      sprintf( __( 'Footer Widget Area %d', 'opstore' ), $i ),
            'description'   =>      esc_html__( 'This is a Footer Sidebar Area.', 'opstore' ),
            'before_widget' =>      '<div id="%1$s" class="widget %2$s ">',
            'after_widget'  =>      '</div>',
            'before_title'  =>      '<h6 class="footer-title">',
            'after_title'   =>      '</h6>'
        ));  
    }
}
add_action( 'widgets_init', 'opstore_widgets_init' );



/*--------------------------------------------------------------------------------------------------------*/
/**
 * Load individual widgets file and required related files too.
 */

get_template_part('/inc/widgets/widget','fields'); // widget fields
get_template_part('/inc/widgets/widget','contact-info'); // Contact Info
get_template_part('/inc/widgets/widget','social-icons'); // Social Icons
if(class_exists('woocommerce')){
get_template_part('/inc/widgets/widget','product-search'); // Product Search
}
 
