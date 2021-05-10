<ul>
    <?php if(!is_user_logged_in()): ?>

        <li class="menu-item">
            <a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id'))); ?>"
               data-modal="<?php echo esc_url(saleszone_get_modal_url('parts/modal/modal-login')); ?>">
                <?php esc_html_e('Login','saleszone'); ?>
            </a>
        </li>

        <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
            <li class="menu-item">
                <a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id'))); ?>">
                    <?php esc_html_e('Register','saleszone'); ?>
                </a>
            </li>
        <?php endif; ?>

    <?php else: ?>

        <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <li class="menu-item">
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                    <?php echo esc_html( $label ); ?>
                </a>
            </li>
        <?php endforeach; ?>

    <?php endif; ?>
</ul>