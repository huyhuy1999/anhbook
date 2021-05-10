<?php
function opstore_dynamic_styles(){
    $default_settings = opstore_get_default_theme_options();

    $header_image = get_post_meta(get_the_ID(),'ultra_page_banner_bg_image',true);

    if($header_image == ''){
        $header_image = get_theme_mod('opstore_banner_image','');
    }else{
        $header_image = wp_get_attachment_image_src($header_image,'full',true);
        $header_image = $header_image[0];
    }

    $output_css = '';

    if($header_image){ 

        $output_css .=
             '.fixed-banner{
                background-image: url('.esc_url($header_image).');
                background-repeat: no-repeat;
			    background-attachment: fixed;
			    background-position: center;
			    background-size: cover;
            }';
    }

    $banner_color = get_post_meta(get_the_ID(),'ultra_page_banner_bg_color',true);
    if($banner_color){
        $output_css .= ".hero-banner.inner-banner,.banner-overlay:before {
            background-color: $banner_color;
        }";
    }
    
    $banner_height = get_post_meta(get_the_ID(),'ultra_page_banner_height',true);
    if($banner_height == ''){
        $banner_height = get_theme_mod('opstore_banner_height',$default_settings['opstore_banner_height']);
    }
    if($banner_height){
        $output_css .= '@media (min-width: 768px) { 
                  .hero-banner.inner-banner, .inner-banner .fixed-banner, .inner-banner .content-wrap, .inner-banner .content-wrap .inner { height:'.$banner_height.'px !important; }
              }';
    }

    //Top Bar Color
    $top_bg_color = get_theme_mod('top_header_bg_color','#000');
    $top_text_color = get_theme_mod('top_header_text_color','#fff');
    $output_css .= "
    .top-bar{ 
        background-color: $top_bg_color;
        color: $top_text_color;
    }
    .top-bar ul li a{
        color:$top_text_color;
    }";

    //Theme Color
    $theme_color = get_theme_mod('opstore_theme_color',$default_settings['opstore_theme_color']);
    $other_color = opstore_hex2rgba($theme_color,0.8);
    $output_css .= "
    .nav.navbar-nav li.menu-item a:hover, .nav.navbar-nav li.menu-item.current-menu-item > a,
    header ul.menu li a:hover, ul.social-share li a:hover,
    header ul.login li a:hover,
    .woocommerce ul.products li.product a:hover,
    .collection-title-wrap h2 a:hover,
    .blog h4 a:hover,
    .modern-list .title h4 a:hover,
    .blog-list .entry-title a:hover,
    .feature-post-list li .post-title a:hover,
    .feature-post-list li a.more:hover,
    .modern-blog-list .modern-list a.more:hover,
    .widget.widget_recent_entries ul li a:hover, .woocommerce-info::before, .blog-list .post-info a:hover,.single_post_pagination_wrapper .next-link .next-text h4 a:hover,
    .single_post_pagination_wrapper .prev-link .prev-text h4 a:hover,
    .single_post_pagination_wrapper .prev-link .prev-text h4 a:hover:before,
    .single_post_pagination_wrapper .next-link .next-text h4 a:hover:after{
        color:$theme_color;
    }
    .woocommerce #respond input#submit.alt, .woocommerce nav.woocommerce-pagination ul li span.current,
    .woocommerce a.button.alt,  .woocommerce ul.products li.product .onsale, 
    .woocommerce span.onsale, #yith-quick-view-content .onsale, span.onsale, 
    .woocommerce button.button.alt, 
    .woocommerce input.button.alt, .quantity-wrap span, input[type=\"submit\"],
    .cart-collaterals .checkout-button, ul.social-icons li a,
    .contact-social .opstore-social-link a, footer .mailpoet_form  input[type=\"submit\"], .woocommerce .off-canvas-cart .widget_shopping_cart_content .button.wc-forward.checkout,
    .woocommerce .off-canvas-cart .widget_shopping_cart_content .button.wc-forward:hover,
    .woocommerce .off-canvas-cart .widget_shopping_cart_content .return-btn, .woocommerce .widget_price_filter .price_slider_amount .button,
    button.single_add_to_cart_button.button, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
    .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce #respond input#submit, 
    .woocommerce a.button, .advance-product-search .woocommerce-product-search .searchsubmit,
    .woocommerce button.button, header ul.menu .count, span.wishlist-count.wishlist-rounded,
    .woocommerce input.button, .widget_search input[type=\"submit\"], .single-product div.product form.cart .button,
    .widget_product_search input[type=\"submit\"], #loading8 .object, .scrollup, .woocommerce #review_form #respond .form-submit input,
    .tagcloud a:hover, .tagcloud a:focus, .tag-links a:hover, .opstore-footer-clothing input.mailpoet_submit{
        background-color:$theme_color;
    }
    .woocommerce .off-canvas-cart .widget_shopping_cart_content .button.wc-forward.checkout:hover, .woocommerce-info, .header-style1 header,
    .tagcloud a:hover, .tagcloud a:focus, .tag-links a:hover, .opstore-footer-clothing input.mailpoet_submit{
        border-color:$theme_color;
    }
    a:hover,
    a:active, 
    a:focus,.navbar-default .navbar-nav>li>a:focus, .navbar-default .navbar-nav>li>a:hover,
    .navbar-default .navbar-nav>li.current-menu-parent>a, .nav.navbar-nav li.menu-item ul.sub-menu li a:hover, .sidebar .widget_recent_comments ul li a,
    .navbar-default .sub-menu li:hover > a, .single-product div.product form.cart .button:hover, .nav.navbar-nav li.menu-item a:hover,
    .middle-right-wrapp ul.site-header-cart li a:hover,header ul.login li a:hover, footer ul li a:hover,footer a:hover,footer .widget ul li a:hover,
    .single-product div.product p.price ins, 
    .single-product div.product span.price ins, .elementor-element-opstore-product-sale small.pull-left, .elementor-element-opstore-product-sale .salecount-timer div span,
    .opstore-footer-clothing ul.list-inline.foo-con-info li i, .error404 .error-header-wrapp h3 {
            color: $other_color;
        }
    button:hover,
    button:focus,
    input[type=\"button\"]:hover,
    input[type=\"button\"]:focus,
    input[type=\"reset\"]:hover,
    input[type=\"reset\"]:focus,
    input[type=\"submit\"]:hover,
    input[type=\"submit\"]:focus, .widget_product_search input[type=\"submit\"]:hover, .scrollup:hover, .woocommerce #respond input#submit.alt:hover, 
    .woocommerce a.button.alt:hover, 
    .woocommerce button.button.alt:hover, 
    .woocommerce input.button.alt:hover, .quantity-wrap span:hover, ul.social-icons li a:hover,
    .contact-social .opstore-social-link a:hover, .contact-page input[type=\"submit\"]:hover, 
    .woocommerce #review_form #respond .form-submit input:hover, .mobile-search input[type=\"submit\"], .woocommerce-account .woocommerce-MyAccount-navigation ul li a:hover,
    .woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active a, footer .mailpoet_form  input[type=\"submit\"]:hover, .woocommerce a.button.alt:hover,
    .widget_search input[type=\"submit\"]:hover,
    .woocommerce .off-canvas-cart .widget_shopping_cart_content .button.wc-forward.checkout:hover, .woocommerce .off-canvas-cart .widget_shopping_cart_content .return-btn:hover,
    .woocommerce .widget_price_filter .price_slider_amount .button:hover,
    button.single_add_to_cart_button.button, .woocommerce a.button:hover, .woocommerce ul.products.product-slide .slick-dots li.slick-active button:before,
    .blog-list-wrap .opstore-btn:hover, footer .widget ul li a:before, 
    footer .widget ul li a:after,
    footer .widget ul li a:hover:before, .opstore-product-info .item-info-wrap a.add_to_cart_button:hover,
    .opstore-product-info .item-info-wrap .btn.product_type_grouped:hover,
    .opstore-product-info .item-info-wrap .btn.product_type_external:hover, .woocommerce div.product .woocommerce-tabs ul.tabs li::after,
    .opstore-stock-percentage, .elementor-element-opstore-product-sale .btn a:hover, .opstore-footer-clothing input.mailpoet_submit:hover,
    .woocommerce #respond input#submit:hover, .opstore-product-info .item-info-wrap a.added_to_cart:hover,
    .woocommerce a.button:hover, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover,
    .woocommerce button.button:hover, .single-product div.product form.cart .button:hover,
    .woocommerce input.button:hover, .opstore-sticky-cart .right-wrap .btn {
            background-color: $other_color;
        }
    button:hover,
    button:focus,
    input[type=\"button\"]:hover,
    input[type=\"button\"]:focus,
    input[type=\"reset\"]:hover,
    input[type=\"reset\"]:focus,
    input[type=\"submit\"]:hover,
    input[type=\"submit\"]:focus, footer .mailpoet_form  input[type=\"submit\"]:hover, .woocommerce .off-canvas-cart .widget_shopping_cart_content .button.wc-forward,
    .thank-you a.btn.btn-default, .elementor-element-opstore-product-sale .btn a {
            border-color: $other_color;
        }
        ";

    //custom style from metabox
    $ultra_page_custom_css = opstore_get_post_meta('ultra_page_custom_css');
    if( $ultra_page_custom_css ){
        $output_css .= "
        ". esc_html($ultra_page_custom_css).";
        ";

         
    }


    wp_add_inline_style('opstore-style', $output_css);
} 
add_action('wp_enqueue_scripts', 'opstore_dynamic_styles');   