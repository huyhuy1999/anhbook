<div class="wrap">
    <!--
        Wp Notice wil be added after first h1 tag
    -->
    <h1 style="display: none;"></h1>

    <div class="saleszone">

        <div class="saleszone__header">

            <div class="saleszone__header-main">
                <h1 class="saleszone__title">
                    <?php 
esc_html_e( 'Welcome to', 'saleszone' );
?> <?php 
echo  esc_html( $themeName ) ;
?> - <?php 
echo  esc_html( wp_get_theme()->Version ) ;
?>
                </h1>
                <div class="saleszone__desc">
                    <?php 
echo  esc_html( $themeName ) ;
?>
                    <?php 
esc_html_e( 'is now installed and ready to be used. We hope the following information will help you. If you want to ask any question or just say hello, you can always contact us. We hope you will enjoy it!', 'saleszone' );
?>

                    <div class="saleszone__desc-buttons">

                        <?php 
$go_premium_url = admin_url( 'themes.php?page=saleszone-pricing' );
$rate_this_theme_url = apply_filters( 'premmerce_rate_theme_url', 'https://wordpress.org/themes/saleszone/' );
$demo_url = apply_filters( 'premmerce_demo_site_url', __( 'http://saleszone-free.premmerce.com/', 'saleszone' ) );
?>

                        <a class="button button-secondary" href="<?php 
esc_attr_e( 'https://premmerce.com/woocommerce-saleszone-theme-tutorial/', 'saleszone' );
?>" target="_blank">
                            <?php 
esc_html_e( 'SalesZone documentation', 'saleszone' );
?>
                        </a>

                        <a class="button button-secondary" href="<?php 
echo  esc_url( $rate_this_theme_url ) ;
?>" target="_blank" >
                            <?php 
esc_html_e( 'Rate This Theme', 'saleszone' );
?>
                        </a>

                        <a class="button button-secondary" href="<?php 
echo  esc_url( $demo_url ) ;
?>" target="_blank">
                            <?php 
esc_html_e( 'View Demo', 'saleszone' );
?>
                        </a>
                        <?php 
?>

                        <?php 
require get_template_directory() . '/functions/admin/views/upgrade-to-premium.php';
?>

                    </div>
                </div>
            </div>

            <div class="saleszone__header-aside">
                <a class="saleszone__logo" href="https://premmerce.com/">
                    <img class="saleszone__logo-img" src="<?php 
echo  esc_url( get_template_directory_uri() . '/functions/admin/assets/img/premmerce-logo.png' ) ;
?>" alt="Premmerce">
                </a>
            </div>

        </div>

        <div class="saleszone__body">

            <div class="saleszone-tab">
                <nav class="saleszone-tab__list nav-tab-wrapper">
                    <?php 
foreach ( $tabs as $tab => $name ) {
    ?>
                        <?php 
    $class = ( $tab == $currentTab ? 'nav-tab-active' : '' );
    ?>
                        <a class='saleszone-tab__link nav-tab <?php 
    echo  esc_attr( $class ) ;
    ?>'
                           href='<?php 
    echo  esc_url( add_query_arg( 'tab', $tab, $pageUrl ) ) ;
    ?>'>
                            <?php 
    echo  esc_html( $name ) ;
    ?>
                        </a>
                    <?php 
}
?>
                </nav>
            </div>



            <?php 
$file = get_template_directory() . "/functions/admin/views/tab-{$currentTab}.php";
?>
            <?php 

if ( file_exists( $file ) ) {
    ?>
                <?php 
    include $file;
    ?>
            <?php 
}

?>

        </div>

    </div>
</div>
