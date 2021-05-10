<?php
if (!defined('ABSPATH')) {
	exit;
}
/**
 * TFWC_Tool_Variation_Swatches_Admin
 */

class TFWC_Tool_Variation_Swatches_Admin {
	
	protected static $instance;

	public static function get_instance() {

		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function __construct() {
		$taxonomies = wc_get_attribute_taxonomies();
		if ( empty( $taxonomies ) ) {
			return;
		}

		foreach ( $taxonomies as $tax ) {
			add_action( 'pa_' . $tax->attribute_name . '_add_form_fields', array( $this, 'add_attribute_fields' ),10, 1 );
			add_action( 'pa_' . $tax->attribute_name . '_edit_form_fields', array( $this, 'edit_attribute_fields' ), 999, 2 );
			add_filter( 'manage_edit-pa_' . $tax->attribute_name . '_columns', array( $this, 'add_attribute_columns' ) );
			add_filter( 'manage_pa_' . $tax->attribute_name . '_custom_column', array( $this, 'add_attribute_column_content' ), 10, 3 );
		}

		add_action( 'created_term', array( $this, 'save_term_meta' ), 10, 2 );
		add_action( 'edit_term', array( $this, 'save_term_meta' ), 10, 2 );
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
		if(isset($_GET['post_type']) && $_GET['post_type'] == 'product' && isset($_GET['page']) && $_GET['page'] == 'product_attributes'){
			add_filter( 'product_attributes_type_selector', function($type){
				$type['color'] = esc_html__( 'Color', 'woo-tools' );
				$type['image'] = esc_html__( 'Image', 'woo-tools' );
				$type['label'] = esc_html__( 'Label', 'woo-tools' );
				$type['radio'] = esc_html__( 'Radio', 'woo-tools' );
				return $type;
			});
		}
		
	}

	public function admin_enqueue_scripts($hook){
		$screen = get_current_screen();
		if ( strpos( $screen->id, 'edit-pa_' ) === false && strpos( $screen->post_type, 'product' ) === false ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_style('tfwc-tool-smart-variation-swatches-admin-style', TFWCTOOL_URI . 'modules/smart-variation-swatches/css/variation-swatches-admin.css');
		wp_enqueue_script('tfwc-tool-smart-variation-swatches-admin-script', TFWCTOOL_URI . 'modules/smart-variation-swatches/js/variation-swatches-admin.js', array('jquery'), null, true);	
		wp_localize_script( 'tfwc-tool-smart-variation-swatches-admin-script', 'TFWCTOOL_VARITION', array(
			'tfwcvari_wc_placeholder_img' => WC()->plugin_url() . '/assets/images/placeholder.png',
		) );
	}

	public function enqueue() {
		wp_enqueue_style('tfwc-tool-smart-variation-swatches-style', TFWCTOOL_URI . 'modules/smart-variation-swatches/css/smart-variation-swatches.css');
		wp_enqueue_script('tfwc-tool-smart-variation-swatches-script', TFWCTOOL_URI . 'modules/smart-variation-swatches/js/smart-variation-swatches.js', array('jquery'), null, true);	
	}

	
	public function save_term_meta($term_id, $tt_id){
		if(isset($_POST['color'])){
			update_term_meta( $term_id, 'color', sanitize_text_field( $_POST['color'] ));
		}

		if(isset($_POST['image'])){
			update_term_meta( $term_id, 'image', absint($_POST['image'] ));
			// echo get_term_meta($term_id, 'image', true);
		}
		
	}
	public function add_attribute_fields($taxonomy){
		
		$attribute_name = substr( $taxonomy, 3 );
		// get_term_by('name', 'news', 'category');
		global $wpdb;
		$attribute = $wpdb->get_row(
			$wpdb->prepare(
				"
				SELECT *
				FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s
				",
				$attribute_name
			)
		);

		if($attribute->attribute_type === 'color'){
		?>
			<div class="form-field term-color-wrap">
				<label for="tag-color">Color</label>
				<input name="color" id="tag-color" type="text" value="" size="40" class="tfwctool-color-field">
				<p>Select Color for Attribute</p>
			</div>

		<?php
		}elseif ($attribute->attribute_type === 'image') {
		?>
		<div class="form-field term-image-wrap">
			<label for="tag-image">Image</label>
			<?php  
					if(isset($image_id) && absint($image_id)){
						$image_src = wp_get_attachment_image_url( $image_id, 'thumbnail' );
						$image_val = $image_id;
					}else{
						$image_src = WC()->plugin_url() . '/assets/images/placeholder.png'; 
						$image_val = '';
					}
			?>
			<div class="thumbnail thumbnail-image tfwctool-product-attributeimage">
				<img class="attachment-thumb" src="<?php echo esc_url($image_src); ?>" draggable="false" width="60" height="60">
			</div>
			<input type="hidden" name="image" id="tag-image" class="tfwctool-text-atr-input tfwctool-image-select-field">
			<button type="button" class="button button-secondary tfwctool-image-select-button"><i class="fa fa-image"></i> <?php esc_html_e('Select image') ?></button>
			<button type="button" class="button button-secondary tfwctool-image-remove-button" <?php echo empty($image_val)?'style="display:none;"':''; ?>><i class="fa fa-times"></i> <?php esc_html_e('Remove') ?></button>
			<p>Select Image for Attribute</p>
		</div>		
		<?php	
		}
	}

	public function edit_attribute_fields($term, $taxonomy){
		// print_r($term);
		
		$attribute_name = substr( $taxonomy, 3 );
		
		global $wpdb;
		$attribute = $wpdb->get_row(
			$wpdb->prepare(
				"
				SELECT *
				FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s
				",
				$attribute_name
			)
		);

		if($attribute->attribute_type === 'color'){
		?>
			<tr class="form-field term-slug-wrap">
				<th scope="row"><label for="tag-color">Color</label></th>
				<td>
					<input name="color" id="tag-color" type="text" value="<?php echo esc_attr(get_term_meta($term->term_id, 'color', true)); ?>" size="40" class="tfwctool-color-field">
					<p>Select Color for Attribute</p>
				</td>
			</tr>
		<?php
		}elseif ($attribute->attribute_type === 'image') {
		?>
		<tr class="form-field term-slug-wrap">
			<th scope="row"><label for="tag-image">Image</label></th>
			<td>
				<?php  
					$value = get_term_meta($term->term_id, 'image', true);
					if(isset($value) && absint($value)){
							$image_src = wp_get_attachment_image_url( $value, 'thumbnail' );
							$image_val = $value;
						}else{
							$image_src = WC()->plugin_url() . '/assets/images/placeholder.png'; 
							$image_val = '';
						}
				?>
				<div class="thumbnail thumbnail-image tfwctool-product-attributeimage">
					<img class="attachment-thumb" src="<?php echo esc_url($image_src); ?>" draggable="false" width="60" height="60">
				</div>
				<input type="hidden" name="image" id="tag-image" class="tfwctool-text-atr-input tfwctool-image-select-field" value="<?php echo absint($image_val); ?>">
				<button type="button" class="button button-secondary tfwctool-image-select-button"><i class="fa fa-image"></i> <?php esc_html_e('Select image') ?></button>
				<button type="button" class="button button-secondary tfwctool-image-remove-button" <?php echo empty($image_val)?'style="display:none;"':''; ?>><i class="fa fa-times"></i> <?php esc_html_e('Remove') ?></button>
				<p>Select Image for Attribute</p>	
			</td>
		</tr>
		<?php	
		}
	}

	public function add_attribute_columns($columns){
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb'];
		$new_columns['preview'] = esc_html__( 'Preview', 'woo-tools' );;
		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}

	public function add_attribute_column_content( $columns, $column, $term_id ){
		$taxonomy = sanitize_text_field( $_REQUEST['taxonomy'] );
		$attribute_name = substr( $taxonomy, 3 );
		
		global $wpdb;
		$attribute = $wpdb->get_row(
			$wpdb->prepare(
				"
				SELECT *
				FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s
				",
				$attribute_name
			)
		);

		$type = $attribute->attribute_type;
		$value = get_term_meta( $term_id, $type, true );
		if($type === 'image'){
			if(absint( $value )){
				$image_src = wp_get_attachment_url( $value );
			}else{
				$image_src = WC()->plugin_url() . '/assets/images/placeholder.png'; 
			}
			
			echo '<img class="tfwc-preview tfwc-preview-image" src="'.esc_url($image_src).'" width="60" height="60">';
		}elseif($type === 'color'){
			echo '<div class="tfwc-preview tfwc-preview-color" style="background-color:'.esc_attr($value).';"></div>';
		}elseif($type === 'lable'){

		}elseif($type === 'lable'){

		}

		// return $columns;
	}

		
}

function TFWC_Tool_Variation_Swatches_Admin() {
	return TFWC_Tool_Variation_Swatches_Admin::get_instance();
}



add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'tfwctool_awesome_woocommerce_dropdown_variation_attribute_options_html', 10, 2);
function tfwctool_awesome_woocommerce_dropdown_variation_attribute_options_html($html, $args){

 	$args = wp_parse_args(
			apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ),
			array(
				'options'          => false,
				'attribute'        => false,
				'product'          => false,
				'selected'         => false,
				'name'             => '',
				'id'               => '',
				'class'            => '',
				'show_option_none' => __( 'Choose an option', 'woocommerce' ),
			)
		);

