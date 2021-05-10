<div class="content__row">
    <div class="row row--ib row--vindent-m">
        <?php foreach ($brands as $brand) :
            $imageURL = wp_get_attachment_image_url(get_term_meta($brand->term_id, 'thumbnail_id', true), 'medium');
            $imageURL = $imageURL ? $imageURL : plugins_url('premmerce-woocommerce-brands/assets/frontend/img/placeholder.png');
            ?>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <a class="brand-image" href="<?php echo esc_url(get_term_link($brand->slug, 'product_brand')); ?>">
                    <span class="brand-image__photo">
                        <img class="brand-image__img" src="<?php echo esc_url($imageURL); ?>" alt="<?php echo esc_attr($brand->name); ?>">
                    </span>
                    <span class="brand-image__title">
                        <?php echo esc_html($brand->name); ?>
                    </span>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>