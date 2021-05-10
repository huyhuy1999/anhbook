<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NewSrore
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer footer">
		<?php if ( is_active_sidebar( 'footer-widget-area-col-1') ||is_active_sidebar( 'footer-widget-area-col-2') ||is_active_sidebar( 'footer-widget-area-col-3') ||is_active_sidebar( 'footer-widget-area-col-4')): ?>
		<div class="footer-widgets">
			<div class="container">
				<div class="row">
					<?php 
						for ($i=1; $i <= 4; $i++){
							if (is_active_sidebar( 'footer-widget-area-col-'.$i) ){
								echo '<div class="footer-widget-column col-md-3 col-sm-6">';
								dynamic_sidebar( 'footer-widget-area-col-'.$i);
								echo '</div>';
							}
						}
					?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="footer-site-info site-info text-center">
			<div class="container">
				<span class="copy-text">
				<?php 
					printf(esc_html__( 'Copyright &copy; %1$s %2$s All Right Reserved.', 'newstore' ), esc_html(date_i18n(__('Y', 'newstore'))), get_bloginfo( 'name', 'display')); 
				?>
				</span>
				<span class="sep">|</span>
				<?php
					/* translators: 1: Theme name, 2: Theme author. */
					printf( esc_html__( 'Theme: %1$s by %2$s', 'newstore' ), 'NewStore', '<a href="'.esc_url('https://www.themefarmer.com').'">ThemeFarmer</a>' );
				?>
				<span class="sep">|</span>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'newstore' ) ); ?>">
					<?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'newstore' ), 'WordPress' );
					?>
				</a>
			</div>
		</div><!-- .site-info -->
		<a href="#" id="scroll-top" style="display: none;"><i class="fa fa-angle-up"></i></a>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
