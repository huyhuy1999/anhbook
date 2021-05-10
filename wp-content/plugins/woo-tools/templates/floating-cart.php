<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="tfwctool-floating-cart-contents">
	<?php if(absint(WC()->cart->get_cart_contents_count())): ?>
	<form class="woocommerce-cart-form1" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<div class="tfwctool-floating-cart-porducts">
		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );	
			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				echo '<div class="tfwc-f-cart-product">';
					$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

					if ( ! $product_permalink ) {
						echo $thumbnail; // PHPCS: XSS ok.
					} else {
						printf( '<a class="product-img-link" href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
					}
					echo '<span class="product-title">';
					if ( ! $product_permalink ) {
						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
					} else {
						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a class="product-title-link" href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
					}

					do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
					echo '</span>';

					// Backorder notification.
					if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
					}

					if ( $_product->is_sold_individually() ) {
						$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
					} else {
						$input_id = uniqid( 'quantity_' );
						$max_value = $_product->get_max_purchase_quantity();
						$min_value = 1;
						$input_name = "cart[{$cart_item_key}][qty]";
						$input_value = $cart_item['quantity'];
						$product_name = $_product->get_name();
						if ( $max_value && $min_value === $max_value ) {
							?>
							<div class="tfwctool-f-cart-quantity hidden">
								<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
							</div>
							<?php
						} else {
							/* translators: %s: Quantity. */
							$label = ! empty( $product_name ) ? sprintf( __( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) : __( 'Quantity', 'woocommerce' );
							?>
							<div class="tfwctool-f-cart-quantity">
								<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
								<input
									type="number"
									id="<?php echo esc_attr( $input_id ); ?>"
									class="input-text tfwctool-f-cart-quantity"
									step="1"
									min="1"
									max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
									name="<?php echo esc_attr($input_name); ?>"
									value="<?php echo esc_attr($input_value); ?>"
									title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
									size="4"
									inputmode="numeric"
									data-item_key="<?php echo esc_attr($cart_item_key) ?>"/>
								<button type="button" class="tfwctool-f-cart-decrease">-</button>
								<button type="button" class="tfwctool-f-cart-increase">+</button>
							</div>
							<?php
						}
					}

					echo '<div class="tfwctool-fl-cart-product-price">';
					echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
					echo '</div>';
					
					echo '<div class="tfwctool-fcrt-meta">';
					// Meta data.
					echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.
					echo '</div>';
					
					// echo "<div class='product-remove'>";
					echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
					// echo "</div>";
				echo '</div>';
			}
		}

		?>
	</div>
	</form>
	<div class="tfwwc-tool-f-cart-bottom">
		<div class="tfwwc-tool-f-cart-bottom-inner">
			<a class="btn btn-tfwctool-chckot-url" href="<?php echo esc_url(wc_get_checkout_url()); ?>">
				<div class="tfwwc-tool-f-cart-checkout">
					<?php esc_html_e( 'Checkout', 'woo-tools' ); ?>
				</div> -
				<div class="tfwwc-tool-f-cart-subtotal">
					<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.  ?>
				</div>
			</a>
		</div>
	</div>
	<?php else: ?>
		<div class="tfwctool-f-cart-empty">
			<?php esc_html_e( 'Your cart is currently empty.', 'woo-tools' ); ?>
		</div>
	<?php endif; ?>
</div>