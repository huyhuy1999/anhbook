<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_Customize_Control')) {
	return;
}

if (class_exists('ThemeFarmer_Field_Image_Select')) {
	return;
}

class ThemeFarmer_Field_Image_Select extends WP_Customize_Control {

	public $type    = 'themefarmer-image-select';
	public $choices = array();
	

	/**
	 * Class constructor
	 */
	public function __construct($manager, $id, $args = array()) {
		parent::__construct($manager, $id, $args);
	}

	public function enqueue() {
		wp_enqueue_style('themefarmer-image-select', THEMEFARMER_FIELDS_URI . 'image-select/css/themefarmer-image-select.css');
	}
	

	protected function render_content() {
		$value = $this->value();
		if (empty($this->choices)) {
			return;
		}
		?>
		<?php if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $this->description ) ) : ?>
            <span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo $this->description ; ?></span>
        <?php endif; ?>
		<div class="themefarmer-image-select" id="<?php echo esc_attr($this->id); ?>">
			<?php foreach ($this->choices as $key => $choice): ?>
				<label>
					<input type="radio" class="themefarmer-image-select-radio" name="tf-input-<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($key); ?>" <?php $this->link(); ?> <?php checked( $this->value(), $key ); ?>>
					<img class="themefarmer-image-select-image" src="<?php echo esc_url($choice); ?>">
				</label>
			<?php endforeach; ?>
		</div>
		<?php
	}
}