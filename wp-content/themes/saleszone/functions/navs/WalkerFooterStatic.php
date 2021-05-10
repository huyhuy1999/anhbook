<?php

class WalkerFooterStatic extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "<ul class=\"footer__items\">";
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $classes = $item->classes;

		$classes = array_merge($classes, array("footer__item"));
		$classes = array_merge($classes, array(($item->current || $item->current_item_ancestor) ? 'footer__item--active' : ''));

		$classNames = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$classNames = ' class="' . esc_attr($classNames) . '"';

		$output .= "<li {$classNames}>";

		/**
		 * Link element classes
		 */
		/* theme classes to link */
		$attributes = ' class="footer__link"';
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
		$item_output .= "<a {$attributes}>";
		$item_output .=  $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= "</a>";
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}