<?php 
function themefarmer_homepage_section_slider() {
	?>
	<div class="slider-section section-slider">
		<div class="home-slider">
			<div class="home-carousel owl-carousel">
				<?php
					$slides = get_theme_mod('themefarmer_home_slider');
					$i = 1;
					if($slides){
						foreach ($slides as $key => $slide) {
							?>
							<div class="owl-slide">
								<?php 
									if(isset($slide['image'])):
										$slide_img = $slide['image'];
								 	else:
								 		$slide_img = get_template_directory_uri().'/images/slide'.$i.'.jpg';
									endif; 
								?>
								<img src="<?php echo esc_url($slide_img); ?>" class="img-responsive img-slide"/>
								<div class="overlay"></div>
				               	<div class="carousel-caption">
				               		<?php if(isset($slide['heading'])): ?>
									<h1 class="slider-heading animation animated-item-1"> <?php echo esc_html($slide['heading']); ?> </h1>
									<?php endif; ?>
									<?php if(isset($slide['description'])): ?>
									<div class="slider-desc animation animated-item-2"><?php echo wp_strip_all_tags($slide['description']); ?></div>
									<?php endif; ?>								
									<?php if(!empty($slide['button1_url'])): ?>
									<a href="<?php echo esc_url($slide['button1_url']); ?>" class="btn animation animated-item-3 banner-link"> <?php echo esc_html($slide['button1_text']); ?> </a>
									<a href="<?php echo esc_url($slide['button2_url']); ?>" class="btn animation animated-item-3 banner-link slide-bt-2"> <?php echo esc_html($slide['button2_text']); ?> </a>
									<?php endif; ?>
								</div>
							</div>
							<?php
							if($i == 2){ $i = 0; }
							$i++;
						}
					}
				?>
			</div>			
		</div>
	</div>
	<?php
}

function themefarmer_homepage_section_services() {
	?>
	<div class="home-section space section-services">
		<div class="home-section-bg section-services"></div>
		<div class="container">
	        <div class="section-heading">
	            <h2 class="section-title"><?php echo esc_html(get_theme_mod('themefarmer_home_services_heading')); ?></h2>
	            <p class="section-description"><?php echo esc_html(get_theme_mod('themefarmer_home_services_desc')); ?></p>
	        </div>
	        <div class="row section-details services-details">
	        	<?php $services = get_theme_mod('themefarmer_home_services'); ?>
	        	<?php if($services): foreach ($services as $key => $service): ?>
	            <div class="col-md-4 col-sm-6 col-xs-6 service-item" style="color:<?php echo isset($service['color'])?esc_attr($service['color']):''; ?>">
	                <div class="service-item-inner">
	                    <div class="service-inner-info">
	                        <div class="service-icon">
	                            <i class="fa <?php echo esc_attr($service['icon']); ?>"></i>
	                        </div>
	                        <div class="service-info">
	                            <h3 class="sub-section-title service-title"><?php echo esc_html($service['heading']); ?></h3>
	                            <p class="sub-section-description service-description"><?php echo esc_html($service['description']); ?></p>
	                            <?php $page_link = (absint($service['page_id']) > 0)?get_permalink(absint($service['page_id'])):$service['button_url']; ?>
	                            <?php if(!empty($page_link)): ?>
	                            <a class="btn btn-read-more" href="<?php echo esc_url($page_link); ?>"><?php echo esc_html($service['button_text']); ?></a>
	                            <?php endif; ?>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <?php endforeach; endif; ?>
	        </div>
	    </div>
	</div>
	<?php
}

function themefarmer_homepage_section_team() {
	?>
	<div class="home-section space section-team">
		<div class="home-section-bg section-team"></div>
	    <div class="container">
	        <div class="section-heading">
	            <h2 class="section-title"><?php echo esc_html(get_theme_mod('themefarmer_home_team_heading')); ?></h2>
	            <p class="section-description"><?php echo esc_html(get_theme_mod('themefarmer_home_team_desc')); ?></p>
	        </div>
	        <div class="section-details row team-details">
	        	<?php $team = get_theme_mod('themefarmer_home_team'); ?>
	        	<?php if($team): foreach ($team as $key => $member): ?>
	            <div class="col-md-3 col-sm-6 col-xs-6 member-item">
	                <div class="meamber-item-inner">
	                    <div class="meamber-image">
	                        <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
	                    </div>
	                    <div class="meamber-info">
	                        <?php if(!empty($member['button_url'])): ?>
	                            <a href="<?php echo esc_url($member['button_url']) ?>">
	                                <h3 class="sub-section-title  member-title"><?php echo esc_html($member['name']); ?></h3>       
	                            </a>
	                        <?php else: ?>
	                            <h3 class="sub-section-title  member-title"><?php echo esc_html($member['name']); ?></h3>
	                        <?php endif; ?>
	                        <h6 class="member-designation"><?php echo esc_html($member['designation']); ?></h6>
	                        <p class="member-description"><?php echo esc_html($member['description']); ?></p>
	                        <div class="member-icons">
	                            <ul>
	                                <?php if($member['socials']): foreach ($member['socials'] as $key => $item): if(!empty($item['link'])):?>
	                                <li><a href="<?php echo esc_url($item['link']); ?>"> <i class="fa <?php echo esc_attr($item['icon']); ?>"></i> </a></li>
	                                <?php endif; endforeach; endif; ?>
	                            </ul>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <?php endforeach; endif; ?>
	        </div>
	    </div>
	</div>
	<?php
}

