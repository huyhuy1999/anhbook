<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package NewSrore
 */

get_header();
do_action( 'newstore_before_blog_post');
?>
<div class="container-full space blog-post-single">
	<div class="container">
		<div id="primary" class="content-area row justify-content-center">
			<main id="main" class="site-main post-single">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'single' );

				newstore_post_navigation();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

			</main><!-- #main -->
			<?php get_sidebar(); ?>
		</div><!-- #primary -->
	</div>
</div>

<?php
get_footer();
