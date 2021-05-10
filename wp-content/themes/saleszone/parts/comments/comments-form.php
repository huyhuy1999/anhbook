<?php

$form_title = __('Write a comment', 'saleszone');
$comment_args = saleszone_get_comments_form_args();

?>
<div class="comments-anchor"></div>
<div class="comments__form">
    <div class="comments__form-header">
        <?php echo esc_html($form_title); ?>
    </div>
    <div class="comments__form-body">
        <?php comment_form($comment_args); ?>
        <div class="hidden" data-reply-form></div>
    </div>
</div>