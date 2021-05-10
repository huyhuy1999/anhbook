<?php get_header(); ?>

<?php if(!is_front_page()): ?>
    <div class="content">
        <div class="content__container">

            <?php if (have_posts()): the_post(); ?>
                <div class="content__header">
                    <h1 class="content__title"><?php the_title(); ?></h1>
                </div>
                <div class="content__row">
                    <div class="typo">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endif ?>

            <?php wp_reset_postdata(); ?>

            <?php if(comments_open()) :?>
                <div class="content__row">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
<?php else: ?>
    <div class="start-page typo">
        <?php if (have_posts()): the_post(); ?>
            <?php the_content(); ?>
        <?php endif; ?>
        <?php if (is_active_sidebar('homepage_widgets')) : ?>
            <div class="start-page__row-widgets">
                <div class="content__container">
                    <div class="row row--ib row--vindent-m">
                        <?php dynamic_sidebar('homepage_widgets'); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php get_footer(); ?>