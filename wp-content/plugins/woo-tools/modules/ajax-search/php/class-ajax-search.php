<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * TFWC_Tool_Ajax_Search
 */

class TFWC_Tool_Ajax_Search {
	
	protected static $instance;

	public static function get_instance() {

		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function __construct() {

		add_action('wp_ajax_tfwctool_search_auto_ajax', array($this, 'search_auto_ajax'));
		add_action('wp_ajax_nopriv_tfwctool_search_auto_ajax', array($this, 'search_auto_ajax'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue'));
	}

	public function enqueue() {
		wp_enqueue_style('tfwc-tool-ajax-search-style', TFWCTOOL_URI . 'modules/ajax-search/css/ajax-search.css');
		wp_enqueue_script('tfwc-tool-ajax-search-script', TFWCTOOL_URI . 'modules/ajax-search/js/ajax-search.js', array('jquery-ui-autocomplete', 'jquery'), null, true);
	}

	public function search_auto_ajax() {
		$results = new WP_Query(array(
			'post_type'      => array('product'),
			'post_status'    => 'publish',
			'nopaging'       => true,
			'posts_per_page' => 10,
			's'              => sanitize_text_field($_POST['search_key']),
		));
		$s_products = $results->get_posts();
		
		$args = array(
			'taxonomy'   => array('product_cat'),
			'orderby'    => 'id',
			'order'      => 'ASC',
			'hide_empty' => true,
			'fields'     => 'all',
			'number'     => 10,
			'name__like' => sanitize_text_field($_POST['search_key']),
		);
		$terms = get_terms($args);

		$items = array();
		if (!empty($s_products)) {
			foreach ($s_products as $aresult) {
				$items[] = array('label' => esc_html($aresult->post_title), 'value' => esc_html($aresult->post_title), 'url' => esc_url(get_the_permalink($aresult->ID)));
			}
		}
		if (!empty($terms)) {
			foreach ($terms as $key => $term) {
				$items[] = array('label' => esc_html($term->name), 'value' => esc_html($term->name), 'url' => esc_url(get_term_link($term->term_id)));
			}
		}
		if(empty($items)){
			$no_result_string = sprintf(__( 'No Result for %s. Click here to search', 'newstore' ), sanitize_text_field($_POST['search_key']));
			$items[] = array(
				'label' => esc_html($no_result_string), 
				'value' => esc_html(sanitize_text_field($_POST['search_key'])), 
				'url' => add_query_arg(array(
						'product_cats' => sanitize_text_field($_POST['search_cat']), 
						's'=> sanitize_text_field($_POST['search_key']), 
						'post_type'=> 'product'
					), 
					esc_url(site_url())),
			);
			
		}
		wp_send_json_success($items);
	}
}

function TFWC_Tool_Ajax_Search() {
	return TFWC_Tool_Ajax_Search::get_instance();
}