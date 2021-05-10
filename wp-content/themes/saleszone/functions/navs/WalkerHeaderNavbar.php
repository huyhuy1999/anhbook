<?php

class WalkerHeaderNavbar extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = array() ) {

        $wrapperClass = ( $depth == 0 ) ? "pc-header-layout-3__navbar-drop" : "overlay__drop";

        $output .= '<nav class="' . $wrapperClass . '"><ul class="overlay">';
    }

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        /**
         * List element classes
         */
        $listAttributes = $args->walker->has_children ? 'data-global-doubletap' : '';

        $classes = $item->classes;

        if( $depth == 0 ) {
            $classes = array_merge($classes, array('pc-header-layout-3__navbar-item'));
            $classes = array_merge($classes, array(($item->current || $item->current_item_ancestor) ? 'pc-header-layout-3__navbar-item--active' : ''));
        } else {
            $classes = array_merge($classes, array('overlay__item'));
            $classes = array_merge($classes, array(($item->current || $item->current_item_ancestor) ? 'overlay__item--active' : ''));
        }

        $classNames = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $classNames = ' class="' . esc_attr($classNames) . '"';

        $output .= "<li {$classNames} {$listAttributes}>";

        /**
         * Link element classes
         */
        /* theme classes to link */
        $attributes = ($depth == 0) ? ' class="pc-header-layout-3__navbar-link"' : ' class="overlay__link"';
        /* target title to link */
        $attributes .= !empty($item->attr_title) ? ' title="'.esc_attr($item->attr_title).'"' : '';
        /* target attribute to link */
        $attributes .= !empty($item->target) ? ' target="'.esc_attr($item->target).'"' : '';
        /* rel attribute to link */
        $attributes .= !empty($item->xfn) ? ' rel="'.esc_attr($item->xfn).'"' : '';
        /* href attribute to link */
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

        /**
         * Output list menu item
         */
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .=  $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= ( $depth == 0 && $args->walker->has_children ) ? '<i class="pc-header-layout-3__navbar-link-arrow"><i class="fa fa-caret-down"></i></i>' : '';
        $item_output .= ( $depth > 0 && $args->walker->has_children ) ? '<i class="overlay__arrow overlay__arrow--right">' . saleszone_get_svg("arrow-right") . '</i>' : '';
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

    }

    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= '</li>';
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= '</ul></nav>';
    }
}