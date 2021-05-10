<div class="pc-section-secondary__inner">
    <div class="small-post">
        <div class="small-post__list">
            <?php if ( $query->have_posts() ) : ?>
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <div class="small-post__item">
                        <div class="small-post__item-inner">
                            <?php if( $showImage && has_post_thumbnail() ) :?>
                                <a class="small-post__image" href="<?php the_permalink(); ?>">
                                    <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="<?php the_title(); ?>">
                                </a>
                            <?php endif; ?>

                            <div class="small-post__inner">
                                <?php if($showDate) :?>
                                    <time class="small-post__date" datetime="<?php the_time('Y-m-d '); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                <?php endif; ?>
                                <div class="small-post__title">
                                    <a href="<?php the_permalink(); ?>" class="small-post__title-link">
                                        <?php the_title(); ?>
                                    </a>
                                </div>
                                <div class="small-post__desc typo typo--sub-color">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>

        </div>
    </div>
</div>