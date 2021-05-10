<?php
/**
 * Social Icons widget
 *
 * @package Opstore
 */
/**
 * Adds Social Icons widget.
 */
 if(!function_exists('opstore_register_social_icons_widget')){
add_action('widgets_init', 'opstore_register_social_icons_widget');

function opstore_register_social_icons_widget() {
    register_widget('Opstore_Social_Icons');
}
}
if(!class_exists('Opstore_Social_Icons')){
class Opstore_Social_Icons extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
                'opstore_social_icons', esc_html__('*Opstore Social Icons','opstore'), array(
                'description' => esc_html__('A widget that shows social icons.', 'opstore')
                )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            // This widget has no title
            // Other fields
            'title_info' => array(
                'opstore_widgets_name' => 'title_info',
                'opstore_widgets_title' => esc_html__('Info Title', 'opstore'),
                'opstore_widgets_field_type' => 'text',
            ),
            'fb' => array(
                'opstore_widgets_name' => 'fb',
                'opstore_widgets_title' => esc_html__('Facebook', 'opstore'),
                'opstore_widgets_field_type' => 'text',
            ),
            'twt' => array(
                'opstore_widgets_name' => 'twt',
                'opstore_widgets_title' => esc_html__('Twitter', 'opstore'),
                'opstore_widgets_field_type' => 'text',
            ),
            'insta' => array(
                'opstore_widgets_name' => 'insta',
                'opstore_widgets_title' => esc_html__('Instagram', 'opstore'),
                'opstore_widgets_field_type' => 'text',
            ),
            'pin' => array(
                'opstore_widgets_name' => 'pin',
                'opstore_widgets_title' => esc_html__('Pinterest', 'opstore'),
                'opstore_widgets_field_type' => 'text',
            ),
            'lnkd' => array(
                'opstore_widgets_name' => 'lnkd',
                'opstore_widgets_title' => esc_html__('Linkedin', 'opstore'),
                'opstore_widgets_field_type' => 'text',
            ),
            'gplus' => array(
                'opstore_widgets_name' => 'gplus',
                'opstore_widgets_title' => esc_html__('Google Plus', 'opstore'),
                'opstore_widgets_field_type' => 'text',
            ),

            
        );

        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        extract($args);
        echo wp_kses_post( $args['before_widget'] );
        if ( ! empty( $instance['title_info'] ) ) {
            echo wp_kses_post( $args['before_title'] ) . apply_filters( 'widget_title', $instance['title_info'] ,$instance, $this->id_base ). wp_kses_post( $args['after_title'] );// WPCS: XSS OK.
        }
        if($instance){
        $fb = $instance['fb'];
        $twet = $instance['twt'];
        $insta = $instance['insta'];
        $pin = $instance['pin'];
        $lnkd = $instance['lnkd'];
        $gplus = $instance['gplus'];
        ?>
        <ul class="social-icons">
            <?php if($fb){?>
            <li><a href="<?php echo esc_url($fb)?>" title="<?php echo esc_attr__('Facebook','opstore');?>"><i class="fa fa-facebook"></i></a></li>
            <?php }?>
            <?php if($twet){?>
            <li><a href="<?php echo esc_url($twet)?>" title="<?php echo esc_attr__('Twitter','opstore');?>"><i class="fa fa-twitter"></i></a></li>
            <?php }?>
            <?php if($lnkd){?>
            <li><a href="<?php echo esc_url($linkedin)?>" title="<?php echo esc_attr__('LinkedIn','opstore');?>"><i class="fa fa-linkedin"></i></a></li>
            <?php }?>
            <?php if($insta){?>
            <li><a href="<?php echo esc_url($insta)?>" title="<?php echo esc_attr__('Instagram','opstore');?>"><i class="fa fa-instagram"></i></a></li>
            <?php }?>
            <?php if($pin){?>
            <li><a href="<?php echo esc_url($pin)?>" title="<?php echo esc_attr__('Pinterest','opstore');?>"><i class="fa fa-pinterest"></i></a></li>
            <?php }?> 
            <?php if($gplus){?>
            <li><a href="<?php echo esc_url($gplus)?>" title="<?php echo esc_attr__('Google plus','opstore');?>"><i class="fa fa-google-plus"></i></a></li>
            <?php }?>                                                     
        </ul>
        <?php
        }
        echo wp_kses_post($after_widget);
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @uses	opstore_widgets_updated_field_value()		defined in widget-fields.php
     *
     * @return	array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            extract($widget_field);

            // Use helper function to get updated field values
            $instance[$opstore_widgets_name] = opstore_widgets_updated_field_value($widget_field, $new_instance[$opstore_widgets_name]);
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param	array $instance Previously saved values from database.
     *
     * @uses	opstore_widgets_show_widget_field()		defined in widget-fields.php
     */
    public function form($instance) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            // Make array elements available as variables
            extract($widget_field);
            $opstore_widgets_field_value = !empty($instance[$opstore_widgets_name]) ? esc_attr($instance[$opstore_widgets_name]) : '';
            opstore_widgets_show_widget_field($this, $widget_field, $opstore_widgets_field_value);
        }
    }

}
}