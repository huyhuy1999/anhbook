<?php
if (!defined('ABSPATH')) {
    exit;
}

global $product;

$image_size = apply_filters('single_product_archive_thumbnail_size', 'shop_catalog');

if ( has_post_thumbnail( $product->get_id() ) ) {
    $main_image_src = wp_get_attachment_image_url($variation->get_image_id(), $image_size);
} elseif ( ( $parent_id = wp_get_post_parent_id( $product->get_id() ) ) && has_post_thumbnail( $parent_id ) ){
    $main_image_src =  wp_get_attachment_image_url($variation->get_image_id(), $image_size);
} else {
    $main_image_src = wc_placeholder_img_src();
}

$use_lazyload = saleszone_option('category-product-lazyload');
$use_spinner = $use_lazyload && saleszone_option('category-product-lazyload-spinner');

?>

<div class="product-photo">
    <a class="product-photo__item"
        <?php echo $use_spinner ? 'data-loader-frame-permanent':'';?>
       data-product-photo-permalink
       href="<?php echo esc_url(get_the_permalink()); ?>">
        <img class="product-photo__img"
            <?php if( $use_lazyload ):?>
                data-lazy-load
                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                data-srcset="<?php echo esc_attr(wp_get_attachment_image_srcset( $variation->get_image_id(), apply_filters('single_product_archive_thumbnail_size', 'shop_catalog') )); ?>"
                data-original="<?php echo esc_url($main_image_src); ?>"
                data-sizes="<?php echo esc_attr(wp_get_attachment_image_sizes( $variation->get_image_id(), apply_filters('single_product_archive_thumbnail_size', 'shop_catalog') )); ?>"
            <?php else : ?>
                src="<?php echo esc_url($main_image_src); ?>"
                srcset="<?php echo esc_attr(wp_get_attachment_image_srcset( $variation->get_image_id(), apply_filters('single_product_archive_thumbnail_size', 'shop_catalog') )); ?>"
                sizes="<?php echo esc_attr(wp_get_attachment_image_sizes( $variation->get_image_id(), apply_filters('single_product_archive_thumbnail_size', 'shop_catalog') )); ?>"
            <?php endif; ?>

             data-product-medium-photo
             data-src-placeholder="<?php echo esc_url(wc_placeholder_img_src()); ?>"
             alt="<?php echo esc_attr(saleszone_get_img_alt($variation->get_image_id(), $variation->get_name())); ?>"
             title="<?php echo esc_attr($variation->get_name()); ?>"
        >
        <?php if( $use_spinner ):?>
            <i class="spinner-circle"></i>
        <?php endif; ?>
    </a>
</div>