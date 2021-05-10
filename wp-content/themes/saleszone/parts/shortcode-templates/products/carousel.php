<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<section class="pc-section-primary" data-slider="section-primary">
    <?php if (!empty($attributes['title'])): ?>
        <div class="pc-section-primary__title"><?php echo esc_html($attributes['title']); ?></div>
    <?php endif; ?>
    <div class="pc-section-primary__inner" data-slider-slides="1,2,3,<?php echo esc_attr($attributes['columns'] ? $attributes['columns'] : 5); ?>">
        <?php echo $content; ?>
    </div>
    <div class="pc-section-primary__arrow pc-section-primary__arrow--left hidden" data-slider-arrow-left>
        <?php saleszone_the_svg('arrow-big-left') ?>
    </div>
    <div class="pc-section-primary__arrow pc-section-primary__arrow--right hidden" data-slider-arrow-right>
        <?php saleszone_the_svg('arrow-big-right') ?>
    </div>
</section>
