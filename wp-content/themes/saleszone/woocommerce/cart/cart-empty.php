<?php
/**
 * Empty cart page
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>

<?php if (wc_get_notices()): ?>
    <div class="content__row">
        <?php wc_print_notices(); ?>
    </div>
<?php endif; ?>

<div class="content__row">
    <div class="typo">
        <?php
        /**
         * @hooked wc_empty_cart_message - 10
         */
        do_action('woocommerce_cart_is_empty');
        ?>
    </div>
</div>

<?php if (wc_get_page_id('shop') > 0) : ?>
    <div class="content__row">
        <a class="btn btn-primary"
           href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
            <?php esc_html_e('Continue Shopping', 'saleszone'); ?>
        </a>
    </div>
<?php endif; ?>
