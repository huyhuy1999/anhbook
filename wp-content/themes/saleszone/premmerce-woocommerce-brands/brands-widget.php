<?php

$allowed_html = array_merge(
    saleszone_svg_allowed_html(),
    saleszone_get_allowed_html('widget')
);

?>
<?php echo wp_kses($args['before_widget'], $allowed_html); ?>

<?php if ($title) : ?>
    <?php echo wp_kses($args['before_title'], $allowed_html); ?>
    <?php echo esc_html($title); ?>
    <div class="pc-section-secondary__viewall">
        <a href="<?php echo esc_url(home_url('brands')); ?>" class="pc-section-secondary__hlink">
            <?php esc_html_e('View all', 'saleszone') ?>
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
<?php echo wp_kses($args['after_widget'], $allowed_html); ?>
