<?php
/**
 * Grouped product add to cart
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product, $post;

wc_get_template('single-product/add-to-cart/add-to-cart.php', array(
    'attributes' => false,
    'grouped_products' => $grouped_products
));