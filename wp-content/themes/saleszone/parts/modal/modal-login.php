<div class="modal modal--sm">
    <?php wc_get_template('../parts/modal/modal-header.php', array(
        'title' => __('Login', 'saleszone')
    )) ?>
    <?php if (!is_user_logged_in()) : ?>
        <form class="form woocommerce-form woocommerce-form-login login"
              action="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" method="post"
              data-profile-ajax="login_form">
            <div class="modal__content">
                <div class="form__field form__notices" data-profile-ajax-form--notices data-ajax-grab="login_notices"
                     data-ajax-inject="login_notices"><?php wc_print_notices(); ?></div>

                <?php if(saleszone_is_plugin_active('nextend-facebook-connect/nextend-facebook-connect.php')) :?>
                    <div class="form__field">
                        <?php wc_get_template('../parts/integrations/nsl-socauth/nsl-socauth.php'); ?>
                    </div>
                <?php endif; ?>

                <div class="form__field" data-profile-ajax-form--content>
                    <?php do_action('woocommerce_login_form_start'); ?>

                    <!-- Username field -->
                    <?php wc_get_template('../parts/forms/input-base.php', array(
                        'type' => 'text',
                        'label' => __('Username or email address', 'saleszone'),
                        'name' => 'username',
                        'value' => !empty($_POST['username']) ? esc_attr(sanitize_text_field(wp_unslash($_POST['username']))) : '',
                        'required' => true
                    )); ?>

                    <!-- Password field -->
                    <?php wc_get_template('../parts/forms/input-base.php', array(
                        'type' => 'password',
                        'label' => __('Password', 'saleszone'),
                        'name' => 'password',
                        'value' => !empty($_POST['password']) ? esc_attr(sanitize_text_field(wp_unslash($_POST['password']))) : '',
                        'required' => true
                    )); ?>

                    <?php do_action('woocommerce_login_form'); ?>
                </div>
                <div class="form__field hidden typo" data-profile-ajax-form--success-message>
                    <h2><?php esc_html_e('Welcome!', 'saleszone') ?></h2>
                    <p>
                        <?php esc_html_e('You have successfully logged in as', 'saleszone') ?>
                        <span data-profile-ajax-form--user-name></span>
                    </p>
                </div>
            </div>
            <div class="modal__footer modal__footer--login">
                <div class="modal__footer-row">
                    <div class="modal__footer-btn">
                        <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                        <input type="hidden" class="btn btn-primary btn-block" name="login"
                               value="<?php esc_html_e('Login', 'saleszone'); ?>"/>
                        <button class="btn btn-primary btn-block" type="submit" data-profile-button>
                            <span><?php esc_html_e('Login', 'saleszone'); ?></span>
                            <i class="button--loader hidden" data-button-loader="loader">
                                <?php saleszone_the_svg('refresh'); ?>
                            </i>
                        </button>
                    </div>
                    <div class="modal__footer-btn">
                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme"
                                   type="checkbox" id="rememberme" value="forever"/>
                            <span>
                            <?php esc_html_e('Remember me', 'saleszone'); ?>
                        </span>
                        </label>
                    </div>
                </div>
                <div class="modal__footer-row typo">
                    <?php esc_html_e('Don\'t Have an Account?', 'saleszone'); ?>
                    <br>
                    <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>
                        <a class="form__link" href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">
                            <?php esc_html_e('Register', 'saleszone'); ?>
                        </a>
                        /
                    <?php endif; ?>
                    <a class="form__link" href="<?php echo esc_url(wp_lostpassword_url()); ?>">
                        <?php esc_html_e('Lost your password?', 'saleszone'); ?>
                    </a>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="modal__content typo">
            <p>
                <?php esc_html_e('You have successfully logged in as', 'saleszone'); ?>

                <?php echo esc_html(wp_get_current_user()->display_name); ?>
            </p>
        </div>
    <?php endif; ?>
</div>
