<?php

/**
 * HTML list of main catalog nav menu items.
 */
class WalkerCatalogVertical extends Walker_Nav_Menu
{
    /**
     * Starts the list before the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $classes = ($depth == 0) ? 'vertical-nav__drop' : 'vertical-nav__drop';
        $output .= '<nav class="' . $classes . '" data-nav-direction="ltr"><ul class="vertical-nav">';
    }

    /**
     * Starts the element output.
     *
     * @since 3.0.0
     * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
     *
     * @see Walker::start_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param WP_Post $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     * @param int $id Current item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $listAttributes = '';
        $listAttributes .= $args->walker->has_children ? 'data-global-doubletap' : '';

        $classes = $item->classes;

        $classes = array_merge($classes, array(($depth == 0) ? 'vertical-nav__item': 'vertical-nav__item'));
        $classes = array_merge($classes, array(($item->current || $item->current_item_ancestor) ? 'is-active' : ''));

        $classNames = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $classNames = ' class="' . esc_attr($classNames) . '"';

        $output .= '<li ' . $classNames . ' ' . $listAttributes . '>';

        /**
         * Link element classes
         */
        /* theme classes to link */
        $attributes = ($depth == 0) ? ' class="vertical-nav__link"' : ' class="vertical-nav__link"';
        /* target title to link */
        $attributes .= !empty($item->attr_title) ? ' title="'.esc_attr($item->attr_title).'"' : '';
        /* target attribute to link */
        $attributes .= !empty($item->target) ? ' target="'.esc_attr($item->target).'"' : '';
        /* rel attribute to link */
        $attributes .= !empty($item->xfn) ? ' rel="'.esc_attr($item->xfn).'"' : '';
        /* href attribute to link */
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
        $attributes .= '';

        /**
         * Output list menu item
         */
        $icon = ( $args->walker->has_children ) ? '<i class="vertical-nav__arrow vertical-nav__arrow--right">' . saleszone_get_svg('arrow-right') . '</i>' : '';

        $item_output = $args->before;
        $item_output .= ( $depth == 0 ) ? '<a' . $attributes . '>' : '<a' . $attributes . '>';
        $item_output .=  $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= ( $depth == 0 ) ? $icon . '</a>' : $icon . '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Ends the element output, if needed.
     *
     * @since 3.0.0
     *
     * @see Walker::end_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param WP_Post $item Page data object. Not used.
     * @param int $depth Depth of page. Not Used.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     */
    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= '</li>';
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::end_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     */
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= '</ul></nav>';
    }
}