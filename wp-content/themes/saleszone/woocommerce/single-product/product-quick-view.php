<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$notices = wc_get_notices() ? wc_get_notices() : false;

$variation = saleszone_get_variation($product);
?>

<div class="modal modal--quick-view <?php if ($notices['error'] && !$notices['success']): ?>modal--sm<?php else: ?>modal--lg<?php endif; ?>">
	<?php if (has_action('premmerce_single_product_summary_popup_title')): ?>

        <?php wc_get_template('../parts/modal/modal-header.php', array(
                'title' => wc_get_template_html( 'single-product/title.php' )
        )); ?>

	<?php endif; ?>

    <div class="modal__content">

        <?php if ($notices): ?>
            <div class="modal__content-cell">
                <?php wc_print_notices(); ?>
            </div>
        <?php endif; ?>

        <div class="pc-product-quick-view">
            <?php if (has_action('woocommerce_before_single_product')): ?>
                <div class="pc-product-quick-view__before">
                    <?php
                    /**
                     * woocommerce_before_single_product hook.
                     *
                     * @hooked wc_print_notices - 10
                     */
                    do_action('woocommerce_before_single_product');
                    ?>
                </div>
            <?php endif; ?>
            <?php
            if (post_password_required()) {
                echo wp_kses_post(get_the_password_form());
                return;
            }
            ?>

            <div id="product-<?php the_ID(); ?>" <?php wc_product_class('pc-product-quick-view__body', $product); ?>
                 data-product="<?php echo esc_attr($product->get_ID()); ?>"
                 data-product-variation="<?php echo esc_attr($variation->get_ID()); ?>"
            >
                <div class="pc-product-quick-view__main">
                    <div class="pc-product-quick-view__summary-wrapper">

                        <?php if (has_action('woocommerce_before_single_product_summary')): ?>
                            <div class="pc-product-quick-view__before-summary">
                                <?php
                                /**
                                 * @hooked saleszone_render_product_labels - 15
                                 * @hooked woocommerce_show_product_images - 20
                                 */
                                do_action('woocommerce_before_single_product_summary', array(
                                    'variation' => $variation
                                ));
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="pc-product-quick-view__summary">

                            <div class="pc-product-summary summary entry-summary">
                                <?php if (has_action('premmerce_single_product_summary_popup_meta')): ?>
                                    <div class="pc-product-summary__header">
                                        <?php
                                        /**
                                         * @hooked woocommerce_template_single_meta - 10
                                         */
                                        do_action('premmerce_single_product_summary_popup_meta');
                                        ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (has_action('woocommerce_single_product_summary')): ?>
                                    <div class="pc-product-summary__body">
                                        <?php
                                        /**
                                         * @removed woocommerce_template_single_rating - 10
                                         * @removed woocommerce_template_single_price - 10
                                         *
                                         * @hooked woocommerce_template_single_add_to_cart - 30
                                         * @hooked WC_Structured_Data::generate_product_data() - 60
                                         */
                                        do_action('woocommerce_single_product_summary');
                                        ?>
                                    </div>
                                <?php endif; ?>
	                            <?php if (has_action('premmerce_single_product_summary_popup_footer')): ?>
                                    <div class="pc-product-summary__footer">
			                            <?php
			                            /**
			                             * @hooked woocommerce_template_single_excerpt - 10
			                             * @hooked saleszone_template_single_more_link - 15
			                             * @hooked woocommerce_template_single_sharing - 20
			                             *
			                             */
			                            do_action('premmerce_single_product_summary_popup_footer');
			                            ?>
                                    </div>
	                            <?php endif; ?>
                            </div><!-- /.pc-product-summary -->

                        </div><!-- /.pc-product-quick-view__summary -->
                    </div><!-- /.pc-product-quick-view__summary-wrapper -->
                </div><!-- /.pc-product-quick-view__main -->

            </div><!-- /.row -->
        </div>
    </div>
</div>