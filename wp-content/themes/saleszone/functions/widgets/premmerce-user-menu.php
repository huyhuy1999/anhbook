<?php

/**
 * Class PremmerceUserMenu
 */
class PremmerceUserMenu extends WP_Widget {

    function __construct() {

        parent::__construct(
            'saleszone_user_menu',
            esc_html__('Premmerce woocommerce user menu','saleszone'),
            array('description' => '')
        );

    }

    /**
     * FRONT
     */
    function widget($args, $instance){
        $title = isset($instance['title']) ? apply_filters( 'widget_title', $instance['title'] ) : '';

        $allowed_html = array_merge(
            saleszone_svg_allowed_html(),
            saleszone_get_allowed_html('widget')
        );

        ?>

        <?php echo wp_kses($args['before_widget'] ,$allowed_html); ?>
        <?php echo wp_kses($args['before_title'] ,$allowed_html); ?>


        <?php if (! empty( $title )) :?>
            <?php echo esc_html($title); ?>
        <?php endif; ?>

        <?php echo wp_kses($args['after_title'] ,$allowed_html); ?>

        <?php wc_get_template('../parts/widgets/premmerce-user-menu.php'); ?>

        <?php

        echo wp_kses($args['after_widget'] ,$allowed_html);
    }

    /**
     * Admin
     */
    function form( $instance ){
        $title = isset($instance['title']) ? $instance['title'] : __('User menu','saleszone');
        ?>

        <!-- Title -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
                <?php esc_html_e( 'Title','saleszone' ); ?>:
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"
                   name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>"
                   type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>

        <?php
    }

    /**
     * Admin save
     */
    function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }
}

if(!function_exists('saleszone_register_wisget_user_menu')){
    function saleszone_register_wisget_user_menu(){
        register_widget('PremmerceUserMenu');
    }
}
if(saleszone_is_woocommerce_activated()){
    add_action('widgets_init', 'saleszone_register_wisget_user_menu');
}