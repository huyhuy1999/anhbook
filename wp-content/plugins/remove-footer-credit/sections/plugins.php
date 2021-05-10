<?php

$plugins = array(
	'modula-best-grid-gallery' => array(
		'title'       => esc_html__( 'Modula - A WordPress Gallery Plugin', 'remove-footer-credit' ),
		'description' => esc_html__( 'Modula is currently the easiest and fastest photo gallery plugin for WordPress. With its wizard you are able to build an image gallery in a few seconds, unlike many other WordPress gallery plugins.', 'remove-footer-credit' ),
		'more'        => 'https://wordpress.org/plugins/modula-best-grid-gallery/',
		'image'       => 'modula.jpg',
	),
	'simple-author-box' => array(
		'title'       => esc_html__( 'Simple Author Box', 'remove-footer-credit' ),
		'description' => esc_html__( 'Simple Author Box adds a responsive author box at the end of your posts, showing the author name, author gravatar and author description. It also adds over 30 social profile fields on WordPress user profile screen, allowing to display the author social icons.', 'remove-footer-credit' ),
		'more'        => 'https://wordpress.org/plugins/simple-author-box/',
		'image'       => 'sab.png',
	),
);

if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$installed_plugins = get_plugins();

function rfc_get_plugin_basename_from_slug( $slug, $installed_plugins ) {
	$keys = array_keys( $installed_plugins );
	foreach ( $keys as $key ) {
		if ( preg_match( '|^' . $slug . '/|', $key ) ) {
			return $key;
		}
	}
	return $slug;
}

?>

<div class="rfc-recomended-plugins">
	<?php
	foreach ( $plugins as $slug => $plugin ) {

		$label       = __( 'Install & Activate', 'remove-footer-credit' );
		$action      = 'install';
		$plugin_path = rfc_get_plugin_basename_from_slug( $slug, $installed_plugins );
		$url         = '#';
		$class       = '';

		if ( file_exists( ABSPATH . 'wp-content/plugins/' . $plugin_path ) ) {

			if ( is_plugin_active( $plugin_path ) ) {
				$label  = __( 'Activated', 'remove-footer-credit' );
				$action = 'disable';
				$class  = 'disabled';
			} else {
				$label  = __( 'Activate', 'remove-footer-credit' );
				$action = 'activate';
				$url    = wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'activate',
							'plugin' => $plugin_path,
						), admin_url( 'plugins.php' )
					), 'activate-plugin_' . $plugin_path
				);
			}
		}

	?>
		<div class="rfc-recomended-plugin">
			<div class="plugin-image">
				<img src="<?php echo esc_url( $this->assets_path . 'images/' . $plugin['image'] ); ?>">
			</div>
			<div class="plugin-information">
				<p class="plugin-name"><strong><?php echo esc_html( $plugin['title'] ); ?></strong></p>
				<p class="plugin-description"><?php echo esc_html( $plugin['description'] ); ?></p>
				<a href="<?php echo esc_url( $url ); ?>" data-action="<?php echo esc_attr( $action ); ?>" data-slug="<?php echo esc_attr( $plugin_path ); ?>" data-message="<?php esc_html_e( 'Activated', 'remove-footer-credit' ); ?>" class="button-primary rfc-plugin-button <?php echo esc_attr( $class ); ?>" ><?php echo esc_html( $label ); ?></a>
				<?php if ( isset( $plugin['more'] ) ) : ?>
					<a href="<?php echo esc_url( $plugin['more'] ); ?>" class="button-secondary" target="_blank"><?php esc_html_e( 'Find out more', 'remove-footer-credit' ); ?></a>
				<?php endif ?>
			</div>
		</div>
	<?php } ?>
</div>
