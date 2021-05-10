<?php
/**
 * Cross-sells
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!$cross_sells) {
    return;
}
?>

<div class="row row--ib row--vindent-m" data-slider-slides="1,2,3,3">

    <?php

    $productIds = array();
    foreach ($cross_sells as $cross_sell){
        $productIds[] = $cross_sell->get_id();
    }

    $query = new WP_Query(array(
        'post_type' => array('product_variation', 'product'),
        'post__in' => $productIds,
        'posts_per_page' => 100
    ));

    ?>

    <?php while ($query->have_posts()) : ?>
        <?php $query->the_post(); ?>
        <div class="col-sm-4" data-slider-slide>
            <?php wc_get_template('content-product_thumb.php', array(
                'show_add_to_cart' => true
            )); ?>
        </div>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
</div>