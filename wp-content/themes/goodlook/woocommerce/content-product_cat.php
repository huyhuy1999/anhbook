<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$loc_image_id = get_term_meta($category->term_id, 'thumbnail_id', true);
?>
<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
    <a class="catalog-section" href="<?php echo esc_url(get_term_link($category, 'product_cat')); ?>">
        <div class="catalog-section__image">
            <?php $image_data = wp_get_attachment_image_src($loc_image_id, 'thumbnail', true); ?>
            <img class="catalog-section__img" src="<?php echo esc_url($image_data[0]); ?>"
                 alt="<?php echo esc_attr(saleszone_get_img_alt($loc_image_id, $category->name)); ?>"
            >
        </div>
        <div class="catalog-section__caption">
            <?php echo esc_html($category->name); ?>
            <?php echo ($category->count > 0) ? apply_filters('woocommerce_subcategory_count_html', ' <mark class="catalog-section__count">(' . $category->count . ')</mark>', $category) : ''; ?>
        </div>
    </a>
</div>
