<?php

global $product;

$productId = isset($productId) ? $productId : $product->get_ID();
$addRoute = home_url('wp-json/premmerce/wishlist/add/popup');
$addUrl = wp_nonce_url($addRoute . '?wishlist_move_from=true&wishlist_product_id=' . $productId ,'wp_rest');

?>
<div class="product-cut__move">
  <i class="product-cut__move-icon">
    <?php saleszone_the_svg('move'); ?>
  </i>
    <button class="product-cut__move-link" data-modal="<?php echo esc_url($addUrl); ?>">
        <?php esc_html_e('Move','goodlook'); ?>
    </button>
</div>