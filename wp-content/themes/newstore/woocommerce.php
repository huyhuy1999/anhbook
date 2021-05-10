<?php
/**
 * The template for displaying woocommerce pages
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Amazica 
 */
$full_width_class ='';
if(is_product()){
	$sidebar = 'product';
}else{
	$sidebar = 'shop';
}
$layout ='';
$layout_class ='';

$layout =  get_theme_mod( 'newstore_shop_index_layout', 'left');
$layout_class = ($layout == 'full')?'full-width':(($layout == 'left')?'order-last':'order-first');

if(is_product()){
	$layout =  get_theme_mod( 'newstore_shop_single_product_layout', 'right');
	$layout_class = ($layout == 'full')?'full-width':(($layout == 'left')?'order-last':'order-first');
}



get_header(); 
do_action( 'newstore_before_shop');
?>
<div class="container-full space blog-post-index">
	<div class="container">
		<div id="primary" class="content-area row justify-content-center woocommerce-container">
			<main id="main" class="site-main wc-site-main <?php echo esc_attr( $layout_class );?>">
				<div id="blog-content" class="">
					<?php if ( have_posts() ) : ?>
	                    <?php woocommerce_content(); ?>
	                <?php endif; ?>
				</div>
				<div class="clearfix"></div>
			</main><!-- #main -->
			<?php 
				if($layout != 'full'){
					get_sidebar($sidebar); 
				}
			?>
		</div><!-- #primary -->
	</div>
</div>
<?php
get_footer();