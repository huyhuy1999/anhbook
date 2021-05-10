<!-- shipping methods -->
<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
<div class="form form--bg" data-checkout-shipping-fragments>
    <div class="form__field">
        <div class="form__title">
            <?php esc_html_e('Delivery method','saleszone'); ?>
        </div>
    </div>
    <div class="cart-totals cart-totals--chekout">
        <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

        <ul class="cart-totals__list">
            <?php wc_cart_totals_shipping_html(); ?>
        </ul>

        <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
    </div>
</div>
<?php endif; ?>