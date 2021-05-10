<?php
/**
 * Single Product stock.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
<div class="stock <?php echo esc_attr($class); ?>">
    <?php echo wp_kses_post($availability); ?>
</div>