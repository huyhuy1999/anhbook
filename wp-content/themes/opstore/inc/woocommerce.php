<?php
if( ! defined( 'ABSPATH' ) ) {
	exit; // exit if accessed directly
}

/**
 * ===================================================
 * WooCommerce function definition & modification file
 * ===================================================
 */

function opstore_woocommerce_setup() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'opstore_woocommerce_setup' );

/**
 * WooCommerce default actions removed
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/**
 * Make some adjustments and rehook the required functions to their actions
 */
add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 50 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 60 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

//remove single sidebar
remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);

/**
 * ===========================================
 * WooCommerce modification made to our theme
 * ===========================================
 */


/**
 * Hide the woocommerce default page title
 */
add_filter( 'woocommerce_show_page_title', 'opstore_wc_page_title' );
function opstore_wc_page_title() {
	return false;
}



/**
 * ==================
 * Products Loop
 * ==================
 */

/**
 * Custom hooks
 */
add_action( 'opstore_loop_before_thumbnail', 'opstore_button_wrapper_open', 5 );
function opstore_button_wrapper_open() {
    echo '<div class="icons">';
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'opstore_loop_add_to_cart_args', 10, 3 );
function opstore_loop_add_to_cart_args( $args, $product ) {

    $class = $args['class'];
    unset( $args['class'] );
    $filtered_class = $class;
    if( preg_match('/\bbutton\b/', $class ) ) {
        $filtered_class = preg_replace('/\bbutton\b/', 'btn ', $class );
    }

    $args['class'] = $filtered_class;

    return $args;
}

add_action( 'opstore_loop_before_thumbnail', 'woocommerce_template_loop_add_to_cart', 10 );

/**
 ** Product Wishlist Button Function
**/
add_action('opstore_wishlist_products','opstore_wishlist_products');
if (defined( 'YITH_WCWL' )) { 

    function opstore_wishlist_products() {      
          global $product;
          $url = add_query_arg( 'add_to_wishlist', get_the_ID() );
          $id = get_the_ID();
          $wishlist_url = YITH_WCWL()->get_wishlist_url(); ?> 

            <div class="add-to-wishlist-custom add-to-wishlist-<?php echo esc_attr( $id ); ?>">
                
                <div class="yith-wcwl-add-button show" style="display:block">
                    <a href="<?php echo esc_url( $url ); ?>" data-toggle="tooltip" data-placement="top" rel="nofollow" data-product-id="<?php echo esc_attr( $id ); ?>" data-product-type="simple" title="<?php esc_attr_e( 'Add to Wishlist', 'opstore' ); ?>" class="add_to_wishlist link-wishlist btn">
                        <span class="lnr lnr-heart"></span>
                    </a>
                </div>            

                <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
                    <a class="link-wishlist btn" href="<?php echo esc_url( $wishlist_url ); ?>"><span class="lnr lnr-checkmark-circle"></span></a>
                </div>

                <div class="yith-wcwl-wishlistexistsbrowse hide" style="display:none">
                    <a  class="link-wishlist btn" href="<?php echo esc_url( $wishlist_url ); ?>"><span class="lnr lnr-checkmark-circle"></span></a>
                </div>

                <div class="clear"></div>
                <div class="yith-wcwl-wishlistaddresponse"></div>

            </div>

         <?php
    }
}    

add_action( 'opstore_loop_before_thumbnail', 'opstore_add_to_favorite_icon', 15 );
function opstore_add_to_favorite_icon() {
    if( ! function_exists('yith_wishlist_constructor') ) {
        return;
    }
    do_action('opstore_wishlist_products');
}


add_action( 'opstore_loop_before_thumbnail', 'opstore_add_to_compare_icon', 15 );
function opstore_add_to_compare_icon() {
    if( ! function_exists('yith_woocompare_constructor') ) {
        return;
    }
    global $product;
    $product_id = $product->get_id();
    $args = array(
        'action' => 'yith-woocompare-add-product',
        'id' => $product_id
    );

    $lang = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : false;
    if( $lang ) {
        $args['lang'] = $lang;
    }
    $url = esc_url_raw( add_query_arg( $args, site_url() ) );
    echo '<a href="'.esc_url($url).'" data-product_id="'.esc_attr($product_id).'" class="compare btn"><span class="lnr lnr-sync"></span></a>';
}

