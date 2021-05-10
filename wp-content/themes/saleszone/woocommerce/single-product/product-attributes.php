<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>

<div class="attributes-table shop_attributes">

    <?php if ($display_dimensions && $product->has_weight()) : ?>
        <div class="attributes-table__item">
            <div class="attributes-table__header">
                <div class="attributes-table__wrapper">
                    <div class="attributes-table__title">
                        <?php esc_html_e('Weight', 'saleszone') ?>
                    </div>
                </div>
            </div>
            <div class="attributes-table__value product_weight">
                <?php echo wp_kses_post(wc_format_weight($product->get_weight())); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($display_dimensions && $product->has_dimensions()) : ?>
        <div class="attributes-table__item">
            <div class="attributes-table__header">
                <div class="attributes-table__wrapper">
                    <div class="attributes-table__title">
                        <?php esc_html_e('Dimensions', 'saleszone') ?>
                    </div>
                </div>
            </div>
            <div class="attributes-table__value product_dimensions">
                <?php echo wp_kses_post(wc_format_dimensions($product->get_dimensions(false))); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php foreach ($attributes as $attribute) : ?>
        <div class="attributes-table__item">
            <div class="attributes-table__header">
                <div class="attributes-table__wrapper">
                    <div class="attributes-table__title">
                        <?php echo wp_kses_post(saleszone_wc_attribute_label($attribute->get_name())); ?>
                    </div>
                </div>
            </div>
            <div class="attributes-table__value">
                <?php echo wp_kses_post(saleszone_get_attribute_terms($attribute)); ?>
            </div>
        </div>
    <?php endforeach; ?>

</div>