<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="content__row content__row--sm">
            <div class="typo">
                <?php the_content(); ?>

                <?php wp_link_pages(array(
                    'before' => '<div class="pagination">' . __('Pages:','saleszone'),
                    'after'  => '</div>',
                )); ?>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<div class="content__row">
    <?php get_template_part('parts/posts/parts/post','tools'); ?>
</div>

<div class="content__row">
    <div class="content__row content__row--sm">
        <?php get_template_part('parts/posts/parts/post','bloginfo'); ?>
    </div>
    <div class="content__row content__row--sm">
        <?php get_template_part('parts/posts/parts/post','navigation'); ?>
    </div>
</div>

<?php comments_template(); ?>
