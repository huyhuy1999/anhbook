<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<?php if (has_action('premmerce_loop_product_cut_action_row')) : ?>
    <div class="product-cut__action-row">
        <?php
        /**
         * @hooked saleszone_render_wishlist_catalog_button
         * @hooked renderComparisonBtn
         *
         */
        do_action('premmerce_loop_product_cut_action_row'); ?>
    </div>
<?php endif; ?>
