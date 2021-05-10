<?php
/**
 * Pay for order form
 *
 * @see      https://docs.woocommerce.com/document/template-structure/
 * @author   WooThemes
 * @package  WooCommerce/Templates
 * @version  3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$order_id = $order->get_order_number();

?>

<form id="order_review" method="post">

    <div class="row row--ib row--vindent-s">
        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="order-details" id="payment">

                <!-- woocommerce-order-overview -->
                <?php wc_get_template( 'order/order-overview.php', array( 'order' => $order ) ) ?>

                <?php if ( $order->needs_payment() ) : ?>
                    <div class="order-details__group">

                        <div class="payments-radio">
                            <ul class="payments-radio__list">
                                <?php
                                if ( ! empty( $available_gateways ) ) {
                                    foreach ( $available_gateways as $gateway ) {
                                        wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
                                    }
                                } else {
                                    echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', __( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'saleszone' ) ) . '</li>';
                                }
                                ?>
                            </ul>
                        </div>

                    </div>
                <?php endif; ?>

                <div class="order-details__group">
                    <input type="hidden" name="woocommerce_pay" value="1" />

                    <?php wc_get_template( 'checkout/terms.php' ); ?>

                    <?php do_action( 'woocommerce_pay_order_before_submit' ); ?>

                    <?php echo apply_filters( 'woocommerce_pay_order_button_html', '<input type="submit" class="btn btn-lg btn-primary button alt" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' ); ?>

                    <?php do_action( 'woocommerce_pay_order_after_submit' ); ?>

                    <?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <?php do_action( 'woocommerce_view_order', $order_id ); ?>
        </div>
    </div>


</form>
