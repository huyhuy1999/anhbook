<?php get_header(); ?>

<div class="content">
  <div class="content__container">

    <div class="error-page">
      <div class="error-page__row">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . "/public/img/404.png"); ?>"
             alt="<?php esc_html_e('Page not found!', 'goodlook'); ?>"
             class="error-page__img">
      </div>
      <div class="error-page__row">
        <h1 class="error-page__title">
          <?php esc_html_e('Page not found!', 'goodlook'); ?>
        </h1>
      </div>
      <div class="error-page__row">
        <p class="error-page__desc">
          <?php esc_html_e('Sorry, the page you’re looking for doesn’t exist!', 'goodlook'); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/')) ?>"
           class="error-page__button">
          <?php esc_html_e('To the homepage', 'goodlook'); ?>
        </a>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
