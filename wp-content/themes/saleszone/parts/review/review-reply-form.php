<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="comments-posts__reply-form" data-comments-reply-form>
    <?php

    if(isset($_REQUEST['post_id'])){
        $post_id = intval($_REQUEST['post_id']);
    }

    $reply_form_args = saleszone_get_comments_form_reply_args();

    comment_form(apply_filters('woocommerce_product_review_comment_form_args', $reply_form_args), $post_id);
    ?>
</div>