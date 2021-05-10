<?php
/**
 * Widget to show about product search
 *
 * @package Wpoperation
 * @subpackage Opstore
 * @since 1.0.0
 */

class Opstore_Product_Search extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'opstore_product_search',
            'description' => __( 'About search product in specific categories.', 'opstore' )
        );
        parent::__construct( 'opstore_product_search', __( '*Opstore Product Search', 'opstore' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $fields = array(

            'search_placeholder' => array(
                'opstore_widgets_name'         => 'search_placeholder',
                'opstore_widgets_title'        => __( 'Placeholder', 'opstore' ),
                'opstore_widgets_default'      => __( 'Search Product', 'opstore' ),
                'opstore_widgets_field_type'   => 'text'
            )
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
    public function widget( $args, $instance ) {
        extract( $args );
        if( empty( $instance ) ) {
            return ;
        }

        $opstore_search_placeholder  = empty( $instance['search_placeholder'] ) ? esc_html__( 'Search For Products', 'opstore' ) : $instance['search_placeholder'];

        echo wp_kses_post($before_widget);
    ?>
    <div class="es-advance-product-search-wrapper">
        <div class="advance-product-search">
            <form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field op-srch" placeholder="<?php echo esc_attr( $opstore_search_placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"/>
            <?php
                $woo_terms = get_terms( array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'parent'     => 0,
                ) );
                if (  ! empty( $woo_terms ) && ! is_wp_error( $woo_terms ) ) {
                    $select_cat = ( isset( $_GET['product_category'] ) ) ? absint( $_GET['product_category'] ) : '' ;
            ?>
                    <select class="es-select-products op-srch" name="product_category">
                        <option value=""><?php esc_html_e( 'All Categories', 'opstore' ); ?></option>
                        <?php foreach ( $woo_terms as $cat ) { ?>
                            <option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php selected( $select_cat, $cat->term_id ); ?> ><?php echo esc_html( $cat->name ); ?></option>
                        <?php } ?>
                    </select>
            <?php } ?>
                <button class="lnr lnr-magnifier searchsubmit op-srch" type="submit"></button>
                <input type="hidden" name="post_type" value="product" />
            </form><!-- .woocommerce-product-search -->
        </div><!-- .advance-product-search -->
    </div><!-- .es-advance-product-search-wrapper -->
    <?php
        echo wp_kses_post($after_widget);
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param   array   $new_instance   Values just sent to be saved.
     * @param   array   $old_instance   Previously saved values from database.
     *
     * @uses    opstore_widgets_updated_field_value()      defined in es-widget-fields.php
     *
     * @return  array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            extract( $widget_field );

            // Use helper function to get updated field values
            $instance[$opstore_widgets_name] = opstore_widgets_updated_field_value( $widget_field, $new_instance[$opstore_widgets_name] );
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param   array $instance Previously saved values from database.
     *
     * @uses    opstore_widgets_show_widget_field()        defined in es-widget-fields.php
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            /// Make array elements available as variables
            extract( $widget_field );

            if ( empty( $instance ) && isset( $opstore_widgets_default ) ) {
                $opstore_widgets_field_value = $opstore_widgets_default;
            } elseif( empty( $instance ) ) {
                $opstore_widgets_field_value = '';
            } else {
                $opstore_widgets_field_value = wp_kses_post( $instance[$opstore_widgets_name] );
            }
            opstore_widgets_show_widget_field( $this, $widget_field, $opstore_widgets_field_value );
        }
    }

}
if(!function_exists('opstore_register_product_search')){
add_action('widgets_init', 'opstore_register_product_search');

function opstore_register_product_search() {
    register_widget('Opstore_Product_Search');
}
}