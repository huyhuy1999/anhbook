<div class="row align-items-center">
	<div class="header-branding col-md-4 col-sm-12 text-sm-center mx-auto">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() || is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$newstore_description = get_bloginfo( 'description', 'display' );
			if ( $newstore_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $newstore_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
	</div>
	<div class="header-search-and-cart col-md-8 col-sm-12 sm-text-center mx-auto">
		<div class="row">
			<div class="col header-wcsearch-form-container mx-auto">
				<?php get_template_part( 'searchform-product'); ?>
			</div>
			<div class="header-cart-withlist-links-container text-right text-md-right text-sm-center mx-auto">
				<div class="header-cart-withlist-links-container-inner">
					<div class="header-wishlist-container">
						<?php newstore_tfwctool_wishlist_link(); ?>
					</div>
					<div class="header-cart-container">
						<?php newstore_woocommerce_header_cart(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>