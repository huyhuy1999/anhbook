<?php

if ( ! defined( 'WPINC' ) ) die;

$modal_url = add_query_arg(array('wc-ajax' => 'found_cheaper_popup', 'product_id' => $product->get_id()), get_the_permalink());

?>

<div class="pc-product-action pc-product-action--found-cheaper">
    <div class="pc-product-action__ico pc-product-action__ico--discount">
        <?php saleszone_the_svg('percentage-discount'); ?>
    </div>
    <button class="pc-product-action__link"
            data-found-less-expensive-button="<?php echo esc_url($modal_url); ?>">
        <?php esc_html_e('Found cheaper?', 'saleszone' ); ?>
    </button>
</div>