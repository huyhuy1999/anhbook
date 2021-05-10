<?php
/**
 *
 */
class ThemeFarmer_Field {

	private $wp_customize;

	protected static $_instance = null;

	public static function instance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	function __construct() {
	}


	public function add_field($wp_customize, $args = array()) {
		if (empty($args) || empty($args['id'])) {
			return;
		}

		$field_id = $args['id'];
		$args     = array_merge(
			array(
				'label'             => null,
				'section'           => null,
				'description'       => null,
				'default'           => null,
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
				'priority'          => 10,
				'type'              => 'text',
				'selective_refresh' => false,
				'selector' => null,
				'render_callback' => null,
				'fallback_refresh' => null,
			),
			$args
		);

		$settings_args['transport'] = $args['transport'];
		$settings_args['default']   = $args['default'];
		$settings_args['sanitize_callback']   = $args['sanitize_callback'];

		if($args['selective_refresh'] == true && isset($wp_customize->selective_refresh)){
			$wp_customize->selective_refresh->add_partial($field_id, array(
				'selector'         => $args['selector'],
				'render_callback' => $args['render_callback'],
				'fallback_refresh' => $args['fallback_refresh'],
			));
			unset($args['selective_refresh']);
			unset($args['selector']);
			unset($args['render_callback']);
			unset($args['fallback_refresh']);
		}
		unset($args['id']);
		unset($args['transport']);
		unset($args['default']);
		unset($args['sanitize_callback']);

		$Control_Class = $this->get_control_class($args['type']);
		if (!empty($Control_Class)) {
			unset($args['type']);
			$wp_customize->add_setting($field_id, $settings_args);
			$wp_customize->add_control(new $Control_Class($wp_customize, $field_id, $args));
		} else {
			$wp_customize->add_setting($field_id, $settings_args);
			$wp_customize->add_control($field_id, $args);
		}
	}

	private function get_control_class($type = '') {
		switch ($type) {
		case 'font-selector':
			return 'ThemeFarmer_Field_Font_Selector';
			break;
		case 'image-select':
			return 'ThemeFarmer_Field_Image_Select';
			break;
		case 'button-select':
			return 'ThemeFarmer_Field_Button_Select';
			break;
		case 'range':
			return 'ThemeFarmer_Field_Range';
			break;
		case 'repeater':
			return 'ThemeFarmer_Field_Repeater';
			break;
		case 'sortable':
			return 'ThemeFarmer_Field_Sortable';
			break;
		case 'switch':
			return 'ThemeFarmer_Field_Switch';
			break;
		case 'tabs':
			return 'ThemeFarmer_Field_Tabs';
			break;
		case 'reorder-sections':
			return 'ThemeFarmer_Field_Reorder_Sections';
			break;
		case 'info':
			return 'ThemeFarmer_Field_Info';
			break;
		case 'divider':
			return 'ThemeFarmer_Field_Divider';
			break;
		case 'icon':
			return 'ThemeFarmer_Field_Icon';
			break;
		case 'color':
			return 'WP_Customize_Color_Control';
			break;
		case 'image':
			return 'WP_Customize_Image_Control';
			break;
		case 'cropped-image':
			return 'WP_Customize_Cropped_Image_Control';
			break;
		}
		return;
	}

}