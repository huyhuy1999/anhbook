<?php

/**
 * Fallback Woocommerce v3.3 woocommerce_output_product_categories function
 */
if(!function_exists('saleszone_compatibility_init')){
    function saleszone_compatibility_init(){
        if (!function_exists('woocommerce_output_product_categories')) {
            function woocommerce_output_product_categories($args)
            {
                woocommerce_product_subcategories($args);
            }
        }
    }
}
add_action('init', 'saleszone_compatibility_init');