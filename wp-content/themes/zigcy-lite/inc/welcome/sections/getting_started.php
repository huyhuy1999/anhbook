<div class="theme-steps-list">

	<div class="theme-steps">
		<h3><?php echo esc_html($this->strings['doc_heading']); ?></h3>
		<p><?php echo esc_html($this->strings['doc_description']); ?></p>
		<a class="button button-primary" target="_blank" href="https://doc.accesspressthemes.com/zigcy-lite/"><?php echo esc_html($this->strings['doc_read_now']); ?></a>
	</div>

	<div class="theme-steps">
		<h3><?php echo esc_html($this->strings['cus_heading']); ?></h3>
		<p><?php echo esc_html($this->strings['cus_description']); ?></p>
		<a class="button button-primary" href="<?php echo esc_url(admin_url('customize.php')); ?>">
			<?php echo esc_html($this->strings['cus_read_now']); ?>
		</a>
	</div>

</div>

<div class="theme-image">
	<img src="<?php echo esc_url(get_template_directory_uri() . '/screenshot.png' ); ?>">
</div>