add_action( 'opstore_loop_before_thumbnail', 'opstore_quick_view_icon', 15 );
function opstore_quick_view_icon() {
    if( ! function_exists('yith_wcqv_init') ) {
        return;
    }
    global $product;
    $product_id = $product->get_id();
    // add_filter( 'yith_add_quick_view_button_html', 'opstore_quick_view_button_html', 10, 3 );
    echo '<a href="#" class="btn yith-wcqv-button" data-product_id="'.esc_attr($product_id).'"><span class="lnr lnr-magnifier"></span></a>';
}


add_action( 'opstore_loop_before_thumbnail', 'opstore_button_wrapper_close', 30 );
function opstore_button_wrapper_close() {
    echo '</div>';
}

add_action( 'woocommerce_before_shop_loop_item_title', 'opstore_before_thumbnail_wrapper_open', 5 );
function opstore_before_thumbnail_wrapper_open() {
    $sale_type = get_theme_mod('opstore_saletag_type','circle');
    $sale_position = 'left';
    echo '<div class="product-wrap base-align '.esc_attr($sale_type).' '.esc_attr($sale_position).'">';
}

add_action( 'woocommerce_before_shop_loop_item_title', 'opstore_print_product_link', 8 );
function opstore_print_product_link() {
    global $product;
    $id = $product->get_id();
    $link = get_permalink( $id );
    echo '<a href="'.esc_url( $link ).'">&nbsp;</a>';
}

add_action( 'woocommerce_before_shop_loop_item_title', 'opstore_after_thumbnail_wrapper_close', 30 );
function opstore_after_thumbnail_wrapper_close() {
    echo '</div>';
}

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'opstore_modify_item_title_output', 10 );
function opstore_modify_item_title_output() {
    echo '<h6 class="woocommerce-loop-product__title"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h6>';
}

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

/**
 * ===========================================
 * Product Archive page & Custom template loop
 * ===========================================
 */

add_filter( 'loop_shop_per_page', 'opstore_loop_shop_per_page', 20 );
function opstore_loop_shop_per_page( $cols ) {
  $number = get_theme_mod('opstore_product_perpage', 9);
  return $number;
}


/**
 * ================================
 * Product Detail Page
 * ================================
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );


/**
 * Remove default stock html
 */
add_filter( 'woocommerce_get_stock_html', 'opstore_remove_default_stock_html', 99, 2 );
function opstore_remove_default_stock_html( $label, $product ) {
    $label = '';

    return $label;
}


add_action( 'woocommerce_single_product_summary', 'opstore_add_breadcrumb_to_product_detial', 4);
function opstore_add_breadcrumb_to_product_detial() {
    if( is_singular( 'product' ) ) {
        $args = array( 'delimeter' => '<span class="">/</span>' );
        woocommerce_breadcrumb( $args );
    }
    
}

/* Add Share Icons */
if(class_exists('Ultra_Companion')){
    add_action('woocommerce_single_product_summary','opstore_share_text',50);
    add_action('woocommerce_single_product_summary','ultra_companion_social_share',50);
}
function opstore_share_text(){
    echo '<div class="sharetxt">'.esc_html__('Share: ','opstore').'</div>';
}


/**
 * Cart Item Counter
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'opstore_woocommerce_header_add_to_cart_fragment' );
function opstore_woocommerce_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    ?>
    <span class="count rounded-crcl"><?php echo absint(WC()->cart->get_cart_contents_count()); ?> </span> 
    <?php
    
    $fragments['span.count.rounded-crcl'] = ob_get_clean();
    
    return $fragments;
}

/* Wishlist Item counter */

