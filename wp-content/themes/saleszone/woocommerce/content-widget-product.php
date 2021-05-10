<?php
/**
 * The template for displaying product widget entries
 *
 * @see    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

defined('ABSPATH') || exit;

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
    return;
}

?>
<div class="widget-sidebar__item">
    <?php do_action('woocommerce_widget_product_item_start', $args); ?>
    <?php wc_get_template('content-product_thumb.php', array(
        'parent_cart' => false
    )); ?>
    <?php do_action('woocommerce_widget_product_item_end', $args); ?>
</div>