<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.


/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 */

$salert_settings = get_option( 'salert_save_settings');
//Image Position
$image_position = $salert_settings['image-position'];
$image_style = $salert_settings['image-style'];


//Random products

$popup_product = $salert_settings['popup-products'];
$product_array = ( isset( $popup_product ) ) ? $popup_product : '';  

if( !empty($product_array)){
	$rand_product = array_rand($product_array['title'],1);
	$image_url = $product_array['url'][$rand_product];
	$product_name = $product_array['title'][$rand_product];
}else{
	$rand_product = '';
	$image_url = '';
	$product_name = '';
}

$popup_contents = $salert_settings['popup-contents'];
$final_content = str_replace('[product]', $product_name, $popup_contents);

?>

<div class="popup-item <?php echo esc_attr($image_position);?> <?php echo ($image_url == '') ? 'textOnly' : ''; ?> clearfix">
    <?php 
    if($salert_settings['close-btn']==1){
        echo '<span class="btn-close"><span class="lnr lnr-cross-circle"></span></span>';
    }
    if($image_url != ''){ 
    if($image_position !== 'textOnly'){ 
    ?>
    <figure class="salert-img <?php echo esc_attr($image_style);?>"><img src="<?php echo esc_url($image_url)?>"></figure>
    <?php }}?>
    <div class="salert-content-wrap">
        <?php echo do_shortcode($final_content);?>
    </div>
</div>







