<?php
/**
 * The template for displaying product search form
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
<div class="product-search"
     <?php if(saleszone_is_plugin_active('premmerce-search/premmerce-search.php')) :?>
     data-autocomplete="product-search"
     data-autocomplete-url="<?php echo esc_url( home_url( '/wp-json/premmerce-search/v1/search' ) ); ?>"
     <?php endif; ?>
>
    <!-- site-search -->
    <form class="product-search__form woocommerce-product-search"
          role="search"
          method="get"
          action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <div class="product-search__input-group">
            <input class="product-search__form-control search-field autocomplete__input"
                   id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"
                   autocomplete="off"
                   type="text"
                   placeholder="<?php echo esc_attr(saleszone_option('shop-search-placeholder')); ?>"
                   value="<?php echo get_search_query(); ?>"
                   name="s" />

            <div class="product-search__input-group-btn">
                <button class="product-search__submit" type="submit">
                    <i class="product-search__submit-icon">
                        <?php if(saleszone_option('header_layout') == 'layout_4') :?>
                            <?php saleszone_the_svg('search-thin')?>
                        <?php else: ?>
                            <?php saleszone_the_svg('search')?>
                        <?php endif?>
                    </i>
                </button>
            </div>
        </div>
        <input type="hidden" name="post_type" value="product" />
    </form>

    <?php
    /**
     * @hooked saleszone_render_saleszone_search
     */
    do_action('premmerce_after_product_search')?>

</div>