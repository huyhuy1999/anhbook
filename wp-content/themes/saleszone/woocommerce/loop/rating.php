<?php
/**
 * Loop Rating
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( get_option( 'woocommerce_enable_reviews' ) === 'no') {
	return;
}

wc_get_template('single-product/rating.php');
