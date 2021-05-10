<?php

$allowed_html = array_merge(
    saleszone_get_allowed_html('widget'),
    saleszone_svg_allowed_html()
);

?>
<?php echo wp_kses($args['before_widget'], $allowed_html); ?>

<?php if(is_front_page()): ?>
    <div class="pc-section-secondary">

        <div class="brands-slider" data-slider="mainpage-brands">

            <?php if ($title) : ?>
            <div class="brands-slider__header">
                <a href="<?php echo esc_url(home_url('brands')); ?>" class="brands-slider__tlink">
                    <?php echo esc_html($title); ?>
                </a>
            </div>
            <?php endif; ?>

            <div class="brands-slider__inner">
                <div class="brands-slider__arrow brands-slider__arrow--prev" data-slider-arrow-left>
                    <?php saleszone_the_svg('angle-left'); ?>
                </div>
                <div class="brands-slider__arrow brands-slider__arrow--next" data-slider-arrow-right>
                    <?php saleszone_the_svg('angle-right'); ?>
                </div>
                <div class="brands-slider__row brands-slider__row--columns-<?php echo esc_attr($attributes['columns']); ?>"
                     data-slider-slides="2,3,4,6,<?php echo esc_attr($attributes['columns']); ?>">
                    <?php foreach ($brands as $brand): ?>
                        <?php $imageURL = wp_get_attachment_image_url(get_term_meta($brand->term_id, 'thumbnail_id', true), 'medium'); ?>
                        <div class="brands-slider__column" data-slider-slide>
                            <a class="brands-slider__link" href="<?php echo esc_url(get_term_link($brand->slug, 'product_brand')); ?>">
                                <?php if ($imageURL = wp_get_attachment_image_url(get_term_meta($brand->term_id, 'thumbnail_id', true), 'thumbnail')) : ?>
                                    <img class="brands-slider__item" src="<?php echo esc_url($imageURL); ?>"
                                         title="<?php echo esc_attr($brand->name); ?>"
                                         alt="<?php echo esc_attr($brand->name); ?>">
                                <?php else: ?>
                                    <span class="brands-slider__item"><?php echo esc_html($brand->name); ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
<?php else: ?>
    <?php if ($title) : ?>
        <?php echo wp_kses($args['before_title'], $allowed_html); ?>
        <?php echo esc_html($title); ?>
        <div class="pc-section-secondary__viewall">
            <a href="<?php echo esc_url(home_url('brands')); ?>" class="pc-section-secondary__hlink">
                <?php esc_html_e('View all', 'goodlook') ?>
            </a>
        </div>
        <?php echo wp_kses($args['after_title'], $allowed_html); ?>
    <?php endif ?>

    <div class="brands-widget">
        <div class="brands-widget__list">
            <?php foreach ($brands as $brand) : ?>
                <div class="brands-widget__list-item">
                    <div class="brands-widget__item">
                        <a class="brands-widget__link"
                           href="<?php echo esc_url(get_term_link($brand->slug, 'product_brand')); ?>">
                            <?php if ($imageURL = wp_get_attachment_image_url(get_term_meta($brand->term_id, 'thumbnail_id', true), 'thumbnail')) : ?>
                                <img class="brands-widget__img" src="<?php echo esc_url($imageURL); ?>" alt="<?php echo esc_attr($brand->name); ?>"
                                     title="<?php echo esc_attr($brand->name); ?>">
                            <?php else: ?>
                                <span class="brands-widget__title">
                                <?php echo esc_html($brand->name); ?>
                            </span>
                            <?php endif ?>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

<?php endif; ?>

<?php echo wp_kses($args['after_widget'], $allowed_html); ?>
