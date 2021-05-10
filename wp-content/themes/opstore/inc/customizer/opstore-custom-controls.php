<?php
/**
 * Opstore Custom classes and definitions
 *
 * @package Opstore
 * 
 */
 
if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
     * Switch button customize control.
     *
     * @since 1.0.0
     * @access public
     */
    class Opstore_Customize_Switch_Control extends WP_Customize_Control {

    	/**
	     * The type of customize control being rendered.
	     *
	     * @since  1.0.0
	     * @access public
	     * @var    string
	     */
		public $type = 'switch';
		/**
	     * Displays the control content.
	     *
	     * @since  1.0.0
	     * @access public
	     * @return void
	     */
		public function render_content() { ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<div class="description customize-control-description"><?php echo esc_html( $this->description ); ?></div>
		        <div class="switch_options">
		        	<?php 
		        		$show_choices = $this->choices;
		        		foreach ( $show_choices as $key => $value ) {
		        			echo '<span class="switch_part '.esc_attr($key).'" data-switch="'.esc_attr($key).'">'. esc_attr($value).'</span>';
		        		}
		        	?>
                  	<input type="hidden" id="ap_switch_option" <?php esc_attr($this->link()); ?> value="<?php echo esc_attr($this->value()); ?>" />
                </div>
            </label>
	<?php
		}
	}

	/**
	 * Customizer section help
	 */
	class Opstore_Customize_Help_Control extends WP_Customize_Control {
		public function render_content() {
			?>
			<div class="tmp-help-info">
				<h4><?php esc_html_e( 'Instruction', 'opstore' ); ?></h4>
				<div style="font-weight: bold; font-style: italic;">
					<?php echo esc_html($this->label); ?>
				</div>
			</div>
	        <?php
		}   
	}

	/* Radio Image control */

	class Opstore_Customize_Radioimage_Control extends WP_Customize_Control {
		public $type = 'radioimage';
		public function enqueue() {
			wp_enqueue_script( 'jquery-ui-button' );
		}
	    public function render_content() {
			$name = '_customize-radio-' . $this->id;
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div id="input_<?php echo esc_html($this->id); ?>" class="image">
				<?php foreach ( $this->choices as $value => $label ) : ?>
					<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_html($this->id) . esc_attr($value); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<label for="<?php echo esc_html($this->id) . esc_attr($value); ?>">
							<img src="<?php echo esc_html( $label ); ?>"/>
						</label>
					</input>
				<?php endforeach; ?>
			</div>
			<script>
				jQuery(document).ready(function($) { $( '[id="input_<?php echo esc_html($this->id); ?>"]' ).buttonset(); });
			</script>
			<?php 
		}
	}
	/*Customizer seperator */
	class Opstore_Customize_Seperator_Control extends WP_Customize_Control {
	    public function render_content() { ?>
	       <span class="customize-control-seperator">
	           <?php echo esc_html( $this->label ); ?>
	       </span>  
	       <?php     
	    }     

	}	


	/**
     * Pro customizer section.
     *
     * @since  1.0.0
     * @access public
     */
    class Opstore_Customize_Section_Pro extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'opstore';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_text = '';

        /**
         * Custom pro button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_url = '';

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();
            $json['pro_text'] = $this->pro_text;
            $json['pro_url']  = esc_url( $this->pro_url );
            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        protected function render_template() { ?>

            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <h3 class="accordion-section-title">
                    {{ data.title }}
                    <# if ( data.pro_text && data.pro_url ) { #>
                        <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
                    <# } #>
                </h3>
            </li>
        <?php }
    }



}