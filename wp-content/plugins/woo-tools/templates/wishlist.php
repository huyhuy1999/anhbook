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

do_action( 'tfwc_tool_wishlist_before_wishlist_messages', $args );

do_action( 'tfwc_tool_wishlist_before_wishlist_template', $args );

?>
<form id="tfwctool-wishlist-form" action="<?php echo esc_url( tfwctool_get_wishlist_url() ); ?>" method="post" class="woocommerce">
	<?php wp_nonce_field( 'tfwctool-wishlist-form', 'tfwctool-wishlist-form-nonce' ) ?>
	<table class="shop_table shop_table_responsive cart">
		<thead>
			<tr>
				<?php if($can_remove_product): ?>
				<th class="product-remove">&nbsp;</th>
				<?php endif; ?>
				<th class="product-thumbnail">&nbsp;</th>
				<th class="product-name"><?php esc_html_e( 'Product Name', 'woocommerce' ); ?></th>
				<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'Stock Status', 'woocommerce' ); ?></th>
				<th class="product-actions">&nbsp;</th>
			</tr>
		</thead>
		<tbody>			
			<?php 
				if($product_ids): 
					foreach ($product_ids as $key => $product_id): 
						global $product;
						$product = $_product = wc_get_product( $product_id ); 
						if($_product  && $_product->exists() && $_product->is_visible()):
							$availability = $_product->get_availability();
	            			$stock_status = $availability['class'];
							$product_permalink = $_product->is_visible() ? $_product->get_permalink( $product_id ) : '';
						?>
						<tr>
						<td><a href="#" class="remove-from-wishlist" data-product_id="<?php echo intval($product_id) ?>" rel="nofollow">x</a></td>
						
						<td class="product-thumbnail">
						<?php
							$thumbnail = $_product->get_image();

							if ( ! $product_permalink ) {
								echo $thumbnail;
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
							}
						?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
						<?php
							if ( ! $product_permalink ) {
								echo $_product->get_name();
							} else {
								echo sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name());
							}
						?>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php echo $_product->get_price_html(); ?>
						</td>
						<td class="product-stock-status">
							<?php echo $stock_status == 'out-of-stock' ? '<span class="wishlist-out-of-stock">' . __( 'Out of Stock', 'woocommerce-tools' ) . '</span>' : '<span class="wishlist-in-stock">' . __( 'In Stock', 'woocommerce-tools' ) . '</span>'; ?>
                        </td>
                        <td class="product-add-to-cart">
                        	<?php 
                        		if( isset( $stock_status ) && $stock_status != 'out-of-stock' ){
                        			woocommerce_template_loop_add_to_cart(); 
                            	}
                            ?>
                        </td>
						</tr>
						<?php endif; ?>
			<?php endforeach; endif; ?>
		</tbody>
	</table>
</form>