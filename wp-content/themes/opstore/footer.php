<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package opstore
 */

?>

	<footer id="opstore-footer">
		<?php do_action('opstore_footer');?>
	</footer>
	<!--footer-->

	<a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>	   
</div>  <!-- end #primary -->

<?php 
do_action( 'opstore_after_body_output' );
?>
<div class="full-search-container">
    <a href="javascript:void(0)" class="closebtn" ><span class="lnr lnr-cross"></span></a>
    <?php echo get_search_form();?>
</div>    

<?php
wp_footer();
?>
</body>

</html>
