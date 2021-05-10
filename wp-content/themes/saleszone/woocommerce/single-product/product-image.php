<?php
/**
 * Single Product Image
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

global $product;
$variation = saleszone_get_variation($product);

$main_image_src = $product->get_image_id() ? wp_get_attachment_image_url($variation->get_image_id(), 'shop_single') : esc_url(wc_placeholder_img_src('woocommerce_single'));
?>

<div class="product-photo" data-magnific-galley data-product-photo-scope>
    <!-- Main photo -->
    <a class="product-photo__item product-photo__item--lg <?php if (!has_post_thumbnail()): ?>product-photo__item--no-photo<?php endif; ?>"
       href="<?php echo esc_url(wp_get_attachment_image_url($variation->get_image_id(), 'large')); ?>" target="_blank"
       data-product-photo-link
       data-magnific-galley-main
       data-magnific-galley-title="<?php echo esc_attr($variation->get_name()); ?>"
       data-magnific-galley-close-text="<?php esc_attr_e('Close', 'saleszone'); ?>"
    >
        <img class="product-photo__img"
             src="<?php echo esc_url($main_image_src); ?>"
             alt="<?php echo esc_attr(saleszone_get_img_alt($variation->get_image_id(), $variation->get_name())); ?>"
             title="<?php echo esc_attr($variation->get_name()); ?>"
             data-product-photo
             data-product-photo-origin="<?php echo esc_url($main_image_src); ?>"
             data-zoom-image-small
             data-zoom-image-url="<?php echo esc_url(wp_get_attachment_image_url($variation->get_image_id(), 'large')); ?>"
             data-src-placeholder="<?php echo esc_url(wc_placeholder_img_src('woocommerce_single')); ?>"
             data-zoom-image
        >
        <span class="product-photo__zoom hidden hidden-sm hidden-xs" data-zoom-wrapper></span>
    </a>
    <div class="product-photo__item product-photo__item--lg product-photo__video hidden"
         data-product-photo-video-frame></div>
    <?php  ?>
    <!-- Additional images -->
    <?php if(saleszone_option('product-thumbnails-type') == 'slides') :?>
        <div class="product-photo__thumbs-wrapper" data-slider="thumbs-slider">
            <div class="product-photo__thumbs-slider">
                <ul class="product-photo__thumbs" data-slider-slides="<?php echo esc_attr(apply_filters('product-photo-data-slider-slides', '2,3,3,4')); ?>">
                    <?php do_action('woocommerce_product_thumbnails'); ?>
                </ul>
                <button class="product-photo__thumbs-arrow product-photo__thumbs-arrow--prev hidden" data-slider-arrow-left>
                    <?php saleszone_the_svg('angle-left'); ?>
                </button>
                <button class="product-photo__thumbs-arrow product-photo__thumbs-arrow--next hidden" data-slider-arrow-right>
                    <?php saleszone_the_svg('angle-right'); ?>
                </button>
            </div>
        </div>
    <?php else: ?>
        <div class="product-photo__thumbs-wrapper">
            <ul class="product-photo__thumbs">
                <?php do_action('woocommerce_product_thumbnails'); ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
