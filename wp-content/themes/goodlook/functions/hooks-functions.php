<?php

/**
 * Define theme hooks functions
 */

/**
 * Additional info for quick view single product
 */

if (!function_exists('goodlook_single_product_add_info')) {
  function goodlook_single_product_add_info()
  {
    global $product;
    if (has_action('woocommerce_product_additional_information')) {
      do_action('woocommerce_product_additional_information', $product);
    }
  }
}


/**
 * Sku number for quick view
 * repeats sku part of saleszone/woocommerce/single-product/meta.php
 */

if (!function_exists('goodlook_single_product_get_sku')) {
  function goodlook_single_product_get_sku()
  {
    global $product;
    if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) {
      $sku = $product->get_sku() ? $product->get_sku() : esc_html__('N/A', 'goodlook');
      echo '<span class="sku _wrapper">' . esc_html__('SKU:', 'goodlook') . '&nbsp;<span class="sku">' . esc_html($sku) . '</span></span>';
    }
  }
}


/**
 * Brand link for single product
 */

if (!function_exists('goodlook_get_brand_link')) {
  function goodlook_get_brand_link()
  {
      if(function_exists('premmerce_get_product_brand')){
          global $product;

          if($product){
              $id = $product->get_ID();
              $brand = premmerce_get_product_brand($id);
              if ($brand) {
                  echo '<div class="brand-link"><a class="link link--secondary" href="' . esc_url(get_term_link($brand->slug, 'product_brand')) . '">' . esc_html($brand->name) . '</a></div>';
              }
          }
      }
  }
}

/**
 * Brand option for cart product
 */

if (!function_exists('goodlook_cart_get_brand_link')) {
  function goodlook_cart_get_brand_link($product)
  {
      if(function_exists('premmerce_get_product_brand')){
          $product_type = $product->get_type();

          if($product_type == 'variation'){
              $id = $product->get_parent_id();
          }else{
              $id = $product->get_id();
          }

          $brand = premmerce_get_product_brand($id);

          if ($brand) {
              echo '<div class="cart-product__option">';
              echo '<span class="cart-product__option-key">' . esc_html_e('Brand', 'goodlook') . ': ' . '</span>';
              echo '<a class="cart-product__option-value" href="' . esc_url(get_term_link($brand->slug, 'product_brand')) . '">' . esc_html($brand->name) . '</a></div>';
          }
      }
  }
}

/**
 * Catalog title
 */

if(!function_exists('goodlook_catalog_title')){
  function goodlook_catalog_title($template_name){
    if ( $template_name == 'loop/products-layout.php' ){
      echo '<div class="content__header content__header--category"><h1 class="content__title">';
      woocommerce_page_title();
      echo '</h1>';
      echo '</div>';
    }
  }
}

/**
 * Catalog header
 */

if(!function_exists('goodlook_render_catalog_header_brand')){
  function goodlook_render_catalog_header_brand(){
      if(!is_tax('product_brand')){
          return;
      }
      ?>
      <div class="pc-category-products-layout__header-brand">
          <div class="row row--ib row--vindent-s">
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                  <?php saleszone_brand_sidebar_image(); ?>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                  <?php if($description = saleszone_archive_description()) :?>
                      <div class="typo">
                          <?php echo wp_kses_post($description); ?>
                      </div>
                  <?php endif; ?>
              </div>
          </div>
      </div>
      <?php
  }
}


/**
 * Catalog description
 */
if(!function_exists('goodlook_catalog_footer')){
  function goodlook_catalog_footer(){
    if(!is_tax('product_brand')){
    wc_get_template('loop/archive-description.php');
    }
  }
}

/**
 * Display upp sells after product summary
 */
if(!function_exists('goodlook_upsell_display')){
    function goodlook_upsell_display(){
        global $product;

        $productUpsell = $product->get_upsell_ids();

        if (empty($productUpsell)) {
            return false;
        }

        function accessories_class($class){
            $class[] = 'product-cut--no-overlay';

            return $class;
        }

        add_filter('post_class', 'accessories_class');

        ?>

        <div class="pc-section-primary pc-section-primary--accessories">
            <div class="pc-section-primary__title">
                <?php esc_html_e('Accessories', 'goodlook'); ?>
            </div>
            <div class="pc-section-primary__inner">
                <?php woocommerce_upsell_display(); ?>
            </div>
        </div>

        <?php

        remove_filter('post_class', 'accessories_class');
    }
}