 		global $wpdb;
		$attr = str_replace('pa_', '', $args['attribute']);
		$attr = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attr'" );
 		
		// Get selected value.
		if ( false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product ) {
			$selected_key     = 'attribute_' . sanitize_title( $args['attribute'] );
			$args['selected'] = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $selected_key ] ) ) : $args['product']->get_variation_default_attribute( $args['attribute'] ); // WPCS: input var ok, CSRF ok, sanitization ok.
		}
		$attribute_type        = $attr->attribute_type;
		$options               = $args['options'];
		$product               = $args['product'];
		$attribute             = $args['attribute'];
		$name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
		$id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
		$class                 = $args['class'];
		$show_option_none      = (bool) $args['show_option_none'];
		$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.
		$swatch_type_options = $product->get_meta('_swatch_type_options', true);

		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}
 		
 		



 		




		
 		$html1='';
 		if($attribute_type === 'image'){
 			if ( ! empty( $options ) ) {
				if ( $product && taxonomy_exists( $attribute ) ) {
					// Get terms if this is a taxonomy - ordered. We need the names too.
					$terms = wc_get_product_terms(
						$product->get_id(),
						$attribute,
						array(
							'fields' => 'all',
						)
					);
					

					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $options, true ) ) {
							// echo'<br>';
							$img_id =  get_term_meta( $term->term_id, 'image', true );
							if($img_id){
								$img_src = wp_get_attachment_url( absint( $img_id ) );
							}
							// $html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) ) . '</option>';

							$term_title1 = apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product );
							// $html1.='<input  name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).'><label for="'.esc_attr($term->slug).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).'</label>';
							$html1.='<label class="tfwctool-varation-swatch tfwctool-varation-swatch-image" for="'.esc_attr( $id.'-'.$term->slug ).'">';
							$html1.='<span class="screen-reader-text">'.$term_title1.'</span>';
							$html1.='<input type="radio" id="' . esc_attr( $id.'-'.$term->slug ) . '" name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).' class="tfwctool-varation-radio-input tfwctool-varation-trigger " >';
							$html1.='<div class="tfwctool-variation-swatch-preview-container"><img class="tfwctool-varation-swatch-preview" src="'.esc_url($img_src).'"  data-toggle="tooltip" title="'.esc_attr($term_title1).'"/></div>';
							$html1.='</label>';
						}
					}
				} else {
					foreach ( $options as $option ) {
						// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
						// $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
						// $html    .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product ) ) . '</option>';
						$checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
						$term_title1 =apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product );
						$html1.='<label class="tfwctool-varation-swatch tfwctool-varation-swatch-image" for="'.esc_attr( $id.'-'.$term->slug ).'">';
						$html1.='<span class="screen-reader-text">'.$term_title1.'</span>';
						$html1.='<input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($option).'" id="'.sanitize_title($option).'" '.$checked.' class="tfwctool-varation-radio-input tfwctool-varation-trigger">';
						$html1.='<div class="tfwctool-variation-swatch-preview-container"><img class="tfwctool-varation-swatch-preview" src="'.esc_url($img_src).'"  data-toggle="tooltip" title="'.esc_attr($term_title1).'"/></div>';
						$html1.='</label>';
					}
				}
			}
 			
 		}elseif ($attribute_type === 'color') {
 			if ( ! empty( $options ) ) {
				if ( $product && taxonomy_exists( $attribute ) ) {
					// Get terms if this is a taxonomy - ordered. We need the names too.
					$terms = wc_get_product_terms(
						$product->get_id(),
						$attribute,
						array(
							'fields' => 'all',
						)
					);
					

					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $options, true ) ) {
							// echo'<br>';
							$color =  get_term_meta( $term->term_id, 'color', true );
							
							// $html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) ) . '</option>';

							$term_title1 = apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product );
							// $html1.='<input  name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).'><label for="'.esc_attr($term->slug).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).'</label>';
							$html1.='<label class="tfwctool-varation-swatch tfwctool-varation-swatch-color" for="'.esc_attr( $id.'-'.$term->slug ).'">';
							$html1.='<span class="screen-reader-text">'.$term_title1.'</span>';
							$html1.='<input type="radio" id="' . esc_attr( $id.'-'.$term->slug ) . '" name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).' class="tfwctool-varation-radio-input tfwctool-varation-trigger">';
							$html1.='<div class="tfwctool-variation-swatch-preview-container"><div class="tfwctool-varation-swatch-preview"  data-toggle="tooltip" title="'.esc_attr($term_title1).'" style="background-color:'.esc_attr($color).'"></div></div>';
							$html1.='</label>';
						}
					}
				} else {
					foreach ( $options as $option ) {
						// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
						// $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
						// $html    .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product ) ) . '</option>';
						$checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
						$term_title1 =apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product );
						$html1.='<label class="tfwctool-varation-swatch tfwctool-varation-swatch-color" for="'.esc_attr( $id.'-'.$term->slug ).'">';
						$html1.='<span class="screen-reader-text">'.$term_title1.'</span>';
						$html1.='<input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($option).'" id="'.sanitize_title($option).'" '.$checked.' class="tfwctool-varation-radio-input tfwctool-varation-trigger">';
						$html1.='<div class="tfwctool-variation-swatch-preview-container"><img class="tfwctool-varation-swatch-preview" src="'.esc_url($img_src).'"  data-toggle="tooltip" title="'.esc_attr($term_title1).'"/></div>';
						$html1.='</label>';
					}
				}
			}
 		}elseif ($attribute_type === 'radio') {
 			if ( ! empty( $options ) ) {
				if ( $product && taxonomy_exists( $attribute ) ) {
					// Get terms if this is a taxonomy - ordered. We need the names too.
					$terms = wc_get_product_terms(
						$product->get_id(),
						$attribute,
						array(
							'fields' => 'all',
						)
					);
					

					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $options, true ) ) {
							// echo'<br>';
							// $label =  get_term_meta( $term->term_id, 'label', true );
							
							// $html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) ) . '</option>';

							$term_title1 = apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product );
							// $html1.='<input  name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).'><label for="'.esc_attr($term->slug).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).'</label>';
							$html1.='<label class="tfwctool-varation-swatch tfwctool-varation-swatch-label" for="'.esc_attr( $id.'-'.$term->slug ).'">';
							$html1.='<span class="screen-reader-text">'.$term_title1.'</span>';
							$html1.='<input type="radio" id="' . esc_attr( $id.'-'.$term->slug ) . '" name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).' class="tfwctool-varation-radio-type-radio-input tfwctool-varation-trigger">';
							$html1.='<div class="tfwctool-variation-swatch-preview-container"><div class="tfwctool-varation-swatch-preview tfwctool-varation-swatch-preview-radio"  data-toggle="tooltip" title="'.esc_attr($term_title1).'">'.esc_attr($term_title1).'</div></div>';
							$html1.='</label>';
						}
					}
				} else {
					foreach ( $options as $option ) {
						// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
						// $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
						// $html    .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product ) ) . '</option>';
						$checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
						$term_title1 =apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product );
						$html1.='<label class="tfwctool-varation-swatch tfwctool-varation-swatch-label" for="'.esc_attr( $id.'-'.$term->slug ).'">';
						$html1.='<span class="screen-reader-text">'.$term_title1.'</span>';
						$html1.='<input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($option).'" id="'.sanitize_title($option).'" '.$checked.' class="tfwctool-varation-radio-input tfwctool-varation-trigger">';
						$html1.='<div class="tfwctool-variation-swatch-preview-container"><img class="tfwctool-varation-swatch-preview" src="'.esc_url($img_src).'"  data-toggle="tooltip" title="'.esc_attr($term_title1).'"/></div>';
						$html1.='</label>';
					}
				}
			}
 		}elseif ($attribute_type === 'label') {
 			if ( ! empty( $options ) ) {
				if ( $product && taxonomy_exists( $attribute ) ) {
					// Get terms if this is a taxonomy - ordered. We need the names too.
					$terms = wc_get_product_terms(
						$product->get_id(),
						$attribute,
						array(
							'fields' => 'all',
						)
					);
					

					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $options, true ) ) {
							// echo'<br>';
							// $label =  get_term_meta( $term->term_id, 'label', true );
							
							// $html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) ) . '</option>';

							$term_title1 = apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product );
							// $html1.='<input  name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).'><label for="'.esc_attr($term->slug).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).'</label>';
							$html1.='<label class="tfwctool-varation-swatch tfwctool-varation-swatch-label" for="'.esc_attr( $id.'-'.$term->slug ).'">';
							$html1.='<span class="screen-reader-text">'.$term_title1.'</span>';
							$html1.='<input type="radio" id="' . esc_attr( $id.'-'.$term->slug ) . '" name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).' class="tfwctool-varation-radio-input tfwctool-varation-trigger">';
							$html1.='<div class="tfwctool-variation-swatch-preview-container"><div class="tfwctool-varation-swatch-preview tfwctool-varation-swatch-preview-label"  data-toggle="tooltip" title="'.esc_attr($term_title1).'">'.esc_attr($term_title1).'</div></div>';
							$html1.='</label>';
						}
					}
				} else {
					foreach ( $options as $option ) {
						// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
						// $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
						// $html    .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product ) ) . '</option>';
						$checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
						$term_title1 =apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product );
						$html1.='<label class="tfwctool-varation-swatch tfwctool-varation-swatch-label" for="'.esc_attr( $id.'-'.$term->slug ).'">';
						$html1.='<span class="screen-reader-text">'.$term_title1.'</span>';
						$html1.='<input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($option).'" id="'.sanitize_title($option).'" '.$checked.' class="tfwctool-varation-radio-input tfwctool-varation-trigger">';
						$html1.='<div class="tfwctool-variation-swatch-preview-container"><img class="tfwctool-varation-swatch-preview" src="'.esc_url($img_src).'"  data-toggle="tooltip" title="'.esc_attr($term_title1).'"/></div>';
						$html1.='</label>';
					}
				}
			}
 		}elseif ($attribute_type === 'text') {
 			
 		}elseif ($attribute_type === 'select') {
 			return '<div class="visible-variation-select">'.$html.'</div>';	
 		}


 		ob_start();
 		print_r($attribute_type);
 		$asdf1 = ob_get_clean();

		return  '<div class="hidden-variation-select">'.$html.'</div>'.$html1;
} 


