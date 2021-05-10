<?php if (array_filter(array_map('wc_get_product', WC()->cart->get_cross_sells()), 'wc_products_array_filter_visible')): ?>
    <div class="content__row" data-cart-cross-sells>
        <div class="frame" data-slider="cross-sells">
            <div class="frame__header">
                <h2 class="frame__title">
                    <?php esc_html_e('You may be interested in&hellip;', 'saleszone'); ?>
                </h2>
                <div class="frame__arrows">
                    <button class="frame__arrow" type="button" data-slider-arrow-left>
                        <?php saleszone_the_svg('angle-left'); ?>
                    </button>
                    <button class="frame__arrow" type="button" data-slider-arrow-right>
                        <?php saleszone_the_svg('angle-right'); ?>
                    </button>
                </div>
            </div>
            <div class="frame__inner">
                <?php woocommerce_cross_sell_display(10); ?>
            </div>
        </div>
    </div>
<?php endif; ?>