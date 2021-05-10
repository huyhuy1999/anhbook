<div class="wrap tfwctool-wrap">
    <h1 class="tfwctool-title"><?php echo esc_html(get_admin_page_title()); ?></h1>
    <?php if(isset($_REQUEST['settings-updated']) && $_REQUEST['settings-updated']== true): ?>
    <div class="notice notice-success is-dismissible">
        <p><?php esc_html_e( 'settings saved successfully', 'woocommerce-tools' ); ?></p>
    </div>
    <?php endif; ?>
    <div class="tfwctool-setting-container">
        <form action="options.php" method="post">
            <?php
            	settings_fields('tfwctool-options-compare');
            	do_settings_sections('tfwctool-options-compare');
            	$options                   = get_option('tfwctool_compare');
            	$button_label               = (isset($options['button_label']))?$options['button_label']:__('Compare', 'woocommerce-tools');
                $button_icon               = (isset($options['button_icon']))?$options['button_icon']:'fa fa-refresh';
                $show_in_prodict_list      = isset($options['show_in_prodict_list'])?$options['show_in_prodict_list']:false;
                $show_in_single_product    = isset($options['show_in_single_product'])?$options['show_in_single_product']:false;
                $show_button_icon          = isset($options['show_button_icon'])?$options['show_button_icon']:false;

            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button Text', 'woocommerce-tools'); ?></th>
                    <td><input type="text" name="tfwctool_compare[button_label]" value="<?php echo esc_attr( $button_label ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button Icon', 'woocommerce-tools'); ?></th>
                    <td><input type="text" name="tfwctool_compare[button_icon]" value="<?php echo esc_attr( $button_icon ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Show icon', 'woocommerce-tools'); ?></th>
                    <td><input type="checkbox" name="tfwctool_compare[show_button_icon]" value="1" <?php checked($show_button_icon, 1, true) ?> /></td>
                </tr>

                <tr><td colspan="2"><hr></td></tr>

                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Show button on product list', 'woocommerce-tools'); ?></th>
                    <td><input type="checkbox" name="tfwctool_compare[show_in_prodict_list]" value="1" <?php checked($show_in_prodict_list, 1, true) ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Show button on single product', 'woocommerce-tools'); ?></th>
                    <td><input type="checkbox" name="tfwctool_compare[show_in_single_product]" value="1" <?php checked($show_in_single_product, 1, true) ?> /></td>
                </tr>
                <tr><td colspan="2"><hr></td></tr>

            </table>
            <div class="submit-button-container">
                <?php submit_button('Save Settings'); ?>
            </div>
        </form>
    </div>
</div>