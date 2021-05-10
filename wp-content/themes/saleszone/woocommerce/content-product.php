<?php
/**
 * The template for displaying product content within loops
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}

// Load variation script for product quick view and for catalog load more button
wp_enqueue_script( 'wc-add-to-cart-variation' );

$variation = saleszone_get_variation($product);

?>
<div <?php wc_product_class('product-cut grid-item', $product); ?>
        data-product="<?php echo esc_attr($product->get_ID()); ?>"
        data-product-variation="<?php echo esc_attr($variation->get_ID()); ?>"
>
    <form class="product-cut__main-info js-add-to-cart-form cart <?php echo $product->get_type() == 'variable' ? 'variations_form':''; ?>"
          method="post"
          enctype="multipart/form-data"
          data-loop-add-to-cart-form
          data-product_id="<?php echo esc_attr(absint($product->get_id())); ?>"
          <?php if($product->get_type() == 'variable') :?>
                <?php if(saleszone_option('category-product-ajax-change-variation')): ?>
                  data-product_variations="false"
                <?php else:
                  $available_variations = $product->get_available_variations();
                  $variations_json = wp_json_encode( $available_variations );
                  $variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
                  ?>
                  data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>"
                <?php endif; ?>
          <?php endif; ?>>

        <?php if (has_action('premmerce_loop_product_cut_before') || has_action('woocommerce_before_shop_loop_item')): ?>
            <div class="product-cut__before">
                <?php
                do_action('premmerce_loop_product_cut_before');
                do_action('woocommerce_before_shop_loop_item');
                ?>
            </div>
        <?php endif; ?>

	    <?php if (has_action('premmerce_loop_product_cut_before_title_right')): ?>
            <div class="product-cut__before-title-right">
			    <?php
			    /**
			     * @hooked saleszone_quick_view_button - 20
			     */
			    do_action('premmerce_loop_product_cut_before_title_right');
			    ?>
            </div>
	    <?php endif; ?>

        <?php if (has_action('premmerce_loop_product_cut_before_title') || has_action('woocommerce_before_shop_loop_item_title')): ?>
            <div class="product-cut__before-title" data-loop-before-title>
                <?php
                /**
                 * @hooked saleszone_render_loop_product_image - 10
                 * @hooked saleszone_render_product_labels - 10
                 * @hooked woocommerce_template_loop_rating - 20
                 */
                do_action('premmerce_loop_product_cut_before_title', array('variation' => $variation));
                do_action('woocommerce_before_shop_loop_item_title');
                ?>
            </div>
        <?php endif; ?>

        <?php if (has_action('premmerce_loop_product_cut_title') || has_action('woocommerce_shop_loop_item_title')): ?>
            <div class="product-cut__title">
                <?php
                /**
                 * @hooked woocommerce_template_loop_product_title - 10
                 */
                do_action('premmerce_loop_product_cut_title', array('variation' => $variation));
                do_action('woocommerce_shop_loop_item_title');
                ?>
            </div>
        <?php endif; ?>

        <?php if (has_action('premmerce_loop_product_cut_after_title') || has_action('woocommerce_after_shop_loop_item_title')): ?>
            <div class="product-cut__after-title">
                <?php
                /**
                 * @hooked woocommerce_template_loop_price - 10
                 * @hooked saleszone_render_wishlist_move_button - 10
                 */
                do_action('premmerce_loop_product_cut_after_title', array('variation' => $variation));
                do_action('woocommerce_after_shop_loop_item_title');
                ?>
            </div>
        <?php endif; ?>

        <?php if (has_action('premmerce_loop_product_cut_after') || has_action('woocommerce_after_shop_loop_item')): ?>
            <div class="product-cut__extra-info">
                <?php
                /**
                 * @hooked saleszone_render_loop_variations - 10
                 * @hooked woocommerce_template_loop_add_to_cart - 20
                 * @hooked saleszone_render_product_actions - 25
                 * @hooked woocommerce_template_single_excerpt - 30
                 * @hooked saleszone_render_main_attributes - 40
                 */
                do_action('premmerce_loop_product_cut_after', array('variation' => $variation, 'show_quantity' => true));
                do_action('woocommerce_after_shop_loop_item');
                ?>
                <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>"/>
                <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>"/>
                <input type="hidden" name="variation_id" class="variation_id"
                       value="<?php echo (int)saleszone_get_default_variation_id($product); ?>"/>
                <div class="single_variation hidden"></div>
            </div>
        <?php endif; ?>

    </form>
</div>
