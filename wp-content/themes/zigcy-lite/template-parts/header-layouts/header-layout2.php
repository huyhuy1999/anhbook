<header id="masthead" class="site-header header-two">
		<div class="container">
			
			<div class ="store-mart-lite-logos">
				<?php do_action('zigcy_lite_header_logo'); ?>
				<div class="store-mart-lite-header-wrap">
					<div class="store-mart-lite-header-icons">
						<?php do_action('zigcy_lite_top_left_header'); ?>
						<?php do_action('zigcy_lite_top_right_header'); ?>
					</div>
					<div class="store-mart-lite-product-cat">
						<?php //do_action('zigcy_lite_product_cat_menu'); ?>
						<?php do_action('zigcy_lite_main_navigation'); ?>
					</div>
				</div>

				<div class="store-mart-lite-login-wrap">
					<?php echo zigcy_lite_header_search_icon(); // WPCS: XSS OK. ?>
					<?php echo zigcy_lite_login_signup(); // WPCS: XSS OK. ?>
					<?php echo zigcy_lite_wishlist_header_count(); // WPCS: XSS OK. ?>
					<?php echo zigcy_lite_woo_cart_icon(); // WPCS: XSS OK. ?>
				</div>
				
			</div>
			
		</div>
	
	</header><!-- #masthead -->