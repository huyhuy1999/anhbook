<header class="header-2">
    <div class="container">
        <div class="row top">              
                
                <div class="header-middle-wrapp">
                    <div class="col-sm-3 col-md-3 col-xs-12 hidden-xs">
                        <?php opstore_site_brandings(); ?>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xs-12 hidden-xs">
                        <?php 
                         if(is_active_sidebar('header-area')){
                            dynamic_sidebar('header-area');
                         }
                        ?>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                    <div class="middle-right-wrapp">
                    <div class="mobile-logo visible-xs">
                        <?php opstore_site_brandings(); ?>
                    </div>
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
                                <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr__('wishlist','opstore'); ?>">
                                    <?php  ?>
                                    <span class="wishlist-count wishlist-rounded"><?php echo (int)$wishlist_count; ?></span>
                                    <span class="lnr lnr-heart icon"></span>
                                </a>
                            </li>
                            <?php
                        endif; 
                        $show_cart = get_theme_mod('opstore_cart_enable','show');
                        if( function_exists( 'WC' ) && $show_cart == 'show' ): ?>
                            <li class="cart-icon">
                                <a href="#" title="<?php echo esc_attr__('cart','opstore'); ?>">
                                    <span class="count rounded-crcl"><?php echo absint(WC()->cart->get_cart_contents_count()) ; ?></span>
                                    <span class="lnr lnr-cart"></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <!--cart-->
                    </ul>
                    <?php 
                    $show_login = get_theme_mod('opstore_login_enable','show');
                    if($show_login == 'show'): ?>
                        <ul class="login hidden-xs">
                            <?php 
                            if( ! is_user_logged_in() && function_exists( 'WC' ) ){ 
                                if(defined('LRM_VERSION')){
                                    ?>
                                    <li> 
                                        <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="btn-login lrm-login">
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
                                            <span class="lnr lnr-user lrm-login"></span>
                                        </a> 
                                    </li>
                                <?php endif;
                            } ?>
                        </ul>
                    <?php endif;?>
                    </div>
                    </div>
                </div>
                <!--right-->
        </div>
    </div>

    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only"><?php esc_html_e('Toggle navigation', 'opstore'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--button-->
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div class="container">
                <?php 
                $args = array(
                    'theme_location' => 'primary',
                    'menu_class' => 'nav navbar-nav nav-left'
                );

                if( has_nav_menu( 'primary' ) ):
                    wp_nav_menu( $args );
                endif;

                $search_enable = get_theme_mod('opstore_search_enable','show');
                if($search_enable == 'show'){
                    ?>
                    <div class="searchbox hidden-xs">
                        <span class="searchbox-icon"><span class="lnr lnr-magnifier"></span></span>
                    </div>
                <?php
                } 
                if($search_enable == 'show' || is_active_sidebar('header-area')) { ?>  
                <div class="mobile-search visible-xs">
                    <?php get_search_form();?>
                </div>
                <?php
                }
                if($show_login == 'show'): ?>
                <div class="login visible-xs">
                    <ul>
                        <?php if( ! is_user_logged_in() && function_exists( 'WC' ) ): ?>
                            <li> 
                                <a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" class="btn-login">
                                    <i class="fa fa-user"></i> <?php esc_html_e('Login', 'opstore'); ?>
                                </a>

                            </li>
                        <?php else: ?>

                            <?php if( function_exists( 'WC' ) ): ?>
                                <li>
                                    <a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>">
                                        <i class="fa fa-user"></i> <?php esc_html_e('My Account', 'opstore'); ?>
                                    </a> 
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                    
                </div>
                <?php endif;?>
            </div>
            <!--container-->
        </div>
        <!-- /.navbar-collapse -->
    </nav>
</header>