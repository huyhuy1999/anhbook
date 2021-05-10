<?php
/**
 * Single variation cart button
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;
$in_cart = saleszone_in_cart($product->get_ID());
$ajax_class = (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes') ? 'ajax_add_to_cart' : '';
$is_available = ($product->get_type() == 'variable') ? $product->get_available_variations() : $product->is_purchasable() && $product->is_in_stock() == true;

if(saleszone_option('catalog-mode')){
    return;
}

?>

<div class="pc-add-to-cart <?php if ($product->get_type() == 'variation'): ?>woocommerce-variation-add-to-cart variations_button<?php endif; ?>">

    <?php if ($product->get_type() == 'external'): ?>
    <form class="cart" action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" method="get">
        <button type="submit" class="single_add_to_cart_button button alt">
            <?php echo esc_html($product->single_add_to_cart_text()); ?>
        </button>
        <?php wc_query_string_form_fields() ?>
    </form>
    <?php elseif ($product->get_type() == 'grouped'): ?>
        <div class="pc-add-to-cart__button">
            <form id="add-to-cart-form-<?php echo esc_attr($product->get_id()); ?>" method="post" enctype="multipart/form-data">
                <button class="single_add_to_cart_button button alt">
                    <?php echo esc_html($product->single_add_to_cart_text()); ?>
                </button>
                <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"/>
            </form>
        </div>
    <?php else: ?>

        <?php if ($is_available): ?>

            <!-- Quantity -->
            <?php do_action('woocommerce_before_add_to_cart_quantity'); ?>

            <div class="pc-add-to-cart__quantity single_variation_wrap <?php echo $in_cart ? 'hidden' : ''; ?>"
                 data-in-cart-state="hidden"
            >
                <?php woocommerce_quantity_input(array(
                    'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                    'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                    'input_value' => isset($_POST['quantity']) ? wc_stock_amount(intval(wp_unslash($_POST['quantity']))) : $product->get_min_purchase_quantity(),
                    'input_type' => apply_filters('premmerce_quantity_input_type', 'number'),
                    'params' => array(
                        'data-quantity-field' => '',
                        'data-quantity-step' => 1,
                        'form' => 'add-to-cart-form-' . $product->get_id()
                    ),
                    'modifier' => 'quantity--single-product'
                )); ?>
            </div>

            <?php do_action('woocommerce_after_add_to_cart_quantity'); ?>

            <!-- Add to cart button -->
            <div class="pc-add-to-cart__button">
                <form id="add-to-cart-form-<?php echo esc_attr($product->get_id()); ?>"
                      method="post"
                      enctype="multipart/form-data">
                    <button class="single_add_to_cart_button button alt add_to_cart_button <?php echo esc_attr($ajax_class); ?> <?php echo $in_cart ? 'hidden' : ''; ?>"
                            data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                            form="add-to-cart-form-<?php echo esc_attr($product->get_id()); ?>"
                            data-in-cart-state="hidden"
                    >
                        <?php if(saleszone_option('product-btn-add-to-cart-icon')){
                            saleszone_the_svg(saleszone_option('add-to-cart-icon'),'pc-add-to-cart__button-icon-cart');
                        } ?>

                        <?php echo esc_html($product->single_add_to_cart_text()); ?>
                        <i class="button--loader hidden"><?php saleszone_the_svg('refresh'); ?></i>
                    </button>
                    <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>"/>
                    <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>"/>

                    <?php if($product->get_type() === 'variable') :?>
                        <input type="hidden" name="variation_id" class="variation_id" value="0"/>
                    <?php endif; ?>

                    <a class="added_to_cart wc-forward ajax_add_to_cart <?php echo $in_cart ? '' : 'hidden'; ?>"
                       href="<?php echo esc_url(wc_get_cart_url()); ?>"
                        <?php if (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes'): ?>
                            data-cart-modal
                        <?php endif; ?>
                       data-in-cart-state="visible"
                    >
                        <?php esc_html_e('View in Cart', 'saleszone'); ?>
                    </a>
                </form>
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>