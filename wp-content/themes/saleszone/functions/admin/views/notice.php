<div class="notice saleszone-notice" data-get-started-notice>

    <p>
        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/public/img/theme-logo.png'); ?>"
             alt="<?php echo esc_attr($themeTextDomain); ?>">
    </p>

    <h1>
        <?php
        /* translators: %1$s: theme name, %2$s theme version */
        printf( esc_html__( 'Welcome to %1$s - Version %2$s', 'saleszone' ), esc_html( $themeName ), esc_html( $themeVersion ) );
        ?>
    </h1>

    <p>
        <?php
        /* translators: %1$s: theme name, %2$s link */
        printf(
                wp_kses_post(__( 'Great to see you around! Thank you for choosing %1$s! To take advantage of the best our theme can offer, please make sure you have visited our <a href="%2$s">Welcome page</a>.', 'saleszone' )),
                    esc_html( $themeName ),
                    esc_url( admin_url( 'themes.php?page=saleszone' ))
              );
        printf( '<a href="%1$s" class="notice-dismiss dashicons dashicons-dismiss dashicons-dismiss-icon" data-get-started-notice--ignore></a>', esc_url(add_query_arg(array('action' => 'saleszone_notice_ignore'), site_url('wp-admin/admin-ajax.php'))));
        ?>
    </p>
    <p>
        <a href="<?php echo esc_url( admin_url( 'themes.php?page=saleszone' ) ) ?>" class="button button-primary button-hero" style="text-decoration: none;">
            <?php
            /* translators: %s theme name */
            printf( esc_html__( 'Get started with %s', 'saleszone' ), esc_html( $themeName ) )
            ?>
        </a>
    </p>
</div>