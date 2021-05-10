<?php

global $product;
global $premmerce_wishlist_frontend;

$productId = isset($productId) ? $productId : $product->get_ID();
$addRoute = home_url('wp-json/premmerce/wishlist/add/popup');
$addUrl = wp_nonce_url($addRoute . '?wishlist_move_from=true&wishlist_product_id=' . $productId ,'wp_rest');

?>
<div class="product-cut__move">
    <button class="product-cut__move-link" data-modal="<?php echo esc_url($addUrl); ?>">
        <?php esc_html_e('Move','saleszone'); ?>
    </button>
</div>