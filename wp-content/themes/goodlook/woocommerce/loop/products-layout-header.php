<?php
/* Include woocommerce/content-product_cat.php template */
if (woocommerce_get_loop_display_mode() == 'both') {
    woocommerce_output_product_categories(array(
        'before' => '<div class="content__row"><div class="woocommerce columns-4"><div class="grid-list">',
        'after' => '</div></div></div>',
        'parent_id' => is_product_category() ? get_queried_object_id() : 0,
    ));
}
?>

<?php wc_get_template('loop/toolbar.php'); ?>