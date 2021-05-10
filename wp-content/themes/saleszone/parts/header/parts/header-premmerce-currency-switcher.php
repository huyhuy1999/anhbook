<?php

if(!function_exists('premmerce_multicurrency')){
    return false;
}

$currencies = premmerce_multicurrency()->getCurrencies();
$userCurrencyId = premmerce_multicurrency()->getUsersCurrencyId();
$activeCurrencies = array_filter($currencies, 'saleszone_filter_active_currecies');

?>
<?php if(count($activeCurrencies) > 1) :?>
    <?php if(saleszone_option('header_layout') == 'layout_3') :?>
        <div class="list-nav__item" data-premmerce-currency-switcher-fragment>
            <?php foreach($currencies as $currency): ?>
                <?php if($currency['id'] == $userCurrencyId) :?>
                    <div class="list-nav__link">
                        <span class="list-nav__text-el">
                            <?php echo apply_filters('premmerce_currency_symbol_format', $currency['code'] . ', ' . $currency['symbol'],  $currency ); ?>
                        </span>
                        <i class="list-nav__arrow list-nav__arrow--down">
                            <?php saleszone_the_svg('arrow-down'); ?>
                        </i>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="list-nav__drop list-nav__drop--rtl">
                <ul class="overlay">
                    <?php foreach($currencies as $currency): ?>
                        <?php if($currency['id'] != $userCurrencyId && $currency['display_on_front']) :?>
                            <li class="overlay__item">
                                <a class="overlay__link"
                                   rel="nofollow"
                                   href="#"
                                   data-currency-id="<?php echo esc_attr($currency['id']); ?>"
                                   data-premmerce-change-currency
                                >
                                    <?php echo apply_filters('premmerce_currency_symbol_format', $currency['code'] . ', ' . $currency['symbol'],  $currency ); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php else: ?>
        <div class="user-panel__item" data-premmerce-currency-switcher-fragment>

            <?php foreach($currencies as $currency): ?>
                <?php if($currency['id'] == $userCurrencyId) :?>
                    <div class="user-panel__link">
                        <span class="user-panel__text-el">
                            <?php echo apply_filters('premmerce_currency_symbol_format', $currency['code'] . ', ' . $currency['symbol'],  $currency ); ?>
                        </span>
                        <i class="user-panel__arrow user-panel__arrow--down">
                            <?php saleszone_the_svg('arrow-down'); ?>
                        </i>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="user-panel__drop user-panel__drop--rtl">
                <ul class="overlay">
                    <?php foreach($currencies as $currency): ?>
                        <?php if($currency['id'] != $userCurrencyId && $currency['display_on_front']) :?>
                            <li class="overlay__item">
                                <a class="overlay__link"
                                   rel="nofollow"
                                   href="#"
                                   data-currency-id="<?php echo esc_attr($currency['id']); ?>"
                                   data-premmerce-change-currency
                                >
                                    <?php echo apply_filters('premmerce_currency_symbol_format', $currency['code'] . ', ' . $currency['symbol'],  $currency ); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>