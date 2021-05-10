<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 	2.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<?php foreach ( $item_data as $data ) : ?>
    <div class="cart-product__option">
        <span class="cart-product__option-key <?php //sanitize_html_class( 'variation-' . $data['key'] ); ?>">
            <?php echo wp_kses_post( $data['key'] ); ?>:
        </span>
        <span class="cart-product__option-val <?php  //sanitize_html_class( 'variation-' . $data['key'] ); ?>">
            <?php echo wp_kses_post( $data['display'] ); ?>
        </span>
    </div>
<?php endforeach; ?>
