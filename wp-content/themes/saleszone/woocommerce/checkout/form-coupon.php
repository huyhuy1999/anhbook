<?php
/**
 * Checkout coupon form
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! wc_coupons_enabled() ) {
	return;
}

$info_message = apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'saleszone' ) . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'saleszone' ) . '</a>' );
wc_print_notice( $info_message, 'notice' );

?>

<form class="checkout_coupon content__row content__row--sm" method="post" style="display:none">
    <div class="input-group input-group--coupon">
        <input type="text" name="coupon_code" class="form-control input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'saleszone' ); ?>" id="coupon_code" value="" />
        <div class="input-group-btn">
            <input type="submit" class="btn btn-default button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'saleszone' ); ?>" />
        </div>
    </div>
</form>