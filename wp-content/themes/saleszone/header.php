<!doctype html>
<html <?php 
language_attributes();
?>>
<head>
    <meta charset="<?php 
bloginfo( 'charset' );
?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php 

if ( !is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
    ?>
        <meta name="description" content="<?php 
    bloginfo( 'description' );
    ?>">
    <?php 
}

?>
    <?php 
wp_head();
?>
</head>
<body <?php 
body_class( 'page' );
?>>
<?php 
do_action( 'premmerce_after_body_open' );
?>

<!-- Main content frame -->
<div class="page__body" data-page-pushy-container>
    <div class="page__layout <?php 
echo  ( saleszone_option( 'general_layout' ) == 'boxed' ? 'page__boxed-layout' : 'page__fluid-layout' ) ;
?>">
        <div class="page__wrapper">

            <?php 
do_action( 'premmerce_before_header' );
?>

            <header class="page__hgroup">
                <div class="page__header">
                    <?php 
get_template_part( 'parts/header/layouts/header', saleszone_option( 'header_layout' ) );
?>
                </div>

                <?php 
?>

            </header>

            <?php 
do_action( 'premmerce_after_header' );
?>

            <div class="page__content">