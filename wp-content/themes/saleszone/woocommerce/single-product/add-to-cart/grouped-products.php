<?php
if (!defined('ABSPATH')) {
    exit;
}
global $product, $post;
?>
<ul class="product-group">
    <?php
    $quantites_required = false;
    $previous_post_id = get_the_ID();
    foreach ($grouped_products as $grouped_product) :

        $args = array(
            'post_type' => 'product',
            'post__in' => array($grouped_product->get_id()),
            'posts_per_page' => 100
        );

        /**
         * Setup post data
         */
        $query = new WP_Query($args);
        while ($query->have_posts()){
            $query->the_post();
        }

        $quantites_required = $quantites_required || ($grouped_product->is_purchasable() && !$grouped_product->has_options());
        ?>

        <li id="product-<?php the_ID(); ?>" <?php wc_product_class('product-group__item', $grouped_product); ?> >
            <a class="product-group__image"
               href="<?php echo esc_url($grouped_product->get_permalink()); ?>"
               title="<?php echo esc_attr($grouped_product->get_name()); ?>"
            >
                <img src="<?php echo esc_url(get_the_post_thumbnail_url($grouped_product->get_id(), 'thumbnail')); ?>"
                     alt="<?php echo esc_attr(saleszone_get_img_alt(get_post_thumbnail_id(), $grouped_product->get_name())); ?>">
            </a>
            <div class="product-group__title">
                <label class="product-group__link label"
                       for="product-<?php echo esc_attr($grouped_product->get_id()); ?>">
                    <?php echo $grouped_product->is_visible() ? '<a href="' . esc_url(apply_filters('woocommerce_grouped_product_list_link', get_permalink($grouped_product->get_id()), $grouped_product->get_id())) . '">' . esc_html($grouped_product->get_name()) . '</a>' : esc_attr($grouped_product->get_name()); ?>
                </label>
                <div class="product-group__price price">
                    <?php echo wp_kses($grouped_product->get_price_html(), saleszone_get_allowed_html('price')); ?>
                </div>
            </div>
            <?php if(!saleszone_option('catalog-mode')) :?>
                <div class="product-group__quantity">
                    <?php if (!$grouped_product->is_purchasable() || $grouped_product->has_options()) : ?>
                        <?php woocommerce_template_loop_add_to_cart(array('variation' => $grouped_product)); ?>

                    <?php elseif ($grouped_product->is_sold_individually()) : ?>
                        <input type="checkbox"
                               name="<?php echo esc_attr('quantity[' . $grouped_product->get_id() . ']'); ?>"
                               value="1"
                               class="wc-grouped-product-add-to-cart-checkbox"
                               form="add-to-cart-form-<?php echo esc_attr($product->get_id()); ?>"
                        />

                    <?php else : ?>
                        <?php do_action('woocommerce_before_add_to_cart_quantity');
                        woocommerce_quantity_input(array(
                            'input_name' => 'quantity[' . $grouped_product->get_id() . ']',
                            'input_value' => isset($_POST['quantity'][$grouped_product->get_id()]) ? wc_stock_amount(intval(wp_unslash($_POST['quantity'][$grouped_product->get_id()]))) : 0,
                            'min_value' => apply_filters('woocommerce_quantity_input_min', 0, $grouped_product),
                            'max_value' => apply_filters('woocommerce_quantity_input_max', $grouped_product->get_max_purchase_quantity(), $grouped_product),
                            'input_type' => apply_filters('premmerce_quantity_input_type', 'number'),
                            'params' => array(
                                'data-quantity-field' => '',
                                'data-quantity-step' => 1,
                                'form' => 'add-to-cart-form-' . $product->get_id()
                            ),
                        ));
                        do_action('woocommerce_after_add_to_cart_quantity');
                        ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php do_action('woocommerce_grouped_product_list_before_price', $grouped_product); ?>
        </li>

        <?php
    endforeach;
    wp_reset_postdata();

    $args = array(
        'post_type' => 'product',
        'post__in' => array($previous_post_id),
        'posts_per_page' => 100
    );
    $query = new WP_Query($args);
    // Return data to original post.
    while ($query->have_posts()){
        $query->the_post();
    }

    ?>
</ul>
