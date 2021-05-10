<?php
/**
 * Checkout Payment Section
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.3
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>
<div class="content__row content__row--sm woocommerce-checkout-payment" id="payment">

    <div class="cart-payment">

        <?php if ( WC()->cart->needs_payment() ) : ?>
        <div class="cart-payment__payment-methods">
            <div class="payments-radio payments-radio--bg">
                <ul class="payments-radio__list wc_payment_methods payment_methods methods">
                    <?php
                    if ( ! empty( $available_gateways ) ) {
                        foreach ( $available_gateways as $gateway ) {
                            wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
                        }
                    } else {
                        echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . esc_html(apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? __( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'saleszone' ) : __( 'Please fill in your details above to see available payment methods.', 'saleszone' ) )) . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>

        <noscript class="cart-payment__noscript">
            <div class="message message--info">
                <?php printf(esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'saleszone' ),'<em>', '</em>'); ?>
            </div>
            <input type="submit" class="btn btn-default button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'saleszone' ); ?>" />
        </noscript>

        <?php if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) :?>
            <div class="cart-payment__terms">
                <?php wc_get_template( 'checkout/terms.php' ); ?>
            </div>
        <?php endif; ?>

        <div class="cart-payment__submit form-row place-order">

            <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

            <?php echo wp_kses(apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="btn btn-lg btn-primary button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' ), saleszone_get_allowed_html('order_button')); ?>

            <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

            <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
        </div>

    </div>

</div>
<?php
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
