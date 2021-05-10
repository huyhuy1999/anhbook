<div id="found-less-expensive-block" class="modal modal--sm">

    <?php wc_get_template('../parts/modal/modal-header.php', array(
        'title' => __('Found cheaper?','saleszone')
    )) ?>

    <form action="#" data-found-less-expensive-form id="data-found-less-expensive-form">
        <div class="modal__content typo" data-found-less-content-responce style="display: none"></div>
        <div class="modal__content" data-found-less-form-content>

            <?php do_action('premmerce-found-less-expensive_before_form_inputs'); ?>

            <?php

                if(!is_user_logged_in()){
                    // Name
                    woocommerce_form_field('name',array(
                        'type' => 'text',
                        'class' => array('form__field'),
                        'label_class' => array('form__label'),
                        'input_class'=> array('form-control'),
                        'name' => 'name',
                        'autocomplete' => 'username',
                        'label' => __( 'Name', 'saleszone' ),
                        'required' => true,
                        'custom_attributes' => array('required' => 'required'),
                        'placeholder' => __('Name', 'saleszone')
                    ));

                    // Email
                    woocommerce_form_field('email',array(
                        'type' => 'email',
                        'class' => array('form__field'),
                        'label_class' => array('form__label'),
                        'input_class'=> array('form-control'),
                        'name' => 'email',
                        'autocomplete' => 'email',
                        'label' => __( 'Email', 'saleszone' ),
                        'required' => true,
                        'custom_attributes' => array('required' => 'required'),
                        'placeholder' => __('Email', 'saleszone')
                    ));
                }

                // Phone
                woocommerce_form_field('phone',array(
                    'type' => 'text',
                    'class' => array('form__field'),
                    'label_class' => array('form__label'),
                    'input_class'=> array('form-control'),
                    'name' => 'phone',
                    'label' => __( 'Phone', 'saleszone' ),
                    'required' => true,
                    'custom_attributes' => array('required' => 'required'),
                    'placeholder' => __('Phone', 'saleszone')
                ));

                // URL product
                woocommerce_form_field('link',array(
                    'type' => 'text',
                    'class' => array('form__field'),
                    'label_class' => array('form__label'),
                    'input_class'=> array('form-control'),
                    'name' => 'link',
                    'label' => __( 'URL to product', 'saleszone' ),
                    'required' => true,
                    'custom_attributes' => array('required' => 'required'),
                    'placeholder' => __('Where you found expensive?', 'saleszone')
                ));

                // Comment
                woocommerce_form_field('comment',array(
                    'type' => 'textarea',
                    'class' => array('form__field'),
                    'label_class' => array('form__label'),
                    'input_class'=> array('form-control'),
                    'name' => 'comment',
                    'label' => __( 'Comments', 'saleszone' ),
                    'custom_attributes' => array('rows' => '3'),
                ));
            ?>

            <?php do_action('premmerce-found-less-expensive_after_form_inputs'); ?>

        </div>

        <div class="modal__footer">
            <div class="modal__footer-row">

                <div class="modal__footer-btn hidden-xs">
                    <button class="btn btn-default" type="reset" data-found-less--btn-close>
                        <?php esc_html_e('Close', 'saleszone'); ?>
                    </button>
                </div>

                <div class="modal__footer-btn">
                    <?php do_action('premmerce-found-less-expensive_before_form_submit'); ?>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary" data-found-less-form-submit>
                        <?php esc_html_e( 'Send', 'saleszone' ); ?>
                    </button>

                    <input type="hidden" name="foundLessExpensive" value="found_less_expensive">

                    <?php if(isset($_GET['product_id'])): ?>
                        <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>">
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </form>
</div>