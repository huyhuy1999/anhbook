<?php

if ( !function_exists( 'saleszone_archive_description' ) ) {
    /**
     * Override woocommerce_archive_description hook functions
     *
     * By default woocommerce_taxonomy_archive_description and woocommerce_product_archive_description functions has 2 problems
     * 1 - has build wrapper divs with classes
     * 2 - data is echoing instead of returning
     * This function clear divs and return value
     *
     *
     * @return string
     */
    function saleszone_archive_description()
    {
        ob_start();
        do_action( 'woocommerce_archive_description' );
        $content = ob_get_contents();
        /* remove woocommerce wrapper divs */
        $content = preg_replace( '/(^<div[^>]*>|<\\/div>$)/i', '', $content );
        ob_end_clean();
        return $content;
    }

}
if ( !function_exists( 'saleszone_in_cart' ) ) {
    /**
     * @param $product_id
     * @param bool $product
     * @return bool
     */
    function saleszone_in_cart( $product_id )
    {
        if ( !WC()->cart ) {
            return false;
        }
        foreach ( WC()->cart->get_cart() as $key => $cart_item ) {
            $id = ( $cart_item['variation_id'] ? $cart_item['variation_id'] : $cart_item['product_id'] );
            $id = ( isset( $cart_item['saleszone_bundle_id'] ) ? $cart_item['saleszone_bundle_id'] : $id );
            if ( $product_id == $id && !isset( $cart_item['saleszone_parent_key'] ) ) {
                return true;
            }
        }
        return false;
    }

}
if ( !function_exists( 'saleszone_in_cart_items' ) ) {
    /**
     * Get cart items array except bundle items
     */
    function saleszone_in_cart_items()
    {
        $cart_items = array();
        foreach ( WC()->cart->get_cart() as $cart_item ) {
            $id = ( $cart_item['variation_id'] ? $cart_item['variation_id'] : $cart_item['product_id'] );
            if ( !isset( $cart_item['saleszone_bundle_id'] ) && !isset( $cart_item['saleszone_parent_key'] ) ) {
                $cart_items[$id] = $cart_item['quantity'];
            }
        }
        return $cart_items;
    }

}
if ( !function_exists( 'saleszone_has_variants' ) ) {
    /**
     * Return true if product type is variable and product has at least one variant
     */
    function saleszone_has_variants( $product )
    {
        $available_variations = $product->get_available_variations();
        if ( $product->get_type() == 'variable' && !empty($available_variations) ) {
            return true;
        }
        return false;
    }

}
if ( !function_exists( 'saleszone_get_default_variation_id' ) ) {
    /**
     * @param $product
     * @return array|mixed
     */
    function saleszone_get_default_variation_id( $product )
    {
        if ( $product->get_type() != 'variable' ) {
            return $product->get_ID();
        }
        $variation_id = false;
        $default_attributes = array();
        /* Query string variation attributes */
        foreach ( $product->get_variation_attributes() as $attribute => $options ) {
            $request_term = ( isset( $_REQUEST['attribute_' . $attribute] ) ? sanitize_title( wp_unslash( $_REQUEST['attribute_' . $attribute] ) ) : false );
            $default_attributes['attribute_' . sanitize_title( $attribute )] = $request_term;
            
            if ( !$request_term || !in_array( $request_term, $options ) ) {
                $default_attributes = false;
                break;
            }
        
        }
        /* Default variation attributes */
        if ( !$default_attributes ) {
            foreach ( $product->get_variation_attributes() as $attribute => $options ) {
                $default_attributes['attribute_' . sanitize_title( $attribute )] = $product->get_variation_default_attribute( $attribute );
            }
        }
        /* Search for variation among attributes */
        foreach ( $product->get_available_variations() as $variation ) {
            if ( $variation['attributes'] === $default_attributes ) {
                $variation_id = $variation['variation_id'];
            }
        }
        return $variation_id;
    }

}
if ( !function_exists( 'saleszone_get_product_image_url' ) ) {
    function saleszone_get_variation_image_url( $product, $size = 'shop_thumbnail' )
    {
        $variation = saleszone_get_variation( $product );
        $src = wp_get_attachment_image_url( $variation->get_image_id(), $size );
        $main_image_src = ( $src ? $src : esc_url( wc_placeholder_img_src() ) );
        return $main_image_src;
    }

}
if ( !function_exists( 'saleszone_get_variation' ) ) {
    /**
     * @param $product
     * @return false|null|WC_Product
     */
    function saleszone_get_variation( $product )
    {
        
        if ( $default_variation_id = saleszone_get_default_variation_id( $product ) ) {
            $cacheKey = 'premmerce_default_variation_' . $default_variation_id;
            if ( $variation = wp_cache_get( $cacheKey ) ) {
                return $variation;
            }
            $variation = wc_get_product( $default_variation_id );
            wp_cache_set( $cacheKey, $variation );
            return $variation;
        }
        
        return $product;
    }

}
if ( !function_exists( 'saleszone_static_attributes' ) ) {
    /**
     * Return product attributes without attributes which have multiple value
     * @return array
     */
    function saleszone_static_attributes()
    {
        global  $product ;
        $attributes = array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' );
        $loc_variation_attributes = array_filter( $attributes, 'wc_attributes_array_filter_variation' );
        return array_diff_key( $attributes, $loc_variation_attributes );
    }

}
if ( !function_exists( 'saleszone_render_main_attributes' ) ) {
    function saleszone_render_main_attributes( $parent_modifiers )
    {
        global  $product ;
        $variation = saleszone_get_variation( $product );
        $dimensions = apply_filters( 'wc_product_enable_dimensions_display', $variation->has_weight() || $variation->has_dimensions() );
        
        if ( !function_exists( 'premmerce_get_main_attributes' ) ) {
            $attributes = saleszone_static_attributes();
        } else {
            $main_attributes = get_option( 'premmerce_main_attributes' );
            $attributes = $product->get_attributes();
            $result = array();
            foreach ( $attributes as $attributes_key => $attributes_data ) {
                if ( in_array( $attributes_key, $main_attributes ) ) {
                    $result[$attributes_key] = $attributes_data;
                }
            }
            $attributes = $result;
        }
        
        if ( !$dimensions && !$attributes ) {
            return;
        }
        wc_get_template( 'single-product/attributes-list.php', array(
            'attributes'       => $attributes,
            'variation'        => $variation,
            'dimensions'       => $dimensions,
            'parent_modifiers' => $parent_modifiers,
        ) );
    }

}
if ( !function_exists( 'saleszone_get_attribute_terms' ) ) {
    /**
     * Return product attribute terms
     *
     * @param $attribute
     * @param string $separator
     * @return string
     */
    function saleszone_get_attribute_terms( $attribute, $separator = ',' )
    {
        global  $product ;
        $values = array();
        
        if ( $attribute->is_taxonomy() ) {
            $attribute_taxonomy = $attribute->get_taxonomy_object();
            $attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array(
                'fields' => 'all',
            ) );
            foreach ( $attribute_values as $attribute_value ) {
                $value_name = esc_html( $attribute_value->name );
                
                if ( $attribute_taxonomy->attribute_public ) {
                    $values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
                } else {
                    $values[] = $value_name;
                }
            
            }
        } else {
            $values = $attribute->get_options();
            foreach ( $values as &$value ) {
                $value = esc_html( $value );
            }
        }
        
        return apply_filters(
            'woocommerce_attribute',
            wpautop( wptexturize( implode( $separator . ' ', $values ) ) ),
            $attribute,
            $values
        );
    }

}
if ( !function_exists( 'saleszone_get_account_address' ) ) {
    /**
     * Return user addresses
     *
     * @param string $address_type
     * @param int $customer_id
     * @return mixed
     */
    function saleszone_get_account_address( $address_type = 'billing', $customer_id = 0 )
    {
        $getter = "get_{$address_type}";
        if ( 0 === $customer_id ) {
            $customer_id = get_current_user_id();
        }
        $customer = new WC_Customer( $customer_id );
        
        if ( is_callable( array( $customer, $getter ) ) ) {
            $address = $customer->{$getter}();
            unset( $address['email'], $address['tel'] );
        }
        
        return $address;
    }

}
if ( !function_exists( 'saleszone_is_plugin_active' ) ) {
    /**
     * Check for plugin using plugin name
     *
     * @param $plugin
     * @return bool
     */
    function saleszone_is_plugin_active( $plugin )
    {
        return in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) == true;
    }

}
if ( !function_exists( 'saleszone_post_pagination' ) ) {
    /**
     * Render pagination for post
     */
    function saleszone_post_pagination( $echo = true )
    {
        global  $wp_query ;
        $total = $wp_query->max_num_pages;
        
        if ( $total > 1 ) {
            $pages = paginate_links( array(
                'current'   => max( 1, get_query_var( 'paged' ) ),
                'total'     => $total,
                'mid_size'  => 3,
                'type'      => 'array',
                'prev_text' => '←',
                'next_text' => '→',
            ) );
            ob_start();
            echo  '<ul class="pagination">' ;
            foreach ( $pages as $page ) {
                echo  '<li class="pagination__item">' . wp_kses( $page, array(
                    'a'    => array(
                    'class' => true,
                    'href'  => true,
                ),
                    'span' => array(
                    'class' => true,
                ),
                ) ) . '</li>' ;
            }
            echo  '</ul>' ;
            $html = ob_get_clean();
            
            if ( $echo ) {
                echo  wp_kses_post( $html ) ;
            } else {
                return $html;
            }
        
        }
    
    }

}
if ( !function_exists( 'saleszone_option' ) ) {
    /**
     * Return default option if the theme mod not exist
     *
     * @param $option
     * @return string
     */
    function saleszone_option( $option )
    {
        return get_theme_mod( $option, saleszone_default_options( $option ) );
    }

}
if ( !function_exists( 'saleszone_minify_css' ) ) {
    /**
     * Minify CSS
     */
    function saleszone_minify_css( $css )
    {
        $css = str_replace( array(
            "\r\n",
            "\r",
            "\n",
            "\t",
            '  ',
            '    ',
            '    '
        ), '', $css );
        return $css;
    }

}
if ( !function_exists( 'saleszone_render_css_variables' ) ) {
    /**
     * Render css variables
     */
    function saleszone_render_css_variables()
    {
        $variables_options = saleszone_default_options_css_variables();
        foreach ( $variables_options as $option ) {
            $color = get_theme_mod( $option['name'] );
            if ( !$color ) {
                $color = $option['data']['default'];
            }
            echo  '--' . esc_html( $option['name'] ) . ':' . esc_html( $color ) . ';' ;
        }
    }

}
if ( !function_exists( 'saleszone_render_bg_image_setting' ) ) {
    function saleszone_render_bg_image_setting( $option_name, $selector )
    {
        $bg_setting = get_theme_mod( $option_name );
        $options_background = saleszone_default_options_background( $option_name );
        
        if ( !$bg_setting ) {
            $default_color = $options_background['default']['background-color'];
        } else {
            $default_color = $bg_setting['background-color'];
        }
        
        $css_properties = array(
            'background-repeat',
            'background-position',
            'background-size',
            'background-attachment'
        );
        echo  esc_html( $selector ) . '{background-color:' . esc_html( $default_color ) . ';' ;
        
        if ( $bg_setting['background-image'] ) {
            echo  'background-image:url(' . esc_html( $bg_setting['background-image'] ) . ');' ;
            foreach ( $css_properties as $prop ) {
                echo  esc_html( $prop ) . ':' . esc_html( $bg_setting[$prop] ) . ';' ;
            }
        }
        
        echo  '}' ;
    }

}
if ( !function_exists( 'saleszone_render_walker_header_statick_list_nav_end' ) ) {
    function saleszone_render_walker_header_statick_list_nav_end()
    {
        ob_start();
        
        if ( function_exists( 'pll_the_languages' ) ) {
            get_template_part( 'parts/header/parts/header', 'language-switch-polylang' );
        } elseif ( function_exists( 'icl_get_languages' ) ) {
            get_template_part( 'parts/header/parts/header', 'language-switch-wpml' );
        }
        
        //Premmerce currency switcher
        get_template_part( 'parts/header/parts/header', 'premmerce-currency-switcher' );
        //Woocommerce currency switcher
        wc_get_template( '../parts/header/parts/header-woocommerce-currency-switcher.php' );
        do_action( 'wcml_currency_switcher', array(
            'format'         => apply_filters( 'saleszone_wpml_currency_format', '%code%, %symbol%' ),
            'switcher_style' => 'saleszone-listnav-currency-switcher',
        ) );
        return ob_get_clean();
    }

}
if ( !function_exists( 'saleszone_register_sidebar' ) ) {
    function saleszone_register_sidebar( $args )
    {
        if ( !is_registered_sidebar( $args['id'] ) ) {
            register_sidebar( $args );
        }
    }

}
if ( !function_exists( 'saleszone_filter_shortcode_products_attrs' ) ) {
    function saleszone_filter_shortcode_products_attrs( $out, $pairs, $atts )
    {
        $out['template'] = ( !empty($atts['template']) ? $atts['template'] : '' );
        $out['title'] = ( !empty($atts['title']) ? $atts['title'] : '' );
        return $out;
    }

}
if ( !function_exists( 'saleszone_get_wishlist_url' ) ) {
    function saleszone_get_wishlist_url()
    {
        return home_url( 'wishlists' );
    }

}
if ( !function_exists( 'saleszone_render_main_menu' ) ) {
    function saleszone_render_main_menu()
    {
        if ( !has_nav_menu( 'main_catalog_nav' ) ) {
            return;
        }
        
        if ( saleszone_option( 'header-main-menu-type' ) == 'mega' ) {
            wp_nav_menu( array(
                'theme_location' => 'main_catalog_nav',
                'walker'         => new WalkerCatalogMega(),
                'container'      => false,
                'items_wrap'     => '<nav class="table-nav table-nav--equal" data-megamenu-horizontal data-megamenu-container><ul class="table-nav__items">%3$s</ul></nav>',
                'depth'          => 4,
            ) );
        } else {
            wp_nav_menu( array(
                'theme_location' => 'main_catalog_nav',
                'walker'         => new WalkerCatalogMain(),
                'container'      => false,
                'items_wrap'     => '<nav class="table-nav table-nav--equal" data-megamenu-container><ul class="table-nav__items">%3$s</ul></nav>',
                'depth'          => 4,
            ) );
        }
    
    }

}
if ( !function_exists( 'saleszone_get_countdown' ) ) {
    function saleszone_get_countdown( $end_date )
    {
        $days = saleszone_countdown_time_to( $end_date, 'days' );
        $hours = saleszone_countdown_time_to( $end_date, 'hours' ) - saleszone_countdown_time_to( $end_date, 'days' ) * 24;
        $minutes = saleszone_countdown_time_to( $end_date, 'minutes' ) - saleszone_countdown_time_to( $end_date, 'hours' ) * 60;
        $seconds = saleszone_countdown_time_to( $end_date, 'seconds' ) - saleszone_countdown_time_to( $end_date, 'minutes' ) * 60;
        return array(
            'gmt' => get_option( 'gmt_offset' ),
            'to'  => $end_date,
            'dd'  => ( $days >= 10 ? $days : '0' . $days ),
            'hh'  => ( $hours >= 10 ? $hours : '0' . $hours ),
            'mm'  => ( $minutes >= 10 ? $minutes : '0' . $minutes ),
            'ss'  => ( $seconds >= 10 ? $seconds : '0' . $seconds ),
        );
    }

}
if ( !function_exists( 'saleszone_countdown_time_to' ) ) {
    function saleszone_countdown_time_to( $to, $type )
    {
        switch ( $type ) {
            case 'days':
                return floor( ($to - time()) / 60 / 60 / 24 );
            case 'hours':
                return floor( ($to - time()) / 60 / 60 );
            case 'minutes':
                return floor( ($to - time()) / 60 );
            case 'seconds':
                return $to - time();
        }
    }

}
if ( !function_exists( 'saleszone_find_matching_product_variation' ) ) {
    /**
     * Find matching product variation
     *
     * @param WC_Product $product
     * @param array $attributes
     * @return int Matching variation ID or 0.
     */
    function saleszone_find_matching_product_variation( $product, $attributes )
    {
        foreach ( $attributes as $key => $value ) {
            if ( strpos( $key, 'attribute_' ) === 0 ) {
                continue;
            }
            unset( $attributes[$key] );
            $attributes[sprintf( 'attribute_%s', $key )] = $value;
        }
        
        if ( class_exists( 'WC_Data_Store' ) ) {
            $data_store = WC_Data_Store::load( 'product' );
            return $data_store->find_matching_product_variation( $product, $attributes );
        } else {
            return $product->get_matching_variation( $attributes );
        }
    
    }

}
if ( !function_exists( 'saleszone_get_default_attributes' ) ) {
    /**
     * Get variation default attributes
     *
     * @param WC_Product $product
     * @return array
     */
    function saleszone_get_default_attributes( $product )
    {
        
        if ( method_exists( $product, 'get_default_attributes' ) ) {
            return $product->get_default_attributes();
        } else {
            return $product->get_variation_default_attributes();
        }
    
    }

}
if ( !function_exists( 'saleszone_get_catalog_template' ) ) {
    function saleszone_get_catalog_template()
    {
        
        if ( isset( $_COOKIE['catalog_view'] ) ) {
            $template = ( $_COOKIE['catalog_view'] == 'list' ? 'list' : 'grid' );
        } else {
            $template = saleszone_option( 'category-product-view' );
        }
        
        return $template;
    }

}
if ( !function_exists( 'saleszone_woocommerce_pagination_html' ) ) {
    function saleszone_woocommerce_pagination_html()
    {
        ob_start();
        woocommerce_pagination();
        return ob_get_clean();
    }

}
if ( !function_exists( 'saleszone_social_links_buttons' ) ) {
    function saleszone_social_links_buttons()
    {
        ob_start();
        do_action( 'profile_personal_options' );
        $content = ob_get_clean();
        $translation = array(
            'Social Login'        => __( 'Social Login', 'saleszone' ),
            'Unlink account from' => __( 'Unlink account from', 'saleszone' ),
            'Link account with'   => __( 'Link account with', 'saleszone' ),
        );
        foreach ( $translation as $key => $val ) {
            $content = str_replace( $key, $val, $content );
        }
        return $content;
    }

}
if ( !function_exists( 'saleszone_get_loop_add_to_cart_icon' ) ) {
    function saleszone_get_loop_add_to_cart_icon()
    {
        
        if ( saleszone_option( 'category-btn-add-to-cart-icon' ) ) {
            return saleszone_get_svg( saleszone_option( 'add-to-cart-icon' ), 'pc-add-to-cart-loop__button-icon-cart' );
        } else {
            return '';
        }
    
    }

}
if ( !function_exists( 'saleszone_is_woocommerce_activated' ) ) {
    /**
     * Query WooCommerce activation
     */
    function saleszone_is_woocommerce_activated()
    {
        return ( class_exists( 'WooCommerce' ) ? true : false );
    }

}
if ( !function_exists( 'saleszone_site_logo' ) ) {
    /**
     * Display the site title or logo
     */
    function saleszone_site_logo()
    {
        
        if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
            $logo = saleszone_get_logo_src();
            ?>
            <a class="site-logo" href="<?php 
            echo  esc_url( home_url( '/' ) ) ;
            ?>" rel="home">
                <img class="site-logo__image" src="<?php 
            echo  esc_url( $logo ) ;
            ?>" alt="<?php 
            echo  esc_attr( saleszone_get_img_alt( get_theme_mod( 'custom_logo' ), get_bloginfo( 'name' ) ) ) ;
            ?>">
                <?php 
            
            if ( get_bloginfo( 'description' ) !== '' && saleszone_option( 'logo-slogan' ) ) {
                ?>
                    <p class="site-logo__decription">
                        <?php 
                echo  esc_html( get_bloginfo( 'description', 'display' ) ) ;
                ?>
                    </p>
                <?php 
            }
            
            ?>
            </a>
            <?php 
        } elseif ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {
            // Copied from jetpack_the_site_logo() function.
            $logo = site_logo()->logo;
            $logo_id = get_theme_mod( 'custom_logo' );
            // Check for WP 4.5 Site Logo
            $logo_id = ( $logo_id ? $logo_id : $logo['id'] );
            // Use WP Core logo if present, otherwise use Jetpack's.
            $size = site_logo()->theme_size();
            ?><a class="site-logo" href="<?php 
            echo  esc_url( home_url( '/' ) ) ;
            ?>" rel="home"><?php 
            wp_get_attachment_image(
                $logo_id,
                $size,
                false,
                array(
                'class'     => 'class="site-logo__image"',
                'data-size' => $size,
                'itemprop'  => 'logo',
            )
            );
            ?></a><?php 
        } else {
            ?>
            <div class="site-logo">
                <a class="site-logo__link" href="<?php 
            echo  esc_url( home_url( '/' ) ) ;
            ?>" rel="home">
                    <?php 
            echo  esc_html( get_bloginfo( 'name' ) ) ;
            ?>
                </a>
                <?php 
            
            if ( get_bloginfo( 'description' ) !== '' ) {
                ?>
                    <p class="site-logo__decription">
                        <?php 
                echo  esc_html( get_bloginfo( 'description', 'display' ) ) ;
                ?>
                    </p>
                <?php 
            }
            
            ?>
            </div>
            <?php 
        }
    
    }

}
if ( !function_exists( 'saleszone_get_template' ) ) {
    function saleszone_get_template( $__name, $__args = array() )
    {
        extract( $__args );
        $__file = locate_template( $__name );
        if ( file_exists( $__file ) ) {
            include $__file;
        }
    }

}
if ( !function_exists( 'saleszone_get_comments_form_args' ) ) {
    function saleszone_get_comments_form_args()
    {
        $commenter = wp_get_current_commenter();
        $required = ( get_option( 'require_name_email' ) ? 'aria-required="true" required' : '' );
        
        if ( saleszone_is_woocommerce_activated() && is_product() ) {
            $textarea_label = __( 'Your review', 'saleszone' );
        } else {
            $textarea_label = __( 'Your comment', 'saleszone' );
        }
        
        ob_start();
        ?>

        <div class="form__field form__field--hor comment-form-cookies-consent ">
            <label class="form__checkbox">
                <span class="form__checkbox-field">
                    <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes">
                </span>
                <span class="form__checkbox-inner">
                    <?php 
        esc_html_e( 'Save my name, email, and website in this browser for the next time I comment.', 'saleszone' );
        ?>
                </span>
            </label>
        </div>

        <?php 
        $cookies = ob_get_clean();
        $args = array(
            'class_form'           => 'form',
            'id_form'              => 'comment_form',
            'title_reply'          => '',
            'title_reply_to'       => '',
            'title_reply_before'   => '<span id="reply-title" class="comment-reply-title">',
            'title_reply_after'    => '</span>',
            'comment_notes_before' => '',
            'comment_notes_after'  => '',
            'fields'               => array(
            'author'  => '<div class="form__field form__field--hor"><div class="form__label"><div class="form__label-require-wrap"><span class="form__label-require-text-el">' . esc_html__( 'Name', 'saleszone' ) . '</span><i class="form__require-mark"></i></div></div> ' . '<div class="form__inner"><input class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $required . ' /></div></div>',
            'email'   => '<div class="form__field form__field--hor"><div class="form__label"><div class="form__label-require-wrap"><span class="form__label-require-text-el">' . esc_html__( 'Email', 'saleszone' ) . '</span><i class="form__require-mark"></i></div></div> ' . '<div class="form__inner"><input class="form-control" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" ' . $required . ' /></div></div>',
            'cookies' => $cookies,
        ),
            'logged_in_as'         => '',
            'label_submit'         => '',
            'submit_button'        => '<button class="btn btn-default">' . __( 'Submit', 'saleszone' ) . '</button>',
            'submit_field'         => '<div class="form__field form__field--hor"><div class="form__label"></div><div class="form__inner">%1$s</div></div>%2$s',
            'comment_field'        => '<div class="form__field form__field--hor"><div class="form__label"><div class="form__label-require-wrap"><span class="form__label-require-text-el">' . esc_html( $textarea_label ) . '</span><i class="form__require-mark"></i></div></div><div class="form__inner"><textarea class="form-control" name="comment" rows="5" aria-required="true" required></textarea></div></div>',
        );
        if ( saleszone_is_woocommerce_activated() ) {
            if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
                /* translators: %s: url*/
                $args['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href=%s>logged in</a> to post a comment.', 'saleszone' ), esc_url( $account_page_url ) ) . '</p>';
            }
        }
        return $args;
    }

}
if ( !function_exists( 'saleszone_get_comments_form_reply_args' ) ) {
    function saleszone_get_comments_form_reply_args()
    {
        $parent_id = ( isset( $_REQUEST['parent_id'] ) ? intval( $_REQUEST['parent_id'] ) : '' );
        $commenter = wp_get_current_commenter();
        $reply_form_args = array(
            'class_form'           => 'form row',
            'id_form'              => 'comment_reply_form_' . $parent_id,
            'title_reply'          => '',
            'title_reply_to'       => '',
            'title_reply_before'   => '<span id="reply-title" class="comment-reply-title">',
            'title_reply_after'    => '</span>',
            'comment_notes_before' => '',
            'comment_notes_after'  => '',
            'fields'               => array(
            'author' => '<div class="col-sm-6 col--spacer"><div class="form__field"><div class="form__inner">' . '<input class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_attr__( 'Name', 'saleszone' ) . '" aria-required="true" required /></div></div></div>',
            'email'  => '<div class="col-sm-6 col--spacer"><div class="form__field"><div class="form__inner">' . '<input class="form-control" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . esc_attr__( 'Email', 'saleszone' ) . '" aria-required="true" required /></div></div></div>',
        ),
            'logged_in_as'         => '',
            'comment_field'        => '',
            'label_submit'         => '',
            'submit_button'        => '<button class="btn btn-default">' . __( 'Submit', 'saleszone' ) . '</button>',
            'submit_field'         => '<div class="col-sm-12 col--spacer"><div class="form__field"><div class="form__inner">%1$s</div></div>%2$s</div>',
        );
        $reply_form_args['comment_field'] = '<div class="col-sm-12"><div class="form__field"><div class="form__inner"><textarea class="form-control" name="comment" rows="5" placeholder="" aria-required="true" required></textarea></div></div></div>';
        if ( saleszone_is_woocommerce_activated() ) {
            if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
                /* translators: %s: url*/
                $reply_form_args['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'saleszone' ), esc_url( $account_page_url ) ) . '</p>';
            }
        }
        return $reply_form_args;
    }

}
if ( !function_exists( 'saleszone_get_comments_pagination_args' ) ) {
    function saleszone_get_comments_pagination_args()
    {
        return array(
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
            'type'      => 'array',
            'echo'      => false,
        );
    }

}
if ( !function_exists( 'saleszone_comments' ) ) {
    /**
     * Callback for wp_list_comments
     * @param $comment
     * @param $args
     * @param $depth
     */
    function saleszone_comments( $comment, $args, $depth )
    {
        $GLOBALS['comment'] = $comment;
        // WPCS: override ok.
        $file = locate_template( '/woocommerce/single-product/review.php' );
        if ( $file ) {
            include $file;
        }
    }

}
if ( !function_exists( 'saleszone_render_header_phone' ) ) {
    function saleszone_render_header_phone()
    {
        $template = saleszone_option( 'header-phone-display-type' );
        if ( $template === 'list-horizontal' ) {
            $template = 'list';
        }
        if ( trim( strip_tags( saleszone_option( 'header-phone' ) ) ) != '' ) {
            get_template_part( '/parts/header/header-phone/header-phone-' . $template );
        }
    }

}
if ( !function_exists( 'saleszone_clear_phone_number' ) ) {
    function saleszone_clear_phone_number( $phone )
    {
        return preg_replace( "/[^\\d]/", '', $phone );
    }

}
if ( !function_exists( 'saleszone_custom_css_render_callback' ) ) {
    function saleszone_custom_css_render_callback()
    {
        return saleszone_custom_css();
    }

}
if ( !function_exists( 'saleszone_get_allowed_attrs' ) ) {
    function saleszone_get_allowed_attrs()
    {
        return array(
            'class'                       => true,
            'data-sidebar-widget--header' => true,
            'data-sidebar-widget--button' => true,
            'data-sidebar-widget--toggle' => true,
            'data-sidebar-widget--scope'  => true,
            'id'                          => true,
        );
    }

}
if ( !function_exists( 'saleszone_get_price_allowed_html' ) ) {
    function saleszone_get_allowed_html( $type )
    {
        switch ( $type ) {
            case 'price':
                return array(
                    'del'  => array(
                    'class'      => true,
                    'product-id' => true,
                ),
                    'span' => array(
                    'class'           => true,
                    'data-product-id' => true,
                ),
                    'div'  => array(
                    'class' => true,
                ),
                );
            case 'widget':
                $attr = saleszone_get_allowed_attrs();
                return array(
                    'div'    => $attr,
                    'button' => $attr,
                    'h2'     => $attr,
                    'span'   => $attr,
                );
            case 'iframe':
                return array(
                    'iframe' => array(
                    'width'           => true,
                    'height'          => true,
                    'src'             => true,
                    'frameborder'     => true,
                    'allow'           => true,
                    'allowfullscreen' => true,
                ),
                );
            case 'order_button':
                return array(
                    'input' => array(
                    'id'         => true,
                    'class'      => true,
                    'type'       => true,
                    'value'      => true,
                    'data-value' => true,
                ),
                );
            case 'prev_next':
                return array(
                    'a' => array(
                    'href' => true,
                    'rel'  => true,
                ),
                );
        }
    }

}
if ( !function_exists( 'saleszone_filter_active_currecies' ) ) {
    function saleszone_filter_active_currecies( $currency )
    {
        return $currency['display_on_front'];
    }

}
if ( !function_exists( 'saleszone_get_comparision_add_url' ) ) {
    function saleszone_get_comparision_add_url()
    {
        return add_query_arg( array(
            'wc-ajax' => 'premmerce_comparison_add',
        ), get_the_permalink() );
    }

}
if ( !function_exists( 'saleszone_wc_attribute_label' ) ) {
    function saleszone_wc_attribute_label( $name )
    {
        $key = 'premmerce_wc_attribute_label_' . $name;
        if ( $label = wp_cache_get( $key ) ) {
            return $label;
        }
        $label = wc_attribute_label( $name );
        wp_cache_set( $key, $label );
        return $label;
    }

}
if ( !function_exists( 'saleszone_excerpt' ) ) {
    function saleszone_excerpt()
    {
        global  $post ;
        $length = 50;
        // Check for custom excerpt
        
        if ( has_excerpt( $post->ID ) ) {
            $output = $post->post_excerpt;
        } else {
            // Check for more tag and return content if it exists
            
            if ( strpos( $post->post_content, '<!--more-->' ) ) {
                $output = apply_filters( 'the_content', get_the_content( false ) );
            } else {
                $output = wp_trim_words( strip_shortcodes( $post->post_content ), $length );
            }
        
        }
        
        return $output;
    }

}
if ( !function_exists( 'saleszone_get_category_first_product_image_url' ) ) {
    function saleszone_get_category_first_product_image_url( $categorySlug )
    {
        $productImageUrl = false;
        $products = wc_get_products( [
            'limit'    => 1,
            'category' => $categorySlug,
        ] );
        
        if ( count( $products ) > 0 ) {
            $product = $products[0];
            $productImageUrl = ( $product->get_image_id() ? wp_get_attachment_image_url( $product->get_image_id(), 'shop_single' ) : false );
        }
        
        return $productImageUrl;
    }

}