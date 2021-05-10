<?php
/**
 * The Template for displaying all single products
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();
?>
    <div class="content">
        <div class="content__container">
            <?php while (have_posts()) : the_post(); ?>
                <?php wc_get_template('content-single-product.php'); ?>
            <?php endwhile; // end of the loop. ?>
        </div><!-- /.content__container -->
    </div><!-- /.content -->
<?php
get_footer();