<article  id="post-<?php the_ID(); ?>"  <?php post_class("col-12 content-single"); ?>>
	<div class="content-single-inner">
		<?php if(has_post_thumbnail()): ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail('full', array( 'class' => 'img-responsive blog-photo' )); ?>
		</div>
		<?php endif; ?>
		<div class="post-content">
			<?php the_title( '<h2 class="entry-title post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<div class="entry-meta post-meta">
				<?php do_action( 'newstore_post_index_meta'); ?>
			</div>
			<div class="entry-content">
				<?php
					the_content();

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'newstore' ),
						'after'  => '</div>',
					) );
				?>
				<div class="clearfix"></div>
			</div><!-- .entry-content -->
			<div class="clearfix"></div>
		</div>
	</div>	
</article>