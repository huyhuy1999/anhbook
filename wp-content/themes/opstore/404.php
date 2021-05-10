<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package opstore
 */

get_header();
?>

<main class="error-page primary-padding">

    <div class="container">
        <div class="row pri-pad">
            <div class="col-sm-12 col-md-12 text-center">
                
                   <div class="error-header-wrapp">
                   <div class="error-title-main"><?php esc_html_e('404','opstore'); ?></div>
                    <h3><?php esc_html_e('Not Found','opstore');?></h3>
                   </div> 
                <h5><?php esc_html_e('Oops. The page you were looking for does not exist.', 'opstore'); ?></h5>

                <div class="mb-55 primary-font">
                	<?php esc_html_e('May be the page you are searching is removed or you may have mistyped.', 'opstore'); ?>
            	</div>

                <a href="<?php echo esc_url( site_url() ); ?>" class="primary-color"> 
                	<?php esc_html_e('Back to the homepage','opstore'); ?>
            	</a>
            </div>
        </div>
    </div>
   
</main>


<?php
get_footer();
?>
