<?php

$nsl_fb = unserialize(get_option('nsl_facebook'));
$nsl_google = unserialize(get_option('nsl_google'));
$nsl_twitter = unserialize(get_option('nsl_twitter'));

?>

<div class="nsl-socauth">

    <div class="nsl-socauth__title">
        <?php esc_html_e('Sign in with', 'saleszone'); ?>
    </div>

    <div class="nsl-socauth__list">

        <?php if($nsl_fb && $nsl_fb['tested']) :?>
            <a class="nsl-socauth__link nsl-socauth__link--facebook"
               data-socauth-popup
               title="<?php esc_attr_e('Login with Facebook','saleszone'); ?>"
               href="<?php echo esc_url(add_query_arg(array('loginSocial' => 'facebook','redirect' => urlencode(get_page_link())), site_url('wp-login.php'))); ?>">
                <?php saleszone_the_svg('facebook') ?>
            </a>
        <?php endif; ?>

        <?php if($nsl_google && $nsl_google['tested']) :?>
            <a class="nsl-socauth__link nsl-socauth__link--google"
               data-socauth-popup
               title="<?php esc_attr_e('Login with Google','saleszone'); ?>"
               href="<?php echo esc_url(add_query_arg(array('loginSocial' => 'google','redirect' => urlencode(get_page_link())), site_url('wp-login.php'))); ?>">
                <?php saleszone_the_svg('google-plus') ?>
            </a>
        <?php endif; ?>

        <?php if($nsl_twitter && $nsl_twitter['tested']) :?>
            <a class="nsl-socauth__link nsl-socauth__link--twitter"
               data-socauth-popup
               title="<?php esc_attr_e('Login with Google','saleszone'); ?>"
               href="<?php echo esc_url(add_query_arg(array('loginSocial' => 'twitter','redirect' => urlencode(get_page_link())), site_url('wp-login.php'))); ?>">
                <?php saleszone_the_svg('twitter') ?>
            </a>
        <?php endif; ?>

    </div>

</div>
