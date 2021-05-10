<?php
if (!count($data)) {
    return;
}
?>
<div class="pc-compare">
    <table class="pc-compare__table">
        <tr class="pc-compare__row">
            <td class="pc-compare__col pc-compare__col--product"></td>
            <?php foreach ($data['products'] as $product): ?>
                <td class="pc-compare__col pc-compare__col--product">
                    <!-- Product thumb -->
                    <div <?php wc_product_class('product-thumb', $product); ?>>
                        <div class="product-thumb__left">
                            <div class="product-photo">
                                <a class="product-photo__item"
                                   href="<?php echo esc_url($product->get_permalink()); ?>">
                                    <img class="product-photo__img"
                                         src="<?php echo esc_url(saleszone_get_variation_image_url($product)); ?>"
                                         alt="<?php echo esc_attr(saleszone_get_img_alt($image_id, $product->get_name())); ?>"
                                         title="<?php echo esc_attr($product->get_name()); ?>"
                                         data-product-thumbnail>
                                </a>
                            </div>
                        </div>
                        <div class="product-thumb__right">
                            <div class="product-thumb__row">
                                <a class="product-thumb__title"
                                   href="<?php echo esc_url($product->get_permalink()); ?>"
                                >
                                    <?php echo esc_html($product->get_name()); ?>
                                </a>
                            </div>
                            <div class="product-thumb__row product-price product-price--bg"
                                 data-product-price
                            >
                                <?php echo wp_kses($product->get_price_html() , saleszone_get_allowed_html('price')); ?>
                            </div>
                            <div class="product-thumb__row">
                                <a class="link link--pale link--sm"
                                   data-compare-delete-button
                                   href="<?php echo esc_url(wp_nonce_url($urlDelete . $product->get_id(), 'wp_rest') . '&products=' . implode(',', array_keys($data['products']))); ?>">
                                    <?php esc_html_e('Delete', 'saleszone'); ?>
                                </a>
                            </div>
                        </div>
                    </div><!-- /.product-thumb -->
                </td><!-- /.pc-compare__product -->
            <?php endforeach; ?>
        </tr><!-- /.pc-compare__product-list -->
        <?php foreach ($data['attributes'] as $attr): ?>
            <tr class="pc-compare__row">
                <td class="pc-compare__col pc-compare__col--param">
                    <?php echo esc_html($attr['title']); ?>
                </td>
                <?php foreach ($attr['values'] as $value): ?>
                    <td class="pc-compare__col pc-compare__col--param">
                        <?php echo esc_html($value) ? esc_html($value) : '-'; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>