<?php

if ( ! defined( 'WPINC' ) ) {
    die;
}

?>

<div class="modal modal--sm" >

    <?php wc_get_template('../parts/modal/modal-header.php', array(
        'title' => __('Notify when available','saleszone')
    )) ?>

    <form class="form" action="#" data-premmerce-product-wait-form>

        <?php if($subscriptionHash): ?>
            <div class="modal__content">
                <div class="typo">
                    <p>
                        <?php echo esc_html($subscribedMessage); ?>
                    </p>
                </div>
            </div>
            <div class="modal__footer">
                <div class="modal__footer-row">
                    <?php if($subscriptionsPageURL) :?>
                        <div class="modal__footer-btn">
                            <a class="btn btn-primary"
                               href="<?php echo esc_url($subscriptionsPageURL); ?>">
                                <?php esc_html_e( 'View the list of subscriptions', 'saleszone' ); ?>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="modal__footer-btn">
                            <a class="btn btn-primary"
                               aria-label="Remove this item"
                               data-product-wait-notlogined-subscription-remove >
                                <?php esc_html_e( 'Remove subscription', 'saleszone' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="modal__content" data-product-wait-popup-content>
                <div class="form__field">
                    <div class="typo">
                        <p>
                            <?php esc_html_e("You'll receive a one email when this product arrives in stock", 'saleszone'); ?>
                        </p>
                    </div>
                </div>

                <?php do_action( 'saleszone_product_wait_before_form_inputs' ); ?>

                <input type="hidden"
                       class="premmerce-product-wait__action"
                       name="wc-ajax"
                       value="premmerceProductWaitSubscribe">

                <?php
                if ( ! $isLoggedIn ){
                    woocommerce_form_field('premmerceProductWaitEmail', array(
                        'type' => 'email',
                        'class' => array('form__field'),
                        'label_class' => array('form__label'),
                        'input_class'=> array('form-control'),
                        'name' => 'premmerceProductWaitEmail',
                        'autocomplete' => 'email',
                        'label' => __( 'Email', 'saleszone' ),
                        'required' => true,
                    ));
                }
                ?>

                <?php do_action( 'saleszone_product-wait_after_form_inputs' ); ?>
            </div>

            <div class="modal__footer">
                <div class="modal__footer-row">
                    <div class="modal__footer-btn hidden-xs">
                        <button class="btn btn-default" type="reset" data-oneclick-order--btn-close>
                            <?php esc_html_e('Close', 'saleszone'); ?>
                        </button>
                    </div>

                    <div class="modal__footer-btn">
                        <button type="submit"
                                class="btn btn-primary">
                            <?php esc_html_e( 'Notify me', 'saleszone' ); ?>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['productId'])): ?>
            <input name="premmerceProductWaitProductId"
                   type="hidden"
                   value="<?php echo esc_attr($_GET['productId']); ?>">
        <?php endif; ?>

    </form>
</div>