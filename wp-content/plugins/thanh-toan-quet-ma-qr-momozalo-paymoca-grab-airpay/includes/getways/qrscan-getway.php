<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WC_Gateway_Paypal Class.
 */
class QrScanGetWay extends WC_Payment_Gateway {

    /** @var bool Whether or not logging is enabled */
    public static $log_enabled = false;

    /** @var WC_Logger Logger instance */
    public static $log = false;

    /**
     * Constructor for the gateway.
     */
    public function __construct() {
        
    }

    public function show_notify(){
        $screen = get_current_screen();
        $valid = $screen->id == 'woocommerce_page_wc-settings' && isset($_GET['section']) && $_GET['section'] ==$this->id;
        if(!$valid) return;
        ?>
        <div class="notice notice-info is-dismissible">
            <p><span class="dashicons dashicons-megaphone"></span> Trải nghiệm bản Pro <strong>3 Tháng Miễn Phí</strong> với COUPON: <strong>FREE90DAYS</strong> <a target="blank" href="https://docs.google.com/forms/d/e/1FAIpQLSe94ioApBSJXJemVkxzBycj930p4VfyuhoQEDuCc2FlNkA8Ng/viewform">Đăng Ký Ngay</a> - Thời gian có hạn</p>
        </div>
        <?php
    }


    public function template_ifinish(){
        ?>
        <div id="finishscan" style="display: none;">
            <p class="questionfinish">Bạn đã thanh toán xong?</p>
            <div class="btnfinish-scan nut-animation">Tôi đã thanh toán xong</div>

            <div id="thongbaofinish" style="display: none">
                <?php echo $this->finish_notify_text; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Logging method.
     *
     * @param string $message Log message.
     * @param string $level   Optional. Default 'info'.
     *     emergency|alert|critical|error|warning|notice|info|debug
     */
    public static function log( $message, $level = 'info' ) {
        if ( self::$log_enabled ) {
            if ( empty( self::$log ) ) {
                self::$log = wc_get_logger();
            }
            self::$log->log( $level, $message, array( 'source' => 'qrscan' ) );
        }
    }

    /**
     * Check if this gateway is enabled and available in the user's country.
     * @return bool
     */
    public function is_valid_for_use() {
        return true;
    }

    /**
     * Initialise Gateway Settings Form Fields.
     */
    public function init_form_fields() {
        
    }

    function process_payment( $order_id ) {
        global $woocommerce;
        $order = new WC_Order( $order_id );

        // Mark as on-hold (we're awaiting the cheque)
        $order->update_status('on-hold', __( 'Đơn hàng tạm giữ', 'woocommerce' ));

        // Remove cart
        $woocommerce->cart->empty_cart();

        // Return thankyou redirect
        return array(
            'result' => 'success',
            'redirect' => $this->get_return_url( $order )
        );
    }



}