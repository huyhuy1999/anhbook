<div class="frame">
    <div class="frame__header">
        <h2 class="frame__title">
            <?php esc_html_e('Register','saleszone'); ?>
        </h2>
    </div>
    <div class="frame__inner">
        <form method="post" class="form form--bg register">

            <div class="form__field form__notices"><?php wc_print_notices(); ?></div>

            <?php do_action( 'woocommerce_register_form_start' ); ?>

            <!-- Username field -->
            <?php if (get_option( 'woocommerce_registration_generate_username' ) === 'no' ) : ?>
                <?php woocommerce_form_field('username',array(
                    'type' => 'text',
                    'class' => array('form__field'),
                    'label_class' => array('form__label'),
                    'input_class'=> array('form-control'),
                    'name' => 'username',
                    'autocomplete' => 'username',
                    'label' => __( 'Username', 'saleszone' ),
                    'required' => true,
                    'custom_attributes' => array('required' => 'required')
                )); ?>
            <?php endif; ?>

            <!-- Email field -->
            <?php woocommerce_form_field('email',array(
                'type' => 'email',
                'class' => array('form__field'),
                'label_class' => array('form__label'),
                'input_class'=> array('form-control'),
                'name' => 'email',
                'autocomplete' => 'email',
                'label' => __( 'Email address', 'saleszone' ),
                'required' => true,
                'custom_attributes' => array('required' => 'required')
            ), ! empty( $_POST['email'] ) ? esc_attr(sanitize_text_field(wp_unslash($_POST['email']))) : ''); ?>

            <!-- Password field -->
            <?php if ( get_option( 'woocommerce_registration_generate_password' ) === 'no' ) : ?>
                <?php woocommerce_form_field('password',array(
                    'type' => 'password',
                    'class' => array('form__field'),
                    'label_class' => array('form__label'),
                    'input_class'=> array('form-control'),
                    'name' => 'password',
                    'autocomplete' => 'email',
                    'label' => __( 'Password', 'saleszone' ),
                    'required' => true,
                    'custom_attributes' => array('required' => 'required')
                ), ! empty( $_POST['email'] ) ? esc_attr(sanitize_text_field(wp_unslash($_POST['email']))) : ''); ?>
            <?php else : ?>

                <p><?php esc_html_e( 'A password will be sent to your email address.', 'saleszone' ); ?></p>

            <?php endif; ?>

            <?php do_action( 'woocommerce_register_form' ); ?>

            <!-- Submit button -->
            <div class="form__field">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <input type="hidden" name="register" value="<?php esc_attr_e('Register','saleszone'); ?>" />
                <button class="btn btn-primary" type="submit">
                    <?php esc_html_e('Register','saleszone'); ?>
                </button>
            </div>

            <?php do_action( 'woocommerce_register_form_end' ); ?>

        </form>
    </div>
</div>