function tfwctool_smartvariation_swatches(){
	wp_enqueue_style('tfwc-tool-smart-variation-swatches-style', TFWCTOOL_URI . 'modules/smart-variation-swatches/css/smart-variation-swatches.css');
	wp_enqueue_script('tfwc-tool-smart-variation-swatches-script', TFWCTOOL_URI . 'modules/smart-variation-swatches/js/smart-variation-swatches.js', array('jquery'), null, true);		
}
add_action( 'wp_enqueue_scripts', 'tfwctool_smartvariation_swatches');




/**
 * Replace add to cart button in the loop.
 */
function tfwctool_variation_change_loop_add_to_cart() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	add_action( 'woocommerce_after_shop_loop_item', 'tfwctool_variation_template_loop_add_to_cart', 10 );
}

// add_action( 'init', 'tfwctool_variation_change_loop_add_to_cart', 10 );

/**
 * Use single add to cart button for variable products.
 */
function tfwctool_variation_template_loop_add_to_cart() {
	global $product;

	if ( ! $product->is_type( 'variable' ) ) {
		woocommerce_template_loop_add_to_cart();
		return;
	}

	remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
	add_action( 'woocommerce_single_variation', 'tfwctool_variation_loop_variation_add_to_cart_button', 20 );

	woocommerce_template_single_add_to_cart();
}

