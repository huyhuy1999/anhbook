<?php if(saleszone_is_woocommerce_activated()) :?>
    <form method="post" id="premmerceImportForm">
        <input type="hidden" name="action" value="saleszone_imp">

        <br>

        <p>
            <?php esc_html_e('Installation of the demo data will take from 10 to 15 minutes.','saleszone'); ?>
        </p>

        <?php do_settings_sections($pageSlug); ?>

        <div class="submit">
            <input type="submit" name="premmerceImport" id="premmerceImport" class="button button-primary" value="<?php esc_attr_e('Import','saleszone'); ?>">
            <div class="spinner" data-import-preloader=""></div>
        </div>

    </form>

    <div data-post-progress-bar></div>
    <div data-import-info></div>
<?php else: ?>
    <p>
        <?php esc_html_e('For the data installer to work, you need to install and activate WooCommerce','saleszone'); ?>

        <?php

        $install_link = esc_url(add_query_arg(array(
                'page' => 'tgmpa-install-plugins',
                'plugin' => 'woocommerce',
                'tgmpa-install' => 'install-plugin',
                'tgmpa-nonce' => wp_create_nonce('tgmpa-install')),
                site_url('wp-admin/admin.php')));

        if (file_exists(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php')) {
            $install_link = esc_url(add_query_arg(array(
                'page' => 'tgmpa-install-plugins',
                'plugin' => 'woocommerce',
                'tgmpa-activate' => 'activate-plugin',
                'tgmpa-nonce' => wp_create_nonce('tgmpa-activate')),
                site_url('wp-admin/admin.php')));
        }

        ?>

        <?php if(!saleszone_is_plugin_active('woocommerce/woocommerce.php')) :?>
            <a class="button button-secondary" href="<?php echo esc_url($install_link); ?>">
                <?php if (file_exists(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php') && !saleszone_is_plugin_active('woocommerce/woocommerce.php')){
                    esc_html_e('Activate WooCommerce','saleszone');
                } else {
                    esc_html_e('Install WooCommerce','saleszone');
                } ?>
            </a>
        <?php endif; ?>
    </p>
<?php endif; ?>
