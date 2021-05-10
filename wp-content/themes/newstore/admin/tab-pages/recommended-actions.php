<?php 
	$r_actions = $this->recommended_actions;
	$actions_todo = get_option( 'newstore_recommended_actions', false );
?>
<div class="action-list">
	<?php if($r_actions): foreach ($r_actions as $key => $a_action): ?>
	<div class="action" id="<?php echo esc_attr($a_action['id']); ?>">
		<div class="action-watch">
		<?php if(!$a_action['is_done']): ?>
			<?php if(!isset($actions_todo[$action['id']]) || !$actions_todo[$action['id']]): ?>
				<span class="dashicons dashicons-visibility"></span>
			<?php else: ?>
				<span class="dashicons dashicons-hidden"></span>
			<?php endif; ?>
		<?php else: ?>
			<span class="dashicons dashicons-yes"></span>
		<?php endif; ?>
		</div>
		<div class="action-inner">
			<h3 class="action-title"><?php echo esc_html($a_action['title']); ?></h3>
			<div class="action-desc"><?php echo wp_kses_post($a_action['desc']); ?></div>
			<?php echo $a_action['link']; ?>
		</div>
	</div>
	<?php endforeach; endif; ?>
</div>