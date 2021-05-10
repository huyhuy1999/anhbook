<?php

/*--------------------------
* Opstore Site Brandings
*---------------------------
*/

if( !function_exists('opstore_site_brandings') ){
	function opstore_site_brandings(){
      ?>
		<div class="site-branding navbar-brand">
	        <?php
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$logo_img = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            if($logo_img!=''){
            ?>
            <a class="navbar-brand" href="<?php echo esc_url( home_url('/') ); ?>">
                <img src="<?php echo esc_url( $logo_img[0] ); ?>" alt="<?php esc_attr(bloginfo('name')); ?>">
            </a>
            <?php
            }
			if ( is_front_page() && is_home() ) : ?>
				<h1 id="logo" class="site-title navbar-brand"><a class="site-brand navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo esc_html($description); /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->
      <?php
	}
}

/*========Get all registered sidebars=====*/
if(!function_exists('opstore_get_sidebars')){
    function opstore_get_sidebars(){
        global $wp_registered_sidebars;
        $ultra_sidebars = array();
        foreach ( $wp_registered_sidebars as $sidebars ) {
            $ultra_sidebars[$sidebars['id']] = $sidebars['name'];
        }
        return $ultra_sidebars;
    }
}

//Get all Categories 
function opstore_get_post_type_categories($taxonomy){
    $terms = get_terms( array(
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
    ));

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
        $options[ $term->term_id ] = $term->name;
    }
     return $options;
    }
}


/*Social Icons */
if(!function_exists('opstore_social_icons')){
	function opstore_social_icons(){
		$fb = get_theme_mod('opstore_Facebook');
		$twet = get_theme_mod('opstore_Twitter');
		$linkedin = get_theme_mod('opstore_Linkedin');
		$insta = get_theme_mod('opstore_Instagram');
		$pin = get_theme_mod('opstore_Pinterest');
		?>
		<ul class="social-icons">
			<?php if($fb){?>
			<li><a href="<?php echo esc_url($fb)?>" title="<?php echo esc_attr__('Facebook','opstore');?>"><i class="fa fa-facebook"></i></a></li>
			<?php }?>
			<?php if($twet){?>
			<li><a href="<?php echo esc_url($twet)?>" title="<?php echo esc_attr__('Twitter','opstore');?>"><i class="fa fa-twitter"></i></a></li>
			<?php }?>
			<?php if($linkedin){?>
			<li><a href="<?php echo esc_url($linkedin)?>" title="<?php echo esc_attr__('LinkedIn','opstore');?>"><i class="fa fa-linkedin"></i></a></li>
			<?php }?>
			<?php if($insta){?>
			<li><a href="<?php echo esc_url($insta)?>" title="<?php echo esc_attr__('Instagram','opstore');?>"><i class="fa fa-instagram"></i></a></li>
			<?php }?>
			<?php if($pin){?>
			<li><a href="<?php echo esc_url($pin)?>" title="<?php echo esc_attr__('Pinterest','opstore');?>"><i class="fa fa-pinterest"></i></a></li>
			<?php }?>														
		</ul>
		<?php
	}
}