function themefarmer_homepage_section_testimonials() {
	?>
	<div class="home-section space section-testimonials">
		<div class="home-section-bg section-testimonials"></div>
	    <div class="container">
	        <div class="section-heading">
	            <h2 class="section-title"><?php echo esc_html(get_theme_mod('themefarmer_home_testimonials_heading')); ?></h2>
	            <p class="section-description"><?php echo esc_html(get_theme_mod('themefarmer_home_testimonials_desc')); ?></p>
	        </div>
	        <div class="testimonials-details">
	            <div class="testimonial-carousel owl-carousel">
	            	<?php $testimonials = get_theme_mod('themefarmer_home_testimonials'); ?>
	            	<?php if($testimonials): foreach ($testimonials as $key => $testimonial): ?>
	                <div class="testimonial-item">
	                    <div class="testimonial-item-inner">
	                        <?php if(!empty($testimonial['link'])): ?>
	                        <div class="testimonial-img">
	                            <a href="<?php echo esc_url($testimonial['link']); ?>">
	                                <img  class="img-responsive" src="<?php echo esc_url($testimonial['image']); ?>">
	                                <h2 class="testimonial-name"><?php echo esc_html($testimonial['title']) ?></h2>
	                            </a>
	                        </div>    
	                        <?php else: ?>
	                        <div class="testimonial-img">
	                            <img  class="img-responsive" src="<?php echo esc_url($testimonial['image']); ?>">
	                            <h2 class="testimonial-name"><?php echo esc_html($testimonial['title']) ?></h2>
	                        </div>
	                        <?php endif; ?>
	                        <div class="testimonial-info">
	                            <h6 class="testimonial-designation"><?php echo esc_html($testimonial['subtitle']) ?></h6>
	                            <p class="testimonial-description"><?php echo esc_html($testimonial['description']) ?></p>
	                        </div>                        
	                    </div>
	                </div>
	                <?php endforeach; endif; ?>
	            </div>
	        </div>
	    </div>
	</div>
	<?php
}

function themefarmer_homepage_section_brands() {
	?>
	<div class="home-section space section-brands">
	    <div class="home-section-bg section-color-bg section-brand-bg"></div>
	    <div class="container">
	        <div class="section-heading">
	            <h2 class="section-title"><?php echo esc_html(get_theme_mod('themefarmer_home_brands_heading')); ?></h2>
	            <p class="section-description"><?php echo esc_html(get_theme_mod('themefarmer_home_brands_desc')); ?></p>
	        </div>
	        <div class="brands-details">
	            <div class="">
	            	<?php $brands = get_theme_mod('themefarmer_home_brands'); ?>
	            	<?php if($brands): foreach ($brands as $key => $brand): ?>
	                <div class="brand-item">
	                    <div class="brand-item-inner">
	                        <?php if(!empty($brand['brand_link'])): ?>
	                            <a href="<?php echo esc_url($brand['brand_link']); ?>">
	                            <img  class="img-responsive" src="<?php echo esc_url($brand['image']); ?>">
	                            </a>
	                        <?php else: ?>
	                            <img  class="img-responsive" src="<?php echo esc_url($brand['image']); ?>">
	                        <?php endif; ?>
	                    </div>
	                </div>
	                <?php endforeach; endif; ?>
	            </div>
	        </div>
	    </div>
	</div>
	<?php
}


function scope_youtube_video_show(){
	$video_id = get_theme_mod('themefarmer_home_about_video_id');
	if(!empty($video_id)):
	?>
	<div class="row justify-content-center about-us-after">
        <div class="col-8">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?feature=oembed&autoplay=0&rel=0&controls=1&showinfo=0&mute=0&wmode=opaque" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <?php
	endif;
}

add_action('scope_after_about_us_section', 'scope_youtube_video_show');