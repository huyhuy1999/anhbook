<?php

class WalkerMobileStatic extends Walker_Nav_Menu
{

    public function start_lvl(&$output, $depth = 0, $args = array())
    {

        $output .= "<ul class=\"mobile-nav__list mobile-nav__list--drop hidden\" data-mobile-nav-list>";

        $output .= "<li class=\"mobile-nav__item\" data-mobile-nav-item>";
        $output .= "<button class=\"mobile-nav__link mobile-nav__link--go-back\" data-mobile-nav-go-back>" . __('Go back', 'saleszone');
        $output .= "<span class=\"mobile-nav__has-children\"><i class=\"mobile-nav__ico\">" . saleszone_get_svg('arrow-right') . "</i></span>";
        $output .= "</button>";
        $output .= "</li>";

        $output .= "<li class=\"mobile-nav__item hidden\" data-mobile-nav-item>";
        $output .= "<a class=\"mobile-nav__link mobile-nav__link--view-all\" data-mobile-nav-viewAll>";
        $output .= __('Show all', 'saleszone');
        $output .= "</a>";
        $output .= "</li>";
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {

        $listAttributes = "data-mobile-nav-item";

        $classes = $item->classes;

        $classes = array_merge($classes, array("mobile-nav__item"));
        $classes = array_merge($classes, array(($item->current || $item->current_item_ancestor) ? 'mobile-nav__item--active' : ''));


        $classNames = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $classNames = ' class="' . esc_attr($classNames) . '"';

        $output .= "<li {$classNames} {$listAttributes}>";

        /**
         * Link element classes
         */
        /* theme classes to link */
        $attributes = ' class="mobile-nav__link"';
        /* theme data-attributes to link */
        $attributes .= $args->walker->has_children ? ' data-mobile-nav-link' : '';
        /* target title to link */
        $attributes .= !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        /* target attribute to link */
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        /* rel attribute to link */
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        /* href attribute to link */
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        /**
         * Output list menu item
         */
        $item_output = $args->before;
        $item_output .= "<a {$attributes}>";
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= $args->walker->has_children ? '<span class="mobile-nav__has-children"><i class="mobile-nav__ico">' . saleszone_get_svg('arrow-right') . '</i></span>' : '';
        $item_output .= "</a>";
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= '</li>';
    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= "</ul>";
    }
}