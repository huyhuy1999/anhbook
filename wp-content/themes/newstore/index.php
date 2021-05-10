<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NewSrore
 */

get_header();
do_action( 'newstore_before_blog_post');
?>
<div class="container-full space blog-post-index">
	<div class="container">
		<div id="primary" class="content-area row justify-content-center">
			<main id="main" class="site-main">
			<?php if ( have_posts() ) : ?>
				<div id="blog-content" class="row posts-index">
				<?php 
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content', 'index' );
					endwhile;
				?>
				</div>
				<div class="clearfix"></div>
				<div class="the-pagination">
					<?php the_posts_pagination(); ?>
				</div>
			<?php
				else :
					get_template_part( 'template-parts/content', 'none' );
			endif; ?>
			</main><!-- #main -->
			<?php get_sidebar(); ?>
		</div><!-- #primary -->
	</div>
</div>
<?php
get_footer();
