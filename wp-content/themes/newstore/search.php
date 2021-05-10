<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
				<header class="page-header">
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: %s', 'newstore' ), '<span>' . get_search_query() . '</span>' );
						?>
					</h1>
				</header><!-- .page-header -->
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
