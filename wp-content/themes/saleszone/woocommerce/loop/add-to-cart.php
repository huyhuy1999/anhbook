<?php
/**
 * Loop Add to Cart
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;
$variation = isset($args['variation']) ? $args['variation'] : $product;
$ajax_class = saleszone_get_default_variation_id($product) ? 'ajax_add_to_cart' : '';
$in_cart = saleszone_in_cart($variation->get_ID());

if ($product->get_type() == 'variable') {
    $is_available = $product->get_available_variations();
} elseif ($product->get_type() == 'simple') {
    $is_available = $product->is_purchasable() && $product->is_in_stock() == true;
} else {
    $is_available = true;
}

if(saleszone_option('category-product-add-to-cart-btn') == 'hide' || saleszone_option('catalog-mode')){
    return ;
}

?>

<?php if($is_available): ?>
    <div class="pc-add-to-cart-loop">
        <?php if (!empty($args['show_quantity']) && saleszone_option('category-product-add-to-cart-btn') != 'only-button' && $product->get_type() != 'grouped'): ?>
            <div class="pc-add-to-cart-loop__quantity <?php echo $in_cart ? 'hidden' : ''; ?>"
                 data-in-cart-state="hidden"
            >
                <?php woocommerce_quantity_input(array(
                    'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                    'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                    'input_value' => isset($_POST['quantity']) ? wc_stock_amount(intval($_POST['quantity'])) : $product->get_min_purchase_quantity(),
                    'input_type' => apply_filters('premmerce_quantity_input_type', 'number'),
                    'params' => array(
                        'data-quantity-field' => '',
                        'data-quantity-step' => 1
                    )
                )); ?>
            </div>
        <?php endif; ?>
        <div class="pc-add-to-cart-loop__button">
            <?php echo apply_filters('woocommerce_loop_add_to_cart_link',
                sprintf('<a rel="nofollow" href="%s" data-quantity="%s" data-in-cart-state="hidden" class="%s ' . ($in_cart ? 'hidden' : '') . ' add_to_cart_button ' . $ajax_class . '" %s>'. saleszone_get_loop_add_to_cart_icon() .'<span data-product-add-to-cart-text>%s</span><i class="button--loader hidden">' . saleszone_get_svg('refresh') . '</i></a>',
                    esc_url($variation->add_to_cart_url()),
                    esc_attr(isset($quantity) ? $quantity : 1),
                    esc_attr(isset($class) ? $class : 'button'),
                    isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                    esc_html($variation->add_to_cart_text())
                ),
                $product, $args);
            ?>
            <!-- Already in cart button -->
            <a class="added_to_cart wc-forward <?php echo $in_cart ? '' : 'hidden' ?>"
               href="<?php echo esc_url(wc_get_cart_url()); ?>"
                <?php if (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes'): ?>
                    data-cart-modal
                <?php endif; ?>
               data-in-cart-state="visible"
            >
                <?php esc_html_e('View in Cart', 'saleszone'); ?>
            </a>
        </div>
    </div>
<?php endif; ?>