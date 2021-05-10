<?php
/**
 * Variable product add to cart
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.5
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
wc_get_template('single-product/add-to-cart/add-to-cart.php', array(
    'attributes' => $attributes,
    'available_variations' => $available_variations
));