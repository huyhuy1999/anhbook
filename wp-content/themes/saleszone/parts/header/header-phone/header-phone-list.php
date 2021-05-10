<?php

$phones = preg_split("/[\n]/", saleszone_option('header-phone'));
$font_size = saleszone_option('header-phone-icon-size') . 'px';

?>

<div class="pc-header-phones" style="font-size: <?php echo esc_attr($font_size); ?>;">
    <?php if(saleszone_option('header-phone-show-icon')) :?>
        <?php $size = saleszone_option('header-phone-icon-size') . 'px'; ?>
        <div class="pc-header-phones__ico"
             style="width: <?php echo esc_attr($size); ?>;height: <?php echo esc_attr($size); ?>;">
            <?php saleszone_the_svg(saleszone_option('header-phone-icon-style')); ?>
        </div>
    <?php endif; ?>
    <div class="pc-header-phones__body">
        <?php if($title = saleszone_option('header-phone-title')) :?>
            <div class="pc-header-phones__phone-title">
                <?php echo esc_html($title); ?>
            </div>
        <?php endif; ?>
        <div class="pc-header-phones__phones-list <?php echo saleszone_option('header-phone-display-type') == 'list-horizontal' ? 'pc-header-phones__phones-list--horizontal':'' ?>">
            <?php foreach ($phones as $phone): ?>
                <div class="pc-header-phones__phones-item">
                    <a class="pc-header-phones__link" href="tel:<?php echo esc_attr(saleszone_clear_phone_number($phone)); ?>"
                       style="font-size: <?php echo esc_attr(saleszone_option('header-phone-font-size')); ?>px;">
                        <?php echo wp_kses_post($phone); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>