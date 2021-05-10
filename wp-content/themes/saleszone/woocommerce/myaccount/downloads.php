<?php
/**
 * Downloads
 *
 * Shows downloads on the account page.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$downloads     = WC()->customer->get_downloadable_products();
$has_downloads = (bool) $downloads;

do_action( 'woocommerce_before_account_downloads', $has_downloads ); ?>

<?php if ( $has_downloads ) : ?>

	<?php do_action( 'woocommerce_before_available_downloads' ); ?>

    <?php wc_get_template( 'order/order-downloads.php', array('downloads' => $downloads, 'table_modifiers' => 'woocommerce-order-downloads--page-downloads')); ?>

	<?php do_action( 'woocommerce_after_available_downloads' ); ?>

<?php else : ?>
    <div class="frame">
        <div class="frame__header">
            <?php esc_html_e( 'No downloads available yet.', 'saleszone' ); ?>
        </div>
        <div class="frame__inner">
            <a class="btn btn-primary" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                <?php esc_html_e( 'Go shop', 'saleszone' ) ?>
            </a>
        </div>
    </div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_downloads', $has_downloads ); ?>
