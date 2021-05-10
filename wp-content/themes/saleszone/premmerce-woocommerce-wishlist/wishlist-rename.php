<div class="modal modal--sm">
    <?php wc_get_template('../parts/modal/modal-header.php',array(
        'title' => __('Edit your list','saleszone')
    )) ?>
    <form method="post" action="<?php echo esc_url($apiUrlWishListPage); ?>">
        <div class="modal__content">
            <div class="form">
                <div class="form__field">
                    <div class="form__label">
                        <?php esc_html_e('List name','saleszone'); ?>
                        <span class="form__require-mark"></span>
                    </div>
                    <div class="form__inner">
                        <input class="form-control" required type="text" name="wishlist_name" value="<?php echo esc_attr($wishlist['name']); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal__footer">
            <div class="modal__footer-row">
                <div class="modal__footer-btn hidden-xs">
                    <button class="btn btn-default" type="reset" data-modal-close=""><?php esc_html_e('Close','saleszone'); ?></button>
                </div>
                <div class="modal__footer-btn">
                    <button class="btn btn-primary" type="submit" data-button-loader="button">
                        <span><?php esc_html_e('Edit list','saleszone'); ?></span>
                        <i class="button--loader hidden" data-button-loader="loader">
                            <?php saleszone_the_svg('refresh'); ?>
                        </i>
                    </button>
                </div>
            </div>
        </div>

        <?php wp_nonce_field('wp_rest'); ?>
        <input type="hidden" name="wishlist_key" value="<?php echo esc_attr($wishlist['wishlist_key']); ?>">
        <input type="hidden" name="rename" class="button alt" style="padding: 0px 5px 0px 5px;" value="<?php esc_attr_e('Rename','saleszone') ?>"/>
    </form>
</div>