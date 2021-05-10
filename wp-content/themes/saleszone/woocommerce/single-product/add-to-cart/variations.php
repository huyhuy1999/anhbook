<?php
if (!defined('ABSPATH')) {
    exit;
}
global $product;

?>

<?php do_action('woocommerce_before_variations_form'); ?>

    <?php
    /**
     *  Check if module active
     *  premmerce-woocommerce-variation-swatches
     */
    if(function_exists('premmerce_get_variation_active_class')) :?>
        <?php
            $attribute_keys = array_keys( $attributes );
            do_action('premmerce_render_advanced_variation', apply_filters( 'wc_product_variable_attributes', $attributes, $attribute_keys ), $product->get_default_attributes(), $product, $attribute_keys, false)
        ?>
        <?php else: ?>
        <div class="pc-product-purchase__variations variations">
            <?php foreach ($attributes as $attribute_name => $options) : ?>
                <div class="pc-product-purchase__variation-item variants-select variants-select--<?php echo esc_attr(sanitize_title($attribute_name)); ?>">
                    <div class="variants-select__label label">
                        <label for="<?php echo esc_attr(sanitize_title($attribute_name)); ?>">
                            <?php echo wp_kses_post(saleszone_wc_attribute_label($attribute_name)); ?>
                        </label>
                    </div>
                    <div class="variants-select__field value">
                        <?php
                        $selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)]) ? wc_clean(stripslashes(urldecode($_REQUEST['attribute_' . sanitize_title($attribute_name)]))) : $product->get_variation_default_attribute($attribute_name);
                        wc_dropdown_variation_attribute_options(array(
                            'options' => $options,
                            'attribute' => $attribute_name,
                            'product' => $product,
                            'selected' => $selected,
                            'attributes' => array(
                                'form' => 'add-to-cart-form-' . $product->get_id()
                            )
                        ));
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<?php do_action('woocommerce_after_variations_form'); ?>

<?php do_action('woocommerce_before_single_variation'); ?>
<?php if (has_action('woocommerce_single_variation')): ?>
    <div class="pc-product-purchase__variation-info">
        <?php
        /**
         * @hooked woocommerce_single_variation - 10 Empty div for variation data
         * @hooked saleszone_render_variation_info - 10
         */
        do_action('woocommerce_single_variation');
        ?>
    </div>
<?php endif; ?>
<?php do_action('woocommerce_after_single_variation'); ?>