<?php
/**
 * Contact Info widget
 *
 * @package Opstore
 */
/**
 * Adds contact info widget.
 */
 if(!function_exists('opstore_register_info_widget')){
add_action('widgets_init', 'opstore_register_info_widget');

function opstore_register_info_widget() {
    register_widget('Opstore_Info');
}
}
if(!class_exists('Opstore_Info')){
class Opstore_Info extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
                'opstore_info', esc_html__('*Opstore Contact Info','opstore'), array(
                'description' => esc_html__('A widget that shows contact information', 'opstore')
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
            'location' => array(
                'opstore_widgets_name' => 'location',
                'opstore_widgets_title' => esc_html__('Location', 'opstore'),
                'opstore_widgets_field_type' => 'text',
            ),
            'phone' => array(
                'opstore_widgets_name' => 'phone',
                'opstore_widgets_title' => esc_html__('Phone', 'opstore'),
                'opstore_widgets_field_type' => 'text',
            ),
            'fax' => array(
                'opstore_widgets_name' => 'fax',
                'opstore_widgets_title' => esc_html__('Fax', 'opstore'),
                'opstore_widgets_field_type' => 'text',
            ),
            'email' => array(
                'opstore_widgets_name' => 'email',
                'opstore_widgets_title' => esc_html__('Email', 'opstore'),
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
        $opstore_location = $instance['location'];
        $opstore_phome = $instance['phone'];
        $opstore_fax = $instance['fax'];
        $opstore_email = $instance['email'];
            ?>
                <div class="footer_info_wrap">
                    <div class="info_wrap">
                        <?php if($opstore_location){ ?>
                            <div class="location_info">
                                <span class="fa_icon_info"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                <span class="location"><?php echo esc_html($opstore_location); ?></span>
                            </div>
                        <?php } ?>
                        <?php if($opstore_phome){ ?>
                            <div class="phone_info">
                                <span class="fa_icon_info"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                <span class="phone"><?php echo esc_html($opstore_phome); ?></span>
                            </div>
                        <?php } ?>
                        <?php if($opstore_fax){ ?>
                            <div class="fax_info">
                                <span class="fa_icon_info"><i class="fa fa-fax" aria-hidden="true"></i></span>
                                <span class="fax"><?php echo esc_html($opstore_fax); ?></span>
                            </div>
                        <?php } ?>
                        <?php if($opstore_email){ ?>
                            <div class="email_info">
                                <span class="fa_icon_info"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                <span class="email"><?php echo esc_html($opstore_email); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
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