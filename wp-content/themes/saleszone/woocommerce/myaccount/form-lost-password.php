<?php
/**
 * Lost password form
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

wc_print_notices(); ?>
<div class="row">
    <div class="col-sm-6">
        <?php do_action( 'woocommerce_before_lost_password_form' ); ?>
        <form method="post" class="form woocommerce-ResetPassword lost_reset_password">

            <p><?php echo esc_html(apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'saleszone' ) )); ?></p>

            <!-- Username field -->
            <?php wc_get_template('../parts/forms/input-base.php',array(
                'type' => 'text',
                'label' => esc_html__( 'Username or email address', 'saleszone' ),
                'name' => 'user_login',
                'required' => true
            )); ?>

            <?php do_action( 'woocommerce_lostpassword_form' ); ?>

            <div class="form__field">
                <input type="hidden" name="wc_reset_password" value="true" />
                <input type="hidden" class="woocommerce-Button button" value="<?php esc_attr_e( 'Reset password', 'saleszone' ); ?>" />
                <button class="btn btn-primary">
                    <?php esc_attr_e( 'Reset password', 'saleszone' ); ?>
                </button>
            </div>

            <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

        </form>
        <?php do_action( 'woocommerce_after_lost_password_form' ); ?>
    </div>
</div>