<?php
/**
 * Order details
 *
 * @see    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

if (!defined('ABSPATH')) {
    exit;
}
if (!$order = wc_get_order($order_id)) {
    return;
}

$order_items = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();

?>

<?php if (has_action('woocommerce_order_details_before_order_table')): ?>
    <div class="content__row content__row--sm">
        <?php do_action('woocommerce_order_details_before_order_table', $order); ?>
    </div>
<?php endif; ?>

<div class="content__row content__row--sm">
    <section class="frame">
        <div class="frame__header">
            <h2 class="frame__title">
                <?php esc_html_e('Order details', 'saleszone'); ?>
            </h2>
        </div>
        <div class="frame__inner">

            <div class="cart-summary">

                <div class="cart-summary__items">

                    <!-- Products -->
                    <?php foreach ($order_items as $item_id => $item): ?>
                        <?php $product = apply_filters('woocommerce_order_item_product', $item->get_product(), $item); ?>
                        <div class="cart-summary__row <?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order)); ?>">

                            <!-- Product -->
                            <div class="cart-summary__cell">
                                <?php wc_get_template('order/order-details-item.php', array(
                                    'order' => $order,
                                    'item_id' => $item_id,
                                    'item' => $item,
                                    'show_purchase_note' => $show_purchase_note,
                                    'purchase_note' => $product ? $product->get_purchase_note() : '',
                                    'product' => $product,
                                )); ?>
                            </div>
                            <!-- product quantity -->
                            <div class="cart-summary__cell">
                                <div class="cart-summary__quantity cart-summary__quantity--sm">
                                    <?php echo wp_kses_post(apply_filters('woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf('&times; %s', $item->get_quantity()) . '</strong>', $item)); ?>
                                </div>
                            </div>
                            <!-- Product total price -->
                            <div class="cart-summary__cell">
                                <div class="cart-summary__price">
                                    <div class="cart-price">
                                        <div class="cart-price__main cart-price__main--small">
                                            <?php echo wp_kses($order->get_formatted_line_subtotal($item) , saleszone_get_allowed_html('price')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div><!-- /.cart-summary__row -->
                    <?php endforeach; ?>

                </div><!-- /.cart-summary__items -->

                <div class="cart-summary__subtotal">
                    <?php foreach ($order->get_order_item_totals() as $key => $total) : ?>
                        <?php if ($key != 'order_total') : ?>
                            <div class="cart-summary__subtotal-item">
                                <div class="cart-summary__subtotal-title">
                                    <?php echo wp_kses($total['label'], saleszone_get_allowed_html('price')); ?>
                                </div>
                                <div class="cart-summary__subtotal-value">
                                    <div class="cart-price">
                                        <div class="cart-price__main cart-price__main--small">
                                            <?php echo wp_kses($total['value'] , saleszone_get_allowed_html('price')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <!-- TOTAL -->
                <?php foreach ($order->get_order_item_totals() as $key => $total) : ?>
                    <?php if ($key == 'order_total') : ?>
                        <div class="cart-summary__total-price cart-summary__total-price--order">
                            <div class="cart-summary__total-label">
                                <?php echo wp_kses($total['label'], saleszone_get_allowed_html('price')); ?>
                            </div>
                            <div class="cart-summary__total-value">
                                <div class="cart-price">
                                    <div class="cart-price__main cart-price__main--lg">
                                        <?php echo wp_kses($total['value'], saleszone_get_allowed_html('price')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

            </div><!-- /.cart-summary -->

            <?php do_action('woocommerce_order_items_table', $order); ?>

        </div>
    </section>
</div>

<?php if (has_action('woocommerce_order_details_after_order_table')): ?>
    <div class="content__row content__row--sm">
        <?php do_action('woocommerce_order_details_after_order_table', $order); ?>
    </div>
<?php endif; ?>


