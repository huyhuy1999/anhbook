<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NewSrore
 */

get_header();
do_action( 'newstore_before_blog_post');
?>
<div class="container-full space blog-post-page">
	<div class="container">
		<div id="primary" class="content-area row justify-content-center">
			<main id="main" class="site-main post-single">
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

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
