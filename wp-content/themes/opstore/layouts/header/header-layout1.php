<header class="home-header header-1">
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only"><?php esc_html_e('Toggle navigation', 'opstore'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--button-->
            <?php 
              opstore_site_brandings();
            ?>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div class="container">
                <?php 
                $args = array(
                    'theme_location' => 'primary',
                    'menu_class' => 'nav navbar-nav'
                );

               if( has_nav_menu( 'primary' ) ):
                    wp_nav_menu( $args );
                endif;
                ?>
                <?php 
                $search_enable = get_theme_mod('opstore_search_enable','show');
                if($search_enable == 'show'): ?>
                <div class="mobile-search visible-xs">
                    <?php get_search_form();?>
                </div>
                <?php endif;
                 $show_login = get_theme_mod('opstore_login_enable','show');
                 if($show_login == 'show'):
                ?>
                <div class="login visible-xs">
                	<ul>
                		<?php if( ! is_user_logged_in() && function_exists( 'WC' ) ): ?>
	                        <li> 
	                            <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="btn-login lrm-login trigger-modal">
	                                <?php esc_html_e('Login', 'opstore'); ?>
	                            </a>
	                        </li>
	                    <?php else: ?>
	                        <?php if( function_exists( 'WC' ) ): ?>
	                            <li>
	                                <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>">
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
        <?php do_action('opstore_header_icons'); ?>
        
    </nav>
</header>