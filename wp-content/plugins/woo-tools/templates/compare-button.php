<?php 
	global $product, $post;
	$product_id = $product->get_id();
	?>
	<a href="<?php echo esc_url( add_query_arg( 'add-to-compare', $product_id ) )?>" class="button tfwctool-add-to-compare tfwctool-add-to-compare-ajax" data-product_id="<?php the_ID(); ?>" rel="nofollow">
		<?php echo wp_kses_post($icon); echo wp_kses_post($button_label);?>
	</a>
<?php
