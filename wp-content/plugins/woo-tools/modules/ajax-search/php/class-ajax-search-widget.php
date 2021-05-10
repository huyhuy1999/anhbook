<?php
defined( 'ABSPATH' ) || exit;

/**
 * Widget Ajax_Search class.
 */
class TFWC_TOOL_Ajax_Search_WP_Widget extends WP_Widget {

	/**
	 * Constructor.
	 */
	function __construct() {
		$args = array(
			'classname'   => 'tfwctool-widget tfwctool-ajax-search-widget widget_search',
			'description' => esc_html__('Ajax Search for woocommerce', 'tfwctool'),
		);
		parent::__construct('tfwctool_ajax_search_widget', esc_html__('Ajax Product Search', 'tfwctool'), $args);
	}
	
	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}
		?>
		<div class="tfwctool_widget_ajax_search_content">
			<form role="search" method="get" class="woocommerce-product-search search-form tfwctool-search-form" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" class="tfwctool-auto-ajaxsearch-input" placeholder="<?php esc_attr_e('Search ','newstore'); ?>" value="<?php the_search_query(); ?>" name="s" title="<?php esc_attr_e('Search for:','newstore'); ?>" autcomplete="false">
				<span class="search-spinner"><i class="fa fa-refresh fa-spin"></i></span>
				<input type="hidden" name="post_type" value="product">
				<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
			</form>
		</div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		$title           = !empty($instance['title']) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e(esc_attr('Title:'));?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance             = array();
		$instance['title']    = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		return $instance;
	}
}

function register_tfwc_tool_ajax_search_widget() {
	register_widget('TFWC_TOOL_Ajax_Search_WP_Widget');
}
add_action('widgets_init', 'register_tfwc_tool_ajax_search_widget');