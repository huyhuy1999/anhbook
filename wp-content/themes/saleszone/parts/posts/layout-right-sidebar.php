<div class="content__header">
    <h1 class="content__title">
        <?php

        if (is_home()) {
            echo get_the_title(get_option('page_for_posts', true));
        }

        if (is_search()) {
            if (have_posts()) {
                /* translators: %s: search query*/
                printf(esc_html__('Search Results for: %s', 'saleszone'), '<q>' . get_search_query() . '</q>');
            } else {
                esc_html_e('No results found', 'saleszone');
            }
        }

        if (is_category()) {
            echo single_cat_title();
        }

        if (is_single()) {
            the_title();
        }

        ?>
    </h1>
</div>
<div class="content__row">
    <?php if (is_active_sidebar('blog_sidebar')) : ?>
        <div class="row row--ib row--vindent-m">
            <div class="col-sm-3 col-sm-push-9 col-xs-12">
                <div class="content__sidebar content__sidebar--right">
                    <?php
                    /**
                     * @hooked saleszone_dynamic_blog_sidebar - 10
                     */
                    do_action('premmerce_blog_sidebar');
                    ?>
                </div>
            </div>
            <div class="col-sm-9 col-sm-pull-3 col-xs-12">
                <?php if (is_single()) : ?>
                    <?php get_template_part('parts/posts/single'); ?>
                <?php else: ?>
                    <?php get_template_part('parts/posts/archive'); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <?php if (is_single()) : ?>
            <?php get_template_part('parts/posts/single'); ?>
        <?php else: ?>
            <?php get_template_part('parts/posts/archive'); ?>
        <?php endif; ?>
    <?php endif; ?>
</div>