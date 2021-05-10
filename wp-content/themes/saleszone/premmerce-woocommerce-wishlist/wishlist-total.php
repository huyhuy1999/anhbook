<?php if(function_exists('premmerce_wishlist')) :?>
    <?php $total = premmerce_wishlist()->wishlistTotal(); ?>

    <?php if(saleszone_option('header_layout') == 'layout_5') :?>

        <li class="pc-header-layout-5__toolbar-item"  data-wishlist-total-fragment>
            <div class="pc-header-layout-5__toolbar-icon pc-header-layout-5__toolbar-icon--wishlist">
                <?php saleszone_the_svg('heart-thin'); ?>
                <?php if ($total) : ?>
                    <div class="pc-header-layout-5__toolbar-counter">
                        <?php echo esc_html($total); ?>
                    </div>
                <?php endif; ?>
            </div>
            <a class="pc-header-layout-5__toolbar-link <?php echo !$total ? 'pc-header-layout-5__toolbar-link--empty' : '' ?>" rel="nofollow"
               href="<?php echo esc_url(saleszone_get_wishlist_url()); ?>"
            >
                <?php esc_html_e('Wishlist','saleszone'); ?>
            </a>
        </li>

    <?php elseif(saleszone_option('header_layout') == 'layout_3') :?>
        <div class="pc-header-layout-3__navbar-item-fragment" data-wishlist-total-fragment>
            <div class="pc-header-layout-3__toolbar-icon pc-header-layout-3__toolbar-icon--wishlist">
                <?php saleszone_the_svg('heart-thin'); ?>
                <?php if($total) :?>
                    <div class="pc-header-layout-3__toolbar-counter">
                        <?php echo esc_html($total); ?>
                    </div>
                <?php endif; ?>
            </div>
            <a class="pc-header-layout-3__toolbar-link <?php echo !$total ? 'pc-header-layout-3__toolbar-link--empty':''?>" href="<?php echo esc_url(saleszone_get_wishlist_url()); ?>" rel="nofollow">
                <?php esc_html_e('Wishlist','saleszone'); ?>
            </a>
        </div>
    <?php else: ?>
        <a class="user-panel__link <?php echo !$total ? 'user-panel__link--empty':''?>" href="<?php echo esc_url(saleszone_get_wishlist_url()); ?>" rel="nofollow" data-wishlist-total-fragment>
            <i class="user-panel__ico user-panel__ico--wishlist">
                <?php saleszone_the_svg('heart'); ?>
            </i>
            <?php esc_html_e('Wishlist','saleszone'); ?> (<?php echo esc_html($total); ?>)
        </a>
    <?php endif; ?>
<?php endif; ?>