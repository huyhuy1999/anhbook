<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$template = saleszone_get_catalog_template();

?>
<div class="pc-category-products-layout pc-category-products-layout__row">
    <?php if (is_active_sidebar('catalog_sidebar')): ?>
        <div class="pc-category-products-layout__sidebar">
            <div class="content__sidebar">
                <?php
                /**
                 * @hooked saleszone_brand_sidebar_image - 10
                 * @hooked saleszone_dynamic_catalog_sidebar - 20
                 */
                do_action('premmerce_catalog_sidebar');
                do_action('woocommerce_sidebar');
                ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="pc-category-products-layout__body">

        <?php do_action( 'woocommerce_before_main_content' ); ?>

        <?php wc_get_template('loop/products-layout-header.php'); ?>

        <?php do_action('premmerce-archive-products-layout-body-after-header'); ?>

        <?php $wc_notice =  wc_get_notices(); ?>
        <?php if (!empty($wc_notice)): ?>
            <div class="content__row">
                <?php wc_print_notices(); ?>
            </div>
        <?php endif; ?>

        <?php if (have_posts()): ?>
            <div class="content__row">
                <div class="pc-product-loop pc-product-loop--per-row-<?php echo esc_attr(saleszone_option('shop-category-per-row')); ?> <?php if ($template == 'list'): ?>pc-product-loop--list<?php else: ?>pc-product-loop--grid<?php endif; ?>" data-load-more-product--container>
                    <?php while (have_posts()): the_post(); ?>
                        <div class="pc-product-loop__col">
                            <?php if ($template == 'list') {
                                wc_get_template_part('content', 'product_snippet');
                            } else {
                                wc_get_template_part('content', 'product');
                            } ?>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="content__row">
                <div class="typo">
                    <?php do_action('woocommerce_no_products_found'); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php woocommerce_pagination(); ?>

        <?php do_action('premmerce-archive-products-layout-body-end'); ?>

        <?php do_action( 'woocommerce_after_main_content' ); ?>
    </div>
</div>