<?php

$phones = preg_split("/[\n]/", saleszone_option('header-phone'));
$font_size = saleszone_option('header-phone-icon-size') . 'px';

$phone = array_pop($phones);
$size = saleszone_option('header-phone-icon-size') . 'px';
$phone_font_size = saleszone_option('header-phone-font-size') . 'px';

?>

<div class="pc-header-phones-drop" style="font-size: <?php echo esc_attr($phone_font_size); ?>">
    <?php if(saleszone_option('header-phone-show-icon')) :?>
        <div class="pc-header-phones-drop__icon" style="width: <?php echo esc_attr($size); ?>;height: <?php echo esc_attr($size); ?>;">
            <?php saleszone_the_svg(saleszone_option('header-phone-icon-style')); ?>
        </div>
    <?php endif; ?>
    <div class="pc-header-phones-drop__body">
        <?php if($title = saleszone_option('header-phone-title')) :?>
            <div class="pc-header-phones-drop__phone-title">
                <?php echo esc_html($title); ?>
            </div>
        <?php endif; ?>
        <div class="pc-header-phones-drop__phone-item">
            <a class="pc-header-phones-drop__phone" href="tel:<?php echo esc_attr(saleszone_clear_phone_number($phone)); ?>"
               style="font-size: <?php echo esc_attr(saleszone_option('header-phone-font-size')); ?>px;">
                <?php echo esc_html($phone); ?>
            </a>
            <div class="pc-header-phones-drop__arrow">
                <?php saleszone_the_svg('arrow-down'); ?>
            </div>
            <?php if(count($phones) > 0) :?>
                <div class="pc-header-phones-drop__drop-down">
                    <div class="pc-header-phones-drop__list">

                        <?php foreach ($phones as $phone): ?>
                            <div class="pc-header-phones-drop__list-item">
                                <a class="pc-header-phones-drop__link" href="tel:<?php echo esc_attr(saleszone_clear_phone_number($phone)); ?>">
                                    <?php echo esc_html($phone); ?>
                                </a>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>