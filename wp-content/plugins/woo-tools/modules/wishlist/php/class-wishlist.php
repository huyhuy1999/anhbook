<?php
if (!defined('ABSPATH')) {
	exit;
}

class TFWC_TOOL_Wishilst {
	private $options;
	private $wishlist_item_table;
	private $wishlist_list_table;
	protected static $instance;
	private $user_id;
	private $button_args;

	public static function get_instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		global $wpdb;
		$this->wishlist_item_table = $wpdb->prefix . 'tfwctool_wishlist_items';
		$this->wishlist_list_table = $wpdb->prefix . 'tfwctool_wishlist_lists';
		$this->options             = get_option('tfwctool_wishlist', true);
		$options                   = $this->options;
		$this->user_id             = get_current_user_id();
		$this->button_args         = $this->get_button_args();

		$show_in_prodict_list   = (isset($options['show_in_prodict_list']) && $options['show_in_prodict_list'] == true) ? true : false;
		$show_in_prodict_list   = apply_filters('tfwctool_wishlist_show_in_prodict_list', $show_in_prodict_list);
		$show_in_single_product = (isset($options['show_in_single_product']) && $options['show_in_single_product'] == true) ? true : false;
		$show_in_single_product = apply_filters('tfwctool_wishlist_show_in_single_product', $show_in_single_product);

