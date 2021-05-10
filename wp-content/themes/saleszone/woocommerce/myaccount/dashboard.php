<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<div class="frame">
    <div class="frame__header">
        <div class="typo">
            <?php
            printf(
                /* translators: %1$s: current user name , %2$s : Log out url  */
                wp_kses(__( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'saleszone' ), array('a' => array('href' => true))),
                '<strong>' . esc_html( $current_user->display_name ) . '</strong>',
                esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) )
                ); ?>
        </div>
    </div>

    <div class="frame__inner">

        <?php if(!saleszone_option('catalog-mode')) :?>
        <div class="content__row content__row--sm typo">
            <p>
                <?php
                printf(
                    /* translators: %1$s: recent orders url, %2$s : shipping and billing addresses url, %3$s edit password url */
                    wp_kses(__( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a> and <a href="%3$s">edit your password and account details</a>.', 'saleszone' ), array('a' => array('href' => true))),
                    esc_url( wc_get_endpoint_url( 'orders' ) ),
                    esc_url( wc_get_endpoint_url( 'edit-address' ) ),
                    esc_url( wc_get_endpoint_url( 'edit-account' ) )
                ); ?>
            </p>
        </div>
        <?php endif; ?>

        <div class="content__row content__row--sm">
            <ul class="row row--ib row--vindent-m">
                <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                    <?php if($endpoint != 'customer-logout' && $endpoint != 'dashboard') :?>
                        <li class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                            <a class="profile-dashboard" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                                <div class="profile-dashboard__image">
                                    <?php saleszone_the_svg($endpoint, 'profile-dashboard__icon'); ?>
                                </div>
                                <div class="profile-dashboard__caption">
                                    <?php echo esc_html( $label ); ?>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if(function_exists('premmerce_wishlist')) :?>
                    <li class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        <a class="profile-dashboard" href="<?php echo esc_url(saleszone_get_wishlist_url()); ?>">
                            <div class="profile-dashboard__image">
                                <?php saleszone_the_svg('heart','profile-dashboard__icon'); ?>
                            </div>
                            <div class="profile-dashboard__caption">
                                <?php esc_html_e('Wishlist','saleszone'); ?>
                            </div>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );