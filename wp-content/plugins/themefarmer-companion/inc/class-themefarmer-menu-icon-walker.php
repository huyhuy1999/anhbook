<?php

/**
 * Custom Walker for Nav Menu Editor.
 */
function themefarmer_companion_admin_scripts($hook) {
	if ('nav-menus.php' === $hook) {
		wp_enqueue_style('themefarmer-admin-panel', THEMEFARMER_COMPANION_URI . 'assets/css/admin-panel.css', false, '1.0.0');
		wp_enqueue_media();
		wp_enqueue_script('themefarmer-admin-panel', THEMEFARMER_COMPANION_URI . 'assets/js/admin-panel.js', array('jquery'), null, true);
	}
	wp_enqueue_style('themefarmer-font-awesome', THEMEFARMER_COMPANION_URI . 'assets/css/font-awesome.css', false, '1.0.0');
}
add_action('admin_enqueue_scripts', 'themefarmer_companion_admin_scripts');

function themefarmer_show_menu_icon($menu_item){
	$icon    = get_post_meta( $menu_item->ID, 'themefarmer_menu_icon', true);
	if(!empty($icon)){
		if(!is_admin()){
			$menu_item->title	= sprintf( '<i class="tf-menu-icon %s"></i> %s', $icon, $menu_item->title );
		}
	}
	return $menu_item;
}
add_filter( 'wp_setup_nav_menu_item', 'themefarmer_show_menu_icon', 10, 1 );
global $themefarmer_nav_images;
$themefarmer_nav_images = array();
function themefarmer_setup_image_nav_menu_items($args, $item, $depth){
	global $themefarmer_nav_images;
	if($depth === 0){
		$image_id   = absint(get_post_meta($item->ID, 'themefarmer_menu_image', true));
		if($image_id > 0){
			$img_src = wp_get_attachment_image_url( $image_id, 'full', false );
			$themefarmer_nav_images[$item->ID] = $img_src;
		}
	}else{
		$image_id   = absint(get_post_meta($item->ID, 'themefarmer_menu_image', true));
		if($image_id > 0){
			$img_src = wp_get_attachment_image_url( $image_id, 'medium', false );
			$item->title = sprintf('<img class="nav-menu-img" src="%s" alt="%s"><span class="img-nav-item-text">%s</span>', $img_src, $item->title, $item->title);
		}
	}
	return $args;
}

function themefaremr_wp_footer_nav_images(){
global $themefarmer_nav_images;
if(!empty($themefarmer_nav_images)):
?>
<style>
	<?php foreach ($themefarmer_nav_images as $key => $url): ?>
		@media (min-width: 768px) {
			#menu-item-<?php echo absint( $key ); ?> > ul,
			.menu-item-<?php echo absint( $key ); ?> > ul{
				background-image: url(<?php echo esc_url($url); ?>);
				background-size: contain;
			    background-repeat: no-repeat;
			    background-position: right bottom;
			}
		}
	<?php endforeach; ?>
</style>
<?php
endif;
}
add_action( 'wp_footer', 'themefaremr_wp_footer_nav_images');

if(!is_admin()){
	add_filter( 'nav_menu_item_args', 'themefarmer_setup_image_nav_menu_items', 10, 3);
	// add_filter( 'wp_nav_menu_items', 'themefarmer_setup_image_nav_menu_items', 10, 2);
}


add_filter( 'wp_edit_nav_menu_walker', 'themefarmer_nav_edit_walker', 999);
function themefarmer_nav_edit_walker() {
	return 'ThemeFarmer_Menu_Icons_Walker';
}

if(!class_exists('Walker_Nav_Menu_Edit')){
	require_once( ABSPATH . 'wp-admin/includes/class-walker-nav-menu-edit.php' );
}

class ThemeFarmer_Menu_Icons_Walker extends Walker_Nav_Menu_Edit {

	/**
	 * Start the element output.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Menu item args.
	 * @param int    $id     Nav menu ID.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		parent::start_el( $output, $item, $depth, $args, $id );
		$icon    = esc_attr(get_post_meta( $item->ID, 'themefarmer_menu_icon', true));
		$image   = esc_attr(get_post_meta( $item->ID, 'themefarmer_menu_image', true));
		$img_src = wp_get_attachment_image_url( $image, 'thumbnail', false );
		$output .= sprintf( '<input type="hidden" name="menu-item-icon[%d]" class="menu-item-icon-field" id="menu-item-icon-%d" value="%s">', $item->ID, $item->ID, $icon );
		$output .= sprintf( '<input type="hidden" name="menu-item-image[%d]" class="menu-item-image-field" id="menu-item-image-%d" value="%s" data-src="%s">', $item->ID, $item->ID, $image, $img_src);
	}
}


add_action( 'wp_update_nav_menu_item', 'themefarmer_save_icon_fields', 10, 3 );
function themefarmer_save_icon_fields( $menu_id, $menu_item_db_id, $menu_item_data ) {
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}

	if ( ! function_exists( 'get_current_screen' ) ) {
	    return;
    }

	$screen = get_current_screen();
	if ( ! $screen instanceof WP_Screen || 'nav-menus' !== $screen->id ) {
		return;
	}

	check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );
	
	if ( isset( $_POST['menu-item-icon'][ $menu_item_db_id ] ) ) {
		$icon	= sanitize_text_field($_POST['menu-item-icon'][$menu_item_db_id]);
		update_post_meta( $menu_item_db_id, 'themefarmer_menu_icon', $icon );
	}

	if ( isset( $_POST['menu-item-image'][ $menu_item_db_id ] ) ) {
		$image	= absint( $_POST['menu-item-image'][$menu_item_db_id] );
		update_post_meta( $menu_item_db_id, 'themefarmer_menu_image', $image );
	}

}