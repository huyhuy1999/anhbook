<div class="pc-header-layout-1">

    <!-- Headline -->
    <div class="pc-header-layout-1__headline">
        <div class="page__container">
            <div class="pc-header-layout-1__headline-body">
                <div class="pc-header-layout-1__headline-left">
                    <?php if (has_nav_menu('header_nav')) {
                        wp_nav_menu(array(
                            'theme_location' => 'header_nav',
                            'walker' => new WalkerHeaderStatic(),
                            'container' => 'nav',
                            'container_class' => 'list-nav',
                            'menu_class' => 'list-nav__items'
                        ));
                    } ?>
                </div>
                <div class="pc-header-layout-1__headline-right">
                    <?php get_template_part('parts/header/parts/header', 'toolbar') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="pc-header-layout-1__main">
        <div class="page__container">
            <div class="pc-header-layout-1__main-body">

                <!-- Hamburger menu -->
                <div class="pc-header-layout-1__hamburger">
                    <button class="btn-mobile-icon" data-page-mobile-btn>
                        <?php saleszone_the_svg('hamburger'); ?>
                    </button>
                    <button class="btn-mobile-icon hidden" data-page-mobile-btn>
                        <?php saleszone_the_svg('close-bold'); ?>
                    </button>
                </div>

                <!-- Logo -->
                <div class="pc-header-layout-1__logo">
                    <?php saleszone_site_logo(); ?>
                </div>

                <!-- Search -->
                <div class="pc-header-layout-1__search">
                    <?php
                    /**
                     * @hooked saleszone_render_header_search - 10
                     */
                    do_action('premmerce_header_search');
                    ?>
                </div>

                <!-- Phones and call-back -->
                <?php if(strip_tags(saleszone_option('header-phone')) != '') :?>
                <div class="pc-header-layout-1__phones">
                    <?php saleszone_render_header_phone(); ?>
                </div>
                <?php endif; ?>
                <!-- Cart -->
                <div class="pc-header-layout-1__cart">
                    <div class="pull-right">
                        <?php
                            if(saleszone_is_woocommerce_activated()){
                                wc_get_template('cart/cart-header.php');
                            }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="pc-header-layout-1__navigation">
        <div class="page__container">
            <?php if (has_nav_menu('main_catalog_nav')) {
                saleszone_render_main_menu();
            } ?>
        </div>
    </div>
</div>