		add_action('wp_ajax_tfwctool_add_to_wishlist', array($this, 'add_to_wishlist_ajax'));
		add_action('wp_ajax_nopriv_tfwctool_add_to_wishlist', array($this, 'add_to_wishlist_ajax'));
		add_action('wp_ajax_tfwctool_remove_from_wishlist', array($this, 'remove_from_wishlist_ajax'));
		add_action('wp_ajax_nopriv_tfwctool_remove_from_wishlist', array($this, 'remove_from_wishlist_ajax'));
		add_action('init', array($this, 'add_to_wishlist_http'));
		add_action('init', array($this, 'remove_from_wishlist_http'));
		add_action('init', array($this, 'add_rewrite_rules'), 0);
		add_filter('query_vars', array($this, 'add_wishlist_query_var'));
		if ($show_in_prodict_list) {
			add_action('woocommerce_after_shop_loop_item', 'tfwctool_add_to_wishlist_button', 30);
		}
		if ($show_in_single_product) {
			add_action('woocommerce_single_product_summary', 'tfwctool_add_to_wishlist_button', 32);
		}
	}

	public function add_to_wishlist_button() {
		tfwctool_get_template('wishlist-button.php', $this->button_args);
	}

	public function add_to_wishlist_ajax() {
		$product_id = absint($_POST['product_id']);
		$this->add_to_wishlist($product_id);
		$this->send_wishlist_over_ajax();
		wp_die();
	}

	public function add_to_wishlist_http() {
		if (isset($_GET['add-to-wishlist'])) {
			$product_id = absint($_GET['add-to-wishlist']);
			$this->add_to_wishlist($product_id);
		}
	}

	public function remove_from_wishlist_ajax() {
		$product_id = absint($_POST['product_id']);
		$this->remove_from_wishlist($product_id);
		$this->send_wishlist_over_ajax();
		wp_die();
	}

	public function remove_from_wishlist_http() {
		if (isset($_GET['remove-from-wishlist'])) {
			$product_id = absint($_GET['remove-from-wishlist']);
			$this->remove_from_wishlist($product_id);
		}
	}

	private function get_user_wishlist_id() {
		$user_id = get_current_user_id();
		global $wpdb;
		$wishlist_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT ID
				FROM $this->wishlist_list_table
				WHERE user_id = %d",
				$user_id
			));

		return $wishlist_id;
	}

	private function get_wishlist_by_token($token = '') {
		global $wpdb;
		$wishlist = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT *
				FROM $this->wishlist_list_table
				WHERE token = %s",
				$token
			));
		return $wishlist;
	}

	private function get_wishlist_id_by_token($token = '') {
		global $wpdb;
		$wishlist_id = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT ID
				FROM $this->wishlist_list_table
				WHERE token = %s",
				$token
			));
		return $wishlist_id;
	}

	private function create_user_wishlist() {
		$user_id = get_current_user_id();
		global $wpdb;
		$genrate = true;
		while ($genrate) {
			$token       = tfwctool_get_rendom_string(15);
			$wishlist_id = $this->get_wishlist_id_by_token($token);

			if (!$wishlist_id) {
				$wpdb->insert(
					$this->wishlist_list_table,
					array(
						'user_id'    => $user_id,
						'token'      => $token,
						'is_private' => false,
						'is_default' => true,
					),
					array(
						'%d',
						'%s',
						'%d',
						'%d',
					)
				);
				$genrate     = false;
				$wishlist_id = $wpdb->insert_id;
			}
		}
		return $wishlist_id;
	}

	private function add_to_wishlist($product_id) {
		$res = false;
		if (is_user_logged_in()) {
			$res = $this->add_to_wishlist_db($product_id);
		} else {
			$res = $this->add_to_wishlist_local($product_id);
		}
		return $res;
	}

	public function remove_from_wishlist($product_id) {
		$res = false;
		if (is_user_logged_in()) {
			$res = $this->remove_from_wishlist_db($product_id);
		} else {
			$res = $this->remove_from_wishlist_local($product_id);
		}
		return $res;
	}

	private function is_product_in_wishlist($user_id, $wishlist_id, $product_id) {
		global $wpdb;
		$product_count = $wpdb->get_var($wpdb->prepare(
			"SELECT COUNT(*)
				FROM $this->wishlist_item_table
				WHERE user_id = %d AND  wishlist_id = %d AND product_id = %d",
			$user_id, $wishlist_id, $product_id
		));
		return $product_count;
	}

	private function add_to_wishlist_db($product_id) {
		$user_id     = get_current_user_id();
		$wishlist_id = $this->get_user_wishlist_id();
		if (!$wishlist_id) {
			$wishlist_id = $this->create_user_wishlist();
		}

		$is_in_wishlist = $this->is_product_in_wishlist($user_id, $wishlist_id, $product_id);

		if ($is_in_wishlist <= 0) {
			global $wpdb;
			$inserted = $wpdb->insert(
				$this->wishlist_item_table,
				array(
					'user_id'     => $user_id,
					'wishlist_id' => $wishlist_id,
					'product_id'  => $product_id,
					'quantity'    => 1,
				),
				array(
					'%d',
					'%d',
					'%d',
					'%d',
				)
			);
			if ($inserted) {
				return $wpdb->insert_id;
			} else {
				return false;
			}
		}
	}

	private function add_to_wishlist_local($product_id) {
		$products = $this->get_wishlist_products_local();

		if ($products && in_array($product_id, $products)) {
			return true;
		}

		$products[] = $product_id;
		$name       = 'tfwc_tool_wishilst';
		$value      = json_encode(stripslashes_deep($products));
		$expiration = time() + apply_filters('tfwc_tool_wishilst_cookie_expiration', 60 * 60 * 24 * 365);
		wc_setcookie($name, $value, $expiration, false);
		return true;
	}

	private function remove_from_wishlist_db($product_id) {
		$user_id     = get_current_user_id();
		$wishlist_id = $this->get_user_wishlist_id();
		if (!$wishlist_id) {
			return;
		}

		$is_in_wishlist = $this->is_product_in_wishlist($user_id, $wishlist_id, $product_id);

		if (intval($is_in_wishlist)) {
			global $wpdb;
			$deleted = $wpdb->delete(
				$this->wishlist_item_table,
				array(
					'user_id'     => $user_id,
					'wishlist_id' => $wishlist_id,
					'product_id'  => $product_id,
				),
				array(
					'%d',
					'%d',
					'%d',
					'%d',
				)
			);

			if ($deleted) {
				return $deleted;
			} else {
				return false;
			}
		}
	}

	private function remove_from_wishlist_local($product_id) {
		$products = $this->get_wishlist_products_local();

		if (($key = array_search($product_id, $products)) !== false) {
			unset($products[$key]);
		}

		$name       = 'tfwc_tool_wishilst';
		$value      = json_encode(stripslashes_deep($products));
		$expiration = time() + apply_filters('tfwc_tool_wishilst_cookie_expiration', 60 * 60 * 24 * 365);
		wc_setcookie($name, $value, $expiration, false);
		return true;
	}

	private function get_wishlist_products_local() {
		if (isset($_COOKIE['tfwc_tool_wishilst'])) {
			return json_decode(stripslashes($_COOKIE['tfwc_tool_wishilst']), true);
		} else {
			return false;
		}
	}

	private function get_user_wishlist() {
		global $wpdb;
		$user_id     = get_current_user_id();
		$wishlist_id = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT *
				FROM $this->wishlist_list_table
				WHERE user_id = %d",
				$user_id
			));

		return $wishlist_id;
	}

	private function get_wishlist_products_by_token($token) {
		global $wpdb;
		$items = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT product_id
				FROM $this->wishlist_item_table items
				INNER JOIN $this->wishlist_list_table lists ON items.wishlist_id = lists.ID
				WHERE lists.token = %s",
				$token
			));
		return $items;
	}
	
	public function get_user_wishlist_products_count(){
		$items = $this->get_user_wishlist_products();
		if(is_array($items)){
			return count($items);
		}
		return 0;
	}

	private function get_user_wishlist_products() {
		if (is_user_logged_in()) {
			return $this->get_user_wishlist_products_db();
		} else {
			return $this->get_wishlist_products_local();
		}
	}

	private function get_user_wishlist_products_db() {
		global $wpdb;
		$user_id = get_current_user_id();
		$items   = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT product_id
				FROM $this->wishlist_item_table items
				INNER JOIN $this->wishlist_list_table lists ON items.wishlist_id = lists.ID
				WHERE lists.user_id = %d",
				$user_id
			));
		return $items;
	}
	public function add_wishlist_query_var($query_vars) {
		$query_vars[] = 'wishlist-route';
		return $query_vars;
	}

	public function add_rewrite_rules() {
		$wishlist_page_id = get_option('tfwctool_wishlist_page_id');

		if (empty($wishlist_page_id)) {
			return;
		}

		$wishlist_page = get_post($wishlist_page_id);
		$wishlist_slug = $wishlist_page->post_name;

		if (empty($wishlist_slug)) {
			return;
		}

		$regex_paged  = '(([^/]+/)*' . $wishlist_slug . ')(/(.*))?/page/([0-9]{1,})/?$';
		$regex_simple = '(([^/]+/)*' . $wishlist_slug . ')(/(.*))?/?$';

		add_rewrite_rule($regex_paged, 'index.php?pagename=$matches[1]&wishlist-route=$matches[4]&paged=$matches[5]', 'top');
		add_rewrite_rule($regex_simple, 'index.php?pagename=$matches[1]&wishlist-route=$matches[4]', 'top');

		$rewrite_rules = get_option('rewrite_rules');

		if (!is_array($rewrite_rules) || !array_key_exists($regex_paged, $rewrite_rules) || !array_key_exists($regex_simple, $rewrite_rules)) {
			flush_rewrite_rules();
		}
	}

	public function print_wishlist($user_id = '') {
		$params  = get_query_var('wishlist-route', false);
		$actions = explode('/', $params);
		$view    = isset($actions[0]) ? $actions[0] : 'view';
		$token   = isset($actions[1]) ? $actions[1] : '';

		if (is_user_logged_in()) {
			$user_id = get_current_user_id();
			if (!empty($token)) {
				$wishlist = $this->get_wishlist_by_token($token);
				if ($wishlist->user_id == $user_id) {
					$product_ids = $this->get_wishlist_products_by_token($token);
					$this->show($product_ids);
				} elseif (!absint($wishlist->is_private)) {
					$product_ids = $this->get_wishlist_products_by_token($token);
					$this->show($product_ids);
				}
			} else {
				$product_ids = $this->get_user_wishlist_products_db();
				$this->show($product_ids);
			}
		} else {
			$product_ids = $this->get_wishlist_products_local();
			$this->show($product_ids);
		}
	}
	public function send_wishlist_over_ajax(){
		ob_start();
		$this->print_mini_wishlist();
		$fragments['.widget_tfwctool_wishlist_content'] = ob_get_clean();
		$data = apply_filters( 'tfwctool_add_to_wishlist_data', array());
		$data['fragments'] = apply_filters( 'tfwctool_add_to_wishlist_fragments', $fragments);
		wp_send_json( $data );
	}

	public static function print_mini_wishlist() {
		$product_ids = array();
		if (is_user_logged_in()) {
			global $wpdb;
			$user_id             = get_current_user_id();
			$wishlist_item_table = $wpdb->prefix . 'tfwctool_wishlist_items';
			$wishlist_list_table = $wpdb->prefix . 'tfwctool_wishlist_lists';
			$product_ids         = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT product_id
					FROM $wishlist_item_table items
					INNER JOIN $wishlist_list_table lists ON items.wishlist_id = lists.ID
					WHERE lists.user_id = %d",
					$user_id
				));

		} elseif (isset($_COOKIE['tfwc_tool_wishilst'])) {
			$product_ids = json_decode(stripslashes($_COOKIE['tfwc_tool_wishilst']), true);
		}

		$args = array(
			'product_ids'        => $product_ids,
			'is_self'            => true,
			'can_remove_product' => true,
		);
		tfwctool_get_template('wishlist-mini.php', $args);
	}

	public function show($product_ids = array()) {
		if ($product_ids && count($product_ids) > 0) {
			$args = array(
				'product_ids'        => $product_ids,
				'is_self'            => true,
				'can_remove_product' => true,
			);
			tfwctool_get_template('wishlist.php', $args);
		} else {
			$args = array();
			tfwctool_get_template('wishlist-empty.php', $args);
		}
	}

	private function get_button_args() {
		$options                     = $this->options;
		$button_label                = isset($options['button_label']) ? $options['button_label'] : esc_html__('Add to Wishlist', 'woocommerce-tools');
		$button_label                = apply_filters('tfwctool_wishlist_button_label', $button_label);
		$button_icon                 = (isset($options['button_icon'])) ? $options['button_icon'] : 'fa fa-heart';
		$button_icon                 = apply_filters('tfwctool_wishlist_button_icon', $button_icon);
		$show_button_icon            = isset($options['show_button_icon']) ? $options['show_button_icon'] : false;
		$show_button_icon            = apply_filters('tfwctool_wishlist_show_button_icon', $show_button_icon);
		$button_args['icon']         = '';
		$button_args['button_label'] = $button_label;

		if ($show_button_icon) {
			$button_args['icon'] = ' <i class="' . esc_attr($button_icon) . '"></i> ';
		}
		return $button_args;
	}
}

function TFWC_TOOL_Wishilst() {
	return TFWC_TOOL_Wishilst::get_instance();
}