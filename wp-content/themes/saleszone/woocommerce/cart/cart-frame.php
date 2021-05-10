<div class="content__row">
    <?php wc_print_notices(); ?>
    <form class="woocommerce-cart-form"
          action="<?php echo esc_url(wc_get_cart_url()); ?>"
          method="post"
          data-cart-frame-fragment
          data-cart-summary="page"
    >
        <?php do_action('woocommerce_before_cart_table'); ?>
        <div class="frame">
            <div class="frame__header">
                <h2 class="frame__title">
                    <?php
                    /* translators: %1$s: cart contents count */
                    printf(esc_html__('Items in your cart (%s)', 'saleszone'), esc_html(WC()->cart->get_cart_contents_count())); ?>
                </h2>
            </div>
            <div class="frame__inner">
                <?php wc_get_template('cart/cart-summary.php', array(
                    'parent_type' => 'order',
                    'parent_coupon' => false,
                    'parent_template' => 'woocommerce/cart/cart',
                    'parent_coupone' => true
                )); ?>
            </div>
        </div>
        <input class="button hidden" type="submit" name="update_cart"
               value="<?php esc_attr_e('Update cart', 'saleszone'); ?>">
        <?php wp_nonce_field('woocommerce-cart', '_wpnonce', false); ?>
        <?php do_action('woocommerce_after_cart_table'); ?>
    </form>
</div>