<?php get_header(); ?>
	<div class="content">
		<div class="content__container">
			<?php if (have_posts()): the_post(); ?>
                <div class="content__header">
                    <h1 class="content__title"><?php the_title(); ?></h1>
                </div>
                <div class="content__row">
                    <?php echo wp_get_attachment_image($post->ID, 'full'); ?>
                </div>
                <div class="content__row">
                    <div class="typo">
                        <?php echo esc_html($post->post_content); ?>
                    </div>
                </div>
			<?php endif ?>
		</div>
	</div>
<?php get_footer(); ?>