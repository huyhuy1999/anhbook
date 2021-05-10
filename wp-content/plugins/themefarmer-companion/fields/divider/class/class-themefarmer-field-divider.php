<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_Customize_Control')) {
	return;
}

if (class_exists('ThemeFarmer_Field_Divider')) {
	return;
}

class ThemeFarmer_Field_Divider extends WP_Customize_Control {

	public $type    = 'themefarmer-divider';
	public $choices = array();
	

	/**
	 * Class constructor
	 */
	public function __construct($manager, $id, $args = array()) {
		parent::__construct($manager, $id, $args);
	}

	public function enqueue() {
		wp_enqueue_style('themefarmer-divider', THEMEFARMER_FIELDS_URI . 'divider/css/themefarmer-divider.css');
	}
	

	protected function render_content() {
		 if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $this->description ) ) : ?>
            <span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo $this->description ; ?></span>
        <?php endif; ?>
		<div class="themefarmer-divider" id="<?php echo esc_attr($this->id); ?>">
			<hr>
		</div>
		<?php
	}
}