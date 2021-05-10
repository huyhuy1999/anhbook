<?php
if (!defined('ABSPATH')) {
    exit;
}

?>
<?php do_action('woocommerce_before_cart_contents'); ?>
    <div class="cart-summary <?php if ($parent_type == 'modal'): ?>cart-summary--in-modal<?php endif; ?>">

        <div class="cart-summary__items woocommerce-cart-form__contents">
            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)): ?>
                    <div class="cart-summary__row">

                        <!-- Delete product -->
                        <div class="cart-summary__cell cart-summary__cell--delete">
                            <div class="cart-summary__delete">
                                <?php
                                echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                    '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">%s</a>',
                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                    __('Remove this item', 'saleszone'),
                                    esc_attr($product_id),
                                    esc_attr($cart_item_key),
                                    esc_attr($_product->get_sku()),
                                    saleszone_get_svg('delete')
                                ), $cart_item_key); ?>

                            </div>
                        </div>

                        <!-- Product item -->
                        <div class="cart-summary__cell">
                            <div class="cart-summary__product">
                                <?php wc_get_template('cart/cart-product.php', array(
                                    'product' => $_product,
                                    'cart_item' => $cart_item,
                                    'cart_item_key' => $cart_item_key
                                )) ?>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="cart-summary__cell">
                            <div class="cart-summary__quantity">
                                <?php if ($_product->get_max_purchase_quantity() == 1): ?>
                                    x<?php echo esc_html($cart_item['quantity']); ?>
                                <?php else: ?>
                                    <?php

                                    if ($_product->is_sold_individually()) {
                                        $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                    } else {
                                        $product_quantity = woocommerce_quantity_input(array(
                                            'min_value' => apply_filters('woocommerce_quantity_input_min', $_product->get_min_purchase_quantity(), $_product),
                                            'max_value' => apply_filters('woocommerce_quantity_input_max', $_product->get_max_purchase_quantity(), $_product),
                                            'input_name' => 'cart[' . $cart_item_key . '][qty]',
                                            'input_value' => apply_filters('woocommerce_widget_cart_item_quantity', esc_attr($cart_item['quantity']), $cart_item, $cart_item_key),
                                            'input_type' => apply_filters('premmerce_quantity_input_type', 'number'),
                                            'inputmode' => 'numeric',
                                            'params' => array(
                                                'data-quantity-field' => '',
                                                'data-quantity-step' => 1,
                                                'data-cart-summary-quantity' => htmlspecialchars(json_encode(array(
                                                    'url' => admin_url('admin-ajax.php'),
                                                    'data' => array(
                                                        'action' => 'saleszone_change_cart_quantity',
                                                        'max' => $_product->get_max_purchase_quantity(),
                                                        'cart_item_key' => $cart_item_key,
                                                        'nonce' => wp_create_nonce('premmerce-cart-quantity-nonce')
                                                    )
                                                )))
                                            )
                                        ), $_product, false);
                                    }

                                    echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);

                                    ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="cart-summary__cell">
                            <div class="cart-summary__price">
                                <div class="cart-price">
                                    <div class="cart-price__main cart-price__main--small">
                                        <?php echo wp_kses(WC()->cart->get_product_subtotal($_product, $cart_item['quantity']) , saleszone_get_allowed_html('price')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.cart-summary_row -->
                <?php endif; ?>
            <?php endforeach; ?>
            <?php do_action('woocommerce_cart_contents'); ?>
        </div><!-- /.cart-summary__items -->

        <div class="cart-summary__total-price">

            <div class="row row--ib row--vindent-s">
                <?php if (wc_coupons_enabled() && isset($parent_coupone) && $parent_coupone == true) : ?>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="pull-left">
                            <div class="input-group input-group--coupon coupon">
                                <input type="text" name="coupon_code"
                                       class="form-control input-text" id="coupon_code" value=""
                                       placeholder="<?php esc_attr_e('Coupon code', 'saleszone'); ?>"/>
                                <div class="input-group-btn">
                                    <input id="coupon_code" type="submit"
                                           class="button btn btn-default" name="apply_coupon"
                                           value="<?php esc_attr_e('Apply coupon', 'saleszone'); ?>"/>
                                </div>
                                <?php do_action('woocommerce_cart_coupon'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="cart-summary__total-label">
                        <?php esc_html_e('Subtotal', 'saleszone'); ?>
                    </div>
                    <div class="cart-summary__total-value">
                        <div class="cart-price">
                            <div class="cart-price__main cart-price__main--lg">
                                <?php echo wp_kses(WC()->cart->get_cart_subtotal(), saleszone_get_allowed_html('price')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php do_action('woocommerce_cart_actions'); ?>

    </div><!-- /.cart-summary -->

<?php do_action('woocommerce_after_cart_contents'); ?>