<div class="bloginfo">
    <div class="row row--ib row--vindent-s">
        <?php 
$tags_list = get_the_tag_list();
?>
        <div class="col-sm-7">
            <?php 

if ( $tags_list ) {
    ?>
                <div class="bloginfo__item">
                    <div class="bloginfo__title">
                        <?php 
    esc_html_e( 'Tags', 'saleszone' );
    ?>
                    </div>
                    <div class="bloginfo__list">
                        <div class="tagcloud">
                            <?php 
    echo  wp_kses_post( $tags_list ) ;
    ?>
                        </div>
                    </div>
                </div>
            <?php 
}

?>
        </div>
        <div class="col-sm-5">
            <?php 
?>
        </div>
    </div>
</div>