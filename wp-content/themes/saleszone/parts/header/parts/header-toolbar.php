<div class="user-panel">

    <!-- Wishlist -->
    <?php if(function_exists('premmerce_wishlist')) :?>
    <div class="user-panel__item" data-ajax-inject="wishlist-total">
        <?php get_template_part('premmerce-woocommerce-wishlist/wishlist', 'total'); ?>
    </div>
    <?php endif; ?>

    <!-- Comparison -->
    <?php if(function_exists('premmerce_comparison')) :?>
        <div class="user-panel__item">
            <?php get_template_part('premmerce-product-comparison/comparison', 'total'); ?>
        </div>
    <?php endif; ?>

    <!-- Woocommerce user profile and auth menu -->
    <?php if(saleszone_is_woocommerce_activated()){get_template_part('parts/header/parts/header', 'profile');} ?>

    <!-- Site languages Polylang -->
    <?php if (function_exists('pll_the_languages')){
        get_template_part('parts/header/parts/header', 'language-switch-polylang');
    } elseif(function_exists('icl_get_languages')) {
        get_template_part('parts/header/parts/header', 'language-switch-wpml');
    } ?>

    <!-- Premmerce currency switcher -->
    <?php get_template_part('parts/header/parts/header', 'premmerce-currency-switcher'); ?>

    <!-- Woocommerce currency switcher -->
    <?php get_template_part('parts/header/parts/header', 'woocommerce-currency-switcher'); ?>

    <!-- WPML Site currencies -->
    <?php do_action('wcml_currency_switcher', array('format' => apply_filters('saleszone_wpml_currency_format','%code%, %symbol%'),'switcher_style' => 'saleszone-toolbar-currency-switcher')); ?>

</div>