<?php
    if ( ! defined( 'WPINC' ) ) {
        die;
    }
?>
<div class="pc-product-action pc-product-action--buy-now">
    <div class="pc-product-action__ico pc-product-action__ico--cart">
        <?php saleszone_the_svg('cart'); ?>
    </div>
    <button class="pc-product-action__link"
            data-oneclick-order--btn="<?php echo esc_attr($popupUrl); ?>"
            data-oneclick-order--product-id="<?php echo esc_attr($productId); ?>">
        <?php esc_html_e('One click order', 'saleszone') ?>
    </button>
</div>