//Title Banner
if( ! function_exists( 'opstore_title_banner' ) ) {
    function opstore_title_banner() {
        $banner_enable = get_theme_mod('opstore_page_banner_show','show');
        if($banner_enable == 'show'){

            $title_position = get_post_meta(get_the_ID(),'ultra_page_title_position',true);
            if(empty($title_position)){
                $title_position = get_theme_mod('opstore_banner_title_position');
            }
        ?>
        <div class="hero-banner inner-banner banner-scroll">
            <div class="fixed-banner" >
                <div class="banner-content">
                    <div class="content-wrap mb-0 banner-overlay">
                        <div class="inner <?php echo esc_attr($title_position);?>">
                            <div class="container">
	                        <?php
                            
                            if( is_home() ){

                                $title =  get_option('page_for_posts');
                                if($title){
                                    echo '<h1 class="page-title">'.  wp_kses_post(get_the_title($title)).'</h1>' ;
                                }else{
                                    echo '<h1 class="page-title">'.esc_html__('Blog','opstore').'</h1>';
                                }    
                            }elseif(class_exists('woocommerce') && is_shop() ){
                                echo '<h1 class="page-title">'.esc_html__('Shop','opstore').'</h1>';
                            }
                            elseif(is_archive()) {
	                           the_archive_title( '<h1 class="page-title">', '</h1>' );

                            } elseif(is_singular('page') || is_single()) {
                                wp_reset_postdata();
                                $custom_title = get_post_meta(get_the_ID(),'ultra_page_custom_title',true);
                                $custom_subtitle =  get_post_meta(get_the_ID(),'ultra_page_custom_subtitle',true);
                                if($custom_title){
                                    echo '<h1 class="page-title">'.esc_html($custom_title).'</h1>';
                                }else{
                                    the_title('<h1 class="page-title">', '</h1>');
                                }
                                if($custom_subtitle){
                                    echo '<p>'.wp_kses_post($custom_subtitle).'</p>';
                                }

                            } elseif(is_search()) {
                                ?>
                                <h1 class="page-title">
                                    <?php 
                                    /* translators: %s: search term */
                                    printf(esc_html__( 'Search Results for: %s', 'opstore' ), '<span>' . get_search_query() . '</span>' ); ?>
                                </h1>
                                <?php
                            } elseif(is_404()) {
                                ?>
                                <h1 class="page-title"><?php esc_html_e( '404 Error', 'opstore' ); ?></h1>
                                <?php
                            }else{
                            	the_archive_title( '<h1 class="page-title">', '</h1>' );
                            }
                            $bread_show = get_post_meta(get_the_ID(),'ultra_page_breadcrumb_show',true); //For page and posts
                            if($bread_show != 'off'){
		                        opstore_breadcrumbs();	  
                            }
	                        ?>
                            </div>
                        </div>
                    </div>
                    <!--content wrap-->
                </div>
                <!--banner content-->
            </div>
        </div>
        <!--main banner-->
        <?php
        }
    }
}

/* Single Post Formats */
if( !function_exists('opstore_post_formats') ){
    function opstore_post_formats(){
        global $post;
        $format = get_post_format();
        $post_audio_url = get_post_meta( $post->ID, 'post_embed_audio_url', true );
        $post_video_url = get_post_meta( $post->ID, 'post_embed_video_url', true );
        $post_images_url = get_post_meta( $post->ID, 'post_images', true );
        if($format == 'video' && !empty($post_video_url) ){
            ?>
            <div class="opstore_video_wrap">
                <?php echo wp_oembed_get( esc_url($post_video_url) ); // WPCS: XSS OK. ?>
            </div>
        <?php 
        }else if($format == 'audio' && !empty($post_audio_url)){
            ?>
            <div class="opstore_audio_wrap">
                <?php echo wp_oembed_get( esc_url($post_audio_url) ); // WPCS: XSS OK. ?>
            </div>
        <?php 
        }else if($format == 'gallery' && !empty($post_images_url)){ 
            wp_enqueue_style('slick');
            wp_enqueue_style('slick-theme');
            wp_enqueue_script('slick');
            ?>
            <div class="post-gallery-wrapper">
                <ul class="opstore-gallery-items">
                    <?php 
                        foreach ( $post_images_url as $image_url) {
                    ?>
                        <li><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr__('gallery-images','opstore');?>"/></li>
                    <?php
                        }
                    ?>
                </ul>
            </div><!-- .post-gallery-wrapper -->
            <?php 
        } else{ the_post_thumbnail('opstore-blog-classic'); } 
    }
}


// opstore entry meta
if( ! function_exists( 'opstore_entry_meta' ) ):
    function opstore_entry_meta() {
        global $post; 
        $author_id=$post->post_author;
        ?>
        <span> 
            <i class="fa fa-calendar"></i>  <?php echo get_the_date(); ?>
        </span>

        <span> 
            <i class="fa fa-user"></i> <?php esc_html_e('By', 'opstore'); ?> <?php the_author_meta( 'nickname', $author_id ); ?>
        </span>

        <span>
            <i class="fa fa-folder"></i><?php  do_action('opstore_post_cat_lists');?>
        </span>

        <span> 
            <i class="fa fa-comments"></i> 
             <?php comments_popup_link();?>
        </span>   
        <?php
    }
