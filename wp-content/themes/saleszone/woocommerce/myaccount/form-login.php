<?php
/**
 * Login Form
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if(saleszone_is_plugin_active('nextend-facebook-connect/nextend-facebook-connect.php')) :?>
    <div class="content__row content__row--sm">
        <?php wc_get_template('../parts/integrations/nsl-socauth/nsl-socauth.php'); ?>
    </div>
<?php endif; ?>

<div class="content__row">
    <div class="row row--ib row--vindent-m">
        <section class="col-sm-6 col-xs-12">
            <?php wc_get_template_part('myaccount/form-login','part-login'); ?>
        </section>

        <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
            <section class="col-sm-6 col-xs-12">
                <?php wc_get_template_part('myaccount/form-login','part-register'); ?>
            </section>
        <?php endif; ?>
    </div>

    <?php do_action( 'woocommerce_after_customer_login_form' ); ?>
</div>
