<?php 
/**
 * WooCommerce Tool 
 *
 * @author ThemeFarmer
 * @version 1.0.0
 * @package WooCommerce Tool 
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


?>
<div class="widget_tfwctool_wishlist_content">
	<?php if($product_ids):  ?>
	<ul class="tfwctools-mini-wishlist  product_wishlist_widget ">
		<?php
		$total = 0; 
		foreach ($product_ids as $key => $product_id): 
			global $product;
			$product = $_product = wc_get_product( $product_id ); 
			if($_product  && $_product->exists() && $_product->is_visible()):
				$availability = $_product->get_availability();
    			$stock_status = $availability['class'];
				$product_permalink = $_product->is_visible() ? $_product->get_permalink( $product_id ) : '';
			?>
			<li class="tfwctools-mini-wishlist-item mini-wishlist-item">
				<?php
					$thumbnail = $_product->get_image();

					if ( ! $product_permalink ) {
						echo $thumbnail;
					} else {
						printf( '<a class="tfwctools-wishlist-thumb" href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
					}
				?>
				<?php
					if ( ! $product_permalink ) {
						echo $_product->get_name();
					} else {
						echo sprintf( '<a class="tfwctools-wishlist-pname" href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name());
					}
				?>
				<span class="tfwctools-wishlist-pprice"><?php echo $_product->get_price_html(); ?></span>
				<?php if($can_remove_product): ?>
				<a href="#" class="remove-from-wishlist" data-product_id="<?php echo intval($product_id) ?>" rel="nofollow">x</a>
				<?php endif; ?>
			</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	<div class="tfwctool-mini-wishlist-bottom-container">
		<div class="tfwctool-mini-wishlist-total">
			<span class="tfwctool-lable"><?php esc_html_e( 'Items', 'tfwctool' ); ?></span><span class="tfwctool-value"><?php echo count($product_ids) ?></span>
		</div>
		<div class="tfwctool-mini-wishlist-actions">
			<a class="btn button tfwctool-wishlist-btn" href="<?php echo esc_url( tfwctool_get_wishlist_url() ); ?>"><?php esc_html_e( 'View Wishlist', 'tfwctool' ); ?></a>
		</div>
	</div>
	<?php else: ?>
		<div class="tfwctool-empty-wishlist"><?php esc_html_e('No products in the wishlist', 'woocommerce-tools'); ?></div>
	<?php endif; ?>
</div>