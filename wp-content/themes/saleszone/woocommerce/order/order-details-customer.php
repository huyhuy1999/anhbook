<?php
/**
 * Order Customer Details
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if (!defined('ABSPATH')) {
    exit;
}

$translations = array(
    'first_name' => __('First name', 'saleszone'),
    'last_name' => __('Last name', 'saleszone'),
    'company' => __('Company', 'saleszone'),
    'address_1' => __('Address', 'saleszone'),
    'address_2' => __('Additional address', 'saleszone'),
    'city' => __('City', 'saleszone'),
    'state' => __('State', 'saleszone') . ' / ' . __('Region', 'saleszone'),
    'postcode' => __('Postcode', 'saleszone'),
    'country' => __('Country', 'saleszone'),
    'email' => __('Email', 'saleszone'),
    'phone' => __('Phone', 'saleszone'),
);
$show_shipping = !wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>

    <!-- Billing address -->
    <section class="order-details__group">

        <div class="order-details__list">
            <div class="order-details__item order-details__item--group-title">
                <?php esc_html_e('Billing address', 'saleszone'); ?>
            </div>
        </div>

        <?php foreach ($order->get_address('billing') as $key => $value) : ?>
            <?php if ($value && isset($translations[$key])) : ?>
                <div class="order-details__list">
                    <div class="order-details__item order-details__item--title">
                        <?php echo esc_html($translations[$key]) ?>:
                    </div>
                    <div class="order-details__item">
                        <?php echo esc_html($value) ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

    </section>

    <!-- Shipping address -->
<?php if ($show_shipping) : ?>
    <section class="order-details__group">

        <div class="order-details__list">
            <div class="order-details__item order-details__item--group-title">
                <?php esc_html_e('Shipping address', 'saleszone'); ?>
            </div>
        </div>

        <?php foreach ($order->get_address('shipping') as $key => $value) : ?>
            <?php if ($value && isset($translations[$key])) : ?>
                <div class="order-details__list">
                    <div class="order-details__item order-details__item--title">
                        <?php echo esc_html($translations[$key]) ?>:
                    </div>
                    <div class="order-details__item">
                        <?php echo esc_html($value) ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

    </section>
<?php endif; ?>

<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
