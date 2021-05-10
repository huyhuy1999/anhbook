<?php
/**
 * Single Product Up-Sells
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if (!$upsells) {
    return;
} ?>
<div class="up-sells">
    <?php

    $productIds = array();

    foreach ($upsells as $upsell){
        $productIds[] = $upsell->get_id();
    }

    $query = new WP_Query(array(
        'post_type' => array('product_variation', 'product'),
        'post__in' => $productIds,
        'posts_per_page' => 100
    )); ?>

    <ul class="up-sells__row">
        <?php while ($query->have_posts()) : ?>
            <?php $query->the_post(); ?>
            <li class="up-sells__columns">
                <?php wc_get_template_part('content', 'product'); ?>
            </li>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </ul>
</div>