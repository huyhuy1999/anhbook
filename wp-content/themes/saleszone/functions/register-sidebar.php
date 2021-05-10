<?php
if(!function_exists('saleszone_register_sidebars')){
    function saleszone_register_sidebars(){

        /**
         * Html for show hide widget button on mobile screen
         */
        ob_start();
        ?>
        <div class="widget-sidebar__header widget-sidebar__header--mobile-toogler" data-sidebar-widget--header>
            <button class="widget-sidebar__toogle-button visible-xs" data-sidebar-widget--button></button>
            <h2 class="widget-sidebar__title">
                <span class="hidden" data-sidebar-widget--toggle><?php esc_html_e('Close', 'saleszone'); ?></span>
                <span data-sidebar-widget--toggle><?php esc_html_e('Show', 'saleszone'); ?></span>
                <?php
                $before_widget_title = ob_get_clean();
                ob_start();
                ?>

                <span class="widget-sidebar__header-arrow-icon hidden" data-sidebar-widget--toggle><?php saleszone_the_svg('arrow-top'); ?></span>
                <span class="widget-sidebar__header-arrow-icon" data-sidebar-widget--toggle><?php saleszone_the_svg('arrow-down'); ?></span>
            </h2>
        </div>
        <?php
        $after_widget_title = ob_get_clean();

        saleszone_register_sidebar(array(
                'name' => esc_html__('Blog sidebar','saleszone'),
                'description' => esc_html__('Sidebar on blog pages','saleszone'),
                'id' => 'blog_sidebar',
                'before_widget' => '<div class="content__sidebar-item %2$s" id="%1$s" data-sidebar-widget--scope><div class="widget-sidebar">',
                'before_title' => $before_widget_title,
                'after_title' => $after_widget_title,
                'after_widget' => '</div></div>',
        ));

        saleszone_register_sidebar(array(
            'name' => esc_html__('Catalog sidebar','saleszone'),
            'description' => esc_html__('Sidebar on Woocommerce Catalog pages','saleszone'),
            'id' => 'catalog_sidebar',
            'before_widget' => '<div class="content__sidebar-item %2$s" id="%1$s" data-sidebar-widget--scope><div class="widget-sidebar">',
            'before_title' => $before_widget_title,
            'after_title' => $after_widget_title,
            'after_widget' => '</div></div>'
        ));

        saleszone_register_sidebar(array(
            'name' => esc_html__('Subcategories sidebar','saleszone'),
            'description' => esc_html__('Sidebar on Woocommerce Subcategories pages','saleszone'),
            'id' => 'subcategories_sidebar',
            'before_widget' => '<div class="content__sidebar-item %2$s" id="%1$s"><div class="widget-sidebar">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-sidebar__header"><h2 class="widget-sidebar__title">',
            'after_title' => '</h2></div>'
        ));

        saleszone_register_sidebar(array(
            'name' => esc_html__('Front Page widgets','saleszone'),
            'description' => esc_html__('Widgets bar on Front page','saleszone'),
            'id' => 'homepage_widgets',
            'before_widget' => '<div class="col-sm-6 col-xs-12 %2$s" id="%1$s"><div class="pc-section-secondary">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="pc-section-secondary__header">',
            'after_title' => '</div>'
        ));

        saleszone_register_sidebar(array(
            'name' => esc_html__('Product sidebar','saleszone'),
            'description' => esc_html__('Sidebar on product pages','saleszone'),
            'id' => 'product_sidebar',
            'before_widget' => '<div class="content__sidebar-item %2$s" id="%1$s"><div class="widget-sidebar">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-sidebar__header"><h2 class="widget-sidebar__title">',
            'after_title' => '</h2></div>'
        ));

        $footer_columns = saleszone_option('footer_columns');

        for ($i = 1; $i <= $footer_columns; $i++) {
            saleszone_register_sidebar(array(
                'name' => esc_html__('Footer Column','saleszone') . ' ' . $i,
                'description' => esc_html__('Footer Column','saleszone') . ' ' . $i,
                'id' => 'footer_' . $i,
                'before_widget' => '<div class="footer__widget %2$s" id="%1$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="footer__widget-title">',
                'after_title' => '</div>'
            ));
        }

    }
}
add_action('widgets_init','saleszone_register_sidebars');

if(!function_exists('saleszone_render_before_widget_product_list')){
    function saleszone_render_before_widget_product_list(){
        return '<div class="widget-sidebar__inner">';
    }
}
add_filter('woocommerce_before_widget_product_list', 'saleszone_render_before_widget_product_list', 80);

if(!function_exists('saleszone_render_after_widget_product_list')){
    function saleszone_render_after_widget_product_list(){
        return '</div>';
    }
}
add_filter('woocommerce_after_widget_product_list', 'saleszone_render_after_widget_product_list', 80);