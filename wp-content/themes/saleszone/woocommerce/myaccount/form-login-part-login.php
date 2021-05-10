<div class="frame">
    <div class="frame__header">
        <h2 class="frame__title">
            <?php esc_html_e('Login','saleszone'); ?>
        </h2>
    </div>
    <div class="frame__inner">

        <form class="form form--bg woocommerce-form woocommerce-form-login login" method="post">

            <div class="form__field form__notices" data-profile-ajax-form--notices data-ajax-grab="login_notices" data-ajax-inject="login_notices"><?php wc_print_notices(); ?></div>

            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <!-- Username field -->
            <?php woocommerce_form_field('username',array(
                'type' => 'text',
                'class' => array('form__field'),
                'label_class' => array('form__label'),
                'input_class'=> array('form-control'),
                'name' => 'username',
                'autocomplete' => 'username',
                'label' => __( 'Username or email address', 'saleszone' ),
                'required' => true,
                'custom_attributes' => array('required' => 'required')
            ), ! empty( $_POST['username'] ) ? esc_attr(sanitize_text_field(wp_unslash($_POST['username']))) : '' ); ?>

            <!-- Password field -->
            <?php woocommerce_form_field('password',array(
                'type' => 'password',
                'class' => array('form__field'),
                'label_class' => array('form__label'),
                'input_class'=> array('form-control'),
                'name' => 'password',
                'autocomplete' => 'password',
                'label' => __( 'Password', 'saleszone' ),
                'required' => true,
                'custom_attributes' => array('required' => 'required')
            )); ?>

            <?php do_action( 'woocommerce_login_form' ); ?>

            <!-- Submit button -->
            <div class="form__field">
                <div class="form__field-btn">
                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                    <input type="hidden" class="btn btn-primary btn-block" name="login" value="<?php esc_attr_e('Login','saleszone'); ?>" />
                    <button class="btn btn-primary" type="submit">
                        <?php esc_html_e('Login','saleszone'); ?>
                    </button>
                </div>
                <div class="form__field-btn">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                        <span>
                    <?php esc_html_e( 'Remember me', 'saleszone' ); ?>
                </span>
                    </label>
                </div>
            </div>

            <div class="form__field">
                <a class="form__link" href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
                    <?php esc_html_e( 'Lost your password?', 'saleszone' ); ?>
                </a>
            </div>

            <?php do_action( 'woocommerce_login_form_end' ); ?>

        </form>

    </div>
</div>