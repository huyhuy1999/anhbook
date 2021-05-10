<?php
/**
 * Cart totals
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>

<div class="frame cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
    <div class="frame__header">
        <h2 class="frame__title">
            <?php esc_html_e('Order summary', 'saleszone'); ?>
        </h2>
    </div>
    <div class="frame__inner">
        <div class="cart-totals">

            <?php do_action( 'woocommerce_before_cart_totals' ); ?>

            <ul class="cart-totals__list">

                <!--  Subtotal  -->
                <li class="cart-totals__item">
                    <div class="cart-totals__label">
                        <?php esc_html_e( 'Subtotal', 'saleszone' ); ?>
                    </div>
                    <div class="cart-totals__value cart-price cart-price__main cart-price__main--small">
                        <?php wc_cart_totals_subtotal_html(); ?>
                    </div>
                </li>

                <!-- coupons -->
                <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                <li class="cart-totals__item coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                    <div class="cart-totals__label">
                        <?php wc_cart_totals_coupon_label( $coupon ); ?>
                    </div>
                    <div class="cart-totals__value">
                        <?php wc_cart_totals_coupon_html( $coupon ); ?>
                    </div>
                </li>
                <?php endforeach; ?>

                <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

                    <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

                    <?php wc_cart_totals_shipping_html(); ?>

                    <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

                <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>
                    <li class="cart-totals__item cart-totals__item--shipping-calculator">
                        <?php woocommerce_shipping_calculator(); ?>
                    </li>
                <?php endif; ?>

                <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                    <!--  fee  -->
                    <li class="cart-totals__item">
                        <div class="cart-totals__label">
                            <?php echo esc_html( $fee->name ); ?>
                        </div>
                        <div class="cart-totals__value">
                            <?php wc_cart_totals_fee_html( $fee ); ?>
                        </div>
                    </li>
                <?php endforeach; ?>

                <?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) :
                    $taxable_address = WC()->customer->get_taxable_address();
                    $estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
                        /* translators: %s: estimated for */
                        ? sprintf( ' <small>' . __( '(estimated for %s)', 'saleszone' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
                        : '';

                    if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                        <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                            <li class="cart-totals__item tax-rate tax-rate-<?php echo esc_attr( $code ); ?>">
                                <div class="cart-totals__label"><?php echo esc_html( $tax->label ) . wp_kses_post($estimated_text); ?></div>
                                <div class="cart-totals__value"><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li class="cart-totals__item">
                            <div class="cart-totals__label"><?php echo esc_html( WC()->countries->tax_or_vat() ) . wp_kses_post($estimated_text); ?></div>
                            <div class="cart-totals__value"><?php wc_cart_totals_taxes_total_html(); ?></div>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

                <li class="cart-totals__item cart-totals__item--final-price cart-summary">
                    <div class="cart-summary__total-price cart-summary__total-price--order">
                        <div class="cart-summary__total-label">
                            <?php esc_html_e( 'Total', 'saleszone' ); ?>
                        </div>
                        <div class="cart-summary__total-value cart-price cart-price__main cart-price__main--lg">
                            <?php wc_cart_totals_order_total_html(); ?>
                        </div>
                    </div>
                </li>

                <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

                <li class="cart-totals__item cart-totals__item--submit">
                    <?php
                    /**
                     * woocommerce_proceed_to_checkout hook.
                     *
                     * @hooked woocommerce_button_proceed_to_checkout - 20
                     */
                    do_action('woocommerce_proceed_to_checkout');
                    ?>
                </li>

                <?php do_action( 'woocommerce_after_cart_totals' ); ?>
            </ul>

        </div>
    </div>
</div>