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
?>
<form id="tfwctool-compare-form" action="<?php echo esc_url( tfwctool_get_wishlist_url() ); ?>" method="post" class="woocommerce">
	<?php wp_nonce_field( 'tfwctool-compare-form', 'tfwctool-compare-form-nonce' ); ?>
	<table class="shop_table shop_table_responsive tfwctool-compare-table">
		<?php if($product_attrs): foreach ($product_attrs as $key => $attr): ?>
			<tr class="<?php echo esc_attr($key); ?>">
				<th><?php echo esc_html($attr); ?></th>
				<?php 
					if($products_data[$key]){
						$items = $products_data[$key]; 
						foreach ($items as $key => $item) {
							$class = ($key % 2 ==0)?'even':'odd';
							echo sprintf('<td class="%s"> %s </td>', $class, $item);
						}
					}
				?>
			</tr>
		<?php endforeach; endif;?>
	</table>
</form>