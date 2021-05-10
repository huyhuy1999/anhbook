<?php
/**
 * Checkout login form
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
	return;
}

$info_message  = apply_filters( 'woocommerce_checkout_login_message', __( 'Returning customer?', 'saleszone' ) );
?>

<div class="content__row content__row--sm typo">
    <?php echo esc_html($info_message); ?>
    <a class=""
       href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id'))); ?>"
       data-modal="<?php echo esc_url(saleszone_get_modal_url('parts/modal/modal-login')); ?>">
        <?php esc_html_e( 'Click here to login', 'saleszone' )?>
    </a>
</div>

