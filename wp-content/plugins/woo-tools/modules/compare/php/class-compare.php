<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 *
 */
class TFWC_TOOL_Compare {

	private $button_location;
	protected static $instance;
	private $options;
	private $button_args;

	public static function get_instance() {

		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function __construct() {

		$this->options = get_option('tfwctool_compare');
		$options       = $this->options;

		$this->button_args      = $this->get_button_args();
		$button_location_shop   = apply_filters('tfwctool_compare_button_location_shop', 'woocommerce_after_shop_loop_item');
		$button_location_single = apply_filters('tfwctool_compare_button_location_single_product', 'woocommerce_single_product_summary');
		$show_in_prodict_list   = (isset($options['show_in_prodict_list']) && $options['show_in_prodict_list'] == true) ? true : false;
		$show_in_prodict_list   = apply_filters('tfwctool_compare_show_in_prodict_list', $show_in_prodict_list);
		$show_in_single_product = (isset($options['show_in_single_product']) && $options['show_in_single_product'] == true) ? true : false;
		$show_in_single_product = apply_filters('tfwctool_compare_show_in_single_product', $show_in_single_product);

		if ($show_in_prodict_list) {
			add_action('woocommerce_after_shop_loop_item', 'tfwctool_add_to_compare_button', 20);
		}

		if ($show_in_single_product) {
			add_action('woocommerce_single_product_summary', 'tfwctool_add_to_compare_button', 35);
		}

		add_action('wp_enqueue_scripts', array($this, 'enqueue'));
		add_action('wp_ajax_tfwctool_add_to_compare', array($this, 'add_to_compare_ajax'));
		add_action('wp_ajax_nopriv_tfwctool_add_to_compare', array($this, 'add_to_compare_ajax'));

		add_action('wp_ajax_tfwctool_remove_from_compare', array($this, 'remove_from_compare_ajax'));
		add_action('wp_ajax_nopriv_tfwctool_remove_from_compare', array($this, 'remove_from_compare_ajax'));

		add_action('wp_ajax_tfwctool_show_compare_porducts', array($this, 'show_compare_products'));
		add_action('wp_ajax_nopriv_tfwctool_show_compare_porducts', array($this, 'show_compare_products'));

		add_action('wp_footer', array($this, 'quick_compare_list'));
		add_action('wp_footer', array($this, 'print_model'));
		add_shortcode('tfwc_tool_compare_button', array($this, 'button_shortcode'));
		//add_shortcode('tfwc_tool_compare_list', array($this, 'compare_list_shortcode'));
		if (isset($_GET['add-to-compare']) && intval($_GET['add-to-compare']) > 0) {
			$product_id = absint($_GET['add-to-compare']);
			$this->add_to_compare($product_id);
		}

	}

	public function enqueue() {
		wp_enqueue_style('tfwc-tool-compare-style', TFWCTOOL_URI . 'modules/compare/css/compare.css');
		wp_enqueue_script('jquery-cookie', TFWCTOOL_URI . 'assets/js/jquery.cookie.min.js', array('jquery'), null, true);
		wp_enqueue_script('tfwc-tool-compare-script', TFWCTOOL_URI . 'modules/compare/js/compare.js', array('jquery', 'jquery-cookie'), null, true);
	}

	public function admin_enqueue() {

	}

	public function print_button() {
		tfwctool_get_template('compare-button.php', $this->button_args);
	}

	public function print_model() {
		tfwctool_get_template('compare-model.php');
	}

	public function change_cart_url($url, $product) {
		return esc_url(wc_get_cart_url() . '?add-to-cart=' . $product->get_id());
	}

	public function add_to_compare_ajax() {
		if (isset($_POST['product_id']) && intval($_POST['product_id']) > 0) {
			$product_id = intval($_POST['product_id']);
			add_filter('woocommerce_product_add_to_cart_url', array($this, 'change_cart_url'), 10, 2);
			$this->show_compare_list();
		} else {
			echo false;
		}
		wp_die();
	}

	public function show_compare_products(){
		$this->show_compare_list();
		wp_die();
	}

	private function get_compare_products() {
		if (isset($_COOKIE['tfwc_tool_compare'])) {
			return json_decode(stripslashes($_COOKIE['tfwc_tool_compare']), true);
		} else {
			return array();
		}
	}

	private function add_to_compare($product_id) {
		$products = $this->get_compare_products();

		if ($products && in_array($product_id, $products)) {
			return true;
		}

		$products[] = $product_id;
		$name       = 'tfwc_tool_compare';
		$value      = json_encode(stripslashes_deep($products));
		$expiration = time() + apply_filters('tfwc_tool_compare_cookie_expiration', 60 * 60 * 24 * 30);
		setcookie($name, $value, $expiration, '/');
		return true;
	}

	public function remove_from_compare_ajax() {
		if (isset($_POST['product_id']) && intval($_POST['product_id']) > 0) {
			$product_id = intval($_POST['product_id']);
			echo $this->remove_from_compare($product_id);
		}
	}

	private function remove_from_compare($product_id) {
		$products      = $this->get_compare_products();
		$products_copy = $products;
		if ($products) {
			foreach ($products as $key => $product) {
				if ($product === $product_id) {
					unset($products_copy[$key]);
				}
			}
		}

		$products   = $products_copy;
		$name       = 'tfwc_tool_compare';
		$value      = json_encode(stripslashes_deep($products));
		$expiration = time() + apply_filters('tfwc_tool_compare_cookie_expiration', 60 * 60 * 24 * 30);
		setcookie($name, $value, $expiration, '/');
		return true;
	}
	public function quick_compare_list() {
		$product_ids = $this->get_compare_products();
		$args = array();
		if ($product_ids) {
			global $product;
			foreach ($product_ids as $key => $product_id) {
				$_product = wc_get_product($product_id);
				$product  = $_product;
				$products_data[] = array();
				if ($_product && $_product->exists() && $_product->is_visible()) {

					$product_permalink = $_product->is_visible() ? $_product->get_permalink($product_id) : '';
					$products_data[$key]['id'] = $product_id;
					$products_data[$key]['remove'] = sprintf('<a href="%s" data-product_id="%s" class="tfwctool-remove-quick-compare"><span>%s</span> <i class="fa fa-times"></i></a>', add_query_arg('remove-from-compare', $product_id, esc_url(site_url())), absint($product_id), esc_html__('Remove', 'woocommerce-tools'));
					$products_data[$key]['image'] = $_product->get_image();;
					

					if (!$product_permalink) {
						$products_data[$key]['title'] = $_product->get_name();
					} else {
						$products_data[$key]['title'] = sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name());
					}
				}
			}
			$args = $products_data;
		}
		tfwctool_get_template('compare-quick-model.php', $args);
	}
	public function show_compare_list() {
		$product_ids = $this->get_compare_products();
		if ($product_ids) {
			$product_attrs = array(
				'remove'       => '',
				'image'        => '',
				'title'        => '',
				'price'        => '',
				'add-to-cart'  => esc_html__('Add to cart'),
				'description'  => esc_html__('Description'),
				'availability' => esc_html__('Availability'),
				'color'        => esc_html__('Color'),
				'sku'          => esc_html__('Sku'),
				'weight'       => esc_html__('Weight'),
				'dimensions'   => esc_html__('Dimensions'),
			);
			$products_data = array();
			foreach ($product_attrs as $key => $attr) {
				$products_data[$key] = array();
			}

			global $product;
			foreach ($product_ids as $key => $product_id) {
				$_product = wc_get_product($product_id);
				$product  = $_product;

				if ($_product && $_product->exists() && $_product->is_visible()) {

					$availability      = $_product->get_availability();
					$stock_status      = $availability['class'];
					$product_permalink = $_product->is_visible() ? $_product->get_permalink($product_id) : '';

					$products_data['remove'][] = sprintf('<a href="%s" data-product_id="%s" class="tfwctool-remove-compare-product"><span>%s</span> <i class="fa fa-times"></i></a>', add_query_arg('remove-from-compare', $product_id, esc_url(site_url())), absint($product_id), esc_html__('Remove', 'woocommerce-tools'));

					$thumbnail = $_product->get_image();
					if (!$product_permalink) {
						$products_data['image'][] = $thumbnail;
					} else {
						$products_data['image'][] = sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
					}

					if (!$product_permalink) {
						$products_data['title'][] = $_product->get_name();
					} else {
						$products_data['title'][] = sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name());
					}

					$products_data['price'][] = $_product->get_price_html();

					$add_to_cart_html = '-';

					if (isset($stock_status) && $stock_status != 'out-of-stock') {
						ob_start();
						woocommerce_template_loop_add_to_cart();
						$add_to_cart_html = ob_get_clean();
					}

					$products_data['add-to-cart'][] = $add_to_cart_html;

					$description = get_the_excerpt($product_id);
					if (empty($description)) {
						$description = '-';
					}
					$products_data['description'][] = $description;

					$stock_data = '-';
					if (isset($stock_status) && $stock_status != 'out-of-stock') {
						$stock_data = esc_html__('In stock', 'woocommerce-tools');
					} else {
						$stock_data = esc_html__('Out of stock', 'woocommerce-tools');
					}

					$products_data['availability'][] = $stock_data;

					$products_data['color'][] = '-';
					$sku                      = $_product->get_sku();
					if (empty($sku)) {
						$sku = '-';
					}
					$products_data['sku'][] = $sku;

					$weight = $_product->get_weight();
					if (empty($weight)) {
						$weight = '-';
					}

					$products_data['weight'][] = $weight;
					$dimensions                = function_exists('wc_format_dimensions') ? wc_format_dimensions($_product->get_dimensions(false)) : $_product->get_dimensions();
					if (empty($dimensions)) {
						$dimensions = '-';
					}
					$products_data['dimensions'][] = $dimensions;
				}
			}

			$args = array(
				'products_data' => $products_data,
				'product_attrs' => $product_attrs,
			);

			tfwctool_get_template('compare.php', $args);
		}
	}

	public function compare_list_shortcode() {
		ob_start();
		$this->show_compare_list();
		return ob_get_clean();
	}

	public function button_shortcode($atts, $contnet) {
		ob_start();
		tfwctool_get_template('compare-button.php', $this->button_args);
		$button_html = ob_get_clean();
		return $button_html;
	}

	private function get_button_args() {
		$options                     = $this->options;
		$button_label                = isset($options['button_label']) ? $options['button_label'] : esc_html__('Compare', 'woocommerce-tools');
		$button_label                = apply_filters('tfwctool_compare_button_label', $button_label);
		$button_icon                 = (isset($options['button_icon'])) ? $options['button_icon'] : 'fa fa-refresh';
		$button_icon                 = apply_filters('tfwctool_compare_button_icon', $button_icon);
		$show_button_icon            = isset($options['show_button_icon']) ? $options['show_button_icon'] : false;
		$show_button_icon            = apply_filters('tfwctool_compare_show_button_icon', $show_button_icon);
		$button_args['icon']         = '';
		$button_args['button_label'] = $button_label;

		if ($show_button_icon) {
			$button_args['icon'] = ' <i class="' . esc_attr($button_icon) . '"></i> ';
		}
		return $button_args;
	}

}

function TFWC_TOOL_Compare() {
	return TFWC_TOOL_Compare::get_instance();
}