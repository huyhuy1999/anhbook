<?php
/**
 * Template Name: FrontPage (NewStore)
 */

get_header();
?>
<div class="container-full front-page-contaienr">
<?php 
get_template_part( 'template-parts/home', 'top-widget' );
get_template_part( 'template-parts/home', 'slider' );
get_template_part( 'template-parts/home', 'categories' );
get_template_part( 'template-parts/home', 'widgets' );
get_template_part( 'template-parts/home', 'columns' );
get_template_part( 'template-parts/home', 'brands' );
?>	
</div>
<?php
get_footer();
