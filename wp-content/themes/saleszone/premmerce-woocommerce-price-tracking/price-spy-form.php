<?php

if ( ! defined( 'WPINC' ) ) die;

?>

<!-- Price spy button -->
<div class="pc-product-action <?php echo $product->get_type() == 'variable' ? 'hidden':'';?>" data-open-popup-spy-link>
    <div class="pc-product-action__ico pc-product-action__ico--profi-chart">
        <?php saleszone_the_svg('price-spy'); ?>
    </div>

    <?php if( $is_spy ): ?>

        <?php if( $is_logged_in ): ?>
            <a class="pc-product-action__link"  href="<?php echo esc_url(get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . 'price-spy'); ?>" >
                <?php esc_html_e('Price is tracked', 'saleszone' ) ?>
            </a>
        <?php else: ?>
            <button class="pc-product-action__link"
               data-price-spy-product-remove
               aria-label="Remove this item"
               data-product_id="<?php echo esc_attr($product->get_id()); ?>" >
                <?php esc_html_e('Price is tracked', 'saleszone' ) ?> x
            </button>
        <?php endif; ?>

    <?php else:?>
        <a class="pc-product-action__link" href="#spy-form" data-open-popup-spy-form>
            <?php esc_html_e('Track price', 'saleszone' ); ?>
        </a>
    <?php endif; ?>

</div>

<!-- Price spy modal -->
<div id="spy-form" class="mfp-hide modal modal--sm">

    <?php wc_get_template('../parts/modal/modal-header.php', array(
        'title' => apply_filters( 'saleszone_price_spy_form_title', __('Track price','saleszone') )
    )); ?>

    <form class="form" action="#" data-price-spy-form>
        <div class="modal__content">
            <?php do_action('premmerce_price_spy_before_form_inputs'); ?>

            <div class="form__field">
                <div class="typo">
                    <?php esc_html_e('Follow the price and we will send you an email once the product price changes', 'saleszone'); ?>
                </div>
            </div>

            <?php

                if( ! $is_logged_in ){
                    woocommerce_form_field('email', array(
                            'type' => 'email',
                            'class' => array('form__field'),
                            'label_class' => array('form__label'),
                            'input_class'=> array('form-control'),
                            'name' => 'email',
                            'autocomplete' => 'email',
                            'placeholder' => 'Email',
                            'label' => __( 'Email', 'saleszone' ),
                            'required' => true,
                            'custom_attributes' => array('required' => 'required')
                        ));
                }
            ?>

            <?php do_action('premmerce_price_spy_after_form_inputs'); ?>
        </div>
        <div class="modal__footer">
            <div class="modal__footer-row">
                <div class="modal__footer-btn hidden-xs">
                    <button class="btn btn-default" type="reset"
                            data-modal-close>
                        <?php esc_html_e('Close','saleszone'); ?>
                    </button>
                </div>
                <div class="modal__footer-btn">
                    <input type="hidden" name="product_id" value="<?php echo esc_attr($product->get_id()); ?>">
                    <button class="btn btn-primary" type="submit" >
                        <?php esc_html_e( 'Track price', 'saleszone' ); ?>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>