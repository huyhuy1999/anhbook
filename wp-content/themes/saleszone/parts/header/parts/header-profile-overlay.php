<div class="overlay">
    <?php if (!is_user_logged_in()): ?>

        <div class="overlay__item">
            <a class="overlay__link"
               href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"
               data-modal="<?php echo esc_url(saleszone_get_modal_url('parts/modal/modal-login')); ?>">
                <?php esc_html_e('Login', 'saleszone'); ?>
            </a>
        </div>

        <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>
            <div class="overlay__item">
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="overlay__link">
                    <?php esc_html_e('Register', 'saleszone'); ?>
                </a>
            </div>
        <?php endif; ?>

    <?php elseif (function_exists('wc_get_account_menu_items')): ?>

        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
            <div class="overlay__item">
                <a class="overlay__link" href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>">
                    <?php echo esc_html($label); ?>
                </a>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</div>