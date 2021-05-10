<?php if ( ! defined( 'WPINC' ) ) {
    die;
}
?>

<div class="pc-product-action">
    <div class="pc-product-action__ico pc-product-action__ico--notification">
        <?php saleszone_the_svg('product-wait'); ?>
    </div>
    <a class="pc-product-action__link"
       data-product-wait-show-popup
       data-product-wait-product-id="<?php echo esc_attr($productID); ?>"
       href="<?php echo esc_url(add_query_arg(array('wc-ajax' => 'premmerceProductWaitShowPopup', 'productId' => $productID), get_permalink()))?>">
        <?php esc_html_e( 'Notify when available', 'saleszone' ) ?>
    </a>
</div>



