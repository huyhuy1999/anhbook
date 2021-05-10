<header id="masthead" class="site-header small-header">
  	<div class="header-topbar">
		<div class="container">
			<div class="row">
				<div class="col-md-6 text-small-center text-left"><?php newstore_get_contact_block(); ?></div>
				<div class="col-md-6 text-small-center text-right">
					<?php 
						wp_nav_menu(array(
							'theme_location'    => 'top_nav',
							'depth'             => 1,
							'container'         => 'div',
							'menu_class'        => 'topbar-menu',
							'menu_id'           => 'topbar-menu',
						));
					?>
					<?php newstore_get_social_block(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="header-main">
    	<div class="container">
    		<div class="primary-menu-container row">
    			<div class="header-branding col-md-3 text-sm-center">
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
				<div class="col">
	        		<nav id="site-navigation" class="main-navigation navbar navbar-expand-md navbar-light row" role="navigation">
						<div class="navbar-header">
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#TF-Navbar" aria-controls="TF-Navbar" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'newstore'); ?>">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<?php
							wp_nav_menu(array(
								'theme_location'    => 'primary',
								'depth'             => 0,
								'container'         => 'div',
								'container_class'   => 'collapse navbar-collapse col-md-12',
								'container_id'      => 'TF-Navbar',
								'menu_class'        => 'nav navbar-nav primary-menu',
								'menu_id'           => 'primary-menu',
								'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
								'walker'            => new WP_Bootstrap_Navwalker(),
							));
						?>
					</nav><!-- #site-navigation -->
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
    <?php if(get_theme_mod( 'newstore_sticky_header_enable', true )): ?>
    <div id="sticky-header-container"></div>
	<?php endif; ?>
</header><!-- #masthead -->