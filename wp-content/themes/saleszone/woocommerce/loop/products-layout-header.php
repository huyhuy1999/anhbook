<div class="content__header">
    <h1 class="content__title">
        <?php woocommerce_page_title(); ?>
    </h1>
    <?php woocommerce_result_count(); ?>
</div>

<?php if(saleszone_option('category-show-description-on-top')){
    saleszone_render_archive_products_description();
} ?>

<?php
/* Include woocommerce/content-product_cat.php template */
if (woocommerce_get_loop_display_mode() == 'both') {

    $args = apply_filters('woocommerce_output_product_categories_args-product-layout', array(
        'before' => '<div class="content__row"><div class="woocommerce columns-4"><div class="grid-list">',
        'after' => '</div></div></div>',
        'parent_id' => is_product_category() ? get_queried_object_id() : 0,
    ));

    woocommerce_output_product_categories($args);
}

?>

<?php wc_get_template('loop/toolbar.php'); ?>