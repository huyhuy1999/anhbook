<?php

global $product;

?>

<button
	class="btn-product-quick-view"
	data-product-id="<?php echo esc_attr($product->get_id()); ?>"
    data-product-quick-view-button="<?php echo esc_attr(json_encode(array(
        'productId' => $product->get_id()
    ))); ?>"
    title="<?php esc_attr_e( 'Quick View', 'goodlook' ); ?>"
    >
  <?php esc_html_e( 'Quick View', 'goodlook' ); ?>
</button>