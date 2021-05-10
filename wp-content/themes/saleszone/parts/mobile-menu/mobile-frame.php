<nav class="mobile-nav" data-mobile-nav>
    <ul class="mobile-nav__list" data-mobile-nav-list>
        <?php if (has_nav_menu('mobile_nav')): ?>
            <li class="mobile-nav__item mobile-nav__item--separator">
                <?php esc_html_e('Shop', 'saleszone'); ?>
            </li>
            <?php wp_nav_menu(array(
                "theme_location" => "mobile_nav",
                "container" => false,
                "items_wrap" => '%3$s',
                "walker" => new WalkerMobileStatic(),
            )); ?>
        <?php endif; ?>

        <?php if (has_nav_menu('mobile_nav_info')): ?>
            <li class="mobile-nav__item mobile-nav__item--separator">
                <?php esc_html_e('Info', 'saleszone'); ?>
            </li>
            <?php wp_nav_menu(array(
                "theme_location" => "mobile_nav_info",
                "container" => false,
                "items_wrap" => '%3$s',
                "walker" => new WalkerMobileStatic(),
            )); ?>
        <?php endif; ?>

        <?php if(saleszone_is_woocommerce_activated()) :?>
            <li class="mobile-nav__item mobile-nav__item--separator">
                <?php esc_html_e('Profile', 'saleszone'); ?>
            </li>
            <?php get_template_part('parts/mobile-menu/mobile', 'profile'); ?>
        <?php endif; ?>

        <!-- Site languages Polylang -->
        <?php if (function_exists('pll_the_languages')) {
            get_template_part('parts/mobile-menu/mobile', 'language-switch-polylang');
        } elseif (function_exists('icl_get_languages')) {
            get_template_part('parts/mobile-menu/mobile', 'language-switch-wpml');
        } ?>

        <?php if(function_exists('premmerce_multicurrency')){
            ?><!-- Premmerce currencies  --><?php
            get_template_part('parts/mobile-menu/mobile', 'premmerce-currency-switcher');
        } ?>

        <!-- WPML Site currencies -->
        <?php if (has_action('wcml_currency_switcher')) : ?>
            <li class="mobile-nav__item mobile-nav__item--separator">
                <?php esc_html_e('Currency', 'saleszone'); ?>
            </li>
            <?php do_action('wcml_currency_switcher', array('format' => apply_filters('saleszone_wpml_currency_format', '%code%, %symbol%'), 'switcher_style' => 'saleszone-mobile-currency-switcher')); ?>
        <?php endif; ?>

        <!-- Woocommerce currency switcher -->
        <?php get_template_part('parts/mobile-menu/mobile', 'woocommerce-currency-switcher'); ?>
    </ul>
</nav>