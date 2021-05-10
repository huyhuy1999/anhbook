<?php
/**
 * My Account page
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="pc-frame-profile">
    <div class="pc-frame-profile__row">
        <div class="pc-frame-profile__sidebar">
            <div class="content__row content__row--sm">
                <?php wc_get_template_part('myaccount/my-account','user'); ?>
            </div>
            <div class="content__row content__row--sm">
                <?php do_action( 'woocommerce_account_navigation' ); ?>
            </div>
        </div>
        <div class="pc-frame-profile__body">

            <?php wc_print_notices(); ?>

            <?php do_action( 'woocommerce_account_content' ); ?>

        </div>
    </div>
</div>