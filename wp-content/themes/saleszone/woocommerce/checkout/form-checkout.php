<?php
/**
 * Checkout Form
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hook woocommerce_before_checkout_form
 * include checkout/form-coupon.php
 */
do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'saleszone' ) );
	return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <div class="row row--ib row--vindent-s">

        <!-- Checkout fields -->
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-6" id="customer_details">

            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

            <!-- Login popup -->
            <?php wc_get_template( 'checkout/form-login.php', array( 'checkout' => WC()->checkout() ) ); ?>

            <?php wc_get_template('checkout/shipping.php'); ?>

            <?php if ( $checkout->get_checkout_fields() ) : ?>

                <!-- Billing form -->
                <?php
                /**
                 * Hook woocommerce_checkout_billing
                 * include checkout/form-billing.php
                 */
                do_action( 'woocommerce_checkout_billing' ); ?>

                <!-- Shipping form -->
                <?php
                /**
                 * Hook woocommerce_checkout_shipping
                 * include checkout/form-shipping.php
                 */
                do_action( 'woocommerce_checkout_shipping' ); ?>

                <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

            <?php endif; ?>
        </div>

        <!-- Order -->
        <div class="col-xs-12 col-sm-6 col-md-7 col-lg-6">

            <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

            <div class="frame frame--checkout-order">
                <div class="frame__header">
                    <div class="frame__title">
                        <h3 id="order_review_heading">
                            <?php esc_html_e( 'Your order', 'saleszone' ); ?>
                        </h3>
                    </div>
                    <a class="pull-right link link--js" href="<?php echo esc_url(wc_get_cart_url()); ?>"
                        <?php if (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes' && !is_cart()): ?>
                            data-cart-modal
                        <?php endif; ?>
                       rel="nofollow">
                        <?php esc_html_e('Edit cart', 'saleszone'); ?>
                    </a>
                </div>
                <div class="frame__inner woocommerce-checkout-review-order" id="order_review">
                    <?php
                    /**
                     * Hook woocommerce_checkout_order_review
                     * include checkout/review-order.php
                     * include checkout/payment.php
                     */
                     do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>
            </div>

            <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
        </div>

    </div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>