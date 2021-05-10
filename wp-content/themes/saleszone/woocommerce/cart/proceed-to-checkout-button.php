<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>

<a class="btn btn-primary btn-lg" href="<?php echo esc_url( wc_get_checkout_url() );?>" data-button-loader="button">
	<?php esc_html_e( 'Proceed to checkout', 'saleszone' ); ?>
    <i class="button--loader hidden" data-button-loader="loader">
        <?php saleszone_the_svg('refresh'); ?>
    </i>
</a>
