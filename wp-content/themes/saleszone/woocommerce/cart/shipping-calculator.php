<?php
/**
 * Shipping Calculator
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="shipping-calculator">
    <?php do_action( 'woocommerce_before_shipping_calculator' ); ?>

    <form class="shipping-calculator__form woocommerce-shipping-calculator"
          action="<?php echo esc_url( wc_get_cart_url() ); ?>"
          method="post">

        <div class="shipping-calculator__header">
            <button class="shipping-calculator__button btn btn-default shipping-calculator-button">
                <?php saleszone_the_svg('delivery-truck','shipping-calculator__button-icon') ?>
                <span class="shipping-calculator__text-el">
                    <?php if($button_text){
                        echo esc_html($button_text);
                    } else {
                        esc_html_e( 'Calculate shipping', 'saleszone' );
                    } ?>
                </span>
            </button>
        </div>

        <ul class="form shipping-calculator__body shipping-calculator-form">

            <!-- Countries fields -->
            <li class="form__field form-row form-row-wide" id="calc_shipping_country_field">
                <div class="form__label">
                    <?php esc_html_e( 'Select a country&hellip;', 'saleszone' ); ?>
                </div>
                <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state country_select" rel="calc_shipping_state">
                    <option value=""><?php esc_html_e( 'Select a country&hellip;', 'saleszone' ); ?></option>
                    <?php foreach ( WC()->countries->get_shipping_countries() as $key => $value ) :?>
                        <option value="<?php echo esc_attr( $key ); ?>"  <?php echo selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ); ?> >
                            <?php echo esc_html( $value ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </li>

            <!-- State / County fields -->
            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_state', true ) ) : ?>
            <li class="form__field form-row form-row-wide" id="calc_shipping_state_field">
                <?php
                $current_cc = WC()->customer->get_shipping_country();
                $current_r  = WC()->customer->get_shipping_state();
                $states     = WC()->countries->get_states( $current_cc );
                ?>
                <div class="form__label">
                    <?php esc_html_e( 'State / County', 'saleszone' ); ?>
                </div>
                <?php if ( is_array( $states ) && empty( $states ) ) : ?>
                    <input type="hidden"
                           name="calc_shipping_state"
                           id="calc_shipping_state"
                           placeholder="<?php esc_attr_e( 'State / County', 'saleszone' ); ?>" />
                <?php elseif(is_array( $states )) : ?>
                    <span>
                        <select name="calc_shipping_state" class="state_select" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'State / County', 'saleszone' ); ?>">
							<option value=""><?php esc_html_e( 'Select a state&hellip;', 'saleszone' ); ?></option>
                            <?php foreach ( $states as $ckey => $cvalue ) : ?>
                                <option value="<?php esc_attr( $ckey ); ?>" <?php echo selected( $current_r, $ckey, false ); ?>>
                                    <?php echo esc_html( $cvalue ) ?>
                                </option>
                            <?php endforeach; ?>
						</select>
                    </span>
                <?php else: ?>
                    <input type="text" class="form-control" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_attr_e( 'State / County', 'saleszone' ); ?>" name="calc_shipping_state" id="calc_shipping_state" />
                <?php endif; ?>
            </li>
            <?php endif; ?>

            <!-- City field -->
            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>
                <li class="form__field" id="calc_shipping_city_field">
                    <div class="form__label">
                        <?php esc_html_e( 'City', 'saleszone' ); ?>
                    </div>
                    <input type="text" class="form-control" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_attr_e( 'City', 'saleszone' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
                </li>
            <?php endif; ?>

            <!-- Postcode  field -->
            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>
                <li class="form__field" id="calc_shipping_postcode_field">
                    <div class="form__label">
                        <?php esc_html_e( 'Postcode / ZIP', 'saleszone' ); ?>
                    </div>
                    <input type="text" class="form-control" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_attr_e( 'Postcode / ZIP', 'saleszone' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
                </li>
            <?php endif; ?>

            <!-- Update totals -->
            <li class="form__field">
                <button type="submit" name="calc_shipping" value="1" class="button btn btn-primary">
                    <?php esc_html_e( 'Update totals', 'saleszone' ); ?>
                </button>
            </li>
        </ul>

        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
    </form>

    <?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
</div>





