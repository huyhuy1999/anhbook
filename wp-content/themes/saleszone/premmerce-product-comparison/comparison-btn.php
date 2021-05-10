<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
//$inList = premmerce_comparison()->checkInComparison($productId) ? true : false;
?>

<?php

if(!isset($type)){
    $type = 'link';
}

?>

<?php if($type == 'button') :?>
    <div class="" data-add-to-compare>
        
        <!-- Item already is in compare list -->
        <a class="btn btn-default hidden"
           title="<?php esc_attr_e('Open in list', 'saleszone'); ?>"
           data-add-to-compare-btn="open"
           href="<?php echo esc_url(premmerce_comparison()->getUrlComparison()); ?>">
            <i class="btn-default__ico btn-default__ico--compare">
                <?php saleszone_the_svg('compare'); ?>
            </i>
        </a>

        <!-- Item isn't in compare list -->
        <button class="btn btn-default" type="button"
                title="<?php esc_attr_e('Add to compare', 'saleszone'); ?>"
                data-add-to-compare-btn="add"
                data-add-to-compare-btn-type="button"
                data-button-loader="button"
                data-add-to-compare-data="<?php echo esc_attr(wp_json_encode(array(
                    'url' => esc_url($url),
                    'comparison_product_id' => $productId,
                    '_wpnonce' => wp_create_nonce('wp_rest')
                ))); ?>"
                data-loader="<?php esc_attr_e('Loading...', 'saleszone'); ?>"
        >
            <i class="btn-default__ico btn-default__ico--compare">
                <?php saleszone_the_svg('compare'); ?>
            </i>
            <i class="button--loader hidden" data-button-loader="loader">
                <?php saleszone_the_svg('refresh'); ?>
            </i>
        </button>
    </div>
<?php elseif ($type == 'link') : ?>
    <div class="pc-product-action" data-add-to-compare>
        <div class="pc-product-action__ico pc-product-action__ico--compare">
            <?php saleszone_the_svg('compare'); ?>
        </div>

        <!-- Item already is in compare list -->
        <a class="pc-product-action__link pc-product-action__link--open hidden"
           href="<?php echo esc_url(premmerce_comparison()->getUrlComparison()); ?>"
           data-add-to-compare-btn="open"
        >
            <?php esc_html_e('Open in list', 'saleszone'); ?>
        </a>

        <!-- Item isn't in compare list -->
        <button class="pc-product-action__link" type="button"
                data-add-to-compare-btn="add"
                data-add-to-compare-btn-type="link"
                data-add-to-compare-data="<?php echo esc_attr(wp_json_encode(array(
                    'url' => esc_url($url),
                    'comparison_product_id' => $productId,
                    '_wpnonce' => wp_create_nonce('wp_rest')
                ))); ?>"
                data-loader="<?php esc_attr_e('Loading...', 'saleszone'); ?>"
        >
            <?php esc_html_e('Add to compare', 'saleszone'); ?>
        </button>

    </div>

<?php endif; ?>