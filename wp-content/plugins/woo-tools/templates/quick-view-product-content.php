<?php 
while ( have_posts() ) : the_post(); ?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('wcaqv-product product'); ?>>
		<div class="product-thumb img-thumbnail">
			<?php do_action('tfwctool_quick_view_product_thumbnail') ?>
		</div>
		<div class="product-content entry-summary">
				<div class="wcaqv-details">
					<?php do_action('tfwctool_quick_view_product_details'); ?>
				</div>
				<div class="wcaqv-actions">
					<?php do_action('tfwctool_quick_view_product_actions'); 
					?>
				</div>
		</div>
</div>
<?php endwhile; // end of the loop. ?>