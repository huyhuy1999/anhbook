<?php
/**
 * Order Item Details
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
?>
<div class="cart-product">
    <!-- Product photo -->
    <div class="cart-product__photo">
        <div class="product-photo">
            <a class="product-photo__item product-photo__item--xs" href="<?php echo esc_url($product->get_permalink()); ?>">
                <img class="product-photo__img"
                     src="<?php echo esc_url(saleszone_get_variation_image_url($product)); ?>"
                     alt="<?php echo esc_attr(saleszone_get_img_alt($product->get_image_id(), $product->get_name())); ?>"
                     title="<?php echo esc_attr($product->get_name()); ?>">
            </a>
        </div>
    </div>
    <div class="cart-product__info">
        <!-- Product title -->
        <div class="cart-product__title">
            <?php $is_visible        = $product && $product->is_visible();
            $product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );
            echo wp_kses_post(apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a class="cart-product__link" href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible )); ?>
        </div>

        <?php if (has_action('woocommerce_order_item_meta_start')):?>
            <div class="cart-product__option">
                <?php do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order ); ?>
            </div>
        <?php endif; ?>

        <?php foreach ( $item->get_formatted_meta_data() as $meta_id => $meta ): ?>
            <div class="cart-product__option">
                <span class="cart-product__option-key">
                    <?php echo wp_kses_post( $meta->display_key ); ?>
                </span>
                <span class="cart-product__option-val">
                    <?php echo wp_kses_post( $meta->display_value ); ?>
                </span>
            </div>
        <?php endforeach; ?>

        <?php if (has_action('woocommerce_order_item_meta_start')):?>
            <div class="cart-product__option">
                <?php do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order ); ?>
            </div>
        <?php endif; ?>

        <!-- Purchase note -->
        <?php if ( $show_purchase_note && $purchase_note ) : ?>
            <div class="cart-product__purchase-note">
                <?php echo wp_kses_post( wpautop( do_shortcode($purchase_note))); ?>
            </div>
        <?php endif; ?>

    </div>
</div>