endif;


//Get Cat Lists
add_action('opstore_post_cat_lists','opstore_post_cat_lists');
if( ! function_exists( 'opstore_post_cat_lists' ) ) :
    function opstore_post_cat_lists() {

        // Hide category and tag text for pages.
        if ( 'post' === get_post_type() ) {
            global $post;
            $categories = get_the_category();
            $separator = ', ';
            $output = '';
            if( $categories ) {
                foreach( $categories as $category ) {
                    $output .= '<a class="cat-links" href="'.get_category_link( $category->term_id ).'" class="cat-' . $category->term_id . '" rel="category tag">'.$category->cat_name.'</a>';                   
                }
                echo wp_kses_post(trim( $output, $separator ));
            }
        }
    }
endif;


// opstore pagination
if( ! function_exists( 'opstore_pagination' ) ):
    function opstore_pagination( $query = null ) {
        global $wp_query;
        if( ! $query ) {
            $query = $wp_query;
        }
        $big = 999999;

        $paged = get_query_var('paged');
        $args = array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $paged ),
            'total' => $query->max_num_pages,
            'type' => 'list',
            'prev_next'          => true,
            'prev_text'          => esc_html__('&larr;', 'opstore'),
            'next_text'          => esc_html__('&rarr;', 'opstore'),
        );
        echo wp_kses_post(paginate_links( $args ));
    }
endif;

/*-----------------------------------------------------------------------------------*/
#  Post Pagination for single Posts
/*-----------------------------------------------------------------------------------*/
function opstore_single_post_pagination(){ 
    $nextPost = get_next_post();
    $prevPost = get_previous_post();
    if( is_a( $prevPost , 'WP_Post' ) || is_a( $nextPost , 'WP_Post' ) ):
    ?>   
    <div class="single_post_pagination_wrapper clearfix">
        <div class="prev-link"> 
            <div class="prev-link-wrapper clearfix">
                <?php
                $prevPost = get_previous_post();
                if ( is_a( $prevPost , 'WP_Post' ) ) :
                    $prevthumbnail = get_the_post_thumbnail($prevPost->ID,'thumbnail'); 
                    $prevtitle = get_the_title($prevPost->ID); ?>
                    
                    <div class="prev-text">
                        <h4><?php previous_post_link('%link', 'Previous Post'); ?></h4>
                        <h2><?php previous_post_link('%link', $prevtitle) ;?></h2>
                    </div>
                
                    <?php
                    if($prevthumbnail){ ?>
                        <span class="prev-image">
                            <?php previous_post_link('%link', $prevthumbnail); ?>
                        </span>
                    <?php } 
                endif; ?>
            </div>
        </div>

        <?php // Display the thumbnail of the next post ?>
        <div class="next-link"> 
            <div class="next-link-wrapper clearfix">
                <?php
                $nextPost = get_next_post();
                if ( is_a( $nextPost , 'WP_Post' ) ) :
                    $nextthumbnail = get_the_post_thumbnail($nextPost->ID,'thumbnail');
                    $nextitle = get_the_title($nextPost->ID); ?>
                    <div class="next-text">
                        <h4><?php next_post_link('%link', 'Next Post'); ?></h4>
                        <h2><?php next_post_link('%link',$nextitle); ?></h2>
                    </div>

                    <?php
                    if($nextthumbnail){ ?>
                        <span class="next-image">
                            <?php next_post_link('%link', $nextthumbnail); ?>
                        </span>
                    <?php } 
                endif; ?>
            </div>
        </div>
    </div> <!-- .single_post_pagination_wrapper -->
<?php 
    endif;
} 

//Hex to RGBA
function opstore_hex2rgba($color, $opacity = false) {
     $default = 'rgb(0,0,0)';
     //Return default if no color provided
     if(empty($color))
           return $default;
     //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
         $color = substr( $color, 1 );
        }
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
        //Check if opacity is set(rgba or rgb)
        if($opacity){
         if(abs($opacity) > 1)
         $opacity = 1.0;
         $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
         $output = 'rgb('.implode(",",$rgb).')';
        }
        //Return rgb(a) color string
        return $output;
}
