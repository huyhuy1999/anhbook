<?php
if (!defined('ABSPATH')) {
    exit;
}

global $product;

if($product->get_type() == 'variable'){
    $available_variations = $product->get_available_variations();
    $variations_json = wp_json_encode( $available_variations );
    $variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
}

?>

<div class="pc-product-purchase">

    <?php if (has_action('woocommerce_before_add_to_cart_form')): ?>
        <div class="pc-product-purchase__header">
            <?php do_action('woocommerce_before_add_to_cart_form'); ?>
        </div>
    <?php endif; ?>

    <div class="pc-product-purchase__body js-add-to-cart-form cart <?php if ($product->get_type() == 'variable'): ?>variations_form<?php endif; ?>"
         data-product_id="<?php echo absint($product->get_id()); ?>"
         <?php if(!empty($available_variations)): ?>
            data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>"
         <?php endif; ?>
    >

        <?php if ($product->get_type() == 'grouped' && isset($grouped_products)) {
            wc_get_template('single-product/add-to-cart/grouped-products.php', array(
                'grouped_products' => $grouped_products
            ));
        } ?>

        <?php if ($product->get_type() == 'variable' && isset($attributes)) {
            wc_get_template('single-product/add-to-cart/variations.php', array(
                'attributes' => $attributes,
                'available_variations' => $available_variations
            ));
        } ?>

        <?php if (has_action('woocommerce_before_add_to_cart_button')): ?>
            <div class="pc-product-purchase__before-add-to-cart">
                <?php do_action('woocommerce_before_add_to_cart_button'); ?>
            </div>
        <?php endif; ?>

        <?php if (has_action('premmerce_add_to_cart_button')): ?>
            <div class="pc-product-purchase__add-to-cart">
                <?php
                /**
                 * @hooked woocommerce_template_single_price - 5
                 * @hooked woocommerce_single_variation_add_to_cart_button - 10
                 */
                do_action('premmerce_add_to_cart_button');
                ?>
            </div>
        <?php endif; ?>

        <div class="pc-product-purchase__second_after-add-to-cart" data-single-after-add-to-cart>
            <?php
            /**
             * @hooked saleszone_render_product_single_action_counter - 10
             */
            do_action('premmerce_after_add_to_cart_button');
            ?>
        </div>

        <?php if (has_action('woocommerce_after_add_to_cart_button')): ?>
            <div class="pc-product-purchase__after-add-to-cart">
                <?php
                /**
                 * @hooked saleszone_render_stock - 5
                 * @hooked saleszone_render_wishlist_product_button - 10
                 */
                do_action('woocommerce_after_add_to_cart_button');
                ?>
            </div>
        <?php endif; ?>

    </div><!-- /.pc-product-purchase__body -->

    <?php if (has_action('woocommerce_after_add_to_cart_form')): ?>
        <div class="pc-product-purchase__footer">
            <?php do_action('woocommerce_after_add_to_cart_form'); ?>
        </div>
    <?php endif; ?>
</div>