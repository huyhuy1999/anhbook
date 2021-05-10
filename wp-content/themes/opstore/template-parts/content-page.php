<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package opstore
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php 
    if( has_post_thumbnail() ):
        ?>
        <figure class="mb-25">
            <?php the_post_thumbnail('full'); ?>
        </figure>
        <!--figure-->
        <?php
    endif;
    ?>

    <div class="entry-post-content clearfix">
        <?php the_content(); ?>
    </div>
    <!--entry post content-->
    
    <?php 
    $display_link_pages = true;

    if( $display_link_pages ): ?>
        <div class="link-pages">
            <?php wp_link_pages(); ?>
        </div>
    <?php endif; ?>
    
</article>
