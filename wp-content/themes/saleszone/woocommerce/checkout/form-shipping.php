<?php
/**
 * Checkout shipping information form
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="form form--bg form--shipping">
    <?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
        <div class="form__field woocommerce-shipping-fields">

            <div class="form__field" id="ship-to-different-address">
                <label class="form__checkbox" for="ship-to-different-address-checkbox">
                    <span class="form__checkbox-field">
                        <input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox " <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
                    </span>
                    <span class="form__checkbox-inner">
                        <span class="form__title">
                            <?php esc_html_e( 'Ship to a different address?', 'saleszone' ); ?>
                        </span>
                    </span>
                </label>
            </div>

            <!-- Shipping address fields-->
            <div class="shipping_address">
                <?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>
                <div class="woocommerce-shipping-fields__field-wrapper">
                    <?php $fields = $checkout->get_checkout_fields( 'shipping' );
                    foreach ($fields as $key => $field) {
                        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                    } ?>
                </div>
                <?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Order notes -->
    <div class="form__field woocommerce-additional-fields">

        <?php if(has_action('woocommerce_before_order_notes')) : ?>
            <div class="form__field">
                <?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>
            </div>
        <?php endif; ?>

        <?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
            <?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>
                <div class="form__field">
                    <h3 class="form__title">
                        <?php esc_html_e( 'Additional information', 'saleszone' ); ?>
                    </h3>
                </div>
            <?php endif; ?>
            <div class="woocommerce-additional-fields__field-wrapper">
                <?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) {
                    $field['class'][] = 'form__field form__field--hor form__field--hor-lg';
                    $field['label_class'][] = 'form__label';
                    $field['input_class'][] = 'form-control';

                    woocommerce_form_field($key, $field, $checkout->get_value($key));
                } ?>
            </div>
        <?php endif; ?>

        <?php if(has_action('woocommerce_after_order_notes')) : ?>
            <div class="form__field">
                <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
            </div>
        <?php endif; ?>

    </div>
</div>