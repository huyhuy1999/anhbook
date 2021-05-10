<?php
if (!class_exists('WP_Customize_Section')) {
	return;
}

/**
 *
 */

if (!class_exists('ThemeFarmer_Button_Section')) {
	class ThemeFarmer_Button_Section extends WP_Customize_Section {
		public $type = 'button-section';
		public $button_text;
		public $button_link;

		public function __construct($manager, $id, $args = array()) {
			parent::__construct($manager, $id, $args);
			add_action('customize_controls_init', array($this, 'enqueue'));
		}

		public function enqueue() {
			wp_enqueue_style('themefarmer-button-section', THEMEFARMER_FIELDS_URI . 'button-section/css/button-section.css');
		}

		public function json() {
			$json                = parent::json();
			$json['button_text'] = $this->button_text;
			$json['button_link'] = $this->button_link;
			return $json;
		}

		protected function render_template() {
			?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section themefarmer-button-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title" tabindex="0">
				{{ data.title }}
				<a class="button button-secondary alignright" href="{{data.button_link}}" target="_blank"> {{data.button_text}} </a>
			</h3>
		</li>
		<?php
		}
	}
}