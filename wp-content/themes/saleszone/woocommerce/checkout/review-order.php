<?php
/**
 * Review order table
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="cart-summary content__row content__row--sm woocommerce-checkout-review-order-table">

    <!-- Products -->
    <div class="cart-summary__items">
        <?php
        do_action( 'woocommerce_review_order_before_cart_contents' );

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                wc_get_template('checkout/review-order/review-order-cart-summary-item.php', array(
                    '_product' => $_product,
                    'cart_item' => $cart_item,
                    'cart_item_key' => $cart_item_key
                ));
            }
        }

        do_action( 'woocommerce_review_order_after_cart_contents' );
        ?>
    </div>

    <!-- cart summary subtotal -->
	<div class="cart-summary__subtotal cart-totals">

        <div class="cart-totals__list">
            <!-- Subtotal -->
            <div class="cart-totals__item">
                <div class="cart-totals__label">
                    <?php esc_html_e( 'Subtotal', 'saleszone' ); ?>
                </div>
                <div class="cart-totals__value cart-price cart-price__main cart-price__main--small">
                    <?php wc_cart_totals_subtotal_html(); ?>
                </div>
            </div>
            <!-- coupons -->
            <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                <div class="cart-totals__item cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                    <div class="cart-totals__label"><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
                    <div class="cart-totals__value"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
                </div>
            <?php endforeach; ?>
            <!-- fees -->
            <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                <div class="cart-totals__item fee">
                    <div class="cart-totals__label"><?php echo esc_html( $fee->name ); ?></div>
                    <div class="cart-totals__value"><?php wc_cart_totals_fee_html( $fee ); ?></div>
                </div>
            <?php endforeach; ?>
            <!-- tax -->
            <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
                <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                    <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                        <div class="cart-totals__item tax-rate-<?php echo esc_attr(sanitize_title( $code )); ?>">
                            <div class="cart-totals__label"><?php echo esc_html( $tax->label ); ?></div>
                            <div class="cart-totals__value"><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="cart-totals__item">
                        <div class="cart-totals__label"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></div>
                        <div class="cart-totals__value"><?php wc_cart_totals_taxes_total_html(); ?></div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div><!-- ./cart-totals__list -->

	</div><!-- ./cart summary subtotal -->

    <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

    <!-- Order total -->
    <div class="cart-summary__total-price cart-summary__total-price--order">
        <div class="cart-summary__total-label">
            <?php esc_html_e( 'Total', 'saleszone' ); ?>
        </div>
        <div class="cart-summary__total-value">
            <div class="cart-price">
                <div class="cart-price__main cart-price__main--lg">
                    <?php wc_cart_totals_order_total_html(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

</div>
