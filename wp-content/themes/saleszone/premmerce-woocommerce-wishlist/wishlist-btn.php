<?php

$addUrl = premmerce_wishlist()->getAddPopupUrl($productId);

if(!isset($type)){
    $type = false;
}

?>

<?php if($type == 'button') :?>
    <button class="btn btn-default" data-modal="<?php echo esc_url($addUrl); ?>">
        <i class="btn-default__ico btn-default__ico--wishlist"><?php saleszone_the_svg('heart'); ?></i>
    </button>
<?php elseif ($type == 'link') : ?>
    <div class="pc-product-action__ico pc-product-action__ico--wishlist">
        <?php saleszone_the_svg('heart'); ?>
    </div>
    <button class="pc-product-action__link" data-modal="<?php echo esc_url($addUrl); ?>">
        <?php esc_html_e('Add to Wishlist','saleszone'); ?>
    </button>
<?php endif; ?>