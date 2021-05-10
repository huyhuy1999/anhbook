<?php
/**
 * Output a single payment method
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<li class="payments-radio__list-item wc_payment_method payment_method_<?php echo $gateway->id; ?>" data-payments-radio--item>
    <div class="payments-radio__control">
        <input id="payment_method_<?php echo $gateway->id; ?>"
               type="radio"
               class="input-radio"
               name="payment_method"
               value="<?php echo esc_attr( $gateway->id ); ?>"
               data-payments-radio--control
            <?php checked( $gateway->chosen, true ); ?>
               data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
    </div>
    <div class="payments-radio__body">
        <label class="payments-radio__title" for="payment_method_<?php echo esc_attr($gateway->id); ?>">
            <?php echo esc_html($gateway->get_title()); ?>
        </label>

        <?php if ( $gateway->has_fields() || $gateway->get_description() || $gateway->get_icon() != '' ) : ?>
            <div class="payments-radio__description payment_box payment_method_<?php echo esc_attr($gateway->id); ?>" data-payments-radio--description>
                <?php if($gateway->get_icon() != ''):?>
                    <div class="payments-radio__payments-logo">
                        <?php echo $gateway->get_icon(); ?>
                    </div>
                <?php endif; ?>
                <?php $gateway->payment_fields(); ?>
            </div>
        <?php endif; ?>
    </div>
</li>
