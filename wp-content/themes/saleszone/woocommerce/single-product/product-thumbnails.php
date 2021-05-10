<?php
/**
 * Single Product Thumbnails
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post, $product;
$variation = saleszone_get_variation($product);
$attachment_ids = $product->get_gallery_image_ids();
$slides_attr = saleszone_option('product-thumbnails-type') == 'slides' ? 'data-slider-slide':'';
if (!$attachment_ids) {
    return;
}
?>

<?php if ($attachment_ids && $product->get_image_id()): ?>
    <!-- First output main image -->
    <li class="product-photo__thumb" <?php echo esc_attr($slides_attr); ?>>
        <a class="product-photo__thumb-item"
           href="<?php echo esc_attr(wp_get_attachment_image_url($variation->get_image_id(), 'large')); ?>" target="_blank"
           data-product-photo-thumb="<?php echo esc_attr(wp_get_attachment_image_url($variation->get_image_id(), 'shop_single')); ?>"
           data-product-photo-thumb-active
           data-magnific-galley-thumb
           data-magnific-galley-title="<?php echo esc_attr($variation->get_name()); ?>"
        >
            <img class="product-photo__thumb-img"
                 src="<?php echo esc_attr(wp_get_attachment_image_url($variation->get_image_id(), 'shop_thumbnail')); ?>"
                 alt="<?php echo esc_attr(saleszone_get_img_alt($variation->get_image_id(), $variation->get_name())); ?>"
                 title="<?php echo esc_attr($variation->get_name()); ?>"
                 data-product-photo-main-thumb>
        </a>
    </li>
<?php endif; ?>

<!-- Additional images list -->
<?php foreach ($attachment_ids as $attachment_id):
    $full_image = wp_get_attachment_image_url($attachment_id, 'large');
    $main_image = wp_get_attachment_image_url($attachment_id, 'shop_single');
    $thumbnail = wp_get_attachment_image_url($attachment_id, 'shop_thumbnail');
    ?>
    <li class="product-photo__thumb" <?php echo esc_attr($slides_attr); ?>>
        <a class="product-photo__thumb-item"
           href="<?php echo esc_attr($full_image); ?>"
           target="_blank"
           data-product-photo-thumb="<?php echo esc_attr($main_image); ?>"
           data-magnific-galley-thumb
           data-magnific-galley-title="<?php echo esc_attr($product->get_name() . ' ' . $attachment_id); ?>"
        >
            <img class="product-photo__thumb-img"
                 src="<?php echo esc_attr($thumbnail); ?>"
                 alt="<?php echo esc_attr(saleszone_get_img_alt($product->get_image_id(), $product->get_name()) . ' ' . $attachment_id); ?>"
                 title="<?php echo esc_attr($product->get_name() . ' ' . $attachment_id); ?>"
                 data-zoom-image-small>
        </a>
    </li>
<?php endforeach; ?>

