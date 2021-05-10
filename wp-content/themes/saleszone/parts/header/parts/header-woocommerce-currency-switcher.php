<?php

global $WOOCS;

if(!$WOOCS){
    return;
}

$currencies = $WOOCS->get_currencies();
?>
<?php if(saleszone_option('header_layout') == 'layout_3') :?>
    <div class="list-nav__item" data-fragment-currency-switcher>
        <?php foreach ($currencies as $currencie) :?>
            <?php if($WOOCS->current_currency == $currencie['name']) :?>
                <div class="list-nav__link">
                    <span class="list-nav__text-el">
                        <?php echo esc_html($currencie['name']); ?>, <?php echo esc_html($currencie['symbol']); ?>
                    </span>
                    <i class="list-nav__arrow list-nav__arrow--down">
                        <?php saleszone_the_svg('arrow-down'); ?>
                    </i>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="list-nav__drop">
            <ul class="overlay">
                <?php foreach ($currencies as $currencie) :?>
                    <li class="overlay__item">
                        <a class="overlay__link" rel="nofollow" data-woo-currency="<?php echo esc_attr($currencie['name']); ?>"
                           onclick="window.location.href = location.protocol + '//' + location.host + location.pathname + '?currency=' + jQuery(this).attr('data-woo-currency');">
                            <?php echo esc_html($currencie['name']); ?>, <?php echo esc_html($currencie['symbol']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php else: ?>
    <div class="user-panel__item" data-fragment-currency-switcher>
        <?php foreach ($currencies as $currencie) :?>
            <?php if($WOOCS->current_currency == $currencie['name']) :?>
                <div class="user-panel__link">
                    <span class="user-panel__text-el">
                        <?php echo esc_html($currencie['name']); ?>, <?php echo esc_html($currencie['symbol']); ?>
                    </span>
                    <i class="user-panel__arrow user-panel__arrow--down">
                        <?php saleszone_the_svg('arrow-down'); ?>
                    </i>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="user-panel__drop user-panel__drop--rtl">
            <ul class="overlay">
                <?php foreach ($currencies as $currencie) :?>
                    <li class="overlay__item">
                        <a class="overlay__link" rel="nofollow" data-woo-currency="<?php echo esc_attr($currencie['name']); ?>" onclick="window.location.href = location.protocol + '//' + location.host + location.pathname + '?currency=' + jQuery(this).attr('data-woo-currency');">
                            <?php echo esc_html($currencie['name']); ?>, <?php echo esc_html($currencie['symbol']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>