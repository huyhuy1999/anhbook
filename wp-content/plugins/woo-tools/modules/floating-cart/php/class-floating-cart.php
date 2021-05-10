<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * TFWC_Tool_Floating_Cart
 */

class TFWC_Tool_Floating_Cart {
	
	protected static $instance;

	public static function get_instance() {

		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function __construct() {

		add_action( 'wp_ajax_tfwctool_floating_cart_update_qty', array( $this, 'floating_cart_update_qty' ) );
		add_action( 'wp_ajax_nopriv_tfwctool_floating_cart_update_qty', array( $this, 'floating_cart_update_qty' ));
		add_action('wp_enqueue_scripts', array($this, 'enqueue'));
		add_action( 'wp_footer', array($this, 'floating_cart_html'));
	}

	public function enqueue() {
		wp_enqueue_style('tfwc-tool-floating-cart-style', TFWCTOOL_URI . 'modules/floating-cart/css/floating-cart.css');
		wp_enqueue_script('tfwc-tool-floating-cart-script', TFWCTOOL_URI . 'modules/floating-cart/js/floating-cart.js', array('jquery'), null, true);
		wp_localize_script( 'tfwc-tool-floating-cart-script', 'TFWCTOOL_FCART', array(
				'ajax_url'             => admin_url( 'admin-ajax.php' ),
				'nonce'                => wp_create_nonce( 'tfwctool-fcart7765-nonce' ),
			)
		);	

	}
	
	public function floating_cart_update_qty(){
		if (isset( $_POST['tfwctoolfcrtnonce'] ) && (wp_verify_nonce( $_POST['tfwctoolfcrtnonce'], 'tfwctool-fcart7765-nonce' ))) {
			if ( isset( $_POST['cart_item_key'] ) && isset( $_POST['cart_item_qty'] ) ) {
				WC()->cart->set_quantity( sanitize_text_field( $_POST['cart_item_key'] ), intval( $_POST['cart_item_qty'] ) );
				WC_AJAX::get_refreshed_fragments();
			}
		}

	}
	public static function print_floating_cart_html(){
		?>
		<div class="tfwctool-floating-cart-container">
			<div class="tfwctool-floating-cart-container-inner">
				<div class="tfwctool-floating-cart-header">
					<?php esc_html_e( 'Cart', 'woo-tools' ); ?>
				</div>
				<?php					
					tfwctool_get_template('floating-cart.php');
				?>
			</div>
			<button id="tf-f-cart-icon" class="tf-f-cart-icon">
				<div class="tf-f-cart-icon-inner">
				<i class="fa fa-shopping-cart"></i>
				<i class="fa fa-arrow-down"></i>
				</div>
				<div class="tf-f-cart-item-count"><?php echo absint(WC()->cart->get_cart_contents_count()); ?></div>
			</button>
		</div>
		<?php
	}

	public function floating_cart_html(){
		$this->print_floating_cart_html();
		?>
		<div class="floating-cart-overlay" style="display: none;"></div>
		<?php
	}	
}

function TFWC_Tool_Floating_Cart() {
	return TFWC_Tool_Floating_Cart::get_instance();
}

function tfwctool_fcart_woocommerce_cart_link_fragment() {
	ob_start();
	TFWC_Tool_Floating_Cart::print_floating_cart_html();
	$fragments['.tfwctool-floating-cart-container'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'tfwctool_fcart_woocommerce_cart_link_fragment' );