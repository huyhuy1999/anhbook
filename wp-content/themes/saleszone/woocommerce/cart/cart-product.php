<?php

defined( 'ABSPATH' ) || exit;

$product_name = apply_filters('woocommerce_cart_item_name', $product->get_name(), $cart_item, $cart_item_key);
$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $product->get_image(), $cart_item, $cart_item_key);
$product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($product), $cart_item, $cart_item_key);
$product_permalink = apply_filters('woocommerce_cart_item_permalink', $product->is_visible() ? $product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
$product_quantity = apply_filters('woocommerce_widget_cart_item_quantity', $cart_item['quantity'], $cart_item, $cart_item_key);
?>

<div class="cart-product">

    <div class="cart-product__photo">
        <div class="product-photo">
            <a class="product-photo__item product-photo__item--xs" href="<?php echo esc_url($product_permalink); ?>">
                <img class="product-photo__img"
                     src="<?php echo esc_url(saleszone_get_variation_image_url($product)); ?>"
                     alt="<?php echo esc_attr(saleszone_get_img_alt($product->get_image_id(), $product_name)); ?>"
                     title="<?php echo esc_attr($product_name); ?>">
            </a>
        </div>
    </div>

    <div class="cart-product__info">
        <?php do_action('premmerce_cart_product_info_start', $product); ?>

        <div class="cart-product__title">
            <a class="cart-product__link" href="<?php echo esc_url($product_permalink); ?>">
                <?php echo wp_kses_post($product_name); ?>
            </a>
        </div>

        <?php do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key ); ?>

        <div class="cart-product__option">
            <span class="cart-product__option-key">
                <?php esc_html_e('Price: ', 'saleszone'); ?>
            </span>
            <span class="cart-product__option-val">
                <?php echo wp_kses($product_price, saleszone_get_allowed_html('price')); ?>
            </span>
        </div>

        <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

        <?php if ($product->get_max_purchase_quantity() > 0): ?>
        <div class="cart-product__option cart-product__option--max-qty">
            <span class="cart-product__option-key">
                <?php esc_html_e('Max quantity: ', 'saleszone'); ?>
            </span>
            <span class="cart-product__option-val">
                <?php echo esc_html($product->get_max_purchase_quantity()); ?>
            </span>
        </div>
        <?php endif; ?>

        <?php if ($product->backorders_require_notification()):
            $stock_quantity = ( $product->get_stock_quantity() ) ? $product->get_stock_quantity() : '';
            ?>
            <div class="cart-product__option">
                <?php
                if($product->get_stock_quantity() > 0 && $product->get_stock_quantity() < $product_quantity){
                    /* translators: %1$s: stock quantity */
                    printf( esc_html__('More than %1$s items available only on backorder', 'saleszone'), esc_html($product->get_stock_quantity()) );
                } elseif($product->get_stock_quantity() <= 0) {
                    esc_html_e( 'Available on backorder', 'saleszone' );
                }
                ?>
            </div>
        <?php endif; ?>

        <?php do_action('premmerce_cart_product_info_end', $product); ?>
    </div>

</div>