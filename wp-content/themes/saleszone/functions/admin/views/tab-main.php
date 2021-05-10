<?php

$user = wp_get_current_user();
$user_id	 = $user->ID;
$theme_data	 = wp_get_theme();

$is_saleszone_active = saleszone_is_plugin_active('premmerce/premmerce.php') || saleszone_is_plugin_active('premmerce-premium/premmerce.php');
$all_recomended_plugin_is_active = saleszone_is_plugin_active('woocommerce/woocommerce.php') && $is_saleszone_active && saleszone_is_plugin_active('kirki/kirki.php');

?>

<div class="task-container">

    <div class="task-container__task">
        <div class="task-container__task-content-row">
            <div class="task-container__task-aside">
                <div class="task-container__task-action">
                    <div class="task-container__task-action-label task-container__task-action-label--auto  task-container__task-action-label-check">
                        <input type="checkbox" class="task-container__task-action-checkbox"
                               <?php echo $all_recomended_plugin_is_active ? 'checked':''; ?>
                        >
                        <span class="task-container__task-action-checkbox-icon">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 91 63" xml:space="preserve"><g id="Shape_2"><g><polygon class="st0" points="91,5.5 85.5,0 33.8,52.1 5.5,23.5 0,29 33.7,63 33.8,62.8 34,63"></polygon></g></g></svg>
                        </span>
                    </div>
                </div>
            </div>
            <div class="task-container__task-body">
                <div class="task-container__task-title">
                    <?php esc_html_e('Install recommended plugins','saleszone'); ?>
                </div>
                <div class="task-container__task-description">
                    <p>
                        <?php esc_html_e('WooCommerce is a basic platform for your future store, one of the most popular on the web. After activation WooCommerce will suggest using the WooCommerce Onboarding Wizard which you can either use or skip and continue settings with the Premmerce Setup Wizard.','saleszone'); ?>
                    </p>
                    <p>
                        <?php esc_html_e('Premmerce is a toolkit of plugins which unites the most essential tools to amplify the WooCommerce core features together with a step-by-step tutorial, called Premmerce Wizard.','saleszone'); ?>
                    </p>
                    <p>
                        <?php esc_html_e('The Kikri plugin is essential for displaying all options that are available for the theme customization via the WordPress Customizer.','saleszone'); ?>
                    </p>
                    <p>
                        <?php esc_html_e('With MetaSlider, you can create your own unique, SEO-optimized slideshow in a matter of seconds!','saleszone'); ?>
                    </p>
                </div>
                <div class="task-container__task-footer">

                    <?php

                    $install_link = add_query_arg(array(
                            'page' => 'tgmpa-install-plugins',
                            'plugin' => 'woocommerce',
                            'tgmpa-install' => 'install-plugin',
                            'tgmpa-nonce' => wp_create_nonce('tgmpa-install')), site_url('wp-admin/admin.php'));

                    if (file_exists(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php')) {
                        $install_link = add_query_arg(array(
                            'page' => 'tgmpa-install-plugins',
                            'plugin' => 'woocommerce',
                            'tgmpa-activate' => 'activate-plugin',
                            'tgmpa-nonce' => wp_create_nonce('tgmpa-activate')),
                            site_url('wp-admin/admin.php'));
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

                    <?php

                    $install_link = add_query_arg(array(
                            'page' => 'tgmpa-install-plugins',
                            'plugin' => 'premmerce',
                            'tgmpa-install' => 'install-plugin',
                            'tgmpa-nonce' => wp_create_nonce('tgmpa-install')),
                            site_url('wp-admin/admin.php'));

                    if (file_exists(WP_PLUGIN_DIR . '/premmerce/premmerce.php')) {
                        $install_link = add_query_arg(array(
                            'page' => 'tgmpa-install-plugins',
                            'plugin' => 'premmerce',
                            'tgmpa-activate' => 'activate-plugin',
                            'tgmpa-nonce' => wp_create_nonce('tgmpa-activate')),
                            site_url('wp-admin/admin.php'));
                    }

                    ?>

                    <?php if(!saleszone_is_plugin_active('premmerce/premmerce.php') && !saleszone_is_plugin_active('premmerce-premium/premmerce.php')) :?>
                    <a class="button button-secondary" href="<?php echo esc_url($install_link); ?>">
                        <?php if (file_exists(WP_PLUGIN_DIR . '/premmerce/premmerce.php') && !saleszone_is_plugin_active('premmerce/premmerce.php')){
                            esc_html_e('Activate Premmerce','saleszone');
                        } else {
                            esc_html_e('Install Premmerce','saleszone');
                        } ?>
                    </a>
                    <?php endif; ?>

                    <?php

                    $install_link = add_query_arg(array(
                            'page' => 'tgmpa-install-plugins',
                            'plugin' => 'ml-slider',
                            'tgmpa-install' => 'install-plugin',
                            'tgmpa-nonce' => wp_create_nonce('tgmpa-install')),
                        site_url('wp-admin/admin.php'));

                    if (file_exists(WP_PLUGIN_DIR . '/ml-slider/ml-slider.php')) {
                        $install_link = add_query_arg(array(
                            'page' => 'tgmpa-install-plugins',
                            'plugin' => 'ml-slider',
                            'tgmpa-activate' => 'activate-plugin',
                            'tgmpa-nonce' => wp_create_nonce('tgmpa-activate')),
                            site_url('wp-admin/admin.php'));
                    }

                    ?>
                    <?php if(!saleszone_is_plugin_active('ml-slider/ml-slider.php')) :?>
                        <a class="button button-secondary" href="<?php echo esc_url($install_link); ?>">
                            <?php if (file_exists(WP_PLUGIN_DIR . '/ml-slider/ml-slider.php') && !saleszone_is_plugin_active('ml-slider/ml-slider.php')){
                                esc_html_e('Activate MetaSlider','saleszone');
                            } else {
                                esc_html_e('Install MetaSlider','saleszone');
                            } ?>
                        </a>
                    <?php endif; ?>

                    <?php
                    
                    $install_link = add_query_arg(array(
                            'page' => 'tgmpa-install-plugins',
                            'plugin' => 'kirki',
                            'tgmpa-install' => 'install-plugin',
                            'tgmpa-nonce' => wp_create_nonce('tgmpa-install')),
                            site_url('wp-admin/admin.php'));

                    if (file_exists(WP_PLUGIN_DIR . '/kirki/kirki.php')) {
                        $install_link = add_query_arg(array(
                            'page' => 'tgmpa-install-plugins',
                            'plugin' => 'kirki',
                            'tgmpa-activate' => 'activate-plugin',
                            'tgmpa-nonce' => wp_create_nonce('tgmpa-activate')),
                            site_url('wp-admin/admin.php'));
                    }

                    ?>
                    <?php if(!saleszone_is_plugin_active('kirki/kirki.php')) :?>
                    <a class="button button-secondary" href="<?php echo esc_url($install_link); ?>">
                        <?php if (file_exists(WP_PLUGIN_DIR . '/kirki/kirki.php') && !saleszone_is_plugin_active('kirki/kirki.php')){
                            esc_html_e('Activate kirki','saleszone');
                        } else {
                            esc_html_e('Install Kikri','saleszone');
                        } ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    $option_name = 'pc-wizzard-2';
    $is_checked = get_user_meta($user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . '-' . $option_name , true) == 'true' ? true : false ; ?>
    <div class="task-container__task">
        <div class="task-container__task-content-row">
            <div class="task-container__task-aside">
                <div class="task-container__task-action">
                    <?php saleszone_get_template('functions/admin/views/task-checkbox.php', array(
                        'option_name' => $option_name,
                        'is_checked' => $is_checked
                    )); ?>
                </div>
            </div>
            <div class="task-container__task-body">
                <div class="task-container__task-title">
                    <?php esc_html_e('Install demo data','saleszone'); ?>
                </div>
                <div class="task-container__task-description">
                    <?php esc_html_e('You can import the demo content with just one click.','saleszone'); ?>
                </div>
                <div class="task-container__task-footer">
                    <a class="button button-secondary" href="<?php echo esc_url(add_query_arg('tab', 'import', $pageUrl)); ?>">
                        <?php  esc_html_e( 'Install demo data', 'saleszone' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php
    $option_name = 'pc-wizzard-3';
    $is_checked = get_user_meta($user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . '-' . $option_name , true) == 'true' ? true : false ; ?>
    <div class="task-container__task">
        <div class="task-container__task-content-row">
            <div class="task-container__task-aside">
                <div class="task-container__task-action">
                    <?php saleszone_get_template('functions/admin/views/task-checkbox.php', array(
                        'option_name' => $option_name,
                        'is_checked' => $is_checked
                    )); ?>
                </div>
            </div>
            <div class="task-container__task-body">
                <div class="task-container__task-title">
                    <?php esc_html_e('Make WooCommerce Settings with Premmerce Wizard','saleszone'); ?>
                </div>
                <div class="task-container__task-description">
                    <?php esc_html_e('Premmerce Wizard will help you with a full set up of your WooCommerce store.','saleszone'); ?>
                </div>
                <div class="task-container__task-footer">
                    <?php if(saleszone_is_plugin_active('premmerce/premmerce.php') || saleszone_is_plugin_active('premmerce-premium/premmerce.php')) :?>
                        <a class="button button-secondary" href="<?php echo esc_url(add_query_arg(array('page' => 'premmerce'),admin_url())); ?>">
                            <?php esc_html_e('Go to Premmerce Wizard','saleszone'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    $option_name = 'pc-wizzard-4';
    $is_checked = get_user_meta($user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . '-' . $option_name , true) == 'true' ? true : false ; ?>
    <div class="task-container__task <?php echo $is_checked ? 'task-container__task-checked':''; ?>>">
        <div class="task-container__task-content-row">
            <div class="task-container__task-aside">
                <div class="task-container__task-action">
                    <?php saleszone_get_template('functions/admin/views/task-checkbox.php', array(
                        'option_name' => $option_name,
                        'is_checked' => $is_checked
                    )); ?>
                </div>
            </div>
            <div class="task-container__task-body">
                <div class="task-container__task-title">
                    <?php esc_html_e('Customize your theme','saleszone'); ?>
                </div>
                <div class="task-container__task-description">
                    <?php esc_html_e('All Settings, Theme Options, Widgets and Menus are available via Customize screen. Have a quick look at it or start customization right away!','saleszone'); ?>
                </div>
                <div class="task-container__task-footer">
                    <a class="button button-secondary" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>">
                        <?php esc_html_e('Go to Customizer','saleszone'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php
    $option_name = 'pc-wizzard-5';
    $is_checked = get_user_meta($user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . '-' . $option_name , true) == 'true' ? true : false ; ?>
    <div class="task-container__task">
        <div class="task-container__task-content-row">
            <div class="task-container__task-aside">
                <div class="task-container__task-action">
                    <?php saleszone_get_template('functions/admin/views/task-checkbox.php', array(
                        'option_name' => $option_name,
                        'is_checked' => $is_checked
                    )); ?>
                </div>
            </div>
            <div class="task-container__task-body">
                <div class="task-container__task-title">
                    <?php esc_html_e('Theme documentation','saleszone'); ?>
                </div>
                <div class="task-container__task-description">
                    <?php esc_html_e('Need help with setting up and configuring? Please take a look at our documentation page.','saleszone'); ?>
                </div>
                <div class="task-container__task-footer">
                    <a class="button button-secondary" href="<?php esc_attr_e('https://premmerce.com/woocommerce-saleszone-theme-tutorial/','saleszone'); ?>" target="_blank">
                        <?php  esc_html_e( 'SalesZone documentation', 'saleszone' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>