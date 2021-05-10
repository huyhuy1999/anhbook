<?php
/**
 * Single variation display
 *
 * This is a javascript-based template for single variations (see https://codex.wordpress.org/Javascript_Reference/wp.template).
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<script type="text/template" id="tmpl-variation-template">
</script>
<script type="text/template" id="tmpl-unavailable-variation-template">
    <p><?php esc_html_e('Sorry, this product is unavailable. Please choose a different combination.', 'saleszone' ); ?></p>
</script>