<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="content__header">
    <h1 class="content__title">
        <?php woocommerce_page_title(); ?>
    </h1>
</div>

<?php if(saleszone_option('category-show-description-on-top')){
    saleszone_render_archive_products_description();
} ?>

<div class="content__row">
    <div class="row">
        <div class="col-md-9">
            <?php

            $args = apply_filters('woocommerce_output_product_categories_args-cat-layout', array(
                'before' => '<div class="woocommerce columns-4"><div class="grid-list">',
                'after' => '</div></div>',
                'parent_id' => is_product_category() ? get_queried_object_id() : 0,
            ));

            woocommerce_output_product_categories($args); ?>

            <?php do_action('premmerce-category-category-layout-body-end'); ?>
        </div>
        <?php if (is_active_sidebar('subcategories_sidebar')): ?>
            <div class="col-md-3 col--spacer-sm hidden-xs hidden-sm">
                <div class="content__sidebar content__sidebar--right">
                    <?php
                    /**
                     * @hooked saleszone_dynamic_subcategories_sidebar
                     */
                    do_action('premmerce_subcategories_sidebar');
                    do_action('woocommerce_sidebar');
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>