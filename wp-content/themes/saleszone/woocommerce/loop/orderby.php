<?php
/**
 * Show options for ordering
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */
defined( 'ABSPATH' ) || exit;
?>

<?php if (count($catalog_orderby_options) > 0): ?>
    <div class="content__row content__row--sm">
        <div class="catalog-toolbar">

            <!-- Sort by -->
            <div class="catalog-toolbar__item">
                <label class="catalog-toolbar__label hidden-xs hidden-sm" for="catalog-sort-by">
                    <?php esc_html_e('Sort by', 'saleszone') ?>
                </label>
                <div class="catalog-toolbar__field">
                    <form method="get">
                        <select class="form-control input-sm"
                                id="catalog-sort-by"
                                name="orderby"
                                data-form-self-submit
                                aria-label="<?php esc_html_e('Sort by', 'saleszone') ?>"
                            <?php if(saleszone_option('product-variation-custom-select')): ?>
                                data-select-styler
                            <?php endif; ?>
                        >
                            <?php foreach ($catalog_orderby_options as $id => $name) : ?>
                                <option value="<?php echo esc_attr($id); ?>" <?php selected($orderby, $id); ?>>
                                    <?php echo esc_html($name); ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <input type="hidden" name="paged" value="1" />
                        <?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
                    </form>
                </div>
            </div>

        </div>
    </div>
<?php endif; ?>