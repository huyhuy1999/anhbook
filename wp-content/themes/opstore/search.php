<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package opstore
 */

get_header();
    
// title bar options
$search_for = 'blog';
$sidebar = true;
if( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'product' ) {
    $search_for = 'shop';
    $sidebar = false;
}


/**
 * OPSTORE Title Banner
 */

$banner_enable = get_theme_mod('opstore_page_banner_show','show');
if( $banner_enable == 'show' ){
    opstore_title_banner();
}

?>

<main class="main primary-padding">
    <section class="blog-block">
        <div class="container">
            <?php 
            if( $search_for === 'shop' ):
                ?>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="blog-list-wrap">
                            <ul class="products">
                                <?php if( function_exists( 'wc_get_template_part' ) ): ?>
                                     wc_get_template_part( 'content', 'product' );
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php  else: ?>
                <?php if( have_posts() ): ?>
                    <?php get_template_part( 'template-parts/archive/layout', 'list' ); ?>
                <?php else: ?>
                    <p><?php esc_html_e( 'Sorry, nothing found.Please try searching another keyword.', 'opstore' ); ?></p>
                    <div class="search-form"><?php get_search_form();?></div>
                    <a href="<?php echo esc_url( home_url('/') ); ?>" class="home-url">
                        <?php esc_html_e( 'Go back to Home', 'opstore' ); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
    <!--blog-->
</main>
<!-- /.main-->

<?php
get_footer();

