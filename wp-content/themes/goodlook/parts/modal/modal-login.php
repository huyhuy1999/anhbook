<div class="modal modal--sm">
    <?php wc_get_template('../parts/modal/modal-header.php', array(
        'title' => esc_html__('Login', 'goodlook')
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
                        'label' => __('Username or email address', 'goodlook'),
                        'name' => 'username',
                        'value' => !empty($_POST['username']) ? esc_attr($_POST['username']) : '',
                        'required' => true,
                        'modifier' => 'form__field--flex'
                    )); ?>

                    <!-- Password field -->
                    <?php wc_get_template('../parts/forms/input-base.php', array(
                        'type' => 'password',
                        'label' => __('Password', 'goodlook'),
                        'name' => 'password',
                        'value' => !empty($_POST['username']) ? esc_attr($_POST['username']) : '',
                        'required' => true,
                        'modifier' => 'form__field--flex'
                    )); ?>

                    <?php do_action('woocommerce_login_form'); ?>
                </div>
                <div class="form__field hidden typo" data-profile-ajax-form--success-message>
                    <h2><?php esc_html_e('Welcome!', 'goodlook') ?></h2>
                    <p>
                        <?php esc_html_e('You have successfully logged in as', 'goodlook') ?>
                        <span data-profile-ajax-form--user-name></span>
                    </p>
                </div>
              <div class="form__field form__field--flex">
                <div class="form__label"></div>
                <div class="form__inner">
                  <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme"
                           type="checkbox" id="rememberme" value="forever"/>
                    <span>
                            <?php esc_html_e('Remember me', 'goodlook'); ?>
                        </span>
                  </label>
                </div>
              </div>
              <div class="form__field form__field--flex">
                <div class="form__label"></div>
                <div class="form__inner">
                  <div class="modal__row modal__row--flex">
                    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                    <input type="hidden" class="btn btn-primary" name="login"
                           value="<?php esc_attr_e('Login', 'goodlook'); ?>"/>
                    <button class="btn btn-primary" type="submit" data-profile-button>
                      <span><?php esc_html_e('Login', 'goodlook'); ?></span>
                      <i class="button--loader hidden" data-button-loader="loader">
                        <?php saleszone_the_svg('refresh'); ?>
                      </i>
                    </button>
                    <a class="form__link" href="<?php echo esc_url(wp_lostpassword_url()); ?>">
                      <?php esc_html_e('Lost your password?', 'goodlook'); ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal__footer modal__footer--login">
                <div class="modal__footer-row typo">
                  <div class="modal__footer-cell"></div>
                  <div class="modal__footer-cell">
                    <?php esc_html_e('Don\'t Have an Account?', 'goodlook'); ?>
                    <br>
                    <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>
                      <a class="btn modal__btn modal__btn--empty" href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">
                        <?php esc_html_e('Register', 'goodlook'); ?>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="modal__content typo">
            <p>
                <?php $current_user = wp_get_current_user();
                esc_html_e('You have successfully logged in as' , 'goodlook'); ?>
                <?php esc_html($current_user->display_name); ?>
            </p>
        </div>
    <?php endif; ?>
</div>