if( defined( 'YITH_WCWL' ) && ! function_exists( 'opstore_yith_wcwl_ajax_update_count' ) ){
function opstore_yith_wcwl_ajax_update_count(){
wp_send_json( array(
'count' => yith_wcwl_count_all_products()
) );
}
add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'opstore_yith_wcwl_ajax_update_count' );
add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'opstore_yith_wcwl_ajax_update_count' );
}


/**
 * YITH Compare
 */
add_filter( 'yith_woocompare_compare_added_label', 'opstore_modify_yith_compare_added_label', 99 );
function opstore_modify_yith_compare_added_label() {
    return '';
}



/**
 * Woo Commerce Number of row filter Function
**/
add_filter('loop_shop_columns', 'opstore_loop_columns');
if (!function_exists('opstore_loop_columns')) {
    function opstore_loop_columns() {

        $xr = get_theme_mod('opstore_woo_column',3);

        return $xr;
    }
}

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function opstore_related_products_args( $args ) {
    $defaults = array(
        'posts_per_page' => 4,
        'columns'        => 4,
    );

    $args = wp_parse_args( $defaults, $args );

    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'opstore_related_products_args' );

/* For Image Flip */
remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail', 10 );

add_action ( 'woocommerce_before_shop_loop_item_title', 'opstore_product_thumb_wrapp',10);

if( ! function_exists('opstore_product_thumb_wrapp') ){
    function opstore_product_thumb_wrapp(){
        $gallery = get_post_meta(get_the_ID(), '_product_image_gallery', true);
        if($gallery == ''){
            $class = 'no-flip';
        }else{
            $class = 'flip';
        }
        $size = 'shop_catalog';
        echo '<div class="opstore-thumb-wrapp '.esc_attr($class).'">';
        echo '<div class="opstore-img-before">';
        echo woocommerce_template_loop_product_thumbnail($size);
        echo '</div>';
        opstore_loop_product_thumbnail_hover();
        echo '</div>';
    }
    
}
function opstore_loop_product_thumbnail_hover() {

    $change_hover_image = true;
    if( ! $change_hover_image )
        return;
    
    $id = get_the_ID();
    $size = 'shop_catalog';
    $gallery = get_post_meta($id, '_product_image_gallery', true);
    $attachment_image = '';
    if (!empty($gallery) && $change_hover_image ) {
        $gallery = explode(',', $gallery);

        if ( $change_hover_image ) {
            $first_image_id = $gallery[0];
                $attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'hover-image'));
        }

        echo '<div class="opstore-img-after'.(($attachment_image)?' img-effect':'').'">';
        // show images
        echo wp_kses_post($attachment_image);
        echo '</div>';
    }
}

/* For Sale Tag */

function change_displayed_sale_price_html() {
    global $product ,$post;
    if( $product->is_on_sale() ):
        $sale_label = get_theme_mod('opstore_saletag_label','discount');
        if($sale_label == 'discount'){
            if( $product->is_type('variable')){
                $percentages = array();

                // Get all variation prices
                $prices = $product->get_variation_prices();

                // Loop through variation prices
                foreach( $prices['price'] as $key => $price ){
                    // Only on sale variations
                    if( $prices['regular_price'][$key] !== $price ){
                        // Calculate and set in the array the percentage for each variation on sale
                        $percentages[] = round(100 - ($prices['sale_price'][$key] / $prices['regular_price'][$key] * 100));
                    }
                }
                // We keep the highest value
                $saving_percentage = max($percentages). '%';
                echo  sprintf( __('<span class="onsale discount-wrap">- %s</span>', 'opstore' ), $saving_percentage );
            }elseif($product->is_type('simple')){    
                // Get product prices
                $regular_price = (float) $product->get_regular_price(); 
                $sale_price = (float) $product->get_price(); 

                // "Saving Percentage" calculation and formatting
                $precision = 1;
                $saving_percentage = 100 - ( $sale_price / $regular_price * 100 );
                $saving_percentage = round($saving_percentage). '%';
                // Append to the formated html price
                echo  sprintf( __('<span class="onsale discount-wrap">- %s</span>', 'opstore' ), $saving_percentage );
            }else{}
        }else{
            $sale_text = get_theme_mod('opstore_saletag_text','Sale');
            echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html($sale_text) . '</span>', $post, $product );
        }
    endif;
    //for out of stock
    if(! $product->is_in_stock()){
        echo '<span class="onsale discount-wrap outstock">'.__('Out of stock','opstore').'</span>';
    }
}
remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash',10 );    
add_action( 'woocommerce_before_shop_loop_item_title','change_displayed_sale_price_html',10 );    

