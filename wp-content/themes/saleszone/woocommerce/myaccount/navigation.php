<?php
/**
 * My Account navigation
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<nav>
    <ul class="sidebar-nav">
        <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <li class="sidebar-nav__item <?php echo esc_attr(wc_get_account_menu_item_classes( $endpoint )); ?>">
                <a class="sidebar-nav__link" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                    <?php echo esc_html( $label ); ?>
                    <span class="sidebar-nav__icon">
                        <?php saleszone_the_svg($endpoint); ?>
                    </span>
                </a>
            </li>
            <?php if($endpoint == 'edit-account' && function_exists('premmerce_wishlist')) :?>
                <li class="sidebar-nav__item">
                    <a class="sidebar-nav__link" href="<?php echo esc_url(saleszone_get_wishlist_url()); ?>">
                        <?php esc_html_e('Wishlist','saleszone'); ?>
                        <span class="sidebar-nav__icon">
                            <?php saleszone_the_svg('heart'); ?>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
