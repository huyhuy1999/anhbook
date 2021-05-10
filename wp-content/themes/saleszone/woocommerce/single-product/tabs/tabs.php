<?php
/**
 * Single Product tabs
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters('woocommerce_product_tabs', array());

if (empty($tabs)) {
    return;
}
?>
<?php if(saleszone_option('product-tabs-type') == 'no-tabs'): ?>
    <div class="product-fullinfo woocommerce-tabs">
        <?php foreach ($tabs as $key => $tab) : ?>
            <div class="product-fullinfo__item">
                <div class="product-fullinfo__header">
                    <div class="product-fullinfo__title">
                        <?php echo esc_html(apply_filters('woocommerce_product_' . $key . '_tab_title', $tab['title'], $key)); ?>
                    </div>
                </div>
                <div class="product-fullinfo__inner">
                    <?php call_user_func($tab['callback'], $key, $tab); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php elseif (saleszone_option('product-tabs-type') == 'tabs'): ?>
    <ul class="accordion-tabs woocommerce-tabs" data-accordion-tabs>
        <?php foreach ($tabs as $key => $tab) : ?>
            <li class="accordion-tabs__item js-init-active" data-accordion-tabs-item>

                <a href="#product-<?php echo esc_attr($key); ?>" class="accordion-tabs__link" data-accordion-tabs-link id="product-<?php echo esc_attr($key); ?>" >
                    <span class="accordion-tabs__link-title">
                        <?php echo esc_html(apply_filters('woocommerce_product_' . $key . '_tab_title', $tab['title'], $key)); ?>
                    </span>
                    <span class="accordion-tabs__link-arrow hidden-sm hidden-md hidden-lg">
                        <?php saleszone_the_svg('angle-right'); ?>
                    </span>
                </a>

                <div class="accordion-tabs__content" data-accordion-tabs-content>
                    <?php call_user_func($tab['callback'], $key, $tab); ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
