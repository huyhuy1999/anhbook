<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div class="content__hinfo" data-load-more-product--result-count>
	<?php
    // if load more
    if(!empty($_GET['ajaxCatalog']) && saleszone_is_ajax()){
        $first = ( $per_page * $current ) - $per_page + 1;
        $last  = min( $total, $per_page * $current );
        printf(
            /* translators: 1: first result  2: total results */
            __('Showing %1$d&nbsp; of %2$d results','saleszone'),
            esc_html($last),
            esc_html($total)
        );
    } else {
        if ( $total <= $per_page || -1 === $per_page ) {

            printf(
                wp_kses_post(
                /* translators: %d: total results */
                    _n( 'Showing the single result <span class="hidden">%d<span>',
                        'Showing all <i class="content__hinfo-number">%d</i> results',
                        $total,
                        'saleszone' )
                ),
                esc_html($total)
            );
        } else {
            $first = ( $per_page * $current ) - $per_page + 1;
            $last  = min( $total, $per_page * $current );
            printf(
                wp_kses_post(
                /* translators: 1: first result 2: last result 3: total results */
                    _nx( 'Showing the single result <span class="hidden">%1$d %2$d %3$d<span>', 'Showing %1$d&nbsp;&ndash;&nbsp;%2$d of %3$d results', $total, 'with first and last result', 'saleszone' )), esc_html($first), esc_html($last), esc_html($total)
            );
        }
    }

	?>
</div>