<?php 
global $post;

$sidebarPositionOld = get_post_meta($post->ID, 'ultra_seven_page_sidebar', true);

$sidebarPosition = get_post_meta($post->ID, 'ultra_sidebar_layout', true);
$sidebarPosition = !empty( $sidebarPosition ) ? $sidebarPosition : $sidebarPositionOld;


if($sidebarPosition == 'default' || $sidebarPosition == ''){
    $sidebarPosition = get_theme_mod('post_page_sidebars_layout','rightsidebar');
}

$main_class = 'col-md-12 col-sm-12 col-xs-12';
if( $sidebarPosition != 'nosidebar' ){
    $main_class = 'primary-content col-md-8 col-sm-8 col-xs-12';
}

if ($sidebarPosition === 'leftsidebar' ): 
    $main_class .= ' pull-right';
endif;


?>
<div class="row classic-single">
    <div class="<?php echo esc_attr( $main_class ); ?>">
        <?php 
        while( have_posts() ): the_post(); 
            if(has_post_thumbnail()){
                $class = 'has-post-thumbnail';
            }else{
                $class = '';
            } ?>
            <div id="post-<?php the_id(); ?>" <?php post_class(array('blog-detail',$class)); ?>>  
                <figure class="opstore-single-content mb-20">
                    <?php opstore_post_formats(); ?>
                </figure>
                <div class="title-wrap-content mb-20">
                    <div class="post-info mb-10">
                        <?php opstore_entry_meta(); ?>
                    </div>
                    <?php 
                    the_title('<h3>', '</h3>' );
                    ?>
                </div>
                <div class="classic-content-wrap entry-content mb-0">
                    <div class="entry-post-content  mb-20">
                        <?php the_content(); ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    $defaults = array(
                        'before'           => '<nav class="navigation">' . __( 'Pages:', 'opstore' ),
                        'after'            => '</nav>',
                        'link_before'      => '<span class="pagenum">',
                        'link_after'       => '</span>',
                        'next_or_number'   => 'number',
                        'separator'        => ' ',
                        'nextpagelink'     => esc_attr__( 'Next page', 'opstore' ),
                        'previouspagelink' => esc_attr__( 'Previous page', 'opstore' ),
                        'pagelink'         => '%',
                        'echo'             => 1

                    );
                    wp_link_pages( $defaults );
                    ?>
                </div>
                <div class="mb-50">
                    <div class="bottom">
                        <div class="tag-links pull-left">
                            <?php 
                            $post_tags = get_the_tags();
                            if( $post_tags ):
                                foreach( $post_tags as $tags ):
                                    $term_id = $tags->term_id;
                                    $name = $tags->name;
                                    ?>
                                    <a href="<?php echo esc_url( get_tag_link( $term_id ) ); ?>"><?php echo esc_html( $name ); ?></a>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                        <!--tag links-->
                        <?php 
                        if(class_exists('Ultra_Companion')):
                            echo '<div class="pull-right">';
                            ultra_companion_social_share('Share: '); 
                            echo '</div>';
                        endif;
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="btn-wrap">
                    <?php 
                     opstore_single_post_pagination();
                    ?>
                </div>
            </div>

        <?php endwhile; ?>

        <?php
        //Related Posts
        do_action('opstore_related_post');
        ?>
        <?php if( comments_open() || get_comments_number() ): ?>

            <div class="comment-area p-pb">
                <?php 
                    comments_template();
                 ?>
          </div>
        <?php endif; ?>
    </div>
    <?php 
    if( $sidebarPosition!='nosidebar' ):
        ?>
        <aside class="sidebar col-sm-3 col-xs-12 col-md-4">
            <?php get_sidebar(); ?>
        </aside>
        <?php
    endif;
    ?>
</div>

