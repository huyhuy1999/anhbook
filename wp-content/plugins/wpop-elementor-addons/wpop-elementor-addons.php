<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/*
 * Plugin Name:       WPOP Elementor Addons
 * Plugin URI:        https://wpoperation.com/plugins
 * Description:       This is Elementor addons for WPoperation Themes.
 * Version:           1.0.6
 * Author:            WPoperation
 * Author URI:        https://wpoperation.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpopea
 * Domain Path:       /languages
 */


/** Necessary Constants **/
defined( 'WPOPEA_VERSION' ) or define( 'WPOPEA_VERSION', '1.0.6' ); //plugin version
defined( 'WPOPEA_TD' ) or define( 'WPOPEA_TD', 'wpopea' ); //plugin's text domain
defined( 'WPOPEA_PATH' ) or define( 'WPOPEA_PATH', plugin_dir_path( __FILE__ ) );
defined( 'WPOPEA_ASSETS' ) or define( 'WPOPEA_ASSETS', plugin_dir_url(__FILE__).'assets/' );


if(!class_exists('Wpop_El_Addons')) :

	class Wpop_El_Addons {

		public function __construct() {

	        /** Loads plugin text domain for internationalization **/
			add_action('init', array($this, 'load_text_domain'));
            add_action( 'wp_enqueue_scripts',array($this,'wpopea_script_register') );
			add_action( 'elementor/widgets/widgets_registered',array($this,'wpopea_elements_register') );
            add_action('admin_init',array($this,'wpopea_check_opstore_pro') );
            $this->includes();
		}
		
		/**
	     * Loads Plugin Text Domain
	     * 
	     */
	    function load_text_domain() {
	        load_plugin_textdomain('wpopea', false, basename(dirname(__FILE__)) . '/languages');
	    }

	    /* Include Theme Files */
	    function includes(){
			require WPOPEA_PATH.'/includes/functions.php';
			require WPOPEA_PATH.'/includes/helpers.php';
	    }

	
		function wpopea_elements_register(){

            require_once WPOPEA_PATH.'elements/opstore/advanced-menu.php';
			require_once WPOPEA_PATH.'elements/opstore/opstore-blog.php';
			if(class_exists('woocommerce')){
				require_once WPOPEA_PATH.'elements/opstore/opstore-products.php';
			    require_once WPOPEA_PATH.'elements/opstore/opstore-product-sale.php';
		    }
			if( defined('OPSTORE_THEME') ){
				if(class_exists('woocommerce')){
					require_once WPOPEA_PATH.'elements/opstore/product-info.php';
				}
		    }
		}

			

		function wpopea_script_register(){
			wp_register_script( 'wpopea-el-slick-js', WPOPEA_ASSETS . 'slick/slick.min.js', array('jquery'), WPOPEA_VERSION, true );
			wp_register_script( 'wpopea-el-isotope-js', WPOPEA_ASSETS . 'isotope/isotope.pkgd.js', array('jquery'), WPOPEA_VERSION, true );
			wp_register_script( 'wpopea-el-countdown-js', WPOPEA_ASSETS . 'countdown/jquery.countdown.min.js', array('jquery'), WPOPEA_VERSION, true );
			wp_enqueue_script( 'wpopea-el-menu-js', WPOPEA_ASSETS . 'advanced-menu.js', array('jquery'), WPOPEA_VERSION, true );
		    wp_enqueue_script( 'wpopea-el-js', WPOPEA_ASSETS . 'wpopea-elements.js', array('jquery','imagesloaded'), WPOPEA_VERSION, true );

		    wp_register_style('wpopea-slick-style',WPOPEA_ASSETS.'slick/slick.css',array(),WPOPEA_VERSION);
		    wp_register_style('wpopea-slick-theme-style',WPOPEA_ASSETS.'slick/slick-theme.css',array(),WPOPEA_VERSION);
		    wp_enqueue_style( 'wpopea-el-css', WPOPEA_ASSETS . 'wpopea-element.css' );
		}


		function wpopea_check_opstore_pro(){

			$current_theme = wp_get_theme();
			$theme_name = $current_theme -> get( 'Name' );
			if( $theme_name != 'Opstore Pro'){
				return;
			}else{
				deactivate_plugins( plugin_basename( __FILE__ ) );
			}

		}
    }

    $bscd_object = new Wpop_El_Addons();
endif;