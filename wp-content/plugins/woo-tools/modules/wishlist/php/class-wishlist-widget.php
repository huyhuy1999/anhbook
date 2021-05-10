<?php
defined( 'ABSPATH' ) || exit;

/**
 * Widget wishlist class.
 */
class TFWC_TOOL_Wishilst_Widget extends WP_Widget {

	/**
	 * Constructor.
	 */
	function __construct() {
		$args = array(
			'classname'   => 'tfwctool-widget tfwctool-wishilst-widget',
			'description' => esc_html__('Display the customer shopping wishlist.', 'tfwctool'),
		);
		parent::__construct('tfwctool_wishlist_widget', esc_html__('Wishlist', 'tfwctool'), $args);
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
		// Insert wishlist widget placeholder - code in wishlist.js will update this on page load.
		echo '<div class="tfwctool_widget_shopping_wishlist_content">';
		TFWC_TOOL_Wishilst::print_mini_wishlist();
		echo '</div>';
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

function register_tfwc_tool_wishilst_widget() {
	register_widget('TFWC_TOOL_Wishilst_Widget');
}
add_action('widgets_init', 'register_tfwc_tool_wishilst_widget');