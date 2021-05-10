<?php
/**
 * Edit account form
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<?php do_action( 'woocommerce_before_edit_account_form' ); ?>

<form action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>
    <div class="row row--ib row--vindent-m">
        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="frame">
                <div class="frame__header">
                    <div class="frame__title">
                        <?php esc_html_e( 'Personal information', 'saleszone' ); ?>
                    </div>
                </div>
                <div class="frame__inner">
                    <div class="form form--bg">
                        <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

                        <?php echo wp_kses_post(saleszone_social_links_buttons()); ?>

                        <?php woocommerce_form_field('account_first_name',array(
                            'type' => 'text',
                            'class' => array('form__field'),
                            'label_class' => array('form__label'),
                            'input_class'=> array('form-control'),
                            'name' => 'account_first_name',
                            'required' => true,
                            'custom_attributes' => array('required' => 'required'),
                            'label' => __( 'First name', 'saleszone' )
                        ),$user->first_name); ?>

                        <?php woocommerce_form_field('account_last_name',array(
                            'type' => 'text',
                            'class' => array('form__field'),
                            'label_class' => array('form__label'),
                            'input_class'=> array('form-control'),
                            'name' => 'account_last_name',
                            'required' => true,
                            'custom_attributes' => array('required' => 'required'),
                            'label' => __( 'Last name', 'saleszone' )
                        ),$user->last_name); ?>

                        <?php woocommerce_form_field('account_display_name',array(
                            'type' => 'text',
                            'class' => array('form__field'),
                            'label_class' => array('form__label'),
                            'input_class'=> array('form-control'),
                            'name' => 'account_display_name',
                            'required' => true,
                            'custom_attributes' => array('required' => 'required'),
                            'label' => __( 'Display name', 'saleszone' )
                        ),$user->display_name); ?>

                        <?php woocommerce_form_field('account_email',array(
                            'type' => 'email',
                            'class' => array('form__field'),
                            'label_class' => array('form__label'),
                            'input_class'=> array('form-control'),
                            'name' => 'account_email',
                            'required' => true,
                            'custom_attributes' => array('required' => 'required'),
                            'label' => __( 'Email address', 'saleszone' )
                        ),$user->user_email); ?>
                        <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
                        <div class="form__field">
                            <button class="btn btn-primary" type="submit">
                                <?php esc_attr_e( 'Save changes', 'saleszone' ); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="frame">
                <div class="frame__header">
                    <div class="frame__title">
                        <?php esc_html_e( 'Password change', 'saleszone' ); ?>
                    </div>
                </div>
                <div class="frame__inner">
                    <div class="form form--bg">

                        <?php woocommerce_form_field('password_current',array(
                            'type' => 'password',
                            'class' => array('form__field', 'form__field--hide-optional-label'),
                            'label_class' => array('form__label'),
                            'input_class'=> array('form-control'),
                            'name' => 'password_current',
                            'autocomplete' => 'off',
                            'label' => __( 'Current password (leave blank to leave unchanged)', 'saleszone' )
                        )); ?>

                        <?php woocommerce_form_field('password_1',array(
                            'type' => 'password',
                            'class' => array('form__field', 'form__field--hide-optional-label'),
                            'label_class' => array('form__label'),
                            'input_class'=> array('form-control'),
                            'name' => 'password_1',
                            'autocomplete' => 'off',
                            'label' => __( 'New password (leave blank to leave unchanged)', 'saleszone' )
                        )); ?>

                        <?php woocommerce_form_field('password_2',array(
                            'type' => 'password',
                            'class' => array('form__field', 'form__field--hide-optional-label'),
                            'label_class' => array('form__label'),
                            'input_class'=> array('form-control'),
                            'name' => 'password_2',
                            'autocomplete' => 'off',
                            'label' => __( 'Confirm new password', 'saleszone' )
                        )); ?>

                        <?php do_action( 'woocommerce_edit_account_form' ); ?>

                        <div class="form__field">
                            <button class="btn btn-primary" type="submit">
                                <?php esc_attr_e( 'Save changes', 'saleszone' ); ?>
                            </button>
                            <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
                            <input type="hidden" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'saleszone' ); ?>" />
                            <input type="hidden" name="action" value="save_account_details" />
                        </div>

                        <?php do_action( 'woocommerce_edit_account_form_end' ); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>

