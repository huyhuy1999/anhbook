<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$form_title = __('Write a review', 'saleszone');
$comment_args = saleszone_get_comments_form_args();

if ($account_page_url = wc_get_page_permalink('myaccount')) {
        /* translators: %s: url*/
    $comment_args['must_log_in'] = '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a review.', 'saleszone'), esc_url($account_page_url)) . '</p>';
}

if (get_option('woocommerce_enable_review_rating') === 'yes' && is_product()) {
    $comment_args['comment_field'] .= '<div class="form__field form__field--hor form__field--static"><div class="form__label">' . esc_html__('Your rating', 'saleszone') . '</div><div class="form__inner"><div class="star-voting"><div class="star-voting__wrap">';

    for ($i = 5; $i > 0; $i--) {
        $comment_args['comment_field'] .= '<input class="star-voting__input" id="star-voting-' . $i . '" type="radio" name="rating" value="' . $i . '">';
        $comment_args['comment_field'] .= '<label class="star-voting__ico" for="star-voting-' . $i . '" title="' . $i . ' ' . __('out of 5 stars', 'saleszone') . '">' . saleszone_get_svg('star') . '</label>';
    }

    $comment_args['comment_field'] .= '</div></div></div></div>';
}

?>
<div id="comments-anchor"></div>
<div class="comments__form">
    <div class="comments__form-header">
        <?php echo esc_html($form_title); ?>
    </div>
    <div class="comments__form-body">
        <?php comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_args)); ?>
        <div class="hidden" data-reply-form></div>
    </div>
</div>