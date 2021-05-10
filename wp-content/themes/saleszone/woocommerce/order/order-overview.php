<div class="order-details__group">

    <!-- Order id number -->
    <div class="order-details__list">
        <div class="order-details__item order-details__item--title">
            <?php esc_html_e( 'Order number:', 'saleszone' ); ?>
        </div>
        <div class="order-details__item">
            <?php echo esc_html($order->get_order_number()); ?>
        </div>
    </div>

    <!-- Order date -->
    <div class="order-details__list">
        <div class="order-details__item order-details__item--title">
            <?php esc_html_e('Date:', 'saleszone' ); ?>
        </div>
        <div class="order-details__item">
            <?php echo esc_html(wc_format_datetime( $order->get_date_created())); ?>
        </div>
    </div>

    <!-- Billing Email  -->
    <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
        <div class="order-details__list">
            <div class="order-details__item order-details__item--title">
                <?php esc_html_e('Email:', 'saleszone' ); ?>
            </div>
            <div class="order-details__item">
                <?php echo esc_html($order->get_billing_email()); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Total -->
    <div class="order-details__list">
        <div class="order-details__item order-details__item--title">
            <?php esc_html_e('Total:', 'saleszone' ); ?>
        </div>
        <div class="order-details__item">
            <?php echo wp_kses($order->get_formatted_order_total(), saleszone_get_allowed_html('price')); ?>
        </div>
    </div>

    <!-- Payment method: -->
    <?php if ( $order->get_payment_method_title() ) : ?>
        <div class="order-details__list">
            <div class="order-details__item order-details__item--title">
                <?php esc_html_e('Payment method:', 'saleszone' ); ?>
            </div>
            <div class="order-details__item">
                <?php echo wp_kses_post( $order->get_payment_method_title() ); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Comments -->
    <?php if($order->get_customer_note()) : ?>
        <div class="order-details__list">
            <div class="order-details__item order-details__item--title">
                <?php esc_html_e('Note:', 'saleszone' ); ?>
            </div>
            <div class="order-details__item">
                <?php echo esc_html(wptexturize($order->get_customer_note())); ?>
            </div>
        </div>
    <?php endif; ?>

</div>