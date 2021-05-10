<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));
?>
<li class="comments-posts__group" id="comment-<?php comment_ID() ?>" data-comments-post="<?php comment_ID() ?>">
    <div class="comments-posts__item">
        <div class="comments-posts__content">
            <?php echo get_avatar($comment, 60, '', get_comment_author(), array('class' => 'comments-posts__avatar')); ?>
            <div class="comments-posts__main">
                <div class="comments-posts__header">
                    <div class="comments-posts__author"><?php comment_author(); ?></div>
                    <time class="comments-posts__date" datetime="<?php comment_date('c'); ?>">
                        <?php if(saleszone_is_woocommerce_activated()){
                            comment_date(get_option(wc_date_format()));
                        } else {
                            comment_date(get_option( 'date_format' ));
                        } ?>
                    </time>
                    <div class="comments-posts__rate">
                        <?php if ($rating && get_option('woocommerce_enable_review_rating') === 'yes' && $depth == 1): ?>
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="star-rating__star <?php if ($i <= $rating): ?>star-rating__star--active<?php endif; ?>"
                                       title="<?php
                                       /* translators: %s: start count  */
                                       printf(esc_html__('%s out of 5 stars', 'saleszone'), esc_html($rating)); ?>">
                                        <?php saleszone_the_svg('star'); ?>
                                    </i>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="comments-posts__text"><?php comment_text(); ?></div>
            </div>
        </div>
        <?php if ($comment->comment_approved === '0'): ?>
            <div class="comments-posts__message">
                <div class="message message--info">
                    <?php esc_attr_e('Your review is awaiting approval', 'saleszone'); ?>
                </div>
            </div>
        <?php else: ?>

            <?php if ($depth < $args['max_depth']): ?>
                <div class="comments-posts__footer">
                    <button class="comments-posts__reply"
                            data-comments-reply-parent-id="<?php echo esc_attr(get_comment_ID()); ?>"
                            data-comments-reply-link="<?php echo esc_url(add_query_arg(array(
                                    'action' => 'saleszone_comment_reply_form',
                                    'post_id' => get_the_ID()
                                ), site_url('wp-admin/admin-ajax.php'))); ?>"
                    >
                        <?php esc_html_e('Reply to this post', 'saleszone'); ?>
                    </button>

                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="hidden" data-comments-reply-form-placeholder></div>
    </div>