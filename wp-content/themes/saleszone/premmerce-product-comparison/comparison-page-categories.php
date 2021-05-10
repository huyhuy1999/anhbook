<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<?php if (count($data)): ?>
    <div class="row row--ib row--ib row--vindent-m">
        <?php foreach ($data as $category):
            $keys = array_keys($category['products']);
            $first_item_key = $keys[0];
            $first_product = $category['products'][$first_item_key];

            if($first_product->get_type() == 'variation'){
                $parent_data = $first_product->get_parent_data();
                $image_id = $parent_data['image_id'];
            } else {
                $image_id = $first_product->get_image_id();
            }

            ?>
            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <a class="catalog-section" href="<?php echo esc_url($category['url']); ?>">
                    <div class="catalog-section__image">
                        <img class="catalog-section__img"
                             src="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'thumbnail', true)); ?>"
                             alt="<?php echo esc_attr(saleszone_get_img_alt($image_id, $category['name'])); ?>"
                        >
                    </div>
                    <div class="catalog-section__caption">
                        <?php
                        /* translators: %s: Category name */
                        printf(esc_html__('%s List', 'saleszone'), esc_html($category['name'])); ?>
                        <span class="catalog-section__count">(<?php echo count($category['products']); ?>)</span>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="typo">
        <?php esc_html_e('No items to compare', 'saleszone'); ?>
    </div>
<?php endif; ?>
