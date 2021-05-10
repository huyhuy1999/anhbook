<header id="masthead" class="site-header">
  	<div class="header-topbar">
		<div class="container">
			<div class="row">
				<div class="col-md-6 text-small-center text-left"><?php newstore_get_contact_block(); ?></div>
				<div class="col-md-6 text-small-center text-right">
					<?php 
						wp_nav_menu(array(
							'theme_location'    => 'top_nav',
							'depth'             => 1,
							'container'         => false,
							'menu_class'        => 'topbar-menu',
							'menu_id'           => 'topbar-menu',
						));
					?>
					<?php newstore_get_social_block(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="header-middle">
		<div class="container">
		<?php 
			if(class_exists('WooCommerce')){
				get_template_part( 'template-parts/header-middle', 'wc' );
			} else{
				get_template_part( 'template-parts/header-middle', 'wp' );
			}
		?>
		</div>
	</div>
	<div class="header-main">
    	<div class="container">
        	<div class="primary-menu-container">
        		<nav id="site-navigation" class="main-navigation navbar navbar-expand-md navbar-light row" role="navigation">					  	
					<div class="navbar-header sm-order-2">
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
							'container_class'   => 'collapse navbar-collapse col-md-10 mx-auto sm-order-last',
							'container_id'      => 'TF-Navbar',
							'menu_class'        => 'nav navbar-nav primary-menu',
							'menu_id'           => 'primary-menu',
							'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
							'walker'            => new WP_Bootstrap_Navwalker(),
						));
					?>
					<div class="header-my-account-btn col-4 col-md-2 col-sm-4 text-right sm-order-first">
						<?php 
							if(function_exists('newstore_get_page_links_dropdown')){
								echo newstore_get_page_links_dropdown();
							}
						?>
					</div>
				</nav><!-- #site-navigation -->
            </div>
        </div>
    </div>
    <?php if(get_theme_mod( 'newstore_sticky_header_enable', true )): ?>
    <div id="sticky-header-container"></div>
	<?php endif; ?>
</header><!-- #masthead -->