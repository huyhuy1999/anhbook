<?php
/**
 * Loop Price
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;
$variation = saleszone_get_variation($product);
?>

<?php if ( $price_html = $variation->get_price_html() ) : ?>
	<div class="product-price product-price--bg" data-product-price>
        <?php echo wp_kses($price_html, saleszone_get_allowed_html('price')); ?>
    </div>
<?php endif; ?>
