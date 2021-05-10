<?php get_header(); ?>
<div class="content">
    <div class="content__container">

        <div class="error-page">
            <div class="error-page__cell error-page__cell--img">
                <img src="<?php echo esc_url(get_template_directory_uri() . "/public/img/404.png"); ?>"
                     alt="<?php esc_attr_e('Page not found!', 'saleszone'); ?>"
                     class="error-page__img">
            </div>
            <div class="error-page__cell error-page__cell--info">
                <h1 class="error-page__title">
                    <?php esc_html_e('Page not found!', 'saleszone'); ?>
                </h1>
                <p class="error-page__desc">
                    <?php esc_html_e('Sorry, the page you\'re looking for doesn\'t exist!', 'saleszone'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/')) ?>"
                   class="error-page__button">
                    <?php esc_html_e('Home', 'saleszone'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>