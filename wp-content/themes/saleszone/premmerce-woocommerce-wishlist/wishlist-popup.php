<?php

if(!isset($success)){
    $success = false;
}
$is_move = isset($_GET['wishlist_move_from']) ? true : false;

if($is_move){
    $routeUrl = home_url('wp-json/premmerce/wishlist/page');
} else {
    $routeUrl = home_url('wp-json/premmerce/wishlist/add');
}
?>

<div class="modal modal--sm">
    <?php

    if($is_move){
        $title = __('Move to another list','saleszone');
    } else {
        $title = __('Add to your list','saleszone');
    }

    wc_get_template('../parts/modal/modal-header.php', array(
        'title' => $title
    )); ?>

    <form method="post" action="<?php echo esc_url($routeUrl); ?>" data-premmerce-wishlist-ajax>

        <div class="modal__content">

            <?php if($success) :?>
                <div class="typo">
                    <?php esc_html_e('Item successfuly added to your Wishlist!','saleszone'); ?>
                </div>
            <?php else: ?>
                <div class="form">

                    <!-- Default list -->
                    <?php if (!count($wishlists)): ?>
                        <div class="form__field">
                            <label class="form__checkbox">
                                <span class="form__checkbox-field">
                                    <input type="radio" value="0" name="wishlist_id" checked>
                                </span>
                                <span class="form__checkbox-inner">
                                    <span class="form__checkbox-title">
                                        <?php esc_html_e('My Wishlist', 'saleszone') ?>
                                    </span>
                                </span>
                            </label>
                        </div>
                    <?php endif; ?>

                    <!-- User lists -->
                    <?php if (count($wishlists)): ?>
                        <div class="form__field">
                            <div class="form__label">
                                <?php esc_html_e('Select a list','saleszone'); ?>
                            </div>
                            <div class="form__inner">
                                <?php $cnt = 0; ?>
                                <?php foreach ($wishlists as $wishlist): ?>
                                    <label class="form__checkbox">
                                        <span class="form__checkbox-field">
                                            <?php if($is_move) :?>
                                                <input type="radio"  value="<?php echo esc_attr($wishlist['wishlist_key']); ?>" name="wishlist_move_to"
                                                    <?php echo premmerce_wishlist()->isProductInWishlist($productId, $wishlist['wishlist_key']) ? 'disabled' : ''?>
                                                >
                                            <?php else : ?>
                                                <input type="radio" value="<?php echo esc_attr($wishlist['ID']); ?>" name="wishlist_id" <?php echo $cnt == 0 ? 'checked':''; ?>>
                                            <?php endif; ?>
                                        </span>
                                        <span class="form__checkbox-inner">
                                            <span class="form__checkbox-title">
                                                <?php echo esc_html($wishlist['name']); ?>
                                            </span>
                                        </span>
                                    </label>
                                    <?php $cnt++; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Create a new list -->
                    <?php if(!$is_move) :?>
                    <div class="form__field" data-wishlist-new-scope>
                        <div class="form__label">
                            <?php esc_html_e('Create a new list','saleszone'); ?>
                        </div>
                        <div class="form__inner">
                            <label class="form__checkbox">
                                <span class="form__checkbox-field">
                                    <input type="radio" value="-1" name="wishlist_id" data-premmerce-wishlist-new-radio>
                                </span>
                                <span class="form__checkbox-inner">
                                    <span class="form__checkbox-title">
                                        <input class="form-control" type="text" name="wishlist_name" data-premmerce-wishlist-new-input>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>

                </div><!-- /.form -->
            <?php endif; ?>

        </div><!-- /.modal__content -->

        <div class="modal__footer">
            <div class="modal__footer-row">
                <div class="modal__footer-btn hidden-xs">
                    <button class="btn btn-default" type="reset"
                            data-modal-close>
                        <?php esc_html_e('Close','saleszone'); ?>
                    </button>
                </div>
                <div class="modal__footer-btn">

                    <?php if($success) :?>
                        <a class="btn btn-primary" href="<?php echo esc_url(saleszone_get_wishlist_url()); ?>"
                           data-button-loader="button">
                            <?php esc_html_e('Go to wishlist','saleszone'); ?>
                            <i class="button--loader hidden" data-button-loader="loader">
                                <?php saleszone_the_svg('refresh'); ?>
                            </i>
                        </a>
                    <?php else: ?>
                        <button class="btn btn-primary" type="submit" data-button-loader="button">
                            <span><?php esc_html_e('Add to list','saleszone'); ?></span>
                            <i class="button--loader hidden" data-button-loader="loader">
                                <?php saleszone_the_svg('refresh'); ?>
                            </i>
                        </button>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <?php if($success) :?>
            <div class="hidden" data-ajax-grab="wishlist-total">
                <?php get_template_part('premmerce-woocommerce-wishlist/wishlist', 'total'); ?>
            </div>
            <div class="hidden" data-ajax-grab="wishlist-link--<?php echo esc_attr($productId); ?>">
                <?php wc_get_template('../premmerce-woocommerce-wishlist/wishlist-btn.php', array(
                    'type' => 'link',
                    'productId' => $productId
                )); ?>
            </div>
            <div class="hidden" data-ajax-grab="wishlist-button--<?php echo esc_attr($productId); ?>">
                <?php wc_get_template('../premmerce-woocommerce-wishlist/wishlist-btn.php', array(
                    'type' => 'button',
                    'productId' => $productId
                )); ?>
            </div>
        <?php endif; ?>

        <?php if($is_move) :?>
            <input type="hidden" name="wishlist_key" value="<?php echo esc_attr(premmerce_wishlist()->getWishlistKeyByProductId($productId)); ?>">
            <input type="hidden" name="product_ids[]" value="<?php echo esc_attr($productId); ?>">
            <input type="hidden" name="move" value="true">

        <?php else: ?>
            <input type="hidden" name="submit" id="submit" class="button alt" value="<?php esc_attr_e('Wishlist','saleszone') ?>"/>
            <input type="hidden" name="wishlist_product_id" value="<?php echo esc_attr($productId); ?>">
        <?php endif; ?>
        <?php wp_nonce_field('wp_rest'); ?>
    </form>
</div>