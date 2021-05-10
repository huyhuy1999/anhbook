<?php
/**
 * List products. One widget to rule them all.
 *
 * @package WooCommerce/Widgets
 * @version 3.3.0
 */

defined('ABSPATH') || exit;

/**
 * Widget products.
 */
class NewStore_WC_Widget_Products extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_products newstore_widget_products';
		$this->widget_description = __("A list of your store's products.", 'newstore');
		$this->widget_id          = 'newstore_woocommerce_products';
		$this->widget_name        = __('TF: Products', 'newstore');
		$this->settings           = array(
			'title'             => array(
				'type'  => 'text',
				'std'   => __('Products', 'newstore'),
				'label' => __('Title', 'newstore'),
			),
			'number'            => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __('Number of products to show', 'newstore'),
			),
			'show'              => array(
				'type'    => 'select',
				'std'     => '',
				'label'   => __('Show', 'newstore'),
				'options' => array(
					''         => __('All products', 'newstore'),
					'featured' => __('Featured products', 'newstore'),
					'onsale'   => __('On-sale products', 'newstore'),
				),
			),
			'orderby'           => array(
				'type'    => 'select',
				'std'     => 'date',
				'label'   => __('Order by', 'newstore'),
				'options' => array(
					'date'  => __('Date', 'newstore'),
					'price' => __('Price', 'newstore'),
					'rand'  => __('Random', 'newstore'),
					'sales' => __('Sales', 'newstore'),
				),
			),
			'order'             => array(
				'type'    => 'select',
				'std'     => 'desc',
				'label'   => _x('Order', 'Sorting order', 'newstore'),
				'options' => array(
					'asc'  => __('ASC', 'newstore'),
					'desc' => __('DESC', 'newstore'),
				),
			),
			'enable_carousel'   => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __('Enable Carousel', 'newstore'),
			),
			'carousel_number'   => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __('Number of products to show in carousel at once', 'newstore'),
			),
			'show_carousel_nav' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __('Show Carousel Nav', 'newstore'),
			),
			'hide_info'         => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __('Hide product Info', 'newstore'),
			),
			'hide_free'         => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __('Hide free products', 'newstore'),
			),
			'show_hidden'       => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __('Show hidden products', 'newstore'),
			),
		);

		parent::__construct();
	}

	/**
	 * Query the products and return them.
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 *
	 * @return WP_Query
	 */
	public function get_products($args, $instance) {
		$number                      = !empty($instance['number']) ? absint($instance['number']) : $this->settings['number']['std'];
		$show                        = !empty($instance['show']) ? sanitize_title($instance['show']) : $this->settings['show']['std'];
		$orderby                     = !empty($instance['orderby']) ? sanitize_title($instance['orderby']) : $this->settings['orderby']['std'];
		$order                       = !empty($instance['order']) ? sanitize_title($instance['order']) : $this->settings['order']['std'];
		$product_visibility_term_ids = wc_get_product_visibility_term_ids();

		$query_args = array(
			'posts_per_page' => $number,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'no_found_rows'  => 1,
			'order'          => $order,
			'meta_query'     => array(),
			'tax_query'      => array(
				'relation' => 'AND',
			),
		); // WPCS: slow query ok.

		if (empty($instance['show_hidden'])) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
				'operator' => 'NOT IN',
			);
			$query_args['post_parent'] = 0;
		}

		if (!empty($instance['hide_free'])) {
			$query_args['meta_query'][] = array(
				'key'     => '_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'DECIMAL',
			);
		}

		if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
			$query_args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['outofstock'],
					'operator' => 'NOT IN',
				),
			); // WPCS: slow query ok.
		}

		switch ($show) {
		case 'featured':
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $product_visibility_term_ids['featured'],
			);
			break;
		case 'onsale':
			$product_ids_on_sale    = wc_get_product_ids_on_sale();
			$product_ids_on_sale[]  = 0;
			$query_args['post__in'] = $product_ids_on_sale;
			break;
		}

		switch ($orderby) {
		case 'price':
			$query_args['meta_key'] = '_price'; // WPCS: slow query ok.
			$query_args['orderby']  = 'meta_value_num';
			break;
		case 'rand':
			$query_args['orderby'] = 'rand';
			break;
		case 'sales':
			$query_args['meta_key'] = 'total_sales'; // WPCS: slow query ok.
			$query_args['orderby']  = 'meta_value_num';
			break;
		default:
			$query_args['orderby'] = 'date';
		}

		return new WP_Query(apply_filters('woocommerce_products_widget_query_args', $query_args));
	}

	/**
	 * Output widget.
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 *
	 * @see WP_Widget
	 */
	public function widget($args, $instance) {
		if ($this->get_cached_widget($args)) {
			return;
		}

		ob_start();

		$products = $this->get_products($args, $instance);
		if ($products && $products->have_posts()) {
			$this->widget_start($args, $instance);
			$widget_classes = (isset($instance['enable_carousel']) && $instance['enable_carousel'] == true) ? ' widget-product-carousel owl-carousel owl-theme' : '';
			$widget_classes .= (isset($instance['hide_info']) && $instance['hide_info'] == true) ? ' info-hidden' : '';
			$widget_classes .= (isset($instance['show_carousel_nav']) && $instance['show_carousel_nav'] == true) ? ' show-carousel-nav' : '';
			echo '<ul data-items="' . absint($instance['carousel_number']) . '" class="product_list_widget justify-content-center' . esc_attr($widget_classes) . '">';

			$template_args = array(
				'widget_id'   => $args['widget_id'],
				'show_rating' => true,
			);

			while ($products->have_posts()) {
				$products->the_post();
				wc_get_template_part('content-product');
			}

			echo wp_kses_post(apply_filters('woocommerce_after_widget_product_list', '</ul>'));

			$this->widget_end($args);
		}

		wp_reset_postdata();

		echo $this->cache_widget($args, ob_get_clean()); // WPCS: XSS ok.
	}
}

function newstore_wc_widget_products_register_widgets() {
	register_widget('NewStore_WC_Widget_Products');
}
add_action('widgets_init', 'newstore_wc_widget_products_register_widgets');