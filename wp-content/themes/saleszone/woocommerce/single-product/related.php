<?php
/**
 * Related Products
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!$related_products) {
    return;
}; ?>

<div class="content__sidebar-item">
    <div class="widget-sidebar widget-sidebar--related-products">
        <div class="widget-sidebar__header">
            <h2 class="widget-sidebar__title"><?php esc_html_e('Related products', 'saleszone'); ?></h2>
        </div>
        <div class="widget-sidebar__inner">

            <?php

            $productIds = array();

            foreach ($related_products as $related_product){
                $productIds[] = $related_product->get_id();
            }

            $query = new WP_Query(array(
                'post_type' => array('product_variation', 'product'),
                'post__in' => $productIds,
                'posts_per_page' => 100
            ));

            ?>

            <?php while ($query->have_posts()) : ?>
                <?php $query->the_post(); ?>
                <div class="widget-sidebar__item">
                    <?php wc_get_template('content-product_thumb.php', array(
                        'show_add_to_cart' => false
                    )); ?>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>

        </div>
    </div>
</div>
