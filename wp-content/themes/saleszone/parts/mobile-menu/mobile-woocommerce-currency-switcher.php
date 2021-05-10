<?php

global $WOOCS;

if (!$WOOCS) {
    return;
}

$currencies = $WOOCS->get_currencies();
?>

    <li class="mobile-nav__item mobile-nav__item--separator">
        <?php esc_html_e('Currency', 'saleszone'); ?>
    </li>

<?php foreach ($currencies as $currencie) : ?>
    <li class="mobile-nav__item">
        <a class="mobile-nav__link" rel="nofollow" data-woo-currency="<?php echo esc_attr($currencie['name']); ?>"
           onclick="window.location.href = location.protocol + '//' + location.host + location.pathname + '?currency=' + jQuery(this).attr('data-woo-currency');">
            <?php echo esc_html($currencie['name']); ?>, <?php echo esc_html($currencie['symbol']); ?>
        </a>
    </li>
<?php endforeach; ?>