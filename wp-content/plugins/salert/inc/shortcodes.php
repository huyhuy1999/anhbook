<?php 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


if(!class_exists('Salert_Shortcodes')){
    class Salert_Shortcodes{
          public $salert_settings;
        // Construtor to load all hooks
	    function __construct(){
          add_shortcode( 'name', array($this,'salert_get_name' ) );
          add_shortcode( 'country', array($this,'salert_get_country' ) );
          add_shortcode( 'time', array($this,'salert_get_time' ) );
          //add_shortcode( 'product', array($this,'salert_get_product' ) );
          $this->salert_settings =  get_option( 'salert_save_settings');
	    }


      //Shortcode  for random name
      function salert_get_name() {
        $rand_name = $this->salert_settings['popup-names'];
        $text_array = explode(',',$rand_name);
        $name = array_rand($text_array,1);
        return $text_array[$name];
      }
      
      //Shortcode for random countries
      function salert_get_country(){
        $rand_country = $this->salert_settings['popup-countries'];
        $country_array = explode(',',$rand_country);
        $country = array_rand($country_array,1);
        return $country_array[$country];
      } 

      //Shortcode for random products

      function salert_get_product( $atts ) {
        $atts = shortcode_atts(
          array(
            'item' => '',
          ), $atts, 'salert_product' );
        $popup_product = $this->salert_settings['popup-products'];
        $product_array = ( isset( $popup_product ) ) ? $popup_product : '';  

        $rand_product = array_rand($product_array['title'],1);
        $image_url = $product_array['url'][$rand_product];
        $product_name = $product_array['title'][$rand_product];
        if($atts['item'] == 'purl'){
          return $image_url;
        }elseif($atts['item'] == 'pname'){
          return $product_name;
        }else{
          return null;
        }
      }

      //Shortcode for random Time
      function salert_get_time(){
        $time = mt_rand(1,15);
        $time_periods = $this->salert_settings['popup-timeperiod'];
        $min_hr = explode(',',$time_periods);
        $timespend = array_rand($min_hr,1);
        $ago = $this->salert_settings['popup-timeago'];
        return '<small class="time">'.esc_attr($time).' '.esc_html($min_hr[$timespend]).' '.esc_html($ago).'</small>';
      }



	}
}	    