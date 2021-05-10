<?php if (!is_user_logged_in()): ?>

    <li class="mobile-nav__item">
        <a class="mobile-nav__link"
           href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">
            <?php esc_html_e('Login', 'saleszone'); ?>
        </a>
    </li>

    <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>
        <li class="mobile-nav__item">
            <a class="mobile-nav__link" href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">
                <?php esc_html_e('Register', 'saleszone'); ?>
            </a>
        </li>
    <?php endif; ?>

<?php elseif (function_exists('wc_get_account_menu_items')): ?>

    <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
        <li class="mobile-nav__item">
            <a class="mobile-nav__link" href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>">
                <?php echo esc_html($label); ?>
            </a>
        </li>
    <?php endforeach; ?>

<?php endif; ?>