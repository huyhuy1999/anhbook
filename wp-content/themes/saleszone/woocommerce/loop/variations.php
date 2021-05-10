<?php

if (!defined('ABSPATH')) {
    exit;
}

global $product;

if($product->get_type() == 'variable'){
    $product_available_variations = $product->get_available_variations();
}
if ($product->get_type() != 'variable' || empty($product_available_variations) || !saleszone_option('category-product-variations')) {
    return;
}

?>

<?php
/**
 *  Check if module active
 *  premmerce-woocommerce-variation-swatches
 */
if(function_exists('premmerce_get_variation_active_class')) :?>
    <?php
    $attributes = $product->get_variation_attributes();
    $attribute_keys = array_keys( $attributes );
    do_action('premmerce_render_advanced_variation', apply_filters( 'wc_product_variable_attributes', $attributes, $attribute_keys ), $product->get_default_attributes(), $product, $attribute_keys, true);
    ?>
<?php else: ?>
    <?php foreach ($product->get_variation_attributes() as $attribute_name => $options) : ?>
        <?php $id_attribute = 'data-'.esc_attr(sanitize_title($attribute_name)).'-'.esc_attr($product->get_ID()); ?>
        <div class="variants-select variants-select--loop variants-select--<?php echo esc_attr(sanitize_title(wp_unslash($attribute_name))); ?>">
            <div class="variants-select__label label">
                <label for="<?php echo esc_attr($id_attribute); ?>">
                    <?php echo esc_html(saleszone_wc_attribute_label($attribute_name)); ?>
                </label>
            </div>
            <div class="variants-select__field value variations">
                <?php
                $selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)]) ? wc_clean(stripslashes(urldecode($_REQUEST['attribute_' . sanitize_title($attribute_name)]))) : $product->get_variation_default_attribute($attribute_name);
                wc_dropdown_variation_attribute_options(array(
                    'options' => $options,
                    'attribute' => $attribute_name,
                    'product' => $product,
                    'selected' => $selected,
                    'id' => $id_attribute,
                    'attributes' => array('data-loop-variation' => '')
                ));
                ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>