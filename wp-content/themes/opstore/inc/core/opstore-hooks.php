<?php

/* Opstore Hooks */

//Header Hooks

add_action('opstore_header','opstore_top_header',0);
add_action('opstore_header','opstore_bottom_header',10);

function opstore_top_header(){

    $top_header = get_theme_mod('opstore_top_header_show','show');
    $top_header_type = get_theme_mod('opstore_topheader_type','info');
    $noti_text = get_theme_mod('top_notification_text');
    $top_email = get_theme_mod('top_email');
    $top_phone = get_theme_mod('top_phone');
    if( $top_header == 'show' ): 
        ?>
        <div class="top-bar">
            <div class="top-bar-wrap bar-visible">
                <div class="row">
                    <?php if($top_header_type == 'info'){?>
                    <div class="col-sm-12">
                        <div class="row">
                        <div class="col-xs-12 col-md-6 col-sm-6">
                        <div class="top-left">
                            <ul>
                                <?php if($top_email){?>
                                <li class="phone"><a href="mailto:<?php echo esc_attr($top_email);?>"><i class="fa fa-envelope"></i><?php echo esc_html($top_email);?></a></li>
                                <?php } if($top_phone){?>
                                <li class="email"><a href="tel:<?php echo esc_attr($top_phone);?>"><i class="fa fa-phone"></i><?php echo esc_html($top_phone);?></a></li>
                                <?php }?>
                            </ul>
                        </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-sm-6">
                        <div class="top-right">
                            <?php 
                            $args = array(
                                'theme_location' => 'top',
                                'menu_class' => 'nav top-menu',
                                'depth' => -1

                            );

                           if( has_nav_menu( 'top' ) ):
                                wp_nav_menu( $args );
                            endif;
                            ?>
                        </div>
                        </div>
                        </div>
                    </div>
                    <?php } else{ ?>
                    <div class="col-sm-12 text-center">
                        <?php echo wp_kses_post($noti_text); ?>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
        <?php 
    endif; 
}

function opstore_bottom_header(){
    $header_layout = get_theme_mod( 'opstore_header_layouts','style1' );
    if($header_layout == 'style1'){
        get_template_part( 'layouts/header/header', 'layout1' ); 
    }else{
        get_template_part( 'layouts/header/header', 'layout2' );
    }
}

//Footer hooks
add_action('opstore_footer','opstore_top_footer',0);
add_action('opstore_footer','opstore_bottom_footer',10);

function opstore_top_footer(){
    $top_footer_show = get_theme_mod('opstore_topfooter_show','show');
    if( $top_footer_show == 'show' ):

        if( ! (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) ){
            return;
        }
        ?>
        <div class="primary-padding top">
            <div class="container">
                <div class="row">
                    <?php 
                    $number = get_theme_mod( 'opstore_topfooter_col',4 );
                    if( ! $number ) {
                        $number = 4;
                    }
                    $total = 12;
                    $cols = $total / $number;
                    $class = 'col-md-'.$cols . ' col-sm-'.$cols;
                    $i = 0; while ( $i < 4 ) : $i++; ?>     
                    <?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>       
                        <div class="block footer-widget wow fadeInRight <?php echo esc_attr($class);?>">
                            <?php dynamic_sidebar( 'footer-' . intval( $i ) ); ?>
                        </div>      
                    <?php endif; ?>     
                <?php endwhile; ?>
                </div>
            </div>
        </div>
        <?php
    endif;
}

function opstore_bottom_footer(){
    $footer_icons = get_theme_mod('opstore_footer_icons','show');
    if($footer_icons == 'show'){
        $fclass = 'col-md-6 col-sm-6 col-xs-12';
    }else{
        $fclass = 'col-md-12 col-sm-12 col-xs-12 text-center';
    }
    ?>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr($fclass);?>">
                    <?php
                    $footer_copyright = get_theme_mod( 'opstore_footer_text');
                    if( !empty( $footer_copyright ) ) { ?>
                        <?php echo wp_kses_post($footer_copyright); ?>   
                    <?php }else{
                        /* translators: %s current year */
                        printf( esc_html('Copyright %s - ','opstore'), date('Y') );
                    }
                    /* translators: %s theme author */
                    printf( wp_kses_post('2019 © Bản Quyền Thuộc Về BizBooksStore | Designed By %s','opstore'), '<a href="https://www.facebook.com/truongbinnehehe.s">'.esc_html('TruongBinIT','opstore').'</a>' )
                       
                    ?>
                </div>
                <!--left-->
                <?php if($footer_icons == 'show'){?>
                <div class="col-md-6 col-sm-6 col-xs-12 text-right ">
                    <?php opstore_social_icons(); ?>
                </div>
                <!--right-->
                <?php }?>
            </div>
        </div>
    </div>
    <?php
}

/* Extra Outbody hooks */
//Off Canvas Cart
add_action('opstore_after_body_output','opstore_offcanvas_cart',0);

function opstore_offcanvas_cart(){
    $show_cart = get_theme_mod('opstore_cart_enable','show');
    if(function_exists('WC') && $show_cart == 'show'){
        ?>
        <div class="off-canvas-cart">
            <a href="javascript:void(0)" class="off-canvas-close"></a>
            <div class="shopping-list-wrap">
                <h3><?php echo esc_html__('Shopping Cart Items','opstore');?></h3>
                <div class="widget_shopping_cart_content">
                    <?php woocommerce_mini_cart(); ?>
                </div>
            </div>
        </div>
        <?php
    }
}

/* For Preloader */
add_action('opstore_before_body_output','opstore_preloader',5);
function opstore_preloader(){
    $preloader = get_theme_mod('opstore_preloader_option','show');
    if( $preloader == 'show'): ?>
        <div id="loading8" class="opstore-loader">
            <div id="loading-center">
                <div id="loading-center-absolute">
                    <div class="object" id="object_one"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_three"></div>
                    <div class="object" id="object_four"></div>
                </div>
            </div>
        </div>
      <?php 
    endif; 
}


//Relates Posts Hook
add_action('opstore_related_post','opstore_related_posts');

function opstore_related_posts(){

    $related_args = array( 
        'post_type' => 'post', 
        'post_status' => 'publish',
        'posts_per_page' => 2,
        'orderby' => 'rand',
        'post__not_in' => array( get_the_ID() ),
    );
    $categories = get_the_category( get_the_ID() );
    if ( $categories ) {
        $category_ids = array();
        foreach( $categories as $individual_category ) {
            $category_ids[] = $individual_category->term_id;
        }
        $related_args['category__in'] = $category_ids;
    }
    $related_query = new WP_Query( $related_args );
    if( $related_query->have_posts() ) {
        ?>
        <div class="related-article blog-list-wrap row news-wrap classic-post">
            <div class="title-main text-center mb-60">
                <h3 class="comments-title"><?php echo esc_html__('Related Articles','opstore'); ?></h3>
            </div>
            <?php
            while( $related_query->have_posts() ) {
                $related_query->the_post();
                $image_id = get_post_thumbnail_id();
                $image_path = wp_get_attachment_image_src( $image_id, 'opstore-blog-col-full', true );
                $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                if(has_post_thumbnail()){
                    $class = 'has-post-thumbnail';
                }else{
                    $class = '';
                }
                ?>
                <div class="col-xs-12 col-sm-6 col-md-6 blog-list mb-60 <?php echo esc_attr($class);?>">
                    <?php if(has_post_thumbnail()){?>
                    <figure>                            
                        <a href="<?php the_permalink();?>" class="image-effect">
                            <img src="<?php echo esc_url($image_path[0]);?>" alt="<?php echo esc_attr($image_alt);?>">
                        </a>
                    </figure>
                    <!--fig-->
                    <?php }?>
                    <div class="entry-content blog">
                        <div class="post-info">
                            <span><i class="fa fa-calendar"></i> <?php echo get_the_date('F j, Y'); ?></span>
                            <span><i class="fa fa-user"></i> <?php the_author(); ?> </span>
                        </div>
                        <h4 class="entry-title mb-15">
                            <a href="<?php the_permalink();?>">
                                <?php the_title();?>
                            </a>
                        </h4>
                        <div class="entry-post-content mb-20">
                        <?php echo  wp_kses_post(get_the_excerpt());?>                 
                       </div>
                        <a href="<?php the_permalink();?>" class="opstore-btn bdr">
                            <?php esc_html_e( 'Read more', 'opstore' ); ?>
                        </a>
                    </div>
                </div>
                <!--single blog-->
               <?php 
            }
            wp_reset_postdata();
            ?>
        </div>
        <?php
    }
}

/**
* Header Icons
*
*/
add_action('opstore_header_icons','opstore_header_icons');
if( ! function_exists('opstore_header_icons')){
    function opstore_header_icons(){ 

        $show_login = get_theme_mod('opstore_login_enable','show');
        $search_enable = get_theme_mod('opstore_search_enable','show');

        ?>
        <div class="header-right"> 
            <?php 
            if($search_enable == 'show'):
            ?>
            <div class="searchbox hidden-xs">
            <span class="searchbox-icon"><span class="lnr lnr-magnifier"></span></span>
            </div>
            <?php endif;?>
            <ul class="site-header-cart menu on-hover">
                <?php 
                    $show_wishlist = get_theme_mod('opstore_wishlist_enable','show');
                    if( function_exists('yith_wishlist_constructor') && $show_wishlist == 'show' ):
                        $wishlist_page = get_option('yith_wcwl_wishlist_page_id');
                        $link = '#';
                        if( $wishlist_page ) {
                            $link = get_permalink( $wishlist_page );
                        }
                        $wishlist_count = YITH_WCWL()->count_products();
                        ?>
                        <li class="wishlist-icon">
                            <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr__('wishlist','opstore');?>">
                                <?php  ?>
                                <span class="wishlist-count wishlist-rounded"><?php echo esc_attr( $wishlist_count ); ?></span>
                                <span class="lnr lnr-heart icon"></span>
                            </a>
                        </li>
                        <?php
                    endif;
                ?>
                <!--wish list-->
                <?php 
                $show_cart = get_theme_mod('opstore_cart_enable','show');
                if( function_exists('WC') && $show_cart == 'show'): ?>
                    <li class="cart-icon dropdown">
                        
                        <a href="#" data-toggle="dropdown" title="<?php echo esc_attr__('cart','opstore'); ?>">
                            <span class="count rounded-crcl"><?php echo  absint(WC()->cart->get_cart_contents_count()); ?></span>
                            <span class="lnr lnr-cart"></span>
                        </a>
                    </li>
                <?php endif; ?>
                <!--cart-->
            </ul>
            <?php if($show_login == 'show'): ?>
            <ul class="login hidden-xs">
                <?php 
                if( ! is_user_logged_in() && function_exists( 'WC' ) ){ 
                    if(defined('LRM_VERSION')){
                        ?>
                        <li> 
                            <a href="/wp-login.php" class="btn-login lrm-login">
                                <span class="lnr lnr-user"></span>
                            </a>
                        </li>
                        <?php
                    } 
                    else{ ?>
                        <li> 
                            <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="btn-login">
                                <span class="lnr lnr-user"></span>
                            </a>
                        </li>
                        <?php
                    }

                } else{ ?>

                    <?php if( function_exists( 'WC' ) ): ?>
                        <li>
                            <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>">
                                <span class="lnr lnr-user"></span>
                            </a> 
                        </li>
                    <?php endif;
                } ?>
            </ul>
            <?php endif;?>
        </div>
        <!--right-->
<?php 
    }
}