<?php

if ( !function_exists( 'saleszone_brand_sidebar_image' ) ) {
    /**
     *  Show brand image
     */
    function saleszone_brand_sidebar_image()
    {
        
        if ( is_tax( 'product_brand' ) ) {
            $brand = get_queried_object();
            $imageURL = wp_get_attachment_image_url( get_term_meta( $brand->term_id, 'thumbnail_id', true ), 'medium' );
            wc_get_template( 'premmerce-woocommerce-brands/brand-image.php', array(
                'brand'    => $brand,
                'imageURL' => $imageURL,
            ) );
        }
    
    }

}
if ( !function_exists( 'saleszone_dynamic_catalog_sidebar' ) ) {
    /**
     *  Show dynamic_sidebar on category products sidebar
     */
    function saleszone_dynamic_catalog_sidebar()
    {
        dynamic_sidebar( 'catalog_sidebar' );
    }

}
if ( !function_exists( 'saleszone_dynamic_blog_sidebar' ) ) {
    /**
     *  Show dynamic_sidebar on category products sidebar
     */
    function saleszone_dynamic_blog_sidebar()
    {
        dynamic_sidebar( 'blog_sidebar' );
    }

}
if ( !function_exists( 'saleszone_dynamic_subcategories_sidebar' ) ) {
    /**
     *  Show dynamic_sidebar on category subcategory sidebar
     */
    function saleszone_dynamic_subcategories_sidebar()
    {
        dynamic_sidebar( 'subcategories_sidebar' );
    }

}
if ( !function_exists( 'saleszone_render_loop_product_image' ) ) {
    function saleszone_render_loop_product_image()
    {
        global  $product ;
        $variation = saleszone_get_variation( $product );
        $flip_image_src = false;
        
        if ( saleszone_option( 'category-product-flipper' ) ) {
            $images_ids = $variation->get_gallery_image_ids();
            if ( !empty($images_ids) ) {
                $flip_image_src = ( has_post_thumbnail() ? wp_get_attachment_image_url( $images_ids[0], apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' ) ) : esc_url( wc_placeholder_img_src() ) );
            }
        }
        
        
        if ( $flip_image_src ) {
            wc_get_template( 'loop/product-image-flipper.php', array(
                'variation'      => $variation,
                'flip_image_src' => $flip_image_src,
            ) );
        } else {
            wc_get_template( 'loop/product-image.php', array(
                'variation'      => $variation,
                'flip_image_src' => false,
            ) );
        }
    
    }

}
if ( !function_exists( 'saleszone_render_product_labels' ) ) {
    function saleszone_render_product_labels()
    {
        global  $product ;
        $variation = saleszone_get_variation( $product );
        wc_get_template( 'single-product/labels.php', array(
            'variation' => $variation,
        ) );
    }

}
if ( !function_exists( 'woocommerce_template_loop_product_title' ) ) {
    function woocommerce_template_loop_product_title( $args )
    {
        echo  '<div class="product-loop-title"><a href="' . esc_url( get_the_permalink() ) . '" data-product-permalink>' . get_the_title( $args['variation']->get_ID() ) . '</a></div>' ;
    }

}
if ( !function_exists( 'saleszone_get_social_share_links' ) ) {
    function saleszone_get_social_share_links()
    {
        global  $post ;
        $share_links = array(
            'facebook'    => 'https://www.facebook.com/sharer/sharer.php?u=' . get_permalink(),
            'twitter'     => 'https://twitter.com/intent/tweet?text=' . get_the_title() . '&amp;url=' . get_permalink(),
            'google-plus' => 'https://plus.google.com/share?url=' . get_permalink(),
            'telegram'    => 'https://telegram.me/share/url?text=' . get_the_title() . '&amp;url=' . get_permalink(),
            'vkontakte'   => 'http://vk.com/share.php?title=' . get_the_title() . '&amp;url=' . get_permalink(),
            'reddit'      => 'https://reddit.com/submit/?url=' . get_permalink(),
            'linkedIn'    => 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . get_permalink() . '&amp;title=' . get_the_title() . '&amp;summary=' . get_the_title() . '&amp;source=' . get_permalink(),
            'xing'        => 'https://www.xing.com/app/user?op=share;url=' . get_permalink() . '&amp;title=' . get_the_title(),
        );
        
        if ( get_post_thumbnail_id( $post->ID ) ) {
            $pinterest_media = ( get_post_thumbnail_id( $post->ID ) ? '&amp;media=' . wp_get_attachment_image_url( get_post_thumbnail_id( $post->ID ) ) : '' );
            $share_links['pinterest'] = 'https://pinterest.com/pin/create/button/?url=' . get_permalink() . $pinterest_media . '&amp;description=' . get_the_title();
        }
        
        return apply_filters( 'premmerce_social_share_links', $share_links );
    }

}
if ( !function_exists( 'saleszone_render_shipping_info' ) ) {
    function saleszone_render_shipping_info()
    {
        wc_get_template( 'single-product/shipping-info.php' );
    }

}
if ( !function_exists( 'saleszone_render_stock' ) ) {
    function saleszone_render_stock()
    {
        global  $product ;
        $class = '';
        if ( $product->get_type() === 'variable' ) {
            $class = 'hidden';
        }
        echo  '<div class="pc-product-action pc-product-action--stock-html ' . esc_attr( $class ) . '" data-product-availability-html>' . wc_get_stock_html( $product ) . '</div>' ;
    }

}
if ( !function_exists( 'saleszone_render_archive_stock' ) ) {
    function saleszone_render_archive_stock()
    {
        if ( saleszone_option( 'category-product-display-stock' ) ) {
            saleszone_render_stock();
        }
    }

}
if ( !function_exists( 'saleszone_render_variation_info' ) ) {
    function saleszone_render_variation_info()
    {
        wc_get_template( 'single-product/variation-info.php' );
    }

}
if ( !function_exists( 'saleszone_render_breadcrumb' ) ) {
    function saleszone_render_breadcrumb()
    {
        if ( !is_front_page() ) {
            
            if ( function_exists( 'yoast_breadcrumb' ) ) {
                yoast_breadcrumb( '<div class="page__breadcrumbs"><div class="page__container"><div class="breadcrumbs breadcrumbs--yoast">', '</div></div></div>' );
            } elseif ( function_exists( 'woocommerce_breadcrumb' ) ) {
                woocommerce_breadcrumb();
            }
        
        }
    }

}
if ( !function_exists( 'saleszone_render_header_search' ) ) {
    function saleszone_render_header_search()
    {
        
        if ( saleszone_is_woocommerce_activated() ) {
            the_widget( 'WC_Widget_Product_Search', 'title=' );
        } else {
            get_search_form();
        }
    
    }

}
if ( !function_exists( 'saleszone_render_wishlist_catalog_button' ) ) {
    function saleszone_render_wishlist_catalog_button()
    {
        
        if ( function_exists( 'premmerce_wishlist' ) ) {
            global  $wishlistPage ;
            global  $product ;
            $productId = $product->get_ID();
            if ( isset( $wishlistPage ) && $wishlistPage == true ) {
                return;
            }
            $type = apply_filters( 'premmerce_wishlist_catalog_button_type', 'link' );
            ?>
            <div class="pc-product-action" data-ajax-inject="wishlist-<?php 
            echo  esc_attr( $type ) ;
            ?>--<?php 
            echo  esc_attr( $productId ) ;
            ?>"> <?php 
            wc_get_template( '../premmerce-woocommerce-wishlist/wishlist-btn.php', array(
                'type'      => $type,
                'productId' => $productId,
            ) );
            ?> </div> <?php 
        }
    
    }

}
if ( !function_exists( 'saleszone_render_wishlist_catalog_button_snippet' ) ) {
    function saleszone_render_wishlist_catalog_button_snippet()
    {
        
        if ( function_exists( 'premmerce_wishlist' ) ) {
            global  $wishlistPage ;
            global  $product ;
            $productId = $product->get_ID();
            if ( isset( $wishlistPage ) && $wishlistPage == true ) {
                return;
            }
            $type = apply_filters( 'premmerce_wishlist_catalog_snippet_button_type', 'link' );
            ?>
            <div class="product-snippet__action-item">
                <div class="pc-product-action"
                     data-ajax-inject="wishlist-<?php 
            echo  esc_attr( $type ) ;
            ?>--<?php 
            echo  esc_attr( $productId ) ;
            ?>"> <?php 
            wc_get_template( '../premmerce-woocommerce-wishlist/wishlist-btn.php', array(
                'type'      => $type,
                'productId' => $productId,
            ) );
            ?>
                </div>
            </div>
            <?php 
        }
    
    }

}
if ( !function_exists( 'saleszone_render_wishlist_product_button' ) ) {
    function saleszone_render_wishlist_product_button()
    {
        
        if ( function_exists( 'premmerce_wishlist' ) ) {
            global  $product ;
            $productId = $product->get_ID();
            $type = apply_filters( 'premmerce_wishlist_product_button_type', 'link' );
            ?>
            <div class="pc-product-action" data-ajax-inject="wishlist-<?php 
            echo  esc_attr( $type ) ;
            ?>--<?php 
            echo  esc_attr( $productId ) ;
            ?>"> <?php 
            wc_get_template( '../premmerce-woocommerce-wishlist/wishlist-btn.php', array(
                'type'      => $type,
                'productId' => $productId,
            ) );
            ?> </div> <?php 
        }
    
    }

}
if ( !function_exists( 'saleszone_render_compare_catalog_button' ) ) {
    function saleszone_render_compare_catalog_button()
    {
        global  $premmerce_comparison_frontend ;
        global  $product ;
        if ( !isset( $premmerce_comparison_frontend ) ) {
            return;
        }
        wc_get_template( 'premmerce-product-comparison/comparison-btn.php', array(
            'url'       => saleszone_get_comparision_add_url(),
            'productId' => $product->get_ID(),
            'type'      => apply_filters( 'premmerce_comparison_catalog_button_type', 'link' ),
        ) );
    }

}
if ( !function_exists( 'saleszone_render_compare_catalog_button_snippet' ) ) {
    function saleszone_render_compare_catalog_button_snippet()
    {
        global  $premmerce_comparison_frontend ;
        global  $product ;
        if ( !isset( $premmerce_comparison_frontend ) ) {
            return;
        }
        ?>
        <div class="product-snippet__action-item">
            <?php 
        wc_get_template( 'premmerce-product-comparison/comparison-btn.php', array(
            'url'       => saleszone_get_comparision_add_url(),
            'productId' => $product->get_ID(),
            'type'      => apply_filters( 'premmerce_comparison_catalog_snippet_button_type', 'link' ),
        ) );
        ?>
        </div>
        <?php 
    }

}
if ( !function_exists( 'saleszone_render_compare_product_button' ) ) {
    function saleszone_render_compare_product_button()
    {
        global  $premmerce_comparison_frontend ;
        global  $product ;
        if ( !isset( $premmerce_comparison_frontend ) ) {
            return;
        }
        ?>
        <div class="pc-product-action">
            <?php 
        wc_get_template( 'premmerce-product-comparison/comparison-btn.php', array(
            'url'       => saleszone_get_comparision_add_url(),
            'productId' => $product->get_ID(),
            'type'      => apply_filters( 'premmerce_comparison_product_button_type', 'link' ),
        ) );
        ?>
        </div>
        <?php 
    }

}
if ( !function_exists( 'saleszone_render_loop_variations' ) ) {
    function saleszone_render_loop_variations()
    {
        wc_get_template( 'loop/variations.php' );
    }

}
if ( !function_exists( 'saleszone_catalog_render_main_attributes' ) ) {
    function saleszone_catalog_render_main_attributes()
    {
        if ( saleszone_option( 'category-product-attributes' ) ) {
            saleszone_render_main_attributes( 'attributes-list--inline attributes-list--small' );
        }
    }

}
if ( !function_exists( 'saleszone_single_product_render_main_attributes' ) ) {
    function saleszone_single_product_render_main_attributes()
    {
        if ( saleszone_option( 'product-main-attributes' ) ) {
            saleszone_render_main_attributes( 'attributes-list--inline' );
        }
    }

}
if ( !function_exists( 'saleszone_template_loop_single_excerpt' ) ) {
    function saleszone_template_loop_single_excerpt()
    {
        if ( !saleszone_option( 'category-product-short-description' ) ) {
            return;
        }
        wc_get_template( 'single-product/short-description.php' );
    }

}
if ( !function_exists( 'saleszone_dynamic_product_sidebar' ) ) {
    /**
     *  Show dynamic_sidebar on category products sidebar
     */
    function saleszone_dynamic_product_sidebar()
    {
        dynamic_sidebar( 'product_sidebar' );
    }

}
if ( !function_exists( 'saleszone_render_css_variable_polifil' ) ) {
    /**
     *  Show dynamic_sidebar on category products sidebar
     */
    function saleszone_render_css_variable_polifil()
    {
        ?>
        <script>
            !function () {
                "use strict";
                var cssVarPoly = {
                    init: function () {
                        window.CSS && window.CSS.supports && window.CSS.supports("(--foo: red)") || (document.querySelector("body").classList.add("cssvars-polyfilled"), cssVarPoly.ratifiedVars = {}, cssVarPoly.varsByBlock = {}, cssVarPoly.oldCSS = {}, cssVarPoly.findCSS(), cssVarPoly.updateCSS())
                    }, findCSS: function () {
                        var e = document.querySelectorAll('style:not(.inserted),link[type="text/css"]'), r = 1;
                        [].forEach.call(e, function (e) {
                            var s = void 0;
                            "STYLE" === e.nodeName ? (s = e.innerHTML, cssVarPoly.findSetters(s, r)) : "LINK" === e.nodeName && (cssVarPoly.getLink(e.getAttribute("href"), r, function (e, r) {
                                    cssVarPoly.findSetters(r.responseText, e), cssVarPoly.oldCSS[e] = r.responseText, cssVarPoly.updateCSS()
                                }), s = ""), cssVarPoly.oldCSS[r] = s, r++
                        })
                    }, findSetters: function (e, r) {
                        cssVarPoly.varsByBlock[r] = e.match(/(--[^-]{1}[-a-zA-Z0-9]+:[^;{}]+;)/g) || []
                    }, updateCSS: function () {
                        cssVarPoly.ratifySetters(cssVarPoly.varsByBlock);
                        for (var e in cssVarPoly.oldCSS) {
                            var r = cssVarPoly.replaceGetters(cssVarPoly.oldCSS[e], cssVarPoly.ratifiedVars);
                            if (document.querySelector("#inserted" + e)) document.querySelector("#inserted" + e).innerHTML = r; else {
                                var s = document.createElement("style");
                                s.type = "text/css", s.innerHTML = r, s.classList.add("inserted"), s.id = "inserted" + e, document.getElementsByTagName("head")[0].appendChild(s)
                            }
                        }
                    }, replaceGetters: function (e, r) {
                        for (var s in r) {
                            var t = new RegExp("var\\(\\s*" + s + "\\s*\\)", "g");
                            e = e.replace(t, r[s])
                        }
                        return e
                    }, ratifySetters: function (e) {
                        for (var r in e) {
                            e[r].forEach(function (e) {
                                var r = e.split(/:/), s = r[0], t = r[1].replace(/;/, "");
                                cssVarPoly.ratifiedVars[s.trim()] = t.trim()
                            })
                        }
                    }, getLink: function (e, r, s) {
                        var t = new XMLHttpRequest;
                        t.open("GET", e, !0), t.overrideMimeType("text/css;"), t.onload = function () {
                            t.status >= 200 && t.status < 400 ? "function" === typeof s && s(r, t) : console.warn("an error was returned from:", e)
                        }, t.onerror = function () {
                            console.warn("we could not get anything from:", e)
                        }, t.send()
                    }
                };
                cssVarPoly.init();
            }();
        </script>
        <?php 
    }

}
/**
 * Display shipping method description form premmerce toolkit plugin
 */
if ( !function_exists( 'saleszone_render_shipping_method_description' ) ) {
    function saleszone_render_shipping_method_description( $method )
    {
        $shippingMethod = WC_Shipping_Zones::get_shipping_method( $method->get_instance_id() );
        if ( !$shippingMethod ) {
            return false;
        }
        $instanceFormFields = $shippingMethod->get_instance_form_fields();
        
        if ( array_key_exists( 'description', $instanceFormFields ) ) {
            echo  "<p>" . esc_html( $shippingMethod->get_instance_option( 'description' ) ) . "</p>" ;
        } else {
            echo  '' ;
        }
    
    }

}
if ( !function_exists( 'saleszone_render_catalog_btn_menu' ) ) {
    function saleszone_render_catalog_btn_menu()
    {
        if ( has_nav_menu( 'main_catalog_nav' ) ) {
            
            if ( get_theme_mod( 'header-main-menu-type' ) == 'mega' ) {
                wp_nav_menu( array(
                    'theme_location' => 'main_catalog_nav',
                    'walker'         => new WalkerCatalogMegaVertical(),
                    'container'      => false,
                    'items_wrap'     => '<nav class="vertical-nav" data-megamenu-vertical><ul class="vertical-nav__items">%3$s</ul></nav>',
                ) );
            } else {
                wp_nav_menu( array(
                    'theme_location' => 'main_catalog_nav',
                    'walker'         => new WalkerCatalogVertical(),
                    'container'      => false,
                    'items_wrap'     => '<nav class="vertical-nav"><ul class="vertical-nav__items">%3$s</ul></nav>',
                ) );
            }
        
        }
    }

}
/**
 * woocommerce_shortcode_before_product_loop
 */
function saleszone_render_before_product_shortcode()
{
    ob_start();
}

function saleszone_render_after_product_shortcode( $attributes )
{
    $template_name = ( empty($attributes['template']) ? 'default' : $attributes['template'] );
    wc_get_template( '../parts/shortcode-templates/products/' . $template_name . '.php', array(
        'attributes' => $attributes,
        'content'    => ob_get_clean(),
    ) );
}

/**
 *
 */
function saleszone_render_product_actions()
{
    wc_get_template( 'loop/actions.php' );
}

if ( !function_exists( 'saleszone_template_single_more_link' ) ) {
    function saleszone_template_single_more_link()
    {
        global  $product ;
        echo  '<div class="pc-product-summary__more-link"><a class="link link--main" href="' . esc_url( $product->get_permalink() ) . '">' . esc_html__( 'More details', 'saleszone' ) . '</a></div>' ;
    }

}
if ( !function_exists( 'saleszone_render_archive_products_description' ) ) {
    function saleszone_render_archive_products_description()
    {
        wc_get_template( 'loop/archive-description.php' );
    }

}
if ( !function_exists( 'saleszone_render_archive_products_description_in_footer' ) ) {
    function saleszone_render_archive_products_description_in_footer()
    {
        if ( !saleszone_option( 'category-show-description-on-top' ) ) {
            saleszone_render_archive_products_description();
        }
    }

}
if ( !function_exists( 'saleszone_render_premmerce_active_filters_widget' ) ) {
    function saleszone_render_premmerce_active_filters_widget()
    {
        if ( !saleszone_option( 'category-active-filter' ) || !saleszone_is_plugin_active( 'premmerce-woocommerce-product-filter/premmerce-filter.php' ) && !saleszone_is_plugin_active( 'premmerce-woocommerce-product-filter-premium/premmerce-filter.php' ) ) {
            return;
        }
        ob_start();
        the_widget( 'Premmerce\\Filter\\Widget\\ActiveFilterWidget' );
        $widget = ob_get_clean();
        ?>

        <?php 
        
        if ( trim( strip_tags( $widget ) ) != '' ) {
            ?>
        <div class="content__row content__row--sm">
            <div class="pc-active-filter pc-active-filter--hor">
                <?php 
            echo  $widget ;
            ?>
            </div>
        </div>
        <?php 
        }
        
        ?>

        <?php 
    }

}
if ( !function_exists( 'saleszone_content_width' ) ) {
    /**
     * Define content width
     */
    function saleszone_content_width()
    {
        $GLOBALS['content_width'] = apply_filters( 'saleszone_content_width', get_theme_mod( 'site-content-width', saleszone_option( 'content_width' ) ) );
    }

}
if ( !function_exists( 'saleszone_add_editor_styles' ) ) {
    function saleszone_add_editor_styles()
    {
        add_editor_style( 'public/css/styles.min.css' );
    }

}