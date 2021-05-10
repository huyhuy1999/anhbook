<?php
if (!defined('ABSPATH')) {
	exit;
}

$gallery_images_ids = $variation->get_gallery_image_ids();
$gallery_first_image = $gallery_images_ids[0];

?>
<div class="flipper
        <?php if(saleszone_option('category-product-flipper-animation') != 'none'):?>
            flipper--<?php echo esc_attr(saleszone_option('category-product-flipper-animation')); ?>
        <?php endif; ?>
    ">
	<div class="flipper__body">
		<div class="flipper__front">
			<?php wc_get_template('loop/product-image.php', array(
				'variation' => $variation,
				'flip_image_src' => false
            )); ?>
		</div>
		<div class="flipper__back">
			<div class="product-photo">
                <div class="product-photo">
                    <a class="product-photo__item" href="<?php echo esc_url(get_the_permalink()); ?>">
                        <img class="product-photo__img"
                             data-flip-img-lazy-load
                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                             data-original="<?php echo esc_url($flip_image_src); ?>"
                             alt="<?php echo esc_attr(saleszone_get_img_alt($variation->get_image_id(), $variation->get_name())); ?>"
                             title="<?php echo esc_attr($variation->get_name()); ?>"
                             data-srcset="<?php echo esc_attr(wp_get_attachment_image_srcset( $gallery_first_image, apply_filters('single_product_archive_thumbnail_size', 'shop_catalog') )); ?>"
                             sizes="<?php echo esc_attr(wp_get_attachment_image_sizes( $gallery_first_image, apply_filters('single_product_archive_thumbnail_size', 'shop_catalog') )); ?>"
                        >
                    </a>
                </div>
			</div>
		</div>
	</div>
</div>
