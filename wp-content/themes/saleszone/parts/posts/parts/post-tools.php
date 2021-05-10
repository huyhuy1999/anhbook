<div class="post-tools">
    <div class="post-tools__item">
        <div class="post-tools__ico">
            <?php saleszone_the_svg('user'); ?>
        </div>
        <div class="post-tools__value"><?php the_author(); ?></div>
    </div>
    <div class="post-tools__item">
        <div class="post-tools__ico">
            <?php saleszone_the_svg('calendar'); ?>
        </div>
        <time class="post-tools__value" datetime="<?php the_time('Y-m-d') ?>"><?php the_time(get_option( 'date_format' )); ?></time>
    </div>
    <div class="post-tools__item">
        <div class="post-tools__ico">
            <?php saleszone_the_svg('comment'); ?>
        </div>
        <div class="post-tools__value">
            <a class="post-tools__link" href="<?php echo esc_url(get_permalink()); ?>#post-comments">
                <?php comments_number(); ?>
            </a>
        </div>
    </div>
    <?php $categories_list = get_the_category_list(', '); ?>
    <div class="post-tools__item">
        <span class="post-tools__key">
            <?php esc_html_e('Posted in:','saleszone'); ?>
        </span>
        <div class="post-tools__value">
            <?php echo wp_kses($categories_list, array('a' => array('class' => true, 'href' => true))); ?>
        </div>
    </div>
</div>