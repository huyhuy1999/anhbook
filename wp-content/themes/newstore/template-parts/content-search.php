<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NewSrore
 */

?>
<article  id="post-<?php the_ID(); ?>"  <?php post_class("col-12 content-index"); ?>>
	<div class="content-index-inner">
		<?php if(has_post_thumbnail()): ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail('newstore-thumb', array( 'class' => 'img-responsive blog-photo' )); ?>
			<div class="overlay">
	            	<a class="post-qk-link the-post-link" href="<?php the_permalink(); ?>"><span class="fa fa-play"></span></a>
	                <a class="post-qk-link the-post-img" href="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), 'full')); ?>"><i class="fa fa-search"></i></a>
            </div>
		</div>
		<?php endif; ?>
		<div class="post-content">
			<?php the_title( '<h2 class="entry-title post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta post-meta">
				<?php do_action( 'newstore_post_index_meta'); ?>
			</div>
			<?php endif; ?>
			<div class="entry-summary post-description"><?php the_excerpt(); ?></div>
			<div class="button-container text-right">
				<a class="btn btn-read-more" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'newstore'); ?></a>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>	
</article>