<?php 
	global $product, $post;
	?>
	<a href="<?php echo esc_url($product->get_permalink()) ?>" class="button tfwctool-quick-view-button" data-product_id="<?php the_ID(); ?>">
		<?php echo wp_kses_post($icon); echo wp_kses_post($button_label);?>
	</a>
<?php
	