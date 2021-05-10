<?php

if (post_password_required()) {
    return;
}

?>
<?php if(comments_open()) :?>
    <div class="content__row">
        <div class="frame" id="post-comments">
            <div class="frame__header">
                <div class="frame__title">
                    <?php esc_html_e('Comments', 'saleszone'); ?>
                </div>
            </div>
            <div class="frame__inner">

                <div class="comments" data-comments>
                    <?php if (have_comments()) : ?>
                        <div class="comments__list">

                            <!-- List of user comments -->
                            <ul class="comments-posts">
                                <?php wp_list_comments(array(
                                    'callback'   => 'saleszone_comments'
                                )); ?>
                            </ul>

                        </div>

                        <!-- Pagination -->
                        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
                            <?php
                            $args = saleszone_get_comments_pagination_args();
                            $pagination = paginate_comments_links($args);
                            ?>
                            <ul class="comments__pagination pagination">
                                <?php foreach ($pagination as $item): ?>
                                    <li class="pagination__item"><?php echo wp_kses_post($item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="comments__list typo">
                            <?php esc_html_e('There are no comments yet.', 'saleszone'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php get_template_part('parts/comments/comments','form'); ?>

                <?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
                    <div class="message message--info">
                        <div class="typo">
                            <?php esc_html_e( 'Comments are closed.', 'saleszone' ); ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php endif; ?>