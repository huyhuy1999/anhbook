<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NewSrore
 */

if (is_active_sidebar( 'woocommerce-sidebar' ) ):
?>
<aside id="secondary" class="sidebar-widget-area widget-area woocommerce-widget-area order-first">
	<?php dynamic_sidebar( 'woocommerce-sidebar' ); ?>
</aside><!-- #secondary -->
<?php else: ?>
<aside id="secondary" class="sidebar-widget-area widget-area woocommerce-widget-area order-first">
	<div class="woocommerce-widget sidebar-widget widget">
		<?php esc_html_e( 'This is a WooCommerce Widget Area. You may add widget here from Customizer or Appearance -> Widgets. Or to hide this you may select full width layout for shop in customier.', 'newstore' ); ?>
	</div>
</aside>
<?php endif; ?>