function tfwctool_variation_woocommerce_layered_nav_term_html($term_html, $term, $link, $count){
	
	$color = get_term_meta($term->term_id, 'color', true);
	if(!empty($color)){
		return '<div class="tf-shot-color-attr" style="background-color:'.esc_attr($color).'"></div>'.$term_html;
	}

	$image = get_term_meta($term->term_id, 'image', true);
	if(absint( $image ) > 0){
		return '<div class="tf-shot-color-attr"> <img src="'.esc_url(wp_get_attachment_image_url(absint( $image ) , 'thumbnail', false )).'" alt="" class="img-responsive"></div>'.$term_html;
	}

	return $term_html;

}
add_filter( 'woocommerce_layered_nav_term_html', 'tfwctool_variation_woocommerce_layered_nav_term_html', 10, 4);

function tfwctool_variation_woocommerce_layered_nav_count($html, $count, $term){
	return '<span class="count">'.absint( $count ).'</span>';
}
add_filter( 'woocommerce_layered_nav_count', 'tfwctool_variation_woocommerce_layered_nav_count', 10, 3);

/**
 * Customise variable add to cart button for loop.
 *
 * Remove qty selector and simplify.
 */
function tfwctool_variation_loop_variation_add_to_cart_button() {
	global $product;

	?>
	<div class="woocommerce-variation-add-to-cart variations_button">
		<button type="submit" class="single_add_to_cart_button button"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
		<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="variation_id" class="variation_id" value="0" />
	</div>
	<?php
}

