<?php
/**
 * Display single product reviews (comments)
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */
defined( 'ABSPATH' ) || exit;

global $product;

if (!comments_open()) {
    return;
}

?>
<div class="comments" data-comments>
    <?php if (have_comments()) : ?>
        <div class="comments__list">

            <!-- List of user comments -->
            <ul class="comments-posts">
                <?php wp_list_comments(apply_filters('woocommerce_product_review_list_args', array('callback' => 'woocommerce_comments'))); ?>
            </ul>

            <!-- Pagination -->
            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
                <?php
                    $args = saleszone_get_comments_pagination_args();
                    $pagination = paginate_comments_links(apply_filters('woocommerce_comment_pagination_args', $args));
                ?>
                <ul class="comments__pagination pagination">
                    <?php foreach ($pagination as $item): ?>
                        <li class="pagination__item">
                            <?php echo wp_kses_post($item); ?>

                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>
    <?php else: ?>
        <div class="comments__list typo">
            <?php esc_html_e('Be the first to review this item. Share your rating and review so that other customers can decide if this is the right item for them.', 'saleszone'); ?>
        </div>
    <?php endif; ?>

    <?php if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())) : ?>
        <!-- Comment form  -->
        <?php wc_get_template('../parts/review/review-form.php'); ?>
    <?php else: ?>
        <!-- Message if user must to sign in to leave a comment -->
        <div class="message message--info">
            <div class="typo">
                <?php esc_html_e('Only logged in customers who have purchased this product may leave a review.', 'saleszone'); ?>
                <?php if (!is_user_logged_in()): ?>
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"
                       data-modal="<?php echo esc_url(saleszone_get_modal_url('parts/modal/modal-login')); ?>">
                        <?php esc_html_e('Login', 'saleszone'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

</div>