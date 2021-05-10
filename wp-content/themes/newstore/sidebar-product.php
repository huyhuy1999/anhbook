<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NewSrore
 */

if (is_active_sidebar( 'woocommerce-product-sidebar' ) ):
if(is_product()):
?>
<aside id="secondary" class="sidebar-widget-area widget-area woocommerce-widget-area product-widget-area">
	<?php dynamic_sidebar( 'woocommerce-product-sidebar' ); ?>
</aside><!-- #secondary -->
<?php endif; ?>
<?php elseif(current_user_can( 'edit_theme_options' )): ?>
<aside id="secondary" class="sidebar-widget-area widget-area woocommerce-widget-area product-widget-area">
	<div class="woocommerce-product-sidebar sidebar-widget widget">
		<?php esc_html_e( 'This is Product Widget Area. You may add widget here from Customizer or Appearance -> Widgets. Or you may select full width layout for products in customier.', 'newstore' ); ?>
	</div>
</aside>
<?php endif; ?>