<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package opstore
 */

get_header();

/**
 * OPSTORE Title Banner
 */
$banner_enable = get_theme_mod('opstore_page_banner_show','show');
if( $banner_enable == 'show' ){
    opstore_title_banner();
}
?>

<main class="main p-pb">
    <section class="blog-block">
        <div class="container">
            <?php get_template_part( 'template-parts/archive/layout', 'list' ); ?>
        </div>
    </section>
    <!--blog-->
</main>
<!-- /.main-->

<?php
get_footer();
