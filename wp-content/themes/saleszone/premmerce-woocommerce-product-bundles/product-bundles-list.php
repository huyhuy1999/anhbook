<?php
/**
 * $productsData - Array of bundles
 * $item['mainItem'] - Main bundle product
 *
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if(!$items) {
    return;
}

global $wp;
?>
<div class="pc-section-primary pc-section-primary--kit" data-slider="<?php echo esc_attr(apply_filters('premmerce-kit-slider-attrs','section-primary')); ?>">
    <h2 class="pc-section-primary__title">
        <?php esc_html_e('Frequently bought together', 'saleszone'); ?>
    </h2>
    <div class="pc-section-primary__inner">
        <div class="pc-section-primary__arrow pc-section-primary__arrow--left hidden" data-slider-arrow-left>
            <?php saleszone_the_svg('arrow-big-left'); ?>
        </div>
        <div class="pc-section-primary__arrow pc-section-primary__arrow--right hidden" data-slider-arrow-right>
            <?php saleszone_the_svg('arrow-big-right'); ?>
        </div>
        <div class="product-kit" data-slider-slides="1,1,1,1">
            <!-- List of bundles -->
            <?php foreach ($items as $item): ?>
                <?php foreach ($item['productsData'] as $key => $productData) :
                    $in_cart = saleszone_in_cart($productData['id']);
                    ?>
                    <div class="product-kit__slide"
                         data-slider-slide
                         data-product-variation="<?php echo esc_attr($productData['id']); ?>"
                         data-product="<?php echo esc_attr($productData['id']); ?>"
                    >
                        <div class="product-kit__item">
                            <!-- Products BEGIN -->
                            <div class="product-kit__products">
                                <div class="product-kit__product">

                                    <!-- Main Product BEGIN -->
                                    <article <?php wc_product_class('product-thumb product-thumb--kit', $item['mainItem']); ?>>
                                        <aside class="product-thumb__left">
                                            <div class="product-photo">
                                                <div class="product-photo__item">
                                                    <img class="product-photo__img"
                                                         src="<?php echo esc_url(saleszone_get_variation_image_url($item['mainItem'])); ?>"
                                                         alt="<?php echo esc_attr(saleszone_get_img_alt($item['mainItem']->get_image_id(), $item['mainItem']->get_name())); ?>"
                                                         title="<?php echo esc_attr($item['mainItem']->get_name()); ?>">
                                                </div>
                                            </div>
                                        </aside>
                                        <div class="product-thumb__right">
                                            <!-- Title -->
                                            <div class="product-thumb__row">
                                                <?php echo esc_html($item['mainItem']->get_name()); ?>
                                            </div>
                                            <?php if ($price_html = $item['mainItem']->get_price_html()): ?>
                                                <div class="product-thumb__row product-price">
                                                    <?php echo wp_kses($price_html , saleszone_get_allowed_html('price')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </article>
                                    <!-- Main Product END -->

                                </div>
                                <?php foreach ($productData['products'] as $key => $product) : ?>
                                    <div class="product-kit__product">

                                        <!-- Additional Product BEGIN -->
                                        <article <?php wc_product_class('product-thumb product-thumb--kit', $product); ?>>
                                            <aside class="product-thumb__left">
                                                <div class="product-photo">
                                                    <a class="product-photo__item"
                                                       href="<?php echo esc_url($product->get_permalink()); ?>">
                                                        <img class="product-photo__img"
                                                             src="<?php echo esc_url(saleszone_get_variation_image_url($product)); ?>"
                                                             alt="<?php echo esc_attr(saleszone_get_img_alt($product->get_image_id(), $product->get_name())); ?>"
                                                             title="<?php echo esc_attr($product->get_name()); ?>">
                                                    </a>
                                                </div>
                                                <div class="product-kit__discount-label"
                                                     data-content="-<?php echo esc_attr($productData['discounts'][$key]); ?>%">
                                                    <?php saleszone_the_svg('new'); ?>
                                                </div>
                                            </aside>
                                            <div class="product-thumb__right">
                                                <!-- Title -->
                                                <div class="product-thumb__row">
                                                    <a class="product-thumb__title"
                                                       href="<?php echo esc_url($product->get_permalink()); ?>">
                                                        <?php echo esc_html($product->get_name()); ?>
                                                    </a>
                                                </div>
                                                <?php if ($price_html = $product->get_price_html()): ?>
                                                    <div class="product-thumb__row product-price">
                                                        <?php $showDiscount = ($productData['old_prices'][$key] != $productData['prices'][$key]) ? true : false; ?>
                                                        <?php if ($showDiscount): ?>
                                                            <del><?php echo wp_kses(wc_price($productData['old_prices'][$key]) , saleszone_get_allowed_html('price')); ?></del>
                                                        <?php endif; ?>

                                                        <?php
                                                        $priceHtml = wc_price($productData['prices'][$key]);
                                                        if ($showDiscount) {
                                                            $priceHtml = '<ins>' . $priceHtml . '</ins>';
                                                        }
                                                        echo wp_kses($priceHtml . $product->get_price_suffix() , saleszone_get_allowed_html('price'));
                                                        ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </article>
                                        <!-- Additional Product END -->
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- Products END -->

                            <!-- Purchase box BEGIN -->
                            <div class="product-kit__purchase">
                                <div class="product-kit__purchase-inner">
                                    <!-- Total price BEGIN -->
                                    <div class="product-kit__price">
                                        <div class="product-price product-price--md">
                                            <?php if ($productData['total_sale'] < $productData['total']): ?>
                                                <del><?php echo wp_kses(wc_price($productData['total']) , saleszone_get_allowed_html('price')); ?></del>
                                            <?php endif; ?>
                                            <ins><?php echo wp_kses(wc_price($productData['total_sale']) . $item['mainItem']->get_price_suffix(), saleszone_get_allowed_html('price')); ?></ins>
                                        </div>
                                    </div>
                                    <div class="product-kit__discount">
                                    <span class="product-kit__discount-title">
                                        <?php esc_html_e('You save', 'saleszone'); ?>
                                    </span>
                                        <span class="product-kit__discount-val">
                                            <?php echo wp_kses(wc_price($productData['total'] - $productData['total_sale']) , saleszone_get_allowed_html('price')); ?>
                                        </span>
                                    </div>
                                    <?php if(!saleszone_option('catalog-mode')) :?>
                                        <div class="product-kit__btn">
                                            <form action="<?php echo esc_url(home_url( $wp->request )); ?>" class="pc-add-to-cart-loop" method="post" data-loop-add-to-cart-form>
                                                <div class="pc-add-to-cart-loop__button">
                                                    <button class="button add_to_cart_button ajax_add_to_cart <?php echo esc_attr($in_cart) ? 'hidden' : ''; ?>"
                                                            type="submit"
                                                            name="add-to-cart"
                                                            value="<?php echo esc_attr($item['mainItem']->get_id()); ?>"
                                                            data-product_id="<?php echo esc_attr($productData['id']); ?>"
                                                            data-in-cart-state="hidden"
                                                    >
                                                        <?php esc_html_e('Add to cart', 'saleszone'); ?>
                                                        <i class="button--loader hidden"><?php saleszone_the_svg('refresh'); ?></i>
                                                    </button>
                                                    <!-- Already in cart button -->
                                                    <a class="added_to_cart wc-forward <?php echo !$in_cart ? 'hidden' : ''; ?>"
                                                       href="<?php echo esc_url(wc_get_cart_url()); ?>"
                                                        <?php if (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes'): ?>
                                                            data-cart-modal
                                                        <?php endif; ?>
                                                       data-in-cart-state="visible"
                                                    >
                                                        <?php esc_html_e('View in Cart', 'saleszone'); ?>
                                                    </a>
                                                </div>
                                                <input type="hidden" name="quantity-<?php echo esc_attr($productData['id']); ?>"
                                                       value="1">
                                                <input type="hidden" name="product_id"
                                                       value="<?php echo esc_attr($item['mainItem']->get_id()); ?>">
                                                <input type="hidden" name="bundle_id"
                                                       value="<?php echo esc_attr($productData['id']); ?>">
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Total price END -->
                                </div>
                            </div>
                            <!-- Purchase box END -->
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>