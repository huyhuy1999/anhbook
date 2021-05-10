<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="row">
    <div class="col-sm-6">
        <?php do_action( 'woocommerce_before_reset_password_form' ); ?>
        <form method="post" class="form woocommerce-ResetPassword lost_reset_password">

            <div class="form__field">
                <?php echo wp_kses_post(apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'saleszone' ) )); ?>
            </div>

            <!-- New password -->
            <?php woocommerce_form_field('password_1',array(
                'type' => 'password',
                'class' => array('form__field'),
                'label_class' => array('form__label'),
                'input_class'=> array('form-control'),
                'name' => 'password_1',
                'autocomplete' => 'new-password',
                'id' => 'password_1',
                'label' => __( 'New password', 'saleszone' ),
                'required' => true,
                'custom_attributes' => array('required' => 'required')
            )); ?>

            <!-- New password -->
            <?php woocommerce_form_field('password_2',array(
                'type' => 'password',
                'class' => array('form__field'),
                'label_class' => array('form__label'),
                'input_class'=> array('form-control'),
                'name' => 'password_2',
                'autocomplete' => 'new-password',
                'id' => 'password_2',
                'label' => __( 'Re-enter new password', 'saleszone' ),
                'required' => true,
                'custom_attributes' => array('required' => 'required')
            )); ?>

            <?php do_action( 'woocommerce_resetpassword_form' ); ?>

            <div class="form__field">

                <input type="hidden" name="wc_reset_password" value="true" />
                <input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
                <input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

                <button type="submit" class="btn btn-primary"
                        value="<?php esc_attr_e( 'Save', 'saleszone' ); ?>">
                    <?php esc_html_e( 'Save', 'saleszone' ); ?>
                </button>
            </div>

            <?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

        </form>
        <?php do_action( 'woocommerce_after_reset_password_form' ); ?>
    </div>
</div>