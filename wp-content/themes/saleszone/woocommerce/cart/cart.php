<?php
/**
 * Cart Page
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>

<?php
do_action('woocommerce_before_cart'); ?>

<div class="row row row--ib row--vindent-s"
     data-cart-total="<?php echo esc_attr(WC()->cart->get_cart_contents_count()); ?>">
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8">

        <!-- Cart frame -->
        <?php wc_get_template('cart/cart-frame.php'); ?>

        <!-- Cross Sells -->
        <?php wc_get_template('cart/cart-cross-sells.php'); ?>

    </div>
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">

        <?php
        /**
         * woocommerce_cart_collaterals hook.
         *
         * @hooked woocommerce_cart_totals - 10
         */
        remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
        do_action('woocommerce_cart_collaterals');
        ?>

    </div>
</div><!-- /.row -->

<?php do_action('woocommerce_after_cart'); ?>