remove_action( 'woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash',10 );    
add_action( 'woocommerce_before_single_product_summary','change_displayed_sale_price_html',10 );

//add class for compare

$is_iframe = (bool)( isset( $_REQUEST['iframe'] ) && $_REQUEST['iframe'] );
function compare_add_class($classes){
    $classes[] = 'woo-compare';
    return $classes;
}
if( function_exists('yith_woocompare_constructor') && $is_iframe ) {
add_filter( 'body_class', 'compare_add_class' );
}


/**
 * Stock counter
 */
function opstore_stock_info() {
    global $product;
    if( $product->is_in_stock() ):
        ?>
        <div class="stock-info mb-10">
            <span>
                <i class="fa fa-check-square"></i> <?php esc_html_e('Instock', 'opstore' ); ?>
            </span>
        </div>
        <?php
    else:
        ?>
        <div class="stock-info out-of-stock mb-10">
            <span>
                <i class="fa fa-minus-square"></i> <?php esc_html_e('Out of stock', 'opstore' ); ?>
            </span>
        </div>
        <?php
    endif;
}
add_action( 'woocommerce_single_product_summary', 'opstore_stock_info', 26 );

/**
 * Sales Counter
 */
function opstore_sales_countdown() {
    global $product;
    if( $product->is_on_sale() ) {

        $from = $product->get_date_on_sale_from();
        $to = $product->get_date_on_sale_to();
        $now = time();

        // we don't have end time so we don't need to process any further
        if( ! $to ) {
            return;
        }

        $dateFrom = $fromTs = null;

        if( $from ) {
            // we've scheduled the date from x to y.
            $dateFrom = new DateTime($from);
            $fromTs = $dateFrom->getTimestamp();
        }
        
        $dateTo = new DateTime($to);
        $toTs = $dateTo->getTimestamp();

        // we don't need to show time cause sales hasn't begun yet.
        if( $from && $fromTs > $now ) {
            return;
        }

        $newTime = $dateTo->format('Y/m/d H:i:s');
        ?>
        <div class="countdown-wrap">
            <?php
            $title = esc_html__('Hurry Up! Offer ends in:','opstore');
            ?>
            <h6>
                <?php echo  esc_html( $title ); ?>
            </h6>

            <div class="salecount-timer" data-date="<?php echo esc_attr($newTime); ?>"></div>
        </div>
        
        
        <?php
    }
}

/* Sticky add to Cart */
function opstore_sticky_cart() {
    global $product;
    if ( is_product() ) : 
        ?>
        <div class="opstore-sticky-cart" style="display:none">
            <div class="row">
                <div class="container">
                    <div class="col-sm-8 col-md-8 col-xs-12">
                        <div class="left-wrap">
                            <div class="img-wrap">
                                <img src="<?php the_post_thumbnail_url('full');?>" alt="<?php echo esc_attr__('product image','opstore');?>">
                            </div>
                            <div class="price-wrap">
                            <?php 
                            do_action( 'woocommerce_shop_loop_item_title' );
                            do_action( 'woocommerce_after_shop_loop_item_title' );
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4 col-xs-12">
                        <div class="right-wrap">
                        <?php woocommerce_template_loop_add_to_cart();?>
                        </div>
                    </div>
                    <div class="closebtn"><span class="lnr lnr-cross-circle"></span></div>
                </div>
            </div>
        </div>

        <?php
    endif;
}
$opstore_sticky_cart = get_theme_mod('opstore_sticky_cart','show');
if($opstore_sticky_cart == 'show'){
    add_action('wp_footer','opstore_sticky_cart');
}
/* PHP Closing tag is omitted */