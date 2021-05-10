<?php

global $wishlistPage;
global $wishlist_current;
$wishlistPage = true;

?>

<?php if (count($wishlists) == 0): ?>

    <div class="typo">
        <h2>
            <?php  esc_html_e('Your wishlist is empty', 'saleszone'); ?>
        </h2>
        <p>
            <?php  esc_html_e('Once added new items, you\'ll be able to continue shopping any time and also share the information about the purchase with your friends.', 'saleszone'); ?>
        </p>
    </div>

<?php else : ?>

    <?php foreach ($wishlists as $wl): ?>
        <?php $wishlist_current = $wl; ?>
        <section class="content__row">
            <div class="frame frame--wishlist">

                <!-- Frame header start -->
                <div class="frame__header">
                    <!-- Name -->
                    <div class="frame__title">
                        <a class="frame__title-link"
                           href="<?php echo esc_url(saleszone_get_wishlist_url() . '?key=' . $wl['wishlist_key']); ?>"
                           rel="nofollow">
                            <?php echo esc_html($wl['name']); ?>
                        </a>
                    </div>
                    <?php if(!$onlyView): ?>
                        <!--  Edit -->
                        <div class="frame__header-nav">
                            <button class="frame__header-link"
                                    data-modal="<?php echo esc_url(home_url(wp_nonce_url($apiUrlWishListRename . $wl['wishlist_key'], 'wp_rest'))); ?>">
                                <?php  esc_html_e('Edit', 'saleszone'); ?>
                            </button>
                        </div>
                        <!-- Delete -->
                        <div class="frame__header-nav">
                            <a class="frame__header-link"
                               data-premmerce-wishlist-delete-button
                               href="<?php echo esc_url(wp_nonce_url($apiUrlWishListDelete . $wl['wishlist_key'], 'wp_rest')); ?>">
                                <?php  esc_html_e('Delete', 'saleszone'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div><!-- Frame header end -->

                <div class="frame__inner content__row content__row--sm">
                    <?php if ($wl['products']): ?>
                        <div class="wishlist">
                            <?php

                            $productsIds = array();

                            foreach ($wl['products'] as $product){
                                $productsIds[] = $product->get_ID();
                            }

                            $query = new WP_Query(array(
                                'post_type' => 'product',
                                'post__in' => $productsIds
                            )); ?>
                            <ul class="wishlist__row">
                                <?php while ($query->have_posts()) : ?>
                                    <?php $query->the_post(); ?>
                                    <li class="wishlist__column">
                                        <?php wc_get_template_part('content', 'product'); ?>
                                    </li>
                                <?php endwhile; ?>
                                <?php wp_reset_postdata(); ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="typo">
                            <h3>
                                <?php  esc_html_e('This list is empty', 'saleszone'); ?>
                            </h3>
                            <p>
                                <?php  esc_html_e('Once added new items, you\'ll be able to continue shopping any time and also share the information about the purchase with your friends.', 'saleszone'); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </section>

    <?php endforeach ?>

<?php endif; ?>
<?php $wishlistPage = false; ?>