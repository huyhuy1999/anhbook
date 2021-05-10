<?php

if (!defined('ABSPATH')) {
    exit;
}

$notices = wc_get_notices() ? wc_get_notices() : false;

?>

<div class="modal <?php if ($notices['error'] && !$notices['success']): ?>modal--sm<?php else: ?>modal--lg<?php endif; ?>"
     data-cart-modal-fragment
>

    <div class="modal__header">
        <div class="modal__header-title">
            <?php esc_html_e('Cart', 'saleszone'); ?>
        </div>
        <div class="modal__header-close" data-modal-close>
            <i class="modal__header-close-ico">
                <?php saleszone_the_svg('close'); ?>
            </i>
        </div>
    </div>

    <div data-cart-summary="modal"
         data-cart-summary--tpl="woocommerce/cart/cart-modal"
         data-cart-summary--url="<?php echo esc_attr(wc_get_cart_url()); ?>">

        <div class="modal__content">

            <?php if ($notices): ?>
                <div class="modal__content-cell">
                    <?php wc_print_notices(); ?>
                </div>
            <?php endif; ?>

            <?php if (!isset($notices['error']) || isset($notices['success'])): ?>
                <?php if (!WC()->cart->is_empty()): ?>
                    <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>"
                          method="post">
                        <?php wc_get_template('cart/cart-summary.php', array(
                            'parent_type' => 'modal',
                            'parent_coupon' => false,
                            'parent_template' => 'woocommerce/cart/cart-modal'
                        )); ?>
                        <input type="hidden" name="update_cart"
                               value="<?php esc_attr_e('Update cart', 'saleszone'); ?>">
                        <?php wp_nonce_field('woocommerce-cart', '_wpnonce', false); ?>
                    </form>
                <?php else: ?>
                    <p class="typo" data-ajax-grab="cart-empty">
                        <?php esc_html_e('Your cart is currently empty.', 'saleszone'); ?>
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="modal__footer">
            <div class="modal__footer-row clearfix">
                <div class="modal__footer-btn pull-left hidden-xs">
                    <button class="btn btn-default" type="reset" data-modal-close>
                        <?php esc_html_e('Continue Shopping', 'saleszone'); ?>
                    </button>
                </div>

                <?php do_action('premmerce-cart-modal-footer'); ?>

                <?php if (!isset($notices['error']) || isset($notices['success'])): ?>
                    <?php if (!WC()->cart->is_empty()): ?>
                        <div class="modal__footer-btn">
                            <a class="btn btn-default" href="<?php echo esc_url(wc_get_cart_url()); ?>">
                                <span><?php esc_html_e('View cart', 'saleszone'); ?></span>
                                <i class="button--loader hidden">
                                    <?php saleszone_the_svg('refresh'); ?>
                                </i>
                            </a>
                        </div>
                        <div class="modal__footer-btn">
                            <a class="btn btn-primary" href="<?php echo esc_url(wc_get_checkout_url()); ?>"
                               data-button-loader="button">
                                <span><?php esc_html_e('Proceed to checkout', 'saleszone'); ?></span>
                                <i class="button--loader hidden" data-button-loader="loader">
                                    <?php saleszone_the_svg('refresh'); ?>
                                </i>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>