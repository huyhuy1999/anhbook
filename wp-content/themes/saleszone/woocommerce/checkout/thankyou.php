<?php
/**
 * Thankyou page
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( $order ){
    $show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
}

$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();


?>
<div class="row">
<?php if ( $order ) : ?>
    <?php if ( $order->has_status( 'failed' ) ) : ?>
        <div class="col-xs-12 typo">
            <p><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'saleszone' ); ?></p>
            <p>
                <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'saleszone' ) ?></a>
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'saleszone' ); ?></a>
                <?php endif; ?>
            </p>
        </div>
    <?php else : ?>
        <!-- User data -->
        <div class="col-sm-6">
            <div class="content__row content__row--sm">
                <div class="order-details">

                    <!-- Message -->
                    <div class="order-details__group typo">
                        <p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'saleszone' ), $order ); ?></p>
                    </div>

                    <!-- woocommerce-order-overview -->
                    <?php wc_get_template( 'order/order-overview.php', array( 'order' => $order ) ) ?>

                    <!-- show_customer_details -->
                    <?php if( $show_customer_details ) :?>
                        <?php wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) ) ?>
                    <?php endif; ?>

                </div>
            </div>
            <?php if ( $show_downloads && count($downloads) > 0) :?>
                <div class="content__row content__row--sm">
                    <?php wc_get_template( 'order/order-downloads.php', array( 'downloads' => $downloads, 'show_title' => true ) ); ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- Order details -->
        <div class="col-sm-6 col--spacer-xs">
            <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
            <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
        </div>
    <?php endif; ?>
<?php else : ?>
    <!-- If order not exist -->
    <div class="col-xs-12 typo">
        <p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'saleszone' ), null ); ?></p>
    </div>
<?php endif; ?>
</div>