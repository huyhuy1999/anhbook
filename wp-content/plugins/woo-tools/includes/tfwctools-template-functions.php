<?php
function tfwctool_add_to_wishlist_button() {
	$options                     = get_option('tfwctool_wishlist', true);
	$button_label                = isset($options['button_label']) ? $options['button_label'] : esc_html__('Add To Wishlist', 'woocommerce-tools');
	$button_label                = apply_filters('tfwctool_wishlist_button_label', $button_label);
	$button_icon                 = (isset($options['button_icon'])) ? $options['button_icon'] : 'fa fa-heart';
	$button_icon                 = apply_filters('tfwctool_wishlist_button_icon', $button_icon);
	$show_button_icon            = isset($options['show_button_icon']) ? $options['show_button_icon'] : false;
	$show_button_icon            = apply_filters('tfwctool_wishlist_show_button_icon', $show_button_icon);
	$button_args['icon']         = '';
	$button_args['button_label'] = $button_label;

	if ($show_button_icon) {
		$button_args['icon'] = ' <i class="' . esc_attr($button_icon) . '"></i> ';
	}
	tfwctool_get_template('wishlist-button.php', $button_args);
}


function tfwctool_add_to_compare_button() {
	$options                     = get_option('tfwctool_compare', true);
	$button_label 				 = isset($options['button_label'])?$options['button_label']:esc_html__('Compare', 'woocommerce-tools');
	$button_label				 = apply_filters('tfwctool_compare_button_label', $button_label);
	$button_icon            	 = (isset($options['button_icon']))?$options['button_icon']:'fa fa-refresh';
	$button_icon				 = apply_filters('tfwctool_compare_button_icon', $button_icon);
   	$show_button_icon       	 = isset($options['show_button_icon'])?$options['show_button_icon']:false;
   	$show_button_icon			 = apply_filters('tfwctool_compare_show_button_icon', $show_button_icon);
	$button_args['icon']         = '';
	$button_args['button_label'] = $button_label;

	if ($show_button_icon) {
		$button_args['icon'] = ' <i class="' . esc_attr($button_icon) . '"></i> ';
	}
	tfwctool_get_template('compare-button.php', $button_args);
}

function tfwctool_quick_view_button() {
	$options                     = get_option('tfwctool_quickview');
	$button_label 				 = isset($options['button_label'])?$options['button_label']:esc_html__('Quick View', 'woocommerce-tools');
	$button_label				 = apply_filters('tfwctool_quickview_button_label', $button_label);
	$button_icon            	 = (isset($options['button_icon']))?$options['button_icon']:'fa fa-eye';
	$button_icon				 = apply_filters('tfwctool_quickview_button_icon', $button_icon);
   	$show_button_icon       	 = isset($options['show_button_icon'])?$options['show_button_icon']:false;
   	$show_button_icon			 = apply_filters('tfwctool_quickview_show_button_icon', $show_button_icon);
	$button_args['icon']         = '';
	$button_args['button_label'] = $button_label;

	if ($show_button_icon) {
		$button_args['icon'] = ' <i class="' . esc_attr($button_icon) . '"></i> ';
	}
	tfwctool_get_template('quick-view-button.php', $button_args);
}