<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
$variation = saleszone_get_variation($product);
$class = 'product-thumb';

if(isset($modifiers)){
    $class = $class . ' ' .$modifiers;
}

?>

<article <?php wc_product_class($class, $product); ?>
        data-product="<?php echo esc_attr($product->get_ID()); ?>"
        data-product-variation="<?php echo esc_attr($variation->get_ID()); ?>"
>
    <aside class="product-thumb__left">
        <div class="product-photo">
            <a class="product-photo__item" href="<?php echo esc_url($variation->get_permalink()); ?>">
                <img class="product-photo__img"
                     src="<?php echo esc_url(saleszone_get_variation_image_url($product)); ?>"
                     alt="<?php echo esc_attr(saleszone_get_img_alt($variation->get_image_id(), $variation->get_name())); ?>"
                     title="<?php echo esc_attr($variation->get_name()); ?>"
                     data-src-placeholder="<?php echo esc_url(wc_placeholder_img_src()); ?>"
                     data-product-thumbnail>
            </a>
        </div>
    </aside>

    <div class="product-thumb__right">

        <!-- Title -->
        <div class="product-thumb__row">
            <a class="product-thumb__title" href="<?php echo esc_url($variation->get_permalink()); ?>">
                <?php echo wp_kses_post($variation->get_name()); ?>
            </a>
        </div>

        <?php if ($price_html = $variation->get_price_html()): ?>
            <div class="product-thumb__row product-price product-price--bg"
                 data-product-price
            >
                <?php echo wp_kses($price_html , saleszone_get_allowed_html('price')); ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($show_add_to_cart)): ?>
        <form class="product-thumb__row <?php echo $product->get_type() == 'variable' ? 'variations_form':''; ?>" method="post" enctype="multipart/form-data"
              data-loop-add-to-cart-form

            <?php if($product->get_type() == 'variable') :?>
            <?php $product_available_variations = $product->get_available_variations(); ?>
                data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $product_available_variations ) ) ?>"
            <?php endif; ?>
        >
            <?php if($product->get_type() == 'variable'){
                wp_enqueue_script( 'wc-add-to-cart-variation' );
            } ?>

            <?php if ($product->get_type() == 'variable' && !empty($product_available_variations)): ?>
                <?php foreach ($product->get_variation_attributes() as $attribute_name => $options) : ?>
                    <div class="product-thumb__row variants-select variants-select--sm variants-select--<?php echo esc_attr(sanitize_title($attribute_name)); ?>">
                        <div class="variants-select__field variations value">
                            <?php
                            if (isset($_REQUEST['attribute_' . sanitize_title(wp_unslash($attribute_name))])) {
                                $selected = wc_clean(stripslashes(urldecode($_REQUEST['attribute_' . sanitize_title($attribute_name)])));
                            } else {
                                $selected = $product->get_variation_default_attribute($attribute_name);
                            }
                            wc_dropdown_variation_attribute_options(array(
                                'options' => $options,
                                'attribute' => $attribute_name,
                                'product' => $product,
                                'selected' => $selected,
                                'attributes' => array('data-loop-variation' => '')
                            ));
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="product-thumb__row">
                <?php woocommerce_template_loop_add_to_cart(array('variation' => $variation, 'show_quantity' => false)); ?>
            </div>

            <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>"/>
            <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>"/>
            <input type="hidden" name="variation_id" class="variation_id"
                   value="<?php echo (int)saleszone_get_default_variation_id($product); ?>"/>
            <div class="single_variation hidden"></div>
        </form>
        <?php endif; ?>

    </div>
</article>
