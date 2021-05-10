<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */
defined( 'ABSPATH' ) || exit;

global $product;
$variation = saleszone_get_variation($product);
?>

<div class="pc-product-single <?php echo saleszone_option('product-sidebar') ? '':'pc-product-single--no-sidebar'?>">

    <?php if (has_action('woocommerce_before_single_product')): ?>
        <div class="pc-product-single__before">
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
        echo get_the_password_form();
        return;
    }
    ?>

    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('pc-product-single__body', $product); ?>
         data-product="<?php echo esc_attr($product->get_ID()); ?>"
         data-product-variation="<?php echo esc_attr($variation->get_ID()); ?>"
    >
        <div class="pc-product-single__main">

            <?php do_action( 'woocommerce_before_main_content' ); ?>

            <div class="pc-product-single__summary-wrapper">

                <?php if (has_action('woocommerce_before_single_product_summary')): ?>
                    <div class="pc-product-single__before-summary">
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

                <div class="pc-product-single__summary">

                    <div class="pc-product-summary summary entry-summary">
                        <?php if (has_action('premmerce_single_product_summary_header')): ?>
                            <div class="pc-product-summary__header">
                                <?php
                                /**
                                 * @hooked woocommerce_template_single_title - 5
                                 * @hooked woocommerce_template_single_meta - 10
                                 */
                                do_action('premmerce_single_product_summary_header');
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
                        <?php if (has_action('premmerce_single_product_summary_footer')): ?>
                            <div class="pc-product-summary__footer">
                                <?php
                                /**
                                 * @hooked woocommerce_template_single_excerpt - 10
                                 * @hooked woocommerce_template_single_sharing - 20
                                 *
                                 */
                                do_action('premmerce_single_product_summary_footer');
                                ?>
                            </div>
                        <?php endif; ?>
                    </div><!-- /.pc-product-summary -->

                </div><!-- /.pc-product-single__summary -->
            </div><!-- /.pc-product-single__summary-wrapper -->

            <div class="pc-product-single__after-summary">
                <?php
                /**
                 * @hooked woocommerce_output_product_data_tabs - 20
                 */
                do_action('woocommerce_after_single_product_summary');
                ?>
            </div>

            <?php do_action( 'woocommerce_after_main_content' ); ?>

        </div><!-- /.pc-product-single__main -->

        <?php if(saleszone_option('product-sidebar')) :?>
            <aside class="pc-product-single__sidebar">
            <div class="content__sidebar content__sidebar--right">
                <?php
                /**
                 * @hooked saleszone_dynamic_product_sidebar - 10
                 */
                do_action('premmerce_product_sidebar');
                ?>
                <?php do_action('woocommerce_sidebar'); ?>
            </div>
        </aside><!-- /.pc-product-single__sidebar -->
        <?php endif; ?>

    </div><!-- /.row -->

</div>