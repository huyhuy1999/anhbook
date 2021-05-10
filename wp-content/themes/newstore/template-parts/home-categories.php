<?php if(class_exists('WooCommerce')): ?>
<div class="homepage-section section-banners">
	<div class="container">
		<div class="row justify-content-center">
			<?php for ($i=1; $i <= 5; $i++):?>
				<?php 
					$acat_id = absint( get_theme_mod( 'newstore_frontpage_cat_id_'.$i) );
					if($acat_id > 0):
						$prod_cat = get_term($acat_id);
						if($prod_cat && isset($prod_cat->term_id) && absint( $prod_cat->term_id ) > 0):
							$cat_thumb_id = get_term_meta( $prod_cat->term_id, 'thumbnail_id', true );
					        $cat_img = wp_get_attachment_image_url($cat_thumb_id, 'newstore_woocommerce_single_thumb' );
							if(empty($cat_img)){
					        	$cat_img= wc_placeholder_img_src( 'newstore_woocommerce_single_thumb' );
					        }
					        $term_link = get_term_link($acat_id, 'product_cat' );
							?>
							<div class="col col-md-20 col-sm-4 col-12  featured-category-item">
								<a class="featured-category-item-inner" href="<?php echo esc_url($term_link); ?>">
									<img src="<?php echo esc_url($cat_img); ?>" class="img-responsive" alt="<?php echo esc_attr( $prod_cat->name ); ?>">
									<div class="overlay">
										<div class="overlay-inner align-middle">
											<h3 class="term-name"><?php echo esc_html( $prod_cat->name ); ?></h3>
											<div class="term-meta">
												<span><span class="label"><?php esc_html_e( 'Items', 'newstore' ); ?></span> <span class="count"><?php echo absint( $prod_cat->count); ?></span></span>
											</div>
										</div>
									</div>
								</a>	
							</div>
		    			<?php 
		    			endif; 
		    		endif; 
		    	endfor; 
		    ?>				
		</div>
	</div>
</div>
<?php endif; ?>