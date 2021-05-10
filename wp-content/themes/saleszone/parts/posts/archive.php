<?php if ( have_posts() ): ?>
    <div class="content__row">
        <div class="post-list">
            <?php while ( have_posts() ): the_post() ?>
                <div class="post-list__item">

                    <article <?php post_class('post'); ?> >
                        <?php if( has_post_thumbnail() ): ?>
                            <a class="post__image" href="<?php the_permalink() ?>">
                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php echo esc_attr(saleszone_get_img_alt(get_post_thumbnail_id(), get_the_title())); ?>">
                            </a>
                        <?php endif ?>
                        <div class="post__inner">
                            <?php the_title(sprintf('<h2 class="post__title"><a class="post__title-link" href="%s">', esc_url(get_permalink())), '</a></h2>') ?>
                            <div class="post__desc">
                                <div class="typo">
                                    <?php echo wp_kses_post(saleszone_excerpt()); ?>
                                </div>
                            </div>
                            <div class="post__footer">
                                <?php get_template_part('parts/posts/parts/post','tools'); ?>
                            </div>
                        </div>
                    </article>


                </div>
            <?php endwhile ?>
        </div>
    </div>
    <div class="content__pagination">
        <?php saleszone_post_pagination(); ?>
    </div>

<?php else: ?>
    <?php get_template_part('parts/posts/content', 'none'); ?>
<?php endif ?>