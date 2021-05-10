<?php
if (!defined('ABSPATH')) {
    exit;
}
global $product;
?>

<div class="attributes-list <?php echo esc_attr($parent_modifiers); ?>">
    <?php if ($dimensions && $variation->has_weight()) : ?>
        <div class="attributes-list__row">
            <div class="attributes-list__name"><?php esc_html_e('Weight', 'saleszone') ?></div>
            <div class="attributes-list__value" data-product-weight>
                <?php echo esc_html(wc_format_weight($variation->get_weight())); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($dimensions && $variation->has_dimensions()) : ?>
        <div class="attributes-list__row">
            <div class="attributes-list__name"><?php esc_html_e('Dimensions', 'saleszone') ?></div>
            <div class="attributes-list__value" data-product-dimensions>
                <?php echo esc_html(wc_format_dimensions($variation->get_dimensions(false))); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php foreach ($attributes as $attribute) : ?>
        <div class="attributes-list__row">
            <div class="attributes-list__name"><?php echo wp_kses_post(saleszone_wc_attribute_label($attribute->get_name())); ?></div>
            <div class="attributes-list__value">
                <?php echo wp_kses_post(saleszone_get_attribute_terms($attribute)); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>