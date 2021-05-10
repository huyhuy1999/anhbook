<?php

if(!function_exists('premmerce_multicurrency')){
    return false;
}

$currencies = premmerce_multicurrency()->getCurrencies();
$userCurrencyId = premmerce_multicurrency()->getUsersCurrencyId();
$activeCurrencies = array_filter($currencies, 'saleszone_filter_active_currecies');

?>
<?php if(count($activeCurrencies) > 1) :?>
    <?php $cnt = 0; ?>
    <?php foreach($currencies as $currency): ?>
        <?php if($currency['display_on_front']) :?>
            <?php if($cnt == 0): ?>
            <li class="mobile-nav__item mobile-nav__item--separator">
                <?php esc_html_e('Currency', 'saleszone'); ?>
            </li>
            <?php endif; ?>
            <li class="mobile-nav__item">
                <a class="mobile-nav__link"
                   rel="nofollow"
                   data-currency-id="<?php echo esc_attr($currency['id']); ?>"
                   data-premmerce-change-currency
                >
                    <?php echo apply_filters('premmerce_currency_symbol_format', $currency['code'] . ', ' . $currency['symbol'],  $currency ); ?>
                </a>
            </li>
            <?php $cnt++; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>