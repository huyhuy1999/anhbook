<?php
$end_date = (int)get_post_meta( $id, '_sale_price_dates_to', true );
//Add 24 hours for correct timer work
$end_date += 24 * 60 * 60;
?>

<?php if($end_date && $end_date > time() && saleszone_option('product-action-counter')): ?>

    <?php
        $date = saleszone_get_countdown($end_date);
        $dateFormat = date('c', $end_date);
    ?>
    <!-- Countdown  -->
    <div class="countdown-product"
         data-countdown="<?php echo esc_attr($dateFormat) ?>"
         data-product-single-action-counter
    >

        <h3 class="countdown-product__title"><?php esc_html_e('On sale ', 'saleszone'); ?></h3>
        <div class="countdown-product__time">

            <div class="countdown-product__time-row">
                <span class="countdown-product__item countdown-product__item--no-marker"
                      data-countdown-item="days">
                  <?php echo esc_html($date['dd']); ?>
                </span>
                <span class="countdown-product__item countdown-product__item--small">
                  <?php
                  $days = intval($date['dd']);
                  echo esc_html(_n( 'day', 'days', $days , 'saleszone' )); ?>
                </span>
            </div>
            <div class="countdown-product__time-row">
                <span class="countdown-product__item"
                      data-countdown-item="hours">
                    <?php echo esc_html($date['hh']); ?>
                </span>
                <span class="countdown-product__item"
                      data-countdown-item="minutes">
                    <?php echo esc_html($date['mm']); ?>
                </span>
                <span class="countdown-product__item"
                      data-countdown-item="seconds">
                    <?php echo esc_html($date['ss']); ?>
                </span>
            </div>
        </div>
    </div>
    <!-- /.countdown-product -->
<?php endif; ?>