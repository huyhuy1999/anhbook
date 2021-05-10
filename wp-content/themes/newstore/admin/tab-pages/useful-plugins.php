<?php 
	$u_plugins = $this->get_useful_plugins();
?>
<div class="usefull-plugins">
	<div class="row">
	<?php  if($u_plugins): foreach ($u_plugins as $key => $plugin): 
		$info = $this->get_plugin_info_api($plugin['slug']);
		?>
		<div class="useful-plugin-install col">
			<div class="plg-icon-box">
				<?php $icon = $this->get_plugin_icon( $info->icons ); ?>
				<img src="<?php echo esc_url($icon); ?>" class="plg-icon">
			</div>
			<div class="plg-title-install-box">
				<?php if(!empty($info->name)): ?>
				<h2><?php echo esc_html($info->name); ?></h2>
				<?php endif; ?>
				<?php 
					$button = $this->get_plugin_buttion($info->slug, $info->name); 
					echo $button['button'];
				?>
			</div>
			<div style="clear: both;"></div>
			<div class="plg-ver-info">
				<?php if ( ! empty( $info->version ) ): ?>
					<?php esc_html_e('Version', 'newstore'); echo ': '.esc_html($info->version); ?>
				<?php endif; ?>
				|
				<?php if ( ! empty( $info->author ) ): ?>
					<?php echo wp_kses_post( strip_tags( $info->author ) ); ?>
				<?php endif; ?>

			</div>
			<div style="clear: both;"></div>
			<?php if(!empty($info->short_description)): ?>
			<div class="descricption"><?php $desc = substr(strip_tags($info->short_description), 0, 150); echo esc_html($desc); ?></div>
			<?php endif; ?>
		</div>
	<?php endforeach; endif; ?>
	</div>
</div>