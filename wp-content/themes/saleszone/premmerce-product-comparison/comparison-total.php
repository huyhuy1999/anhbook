<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<?php if(function_exists('premmerce_comparison')) :?>
  <?php $total = premmerce_comparison()->totalProducts(); ?>

<?php if (saleszone_option('header_layout') == 'layout_5') : ?>
        <li class="pc-header-layout-5__toolbar-item"  data-comparison-total-fragment>
            <div class="pc-header-layout-5__toolbar-icon pc-header-layout-5__toolbar-icon--cart">
                <?php saleszone_the_svg('libra'); ?>
                <?php if ($total) : ?>
                    <div class="pc-header-layout-5__toolbar-counter">
                        <?php echo esc_html($total); ?>
                    </div>
                <?php endif; ?>
            </div>
            <a class="pc-header-layout-5__toolbar-link <?php echo !$total ? 'pc-header-layout-5__toolbar-link--empty' : '' ?>" rel="nofollow"
               href="<?php echo esc_url(premmerce_comparison()->getUrlComparison()); ?>"
            >
                <?php esc_html_e('Compare', 'saleszone'); ?>
            </a>
        </li>
<?php elseif(saleszone_option('header_layout') == 'layout_3') : ?>
    <div class="pc-header-layout-3__navbar-item-fragment" data-comparison-total-fragment>
        <div class="pc-header-layout-3__toolbar-icon pc-header-layout-3__toolbar-icon--compare">
            <?php saleszone_the_svg('compare'); ?>
            <?php if ($total) : ?>
                <div class="pc-header-layout-3__toolbar-counter">
                    <?php echo esc_html($total); ?>
                </div>
            <?php endif; ?>
        </div>
        <a class="pc-header-layout-3__toolbar-link <?php echo !$total ? 'pc-header-layout-3__toolbar-link--empty' : '' ?>"
           href="<?php echo esc_url(premmerce_comparison()->getUrlComparison()); ?>" rel="nofollow">
            <?php esc_html_e('Compare', 'saleszone'); ?>
        </a>
    </div>
<?php else: ?>
    <a class="user-panel__link <?php echo !$total ? 'user-panel__link--empty' : '' ?>"
       href="<?php echo esc_url(premmerce_comparison()->getUrlComparison()); ?>" rel="nofollow" data-comparison-total-fragment>
        <i class="user-panel__ico user-panel__ico--compare">
            <?php saleszone_the_svg('compare'); ?>
        </i>
        <?php esc_html_e('Compare', 'saleszone'); ?> (<?php echo esc_html($total); ?>)
    </a>
<?php endif; ?>
<?php endif; ?>
