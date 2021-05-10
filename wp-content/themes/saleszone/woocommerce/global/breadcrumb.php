<?php
/**
 * Shop breadcrumb
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* Remove catalog page number from breadcrumbs */
if (get_query_var('paged')) {
    array_pop($breadcrumb);
}

$last_item = array_pop($breadcrumb);
?>

<div class="page__breadcrumbs">
    <div class="page__container">
        <ul class="breadcrumbs breadcrumbs--woocommerce" xmlns:v="http://rdf.data-vocabulary.org/#">
            <?php foreach ($breadcrumb as $key => $crumb): ?>
                <li class="breadcrumbs__item" typeof="v:Breadcrumb">
                    <a class="breadcrumbs__link" href="<?php echo esc_url($crumb[1]) ?>" rel="v:url" property="v:title">
                        <?php echo esc_html($crumb[0]) ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li class="breadcrumbs__item" typeof="v:Breadcrumb" rel="v:url nofollow"
                property="v:title">
                <?php echo esc_html($last_item[0]) ?>
            </li>
        </ul>
    </div>
</div>