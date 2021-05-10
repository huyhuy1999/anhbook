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
            	settings_fields('tfwctool-options-wishlist');
            	do_settings_sections('tfwctool-options-wishlist');
                $wishlist_page_id =          get_option('tfwctool_wishlist_page_id');
            	$options                   = get_option('tfwctool_wishlist');
            	$button_label               = (isset($options['button_label']))?$options['button_label']:__('Add To Wishlist', 'woocommerce-tools');
                $button_icon               = (isset($options['button_icon']))?$options['button_icon']:'fa fa-heart';
                $show_in_prodict_list      = isset($options['show_in_prodict_list'])?$options['show_in_prodict_list']:false;
                $show_in_single_product    = isset($options['show_in_single_product'])?$options['show_in_single_product']:false;
                $show_button_icon          = isset($options['show_button_icon'])?$options['show_button_icon']:false;
                $pages = get_pages(array('post_type' => 'page', 'post_status' => 'publish'));
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Wishlist Page', 'woocommerce-tools'); ?></th>
                    <td> 
                        <?php if($pages): ?>
                        <select name="tfwctool_wishlist_page_id" id="" class="select2">
                            <option value=""><?php esc_html_e('Select Wishlist Page'); ?></option>
                            <?php foreach ($pages as $key => $page): ?>
                            <option value="<?php echo absint($page->ID); ?>" <?php selected($page->ID, $wishlist_page_id, true ); ?>><?php echo esc_html($page->post_title); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <span class="description"><?php _e('Make sure page content have <strong>[tfwc_tool_wishilst]</strong> Shortcode to show wishlist'); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr><td colspan="2"><hr></td></tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button Text', 'woocommerce-tools'); ?></th>
                    <td><input type="text" name="tfwctool_wishlist[button_label]" value="<?php echo esc_attr( $button_label ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button Icon', 'woocommerce-tools'); ?></th>
                    <td><input type="text" name="tfwctool_wishlist[button_icon]" value="<?php echo esc_attr( $button_icon ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Show icon', 'woocommerce-tools'); ?></th>
                    <td><input type="checkbox" name="tfwctool_wishlist[show_button_icon]" value="1" <?php checked($show_button_icon, 1, true) ?> /></td>
                </tr>
                <tr><td colspan="2"><hr></td></tr>

                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Show button on product list', 'woocommerce-tools'); ?></th>
                    <td><input type="checkbox" name="tfwctool_wishlist[show_in_prodict_list]" value="1" <?php checked($show_in_prodict_list, 1, true) ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Show button on single product', 'woocommerce-tools'); ?></th>
                    <td><input type="checkbox" name="tfwctool_wishlist[show_in_single_product]" value="1" <?php checked($show_in_single_product, 1, true) ?> /></td>
                </tr>
                <tr><td colspan="2"><hr></td></tr>

            </table>
            <div class="submit-button-container">
                <?php submit_button('Save Settings'); ?>
            </div>
        </form>
    </div>
</div>