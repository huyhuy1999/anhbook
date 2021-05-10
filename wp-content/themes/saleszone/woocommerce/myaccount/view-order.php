<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! $order = wc_get_order( $order_id ) ) {
    return;
}
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

?>

<div class="row row--ib row--vindent-m">
    <div class="col-xs-12 col-lg-7">

        <!-- show_customer_details -->
        <div class="content__row content__row--sm">
            <div class="order-details">
                <div class="order-details__group">
                    <p>
                        <?php
                        printf(
                            /* translators: %1$s: order number %2$s: order date %3$s: order status */
                            esc_html__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'saleszone' ),
                            '<mark class="order-number">' . esc_html($order->get_order_number()) . '</mark>',
                            '<mark class="order-date">' . esc_html(wc_format_datetime( $order->get_date_created() )) . '</mark>',
                            '<mark class="order-status">' . esc_html(wc_get_order_status_name( $order->get_status() )) . '</mark>'
                        );
                        ?>
                    </p>
                </div>
                <?php if ( $notes = $order->get_customer_order_notes() ) : ?>
                <div class="order-details__group">
                    <div class="order-details__list">
                        <div class="order-details__item order-details__item--group-title">
                            <?php esc_html_e( 'Order updates', 'saleszone' ); ?>
                        </div>
                    </div>
                    <ul class="order-updates">
                        <?php foreach ( $notes as $note ) : ?>
                            <li class="order-updates__item">
                                <div class="order-updates__item-meta">
                                    <?php echo esc_html(date_i18n( __( 'l jS \o\f F Y, h:ia', 'saleszone' ), strtotime( $note->comment_date ) )); ?>
                                </div>
                                <div class="order-updates__item-description">
                                    <?php echo esc_html(wpautop( wptexturize( $note->comment_content ) )); ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) ) ?>
        </div>
        </div>
        <?php if ( $show_downloads && count($downloads) > 0) :?>
            <div class="content__row content__row--sm">
                <?php wc_get_template( 'order/order-downloads.php', array( 'downloads' => $downloads, 'show_title' => true ) ); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-lg-5">
        <?php do_action( 'woocommerce_view_order', $order_id ); ?>
    </div>
</div>
