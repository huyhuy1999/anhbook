<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * TFWC_Tool_Quick_View
 */

class TFWC_Tool_Quick_View {
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

		$this->options = get_option('tfwctool_quickview');
		$options = $this->options;
		$this->button_args 		= $this->get_button_args();
		$show_in_prodict_list   = (isset($options['show_in_prodict_list']) && $options['show_in_prodict_list'] == true) ? true : false;
		$show_in_prodict_list   = apply_filters('tfwctool_quickview_show_in_prodict_list', $show_in_prodict_list);


		add_action('tfwctool_quick_view_product_thumbnail', 'woocommerce_show_product_sale_flash', 10);
		add_action('tfwctool_quick_view_product_thumbnail', 'woocommerce_show_product_images', 20);
		add_action('tfwctool_quick_view_product_details', 'woocommerce_template_single_title', 10);
		add_action('tfwctool_quick_view_product_details', 'woocommerce_template_single_rating', 20);
		add_action('tfwctool_quick_view_product_details', 'woocommerce_template_single_price', 30);
		add_action('tfwctool_quick_view_product_details', 'woocommerce_template_single_excerpt', 40);
		add_action('tfwctool_quick_view_product_actions', 'woocommerce_template_single_add_to_cart', 10);
		add_action('tfwctool_quick_view_product_actions', 'woocommerce_template_single_meta', 20);

		add_action('wp_ajax_tfwctool_show_product', array($this, 'show_product_ajax'));
		add_action('wp_ajax_nopriv_tfwctool_show_product', array($this, 'show_product_ajax'));

		add_action('wp_enqueue_scripts', array($this, 'enqueue'));
		if($show_in_prodict_list){
			add_action('woocommerce_after_shop_loop_item', 'tfwctool_quick_view_button', 20);
		}
		add_action('wp_footer', array($this, 'print_model'));
	}

	public function enqueue() {
		wp_enqueue_style('tfwc-tool-quick-view-style', TFWCTOOL_URI . 'modules/quick-view/css/quick-view-style.css');
		wp_enqueue_script('tfwc-tool-quick-view-script', TFWCTOOL_URI . 'modules/quick-view/js/quick-view-script.js', array('jquery'), null, true);
	}

	public function admin_enqueue() {

	}

	public function print_button() {
		tfwctool_get_template('quick-view-button.php', $this->button_args);
	}

	public function print_model() {
		tfwctool_get_template('quick-view-model.php');
	}

	public function show_product_ajax() {
		global $wpdb; // this is how you get access to the database

		$product_id = intval($_POST['product_id']);
		if ($product_id > 0):

			wp('p=' . $product_id . '&post_type=product');
			remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
			ob_start();
			tfwctool_get_template('quick-view-product-content.php');
			echo ob_get_clean();

		endif;

		wp_die(); // this is required to terminate immediately and return a proper response
	}

	private function get_button_args() {
		$options                     = $this->options;
		$button_label 				 = isset($options['button_label'])?$options['button_label']:esc_html__('Quick View', 'woocommerce-tools');
		$button_label				 = apply_filters('tfwctool_quickview_button_label', $button_label);
		$button_icon            	 = (isset($options['button_icon']))?$options['button_icon']:'fa fa-eye';
		$button_icon				 = apply_filters('tfwctool_quickview_button_icon', $button_icon);
	   	$show_button_icon       	 = isset($options['show_button_icon'])?$options['show_button_icon']:false;
	   	$show_button_icon			 = apply_filters('tfwctool_quickview_show_button_icon', $show_button_icon);
		$button_args['icon']         = '';
		$button_args['button_label'] = $button_label;

		if ($show_button_icon) {
			$button_args['icon'] = ' <i class="' . esc_attr($button_icon) . '"></i> ';
		}
		return $button_args;
	}
	
}

function TFWC_Tool_Quick_View() {
	return TFWC_Tool_Quick_View::get_instance();
}