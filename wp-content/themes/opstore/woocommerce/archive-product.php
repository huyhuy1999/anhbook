<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce_loop;

get_header(); 


$banner_enable = get_theme_mod('opstore_page_banner_show','show');
if( $banner_enable == 'show' ){
    opstore_title_banner();
}
?>

	<?php			
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
  <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
    <header class="woocommerce-products-header">

		<h1 class="woocommerce-products-header__title page-title">
			<?php woocommerce_page_title(); ?>
		</h1>

		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>
    </header>
    <?php endif; ?>
		<?php
		$container_class = 'col-md-12 col-sm-12 col-xs-12';
		$sidebar_position = get_theme_mod('opstore_shop_sidebar_layout','rightsidebar');
		$opstore_shop_sidebar = get_theme_mod('opstore_shop_sidebar','shop-sidebar');

		if( ($sidebar_position != 'nosidebar') && is_active_sidebar($opstore_shop_sidebar) ) {

			$container_class = 'primary-content col-md-9 col-sm-8 col-xs-12';
		}

		if( $sidebar_position === 'leftsidebar' ) {
			$container_class .= ' pull-right';
		}
		?>

    	<div class="<?php echo esc_attr( $container_class ); ?> view-grid">
			<?php if ( have_posts() ) : ?>
				<?php if( ! is_search() ): ?>
					<?php echo wc_print_notices();?>
					<div class="opstore-sorting opstore-sorting clearfix">
						<?php
							/**
							 * woocommerce_before_shop_loop hook.
							 *
							 * @hooked wc_print_notices - 10
							 * @hooked woocommerce_result_count - 20
							 * @hooked woocommerce_catalog_ordering - 30
							 */
							do_action( 'woocommerce_before_shop_loop' );
						?>
					</div>
				<?php endif; ?>

				<?php woocommerce_product_loop_start(); ?>

					<?php woocommerce_product_subcategories(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/**
							 * woocommerce_shop_loop hook.
							 *
							 * @hooked WC_Structured_Data::generate_product_data() - 10
							 */
							do_action( 'woocommerce_shop_loop' );
						?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>

				<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
				?>

			<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

				<?php
					/**
					 * woocommerce_no_products_found hook.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action( 'woocommerce_no_products_found' );
				?>

			<?php endif; ?>

		</div>

		<?php 
		// only display if it's enabled from theme options
		if( ($sidebar_position != 'nosidebar')  && is_active_sidebar($opstore_shop_sidebar)):
			?>
			<aside class="sidebar shop-sidebar col-sm-4 col-md-3 col-xs-12">
				<?php
                   get_sidebar();
				?>
			</aside>
			<?php
		endif;
		?>
		

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	

<?php get_footer( 'shop' ); ?>
