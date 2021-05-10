<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_Customize_Control')) {
	return;
}

if (class_exists('ThemeFarmer_Field_Button_Select')) {
	return;
}

class ThemeFarmer_Field_Button_Select extends WP_Customize_Control {

	public $type    = 'themefarmer-button-select';
	public $choices = array();
	

	/**
	 * Class constructor
	 */
	public function __construct($manager, $id, $args = array()) {
		parent::__construct($manager, $id, $args);
	}

	public function enqueue() {
		wp_enqueue_style('themefarmer-button-select', THEMEFARMER_FIELDS_URI . 'button-select/css/themefarmer-button-select.css');
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
		<div class="themefarmer-button-select" id="<?php echo esc_attr($this->id); ?>">
			<?php foreach ($this->choices as $key => $choice): ?>
				<label>
					<input type="radio" class="themefarmer-button-select-radio" name="tf-input-<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($key); ?>" <?php $this->link(); ?> <?php checked( $this->value(), $key ); ?>>
					<div class="themefarmer-button-select-button"><?php echo esc_html($choice); ?></div>
				</label>
			<?php endforeach; ?>
		</div>
		<?php
	}
}