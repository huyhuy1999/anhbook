<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package NewSrore
 */

get_header();
?>
<div class="container-full space blog-post-index page-404">
	<div class="container">
		<div id="primary" class="content-area row justify-content-center">
			<main id="main" class="site-main col-12">
				<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'newstore' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'newstore' ); ?></p>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
			</main>
		</div><!-- #primary -->
	</div>
</div>

<?php
get_footer();
