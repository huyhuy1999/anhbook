<?php
/**
 * My Addresses
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


$translations = array(
    'first_name' => __('First name','saleszone'),
    'last_name' => __('Last name','saleszone'),
    'company' => __('Company','saleszone'),
    'address_1' => __('Address','saleszone'),
    'address_2' => __('Additional address','saleszone'),
    'city' => __('City','saleszone'),
    'state' => __('State','saleszone'),
    'postcode' => __('Postcode','saleszone'),
    'country' => __('Country','saleszone'),
    'email' => __('Email address','saleszone'),
    'phone' => __('Phone','saleszone'),
);

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => __( 'Billing address', 'saleszone' ),
		'shipping' => __( 'Shipping address', 'saleszone' ),
	), $customer_id );
} else {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => __( 'Billing address', 'saleszone' ),
	), $customer_id );
}

?>

<div class="order-details">
    <div class="order-details__group typo">
        <?php echo esc_html(apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'saleszone' ) )); ?>
    </div>
    <div class="order-details__group">
        <div class="row row--ib row--vindent-s">
            <?php $cnt = 0; ?>

            <?php foreach ( $get_addresses as $name => $title ) :
                $column_classes = 'col-md-4 col-xs-12 col-sm-12';
                if($cnt == 1){
                    $column_classes .= ' col-md-offset-1';
                } ?>
                <div class="<?php echo esc_attr(apply_filters('premmerce-myaccount-edit-address-column-class',  $column_classes)); ?>">
                    <div class="order-details__group">
                        <h3 class="order-details__list">
                            <div class="order-details__item order-details__item--group-title">
                                <?php echo esc_html($title); ?>
                            </div>
                            <div class="order-details__item">
                                <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>">
                                    <?php esc_html_e( 'Edit', 'saleszone' ); ?>
                                    <?php saleszone_the_svg('edit','svg-icon--edit'); ?>
                                </a>
                            </div>
                        </h3>

                        <?php $address = array_map('wp_kses_post', saleszone_get_account_address($name)); ?>

                        <?php foreach ($address as $key => $value) :?>
                            <?php if($value && isset($translations[$key])) :?>
                                <div class="order-details__list">
                                    <div class="order-details__item order-details__item--title">
                                        <?php echo esc_html($translations[$key]); ?>:
                                    </div>
                                    <div class="order-details__item">
                                        <?php echo esc_html($value); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <?php $address = wc_get_account_formatted_address( $name );?>

                        <?php if($address === ''): ?>
                            <div class="order-details__list typo">
                                <?php esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php $cnt++; ?>
            <?php endforeach; ?>

        </div>
    </div>
</div>

