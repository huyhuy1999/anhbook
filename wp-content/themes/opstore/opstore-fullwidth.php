<?php
/**
 * Template Name: Opstore Fullwidth
 */

get_header();
?>

<main class="main">
	<div class="opstore-main-content">
		<?php 
		while( have_posts() ):
			the_post();
			the_content();
		endwhile;
		?>
	</div>
</main>
<?php
get_footer();