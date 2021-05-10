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

?>
<li class="grid-item">
    <a class="catalog-section" href="<?php echo esc_url(get_term_link($category, 'product_cat')); ?>">
        <div class="catalog-section__image">
            <?php
            $loc_image_id = get_term_meta($category->term_id, 'thumbnail_id', true);
            if($loc_image_id){
                    $attachment_image_url = wp_get_attachment_image_url($loc_image_id, 'thumbnail', true);
            } else if($productImage = saleszone_get_category_first_product_image_url($category->slug)) {
                $attachment_image_url = $productImage;
            } else {
                $attachment_image_url = wc_placeholder_img_src();
            }
            ?>
            <img class="catalog-section__img" src="<?php echo esc_url($attachment_image_url); ?>"
                 alt="<?php echo esc_attr(saleszone_get_img_alt($loc_image_id, $category->name)); ?>"
            >
        </div>
        <div class="catalog-section__caption">
            <?php echo esc_html($category->name); ?>
            <?php echo ($category->count > 0) ? apply_filters('woocommerce_subcategory_count_html', ' <mark class="catalog-section__count">(' . $category->count . ')</mark>', $category) : ''; ?>
        </div>
    </a>
</li>
