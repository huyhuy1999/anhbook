
</div><!-- .page__content -->

</div><!-- .page__wrapper -->

<!-- Footer -->
<footer class="page__fgroup">

    <?php 
?>

    <?php 
do_action( 'premmerce_before_footer_1' );
?>

    <?php 

if ( saleszone_option( 'footer_1' ) ) {
    ?>
    <div class="page__footer">
        <div class="page__container">
            <div class="footer">
                <?php 
    $footer_columns = saleszone_option( 'footer_columns' );
    ?>
                <div class="footer__row footer__row--columns-<?php 
    echo  esc_attr( $footer_columns ) ;
    ?>">
                    <?php 
    for ( $i = 1 ;  $i <= $footer_columns ;  $i++ ) {
        ?>
                        <?php 
        
        if ( is_active_sidebar( 'footer_' . $i ) ) {
            ?>
                            <div class="footer__col">
                                <?php 
            dynamic_sidebar( 'footer_' . $i );
            ?>
                            </div>
                        <?php 
        }
        
        ?>
                    <?php 
    }
    ?>
                </div>
            </div>
        </div>
    </div>
    <?php 
}

?>

    <?php 
?>

</footer>

</div><!-- /.page__*-layout -->
</div><!-- /.page__body -->

<!-- Mobile slide frame -->
<div class="page__mobile" data-page-pushy-mobile>
    <?php 
get_template_part( 'parts/mobile-menu/mobile', 'frame' );
?>
</div>

<!-- Site background overlay when mobile menu is open -->
<div class="page__overlay hidden" data-page-pushy-overlay></div>

<?php 
wp_footer();
?>
</body>
</html>