<?php
if (!defined('ABSPATH')) {
    exit;
}

if(saleszone_option('catalog-mode')){
    return;
}

?>
<?php if(saleszone_option('header_layout') == 'layout_5') :?>
    <li class="pc-header-layout-5__toolbar-item"  data-cart-header-fragment>
        <div class="pc-header-layout-5__toolbar-icon pc-header-layout-5__toolbar-icon--cart">
            <?php saleszone_the_svg('cart-thin'); ?>
            <?php if(WC()->cart->get_cart_contents_count() > 0) :?>
                <div class="pc-header-layout-5__toolbar-counter">
                    <?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>
                </div>
            <?php endif; ?>
        </div>
        <a class="pc-header-layout-5__toolbar-link <?php echo WC()->cart->is_empty() ? 'pc-header-layout-5__toolbar-link--empty':''?>" href="<?php echo esc_url(wc_get_cart_url()); ?>" rel="nofollow"
            <?php if (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes' && !is_cart()): ?>
                data-cart-modal
            <?php endif; ?>
        >
            <?php esc_html_e('Cart', 'saleszone'); ?>
        </a>
    </li>
<?php elseif(saleszone_option('header_layout') == 'layout_3') :?>
    <div class="pc-header-layout-3__navbar-item-fragment"  data-cart-header-fragment>
        <div class="pc-header-layout-3__toolbar-icon pc-header-layout-3__toolbar-icon--cart">
            <?php saleszone_the_svg('cart-thin'); ?>
            <?php if(WC()->cart->get_cart_contents_count() > 0) :?>
                <div class="pc-header-layout-3__toolbar-counter">
                    <?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>
                </div>
            <?php endif; ?>
        </div>
        <a class="pc-header-layout-3__toolbar-link <?php echo WC()->cart->is_empty() ? 'pc-header-layout-3__toolbar-link--empty':''?>" href="<?php echo esc_url(wc_get_cart_url()); ?>" rel="nofollow"
            <?php if (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes' && !is_cart()): ?>
                data-cart-modal
            <?php endif; ?>
        >
            <?php esc_html_e('Cart', 'saleszone'); ?>
        </a>
    </div>
<?php elseif(saleszone_option('header_layout') == 'layout_4') :?>
    <div class="cart-button" data-cart-header-fragment>

        <a class="cart-button__btn <?php if (WC()->cart->is_empty()): ?>cart-button__btn--disabled<?php endif; ?>"
           href="<?php echo esc_url(wc_get_cart_url()); ?>"
          <?php if (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes' && !is_cart()): ?>
              data-cart-modal
          <?php endif; ?>
           rel="nofollow">

            <span class="cart-button__btn-cell">
                <i class="cart-button__icon">
                    <?php saleszone_the_svg('cart-bag'); ?>

                    <!-- Single Icon Cart with badge on mobile devices  -->
                    <?php if (!WC()->cart->is_empty()): ?>
                        <span class="cart-button__badge">
                            <?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>
                        </span>
                    <?php endif;?>
                </i>
            </span>

            <span class="cart-button__btn-cell cart-button__btn-cell--hidden">
                            <!-- Cart name If empty -->
                <?php if (WC()->cart->is_empty()): ?>
                    <?php esc_html_e('Cart', 'saleszone'); ?>
                <?php else: ?>

                <!-- Cart with price and name on desktop -->
                <span class="cart-button__desc">
                    <?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>
                        - <?php echo wp_kses(WC()->cart->get_cart_subtotal(), saleszone_get_allowed_html('price')); ?>
                </span>
                <?php endif; ?>
            </span>
        </a>
    </div>
<?php else: ?>
    <div class="cart-header" data-cart-header-fragment>

        <!-- Single Icon Cart on mobile devices -->
        <div class="cart-header__aside">
            <a class="cart-header__ico<?php if (WC()->cart->is_empty()): ?> cart-header__ico--empty <?php endif; ?>"
               href="<?php echo esc_url(wc_get_cart_url()); ?>"
                <?php if (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes' && !is_cart()): ?>
                    data-cart-modal
                <?php endif; ?>
               rel="nofollow"
            >
                <?php saleszone_the_svg('cart'); ?>
                <span class="cart-header__badge hidden-lg">
                    <?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>
                </span>
            </a>
        </div>

        <!-- Cart with price and name on desktop -->
        <div class="cart-header__inner visible-lg">
            <div class="cart-header__title">
                <a class="cart-header__link <?php if (WC()->cart->is_empty()): ?> cart-header__link--empty <?php endif; ?>"
                   href="<?php echo esc_url(wc_get_cart_url()); ?>"
                    <?php if (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes' && !is_cart()): ?>
                        data-cart-modal
                    <?php endif; ?>
                   rel="nofollow"
                >
                    <?php esc_html_e('Cart', 'saleszone'); ?>
                </a>
            </div>
            <div class="cart-header__desc">
                <?php if (!WC()->cart->is_empty()): ?>
                    <span class="cart-header__count">
                        <?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>
                    </span>
                    <span class="cart-header__separator">
                     -
                    </span>
                    <span class="cart-header__subtotal">
                        <?php echo wp_kses(WC()->cart->get_cart_subtotal(), saleszone_get_allowed_html('price')); ?>
                    </span>
                <?php else: ?>
                    <?php esc_html_e('Empty', 'saleszone'); ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
<?php endif; ?>