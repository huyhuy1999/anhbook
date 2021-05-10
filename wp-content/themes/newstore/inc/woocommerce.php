<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package NewSrore
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function newstore_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-lightbox' );
}
add_action( 'after_setup_theme', 'newstore_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function newstore_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'newstore_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function newstore_woocommerce_products_per_page() {
	$default_count = get_theme_mod( 'themefarmer_woocommerce_products_per_page', 12 );
	$selected_count = isset($_REQUEST['count'])?intval($_REQUEST['count']):$default_count;
	return intval($selected_count);
}
add_filter( 'loop_shop_per_page', 'newstore_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function newstore_woocommerce_thumbnail_columns() {
	return get_theme_mod( 'themefarmer_woocommerce_thumbnail_columns', 4 );
}
add_filter( 'woocommerce_product_thumbnails_columns', 'newstore_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function newstore_woocommerce_loop_columns() {
	return get_theme_mod( 'themefarmer_woocommerce_loop_columns', 3 );
}
add_filter( 'loop_shop_columns', 'newstore_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function newstore_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => get_theme_mod( 'themefarmer_woocommerce_related_products_posts_per_page', 3),
		'columns'        => get_theme_mod( 'themefarmer_woocommerce_related_products_columns', 3),
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'newstore_woocommerce_related_products_args' );

if ( ! function_exists( 'newstore_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function newstore_woocommerce_product_columns_wrapper() {
		$columns = newstore_woocommerce_loop_columns();
		echo '<div id="tf-product-loop-container" class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'newstore_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'newstore_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function newstore_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'newstore_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'newstore_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function newstore_woocommerce_wrapper_before() {
		?>
		<div class="container-full space woocommerce-wrapper">
			<div class="container">
				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'newstore_woocommerce_wrapper_before' );

if ( ! function_exists( 'newstore_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function newstore_woocommerce_wrapper_after() {
			?>
					</main><!-- #main -->
				</div><!-- #primary -->
			</div>
		</div>
	<?php
	}
}
add_action( 'woocommerce_after_main_content', 'newstore_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'newstore_woocommerce_header_cart' ) ) {
			newstore_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'newstore_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function newstore_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		newstore_woocommerce_header_cart();
		$fragments['#site-header-cart'] = ob_get_clean();
		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'newstore_woocommerce_cart_link_fragment' );

function newstore_tfwctool_wishlist_link(){
	if (class_exists('TFWC_TOOL') && class_exists('TFWC_TOOL_Wishilst')) {
		
		?>
		<a class="wishlist-link-contents" href="<?php echo esc_url(tfwctool_get_wishlist_url()); ?>">
			<div class="wishlist-link-contents-inner">
				<span class="icon"><i class="fa fa-heart"></i></span>
				<span class="count"><?php echo absint( TFWC_TOOL()->wishlist->get_user_wishlist_products_count() ); ?></span>
			</div>
		</a>
		<?php
	}
}
function newstore_tfwctool_wishlist_link_fragment($fragments){
	
	ob_start();
	newstore_tfwctool_wishlist_link();
	$fragments['.wishlist-link-contents'] = ob_get_clean();
	return $fragments;
}
add_filter( 'tfwctool_add_to_wishlist_fragments', 'newstore_tfwctool_wishlist_link_fragment' );

if ( ! function_exists( 'newstore_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function newstore_woocommerce_cart_link() {
		?>
		<a class="cart-link-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
			<div class="header-cart-top-link-left">
			<span class="icon"><i class="fa fa-shopping-basket"></i></span>
			<span class="count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
			</div>
			<div class="header-cart-top-link-right">
				<div class="label"><?php esc_html_e( 'Total', 'newstore' ); ?></div>
				<div class="amount"><?php echo WC()->cart->get_cart_subtotal();  ?></div>
			</div>
		</a>
		<?php
	}
}

if ( ! function_exists( 'newstore_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function newstore_woocommerce_header_cart() {
		?>
		<div id="site-header-cart" class="site-header-cart woocommerce">
			<div class="site-header-cart-inner">
				<?php newstore_woocommerce_cart_link(); ?>
				<div class="header-cart-conetnts">
					<div class="header-cart-top">
					<?php
						$item_count_text = sprintf(
							/* translators: number of items in the mini cart. */
							_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'newstore' ),
							WC()->cart->get_cart_contents_count()
						);
					?>
					<div class="header-cart-top-left"><?php echo esc_html($item_count_text); ?></div>
					<div class="header-cart-top-right"><a class="header-cart-top-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'View Cart', 'newstore' ); ?></a></div>
					</div>
					<div class="header-cart-products">
						<?php 
							$instance = array(
								'title' => '',
							);
							wc_get_template_part('cart/mini-cart');
						 ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

function newstore_product_view_style(){
	?>
	<div class="product-view-change-container">
		<span class="product-view-type-item view-type-grid active" data-item="grid"><i class="fa fa-th"></i></span>
		<span class="product-view-type-item view-type-list" data-item="list"><i class="fa fa-bars"></i></span>
		<!-- <span class="product-view-type-item view-type-block" data-item="block"><i class="fa fa-stop"></i></span> -->
	</div>
	<?php
}
if (get_theme_mod( 'themefarmer_show_product_view_style', true )) {
	add_action( 'woocommerce_before_shop_loop', 'newstore_product_view_style', 30);
}


function newstore_woocommerce_loop_porduct_start(){
	?>
	<div class="product-inner">
		<div class="tf-loop-product-img-container">
			<div class="tf-loop-product-thumbs">
	<?php
}

function newstore_woocommerce_loop_porduct_image_end(){
	?>
			</div><!-- .tf-loop-product-thumbs -->
			<?php do_action('newstore_action_before_image_end'); ?>
		</div><!-- .tf-loop-product-img-container -->
	<?php
}

function newstore_woocommerce_loop_porduct_info_start(){
	?>
	<div class="tf-loop-product-info-container">
	<?php
}

function newstore_woocommerce_loop_porduct_end(){
	?>
		</div><!-- .tf-loop-product-info-container -->
	</div><!-- .porduct-inner -->
	<?php
}


remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 7);
add_action( 'woocommerce_before_shop_loop_item', 'newstore_woocommerce_loop_porduct_start', 0);
add_action( 'woocommerce_after_shop_loop_item', 'newstore_woocommerce_loop_porduct_end', 9999);

// add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 100);
// remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 3);

add_action( 'woocommerce_before_shop_loop_item_title', 'newstore_woocommerce_loop_porduct_image_end', 120);
add_action( 'woocommerce_shop_loop_item_title', 'newstore_woocommerce_loop_porduct_info_start', 1);



add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_single_excerpt', 30);


function newstore_add_categories_before_title(){
	global $product;
	echo '<div class="product-categories">';
	echo wp_kses_post( get_the_term_list( $product->get_ID(), 'product_cat', '', ', ' ) );
	echo '</div>';
}
add_action( 'woocommerce_shop_loop_item_title', 'newstore_add_categories_before_title', 5);
// remove_action('woocommerce_after_shop_loop_item', 'TFWC_TOOL_Wishilst::add_to_wishlist_button', 30);

if(class_exists('TFWC_TOOL')){
	remove_action('woocommerce_after_shop_loop_item', 'tfwctool_add_to_wishlist_button', 30);
	add_action('newstore_action_before_image_end', 'tfwctool_add_to_wishlist_button');

	remove_action('woocommerce_after_shop_loop_item', 'tfwctool_quick_view_button', 20);
	add_action('newstore_action_before_image_end', 'tfwctool_quick_view_button');
	remove_action('woocommerce_single_product_summary', 'tfwctool_add_to_compare_button', 35);
	add_action('woocommerce_single_product_summary', 'tfwctool_add_to_compare_button', 999);
}

function newstore_woocommerce_sale_flash($sale_flash, $post, $product){
    $sale_price = (float) $product->get_price(); 
	$regular_price = (float) $product->get_regular_price();
    
    $precision = 1;
    if($sale_price < $regular_price){
    	$saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%';
		return '<span class="onsale">' . esc_html($saving_percentage) . '</span>';
    }
    return $sale_flash;
}
add_filter( 'woocommerce_sale_flash', 'newstore_woocommerce_sale_flash', 10, 3 );


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

function newstore_woocommerce_result_count_change_dropdown(){
	$default_count = get_theme_mod( 'themefarmer_woocommerce_products_per_page', 12 );
	$selected_count = isset($_REQUEST['count'])?intval($_REQUEST['count']):$default_count;
	$product_count1 = intval($default_count);
	$product_count2 = intval($default_count*2);
	$product_count3 = intval($default_count*3);
	$product_count4 = intval($default_count*4);
	$product_count5 = intval($default_count*5);
	?>
	<div class="shop-product-count-dropdown-con">
		<label for="woocommerce_product_count_select"><?php esc_html_e( 'Show', 'newstore' ); ?></label>
		<select name="product_count" id="woocommerce_product_count_select">
			<option value="<?php echo esc_url( add_query_arg('count', $product_count1) ); ?>" <?php selected( $selected_count, $product_count1, true ); ?>><?php echo $product_count1; ?></option>
			<option value="<?php echo esc_url( add_query_arg('count', $product_count2) ); ?>" <?php selected( $selected_count, $product_count2, true ); ?>><?php echo $product_count2; ?></option>
			<option value="<?php echo esc_url( add_query_arg('count', $product_count3) ); ?>" <?php selected( $selected_count, $product_count3, true ); ?>><?php echo $product_count3; ?></option>
			<option value="<?php echo esc_url( add_query_arg('count', $product_count4) ); ?>" <?php selected( $selected_count, $product_count4, true ); ?>><?php echo $product_count4; ?></option>
			<option value="<?php echo esc_url( add_query_arg('count', $product_count5) ); ?>" <?php selected( $selected_count, $product_count5, true ); ?>><?php echo $product_count5; ?></option>
		</select>
	</div>
	<?php
}
add_action( 'woocommerce_before_shop_loop', 'newstore_woocommerce_result_count_change_dropdown', 10 );


function newstore_woocommerce_product_get_rating_html($html, $rating, $count){
	if($rating > 0 ){
		$html = '<div class="star-rating" data-toggle="tooltip" title="'.floatval($rating).'">' . wc_get_star_rating_html( $rating, $count ) . '</div>';
	}else{
		$html = '<div class="star-rating" data-toggle="tooltip" title="'.esc_attr__( 'No Review', 'newstore' ).'">' . wc_get_star_rating_html( $rating, $count ) . '</div>';
	}
	return $html;
}
add_filter( 'woocommerce_product_get_rating_html', 'newstore_woocommerce_product_get_rating_html', 10, 3 );

function newstore_woocommerce_product_image_thumbs(){
	global $product;
	$attachment_ids = $product->get_gallery_image_ids();
	if ( $attachment_ids && has_post_thumbnail() ) {
		foreach ( $attachment_ids as $attachment_id ) {
			$image             = wp_get_attachment_image( $attachment_id, 'woocommerce_thumbnail', false, array(
				'class'                   => 'wp-post-image tf-wc-loop-thumbs',
			));
			echo wp_kses_post( $image ).'<div class="product-small-bullets"><span></span><span></span></div>';
			break;
		}
	}
}
add_action('woocommerce_before_shop_loop_item_title', 'newstore_woocommerce_product_image_thumbs', 10);

remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination');
function newstore_woocommerce_pagination() {
	?>
        <div class="clearfix"></div>
        <div class="the-pagination">
            <?php the_posts_pagination();?>
        </div>
    <?php
}
add_action('woocommerce_after_shop_loop', 'newstore_woocommerce_pagination', 10);

function newstore_wc_get_gallery_image_html( $attachment_id, $main_image = false, $index, $is_thumb = false) {
	$flexslider        = (bool) apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
	$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
	$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
	$image_size        = apply_filters( 'woocommerce_gallery_image_size', $flexslider || $main_image ? 'newstore_woocommerce_single_thumb' : $thumbnail_size );
	$full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
	$thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
	$full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
	$alt_text          = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
	$image             = wp_get_attachment_image(
		$attachment_id,
		$image_size,
		false,
		apply_filters(
			'woocommerce_gallery_image_html_attachment_image_params',
			array(
				'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
				'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
				'data-src'                => esc_url( $full_src[0] ),
				'data-large_image'        => esc_url( $full_src[0] ),
				'data-large_image_width'  => esc_attr( $full_src[1] ),
				'data-large_image_height' => esc_attr( $full_src[2] ),
				'class'                   => esc_attr( $main_image ? 'wp-post-image' : '' ),
			),
			$attachment_id,
			$image_size,
			$main_image
		)
	);
	if($is_thumb){
		return '<div data-index="'.absint($index).'" data-thumb="' . esc_url( $thumbnail_src[0] ) . '" data-thumb-alt="' . esc_attr( $alt_text ) . '" class="woocommerce-product-gallery__image">' . $image . '</div>';
	}else{
		return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" data-thumb-alt="' . esc_attr( $alt_text ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_src[0] ) . '">' . $image . '</a></div>';	
	}
}


function newstore_get_page_labels() {
	$lables = array(
		'myaccount' => '<i class="fa fa-user"></i> ' . __('My Account', 'newstore'),
		'orders'    => '<i class="fa fa-archive"></i>'.__('My Orders', 'newstore'),
		'details'   => '<i class="fa fa-user-circle-o"></i>'.__('Account details', 'newstore'),
		'login'     => '<i class="fa fa-sign-in"></i> ' . __('Login', 'newstore'),
		'register'  => '<i class="fa fa-user-plus"></i> ' . __('Register', 'newstore'),
		'cart'      => '<i class="fa fa-shopping-basket"></i> ' . __('Cart', 'newstore'),
		'checkout'  => '<i class="fa fa-check-circle-o"></i> ' . __('Checkout', 'newstore'),
		'wishlist'  => '<i class="fa fa-heart"></i> ' . __('Wishlist', 'newstore'),
		'logout'    => '<i class="fa fa-sign-out"></i> ' . __('Logout', 'newstore'),
	);

	$lables = apply_filters('newstore_page_labels', $lables);
	return $lables;
}

function newstore_get_page_links_dropdown() {
	if (class_exists('WooCommerce')) {

		global $woocommerce;

		$myaccount_page_id = get_option('woocommerce_myaccount_page_id');
		$links             = array();
		$account_link      = '#';
		if ($myaccount_page_id) {
			$account_link = get_permalink(absint($myaccount_page_id));
		}

		if (is_user_logged_in()) {
			$links['myaccount'] = $account_link;
		} else {
			$links['login']    = $account_link;
			$links['register'] = $account_link;
		}

		// $links['cart']     = wc_get_cart_url();
		// $links['checkout'] = wc_get_checkout_url();
		$wishlist_page_id = get_option('tfwctool_wishlist_page_id');
		if($wishlist_page_id){
			$links['wishlist'] = get_permalink(absint($wishlist_page_id));
		}

		if (is_user_logged_in()) {
			$links['orders'] = wc_get_account_endpoint_url( 'orders' );
			$links['details'] = wc_get_account_endpoint_url( 'edit-account' );
		}

		if (is_user_logged_in()) {
			$links['logout'] = wp_logout_url(esc_url(home_url('/')));

			if (get_option('woocommerce_force_ssl_checkout') == 'yes') {
				$links['logout'] = str_replace('http:', 'https:', $links['logout']);
			}
		}

		$links  = apply_filters('newstore_page_links', $links);
		$lables = newstore_get_page_labels();
		$html   = '';

		foreach ($links as $key => $link) {
			$html .= sprintf('<a class="dropdown-item top-bl-%1$s" href="%2$s"> %3$s </a>',
				esc_attr($key),
				esc_url($link),
				wp_kses_post($lables[$key])
			);
		}
		
		$html = '<div class="newstore-myaccount-dropdown dropdown">
					<button class="btn btn-menu-myaccount dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    '.esc_html__('My Account', 'newstore').'
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				    	'.$html.'
					</div>
				</div>';
		return $html;
	}
}