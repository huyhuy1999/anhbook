<?php
/**
 * Default theme options.
 *
 * @package Opstore
 * @since 1.0.0
 */

if (!function_exists('opstore_get_default_theme_options')):

/**
 * Get default theme options
 *
 * @since 1.0.0
 *
 * @return array Default theme options.
 */
function opstore_get_default_theme_options() {

    $defaults = array();
    
    $defaults['opstore_theme_color']            = '#89c350';
    $defaults['opstore_show_hide_option']       = 'show';
    $defaults['opstore_sticky_menu']            = 'hide';
    $defaults['opstore_breadcrumb_delimiter']   = '>>';
    $defaults['opstore_webpage_layout']         = 'opstore-fullwidth';
    $defaults['opstore_header_layouts']         = 'style1';
    $defaults['opstore_sider_layout']           = 'slider-1';
    $defaults['archive_page_sidebars_layout']   = 'rightsidebar';
    $defaults['archive_page_sidebars']          = 'right-sidebar';
    $defaults['opstore_archive_page_excerpts']  = 50;
    $defaults['opstore_archive_read_more']      = esc_html__('Read More', 'opstore' );
    $defaults['opstore_topfooter_col']          = 4;
    $defaults['opstore_woo_column']             = 3;
    $defaults['opstore_product_perpage']        = 9;
    $defaults['opstore_banner_title_position'] = 'center';
    $defaults['opstore_banner_height'] = '200';

    // Pass through filter.
    $defaults = apply_filters('opstore_filter_default_theme_options', $defaults);

	return $defaults;

}

endif;
