<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text = '';

?>

<li class="cart-totals__item">
    <div class="cart-totals__label">
        <?php echo wp_kses_post($package_name); ?>
    </div>
    <div class="cart-totals__value">
        <div class="shipping">
            <div class="shipping-methods <?php echo is_checkout() ? 'shipping-methods--checkout':'' ?>" data-title="<?php echo esc_attr($package_name); ?>">

                <?php if ($available_methods) : ?>
                    <ul class="shipping-methods__list" id="shipping_method">
                        <?php foreach ($available_methods as $method) : ?>
                            <li class="shipping-methods__item">
                                <div class="shipping-methods__field">
                                    <input class="shipping-methods__control shipping_method"
                                           type="radio"
                                           name="shipping_method[<?php echo esc_attr($index); ?>]"
                                           data-index="<?php echo esc_attr($index); ?>"
                                           id="shipping_method_<?php echo esc_attr($index); ?>_<?php echo esc_attr(sanitize_title($method->id)); ?>"
                                           value="<?php echo esc_attr($method->id); ?>"
                                        <?php echo checked($method->id, $chosen_method, false); ?> />
                                    <label class="shipping-methods__title"
                                           for="shipping_method_<?php echo esc_attr($index); ?>_<?php echo esc_attr(sanitize_title($method->id)); ?>">
                                        <?php echo wp_kses_post(wc_cart_totals_shipping_method_label($method)); ?>
                                    </label>
                                </div>
                                <?php
                                if (has_action('woocommerce_after_shipping_rate')): ?>
                                    <div class="shipping-methods__after-field">
                                        <?php do_action('woocommerce_after_shipping_rate', $method, $index); ?>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- shipping-methods if $available_methods == 1 -->
                    <?php if ( is_cart() ) : ?>
                        <p class="woocommerce-shipping-destination">
                            <?php
                            if ( $formatted_destination ) {
                                // Translators: $s shipping destination.
                                printf( esc_html__( 'Estimate for %s.', 'saleszone' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' );
                                $calculator_text = __( 'Change address', 'saleszone' );
                            } else {
                                echo esc_html__( 'This is only an estimate. Prices will be updated during checkout.', 'saleszone' );
                            }
                            ?>
                        </p>
                    <?php endif; ?>
                <?php elseif (! $has_calculated_shipping || ! $formatted_destination) :
                    esc_html_e( 'Enter your address to view shipping options.', 'saleszone' );
                elseif ( ! is_cart() ) :
                    echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping methods available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'saleszone' ) ) );
                else :
                    // Translators: $s shipping destination.
                    echo wp_kses_post( apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'saleszone' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ) ) );
                    $calculator_text = __( 'Enter a different address', 'saleszone' );
                endif; ?>

                <?php if ($show_package_details) : ?>
                    <?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html($package_details) . '</small></p>'; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</li>

<!--  shipping_calculator  -->
<?php if( $show_shipping_calculator ) :?>
    <li class="cart-totals__item cart-totals__item--shipping-calculator">
        <?php woocommerce_shipping_calculator($calculator_text); ?>
    </li>
<?php endif; ?>