<div class="row">
	<div class="col">
		<h2><?php esc_html_e('Recommended actions', 'newstore'); ?></h2>
		<p><?php esc_html_e('we have created list of steps to take so you get amazing expriance with theme.', 'newstore'); ?></p>
		<a class="button" href="<?php echo esc_url(admin_url( 'themes.php?page=newstore-welcome&tab=recommended_actions' )); ?>"><?php esc_html_e('Go to Recommended actions', 'newstore'); ?></a>
	</div>
	<div class="col">
		<h2><?php esc_html_e('Read Theme Documentation', 'newstore'); ?></h2>
		<p><?php esc_html_e('Missing Something..? Please check our full documentation for detaild information about NewStore ', 'newstore'); ?></p>
		<a class="button" href="<?php echo esc_url($this->docs_link); ?>" target="_blank"><?php esc_html_e('Go to Documentation', 'newstore'); ?></a>
	</div>
	<div class="col">
		<h2><?php esc_html_e('Customize NewStore ', 'newstore'); ?></h2>
		<p><?php esc_html_e('Use customizer to setup NewStore ', 'newstore'); ?></p>
		<a class="button button-primary" href="<?php echo esc_url( admin_url('customize.php') ); ?>" target="_blank"><?php esc_html_e('Go to Customizer', 'newstore'); ?></a>
	</div>
</div>
