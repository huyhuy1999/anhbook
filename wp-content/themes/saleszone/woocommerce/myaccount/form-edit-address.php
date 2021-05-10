<?php
/**
 * Edit address form
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_title = ( 'billing' === $load_address ) ? __( 'Billing address', 'saleszone' ) : __( 'Shipping address', 'saleszone' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address ) : ?>
    <?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

    <div class="frame">
        <div class="frame__header">
            <div class="frame__title">
                <?php echo esc_html(apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address )); ?>
            </div>
        </div>
        <div class="frame__inner woocommerce-address-fields">
            <form class="form form--bg" method="post">
                <?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>
                <div class="woocommerce-address-fields__field-wrapper">

                    <?php
                    foreach ( $address as $key => $field ) {
                        woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
                    }
                    ?>

                    <div class="form-row form-row-wide form__field">
                        <button class="btn btn-primary" type="submit">
                            <?php esc_attr_e( 'Save address', 'saleszone' ); ?>
                        </button>
                        <input type="hidden" class="button" name="save_address" value="<?php esc_attr_e( 'Save address', 'saleszone' ); ?>" />
                        <?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
                        <input type="hidden" name="action" value="edit_address" />
                    </div>

                    <?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>
                </div>
            </form>
        </div>
    </div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
