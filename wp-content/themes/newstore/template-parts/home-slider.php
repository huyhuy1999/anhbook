<div class="homepage-section space section-slider">
	<div class="container">
		<div class="section-slider-inner row">
			<div class="cats-menu-container d-none d-md-block">
				<h2 class="product-van-heading"><i class="fa fa-bars"></i> <span><?php esc_html_e( 'All Products', 'newstore' ); ?></span></h2>
				<div class="clearfix"></div>
				<?php 
					wp_nav_menu(array(
							'theme_location'    => 'product_catalog',
							'depth'             => 0,
							'container'         => 'div',
							'menu_class'        => 'product-catalogue-menu',
							'menu_id'           => 'product-catalogue-menu',
							'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
							'walker'            => new WP_Bootstrap_Navwalker(),
						));
				?>
			</div>
			<div class="slider-content">
				<?php if(function_exists('themefarmer_companion')): ?>
				<div class="slider-content-inner main-slider-carousel owl-carousel">
					<?php
						$slides = get_theme_mod('themefarmer_home_slider');
						$i = 1;
						if($slides){
							foreach ($slides as $key => $slide) {
								?>
								<div class="front-slider-item">
									<?php if(isset($slide['image'])): ?>
									<img src="<?php echo esc_url($slide['image']); ?>" class="img-responsive img-slide"/>
									<?php endif; ?>
									<div class="overlay"></div>
									<?php if(!empty($slide['heading']) || !empty($slide['description']) || !empty($slide['button_url'])): ?>
					               	<div class="carousel-caption">
					               		<?php if(isset($slide['heading']) && !empty($slide['heading'])): ?>
										<h1 class="slide-heading animation animated-item-1"> <?php echo wp_kses_post($slide['heading']); ?> </h1>
										<?php endif; ?>
										<?php if(isset($slide['description']) && !empty($slide['description'])): ?>
										<div class="clearfix"></div>
										<div class="slide-descriptin animation animated-item-2"><?php echo wp_strip_all_tags($slide['description']); ?></div>
										<?php endif; ?>								
										<?php if(!empty($slide['button_url'])): ?>
										<div class="clearfix"></div>
										<a href="<?php echo esc_url($slide['button_url']); ?>" class="btn btn-main-slide animation animated-item-3"> <?php echo esc_html($slide['button_text']); ?> </a>
										<?php endif; ?>
									</div>
									<?php endif ?>
								</div>
								<?php
							}
						}
					?>								
				</div>
				<?php endif; ?>
			</div>
			<div class="front-main-cats">
				<div class="front-main-cats-inner row">
					<?php for ($i=1; $i < 4; $i++): ?>
					<div class="front-main-cat-item col-lg-12 col-12 col-sm-4">
						<a href="<?php echo esc_url(get_theme_mod('newstore_frontpage_banner_link_'.$i)); ?>">
							<img src="<?php echo esc_url(get_theme_mod( 'newstore_frontpage_banner_'.$i )); ?>">
						</a>
					</div>
					<?php endfor; ?>
				</div>
			</div>
		</div>
	</div>
</div>