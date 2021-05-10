<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version    3.4.0
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

get_header();
?>

<div class="content">
    <div class="content__container">
        <?php 

if ( !woocommerce_product_loop() || woocommerce_products_will_display() || is_search() || wc_get_loop_prop( 'is_filtered' ) || is_product_taxonomy() && !is_product_category() ) {
    wc_get_template( 'loop/products-layout.php' );
} else {
    wc_get_template( 'loop/categories-layout.php' );
}

?>

        <?php 
/**
 * @Hooked saleszone_render_archive_products_description
 */
do_action( 'premmerce-archive-products-container-end' );
?>

    </div><!-- /.content__container -->
</div><!-- /.content -->

<?php 
get_footer();