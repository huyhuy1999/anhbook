<?php

if ( ! defined( 'WPINC' ) ) die;

?>

<?php if( ! empty( $list ) ): ?>

<div class="frame">
    <div class="frame__header hidden-lg hidden-md hidden-sm">
        <div class="frame__title">
            <?php esc_html_e( 'Price spy', 'saleszone' ); ?>
        </div>
    </div>
    <div class="frame__inner">
        <table class="pricespy-table">
            <thead class="pricespy-table__thead hidden-xs">
            <tr class="pricespy-table__thead-row">
                <th class="pricespy-table__col">
                    <?php esc_html_e( 'Product', 'saleszone' ); ?>
                </th class="pricespy-table__col">
                <th class="pricespy-table__col">
                    <?php esc_html_e( 'Price', 'saleszone' ); ?>
                </th>
                <th class="pricespy-table__col">
                    <?php esc_html_e( 'New price', 'saleszone' ); ?>
                </th>
                <?php if(has_action('premmerce_price_spy_frontend_tableheader')) :?>
                    <th class="pricespy-table__col">
                        <?php do_action( 'saleszone_price_spy_frontend_tableheader', $list )?>
                    </th>
                <?php endif; ?>
                <th class="pricespy-table__col">
                    <?php esc_html_e( 'Remove', 'saleszone' ); ?>
                </th>
            </tr>
            </thead>
            <tbody class="pricespy-table__body">
            <?php foreach($list as $item):?>
                <?php
                $product = wc_get_product( (int) $item->product_id );

                if( $item->old_price == $product->get_price() || empty( $item->new_price ) ) $icon_class = '';
                ?>
                <tr class="pricespy-table__row">

                    <td class="pricespy-table__col" data-title="<?php esc_html_e( 'Product', 'saleszone' ); ?>" >
                        <a href="<?php echo esc_url(get_permalink( $item->product_id )); ?>">
                            <?php echo esc_html($product->get_name()); ?>
                        </a>
                    </td>

                    <td class="pricespy-table__col" data-title="<?php esc_html_e( 'Price', 'saleszone' ); ?>" >
                        <?php echo wp_kses($item->old_price, saleszone_get_allowed_html('price')); ?>
                    </td>

                    <td class="pricespy-table__col" data-title="<?php esc_html_e( 'New price', 'saleszone' ); ?>" >
                        <b>
                            <?php echo empty($item->new_price) ? ' - ' : wp_kses($item->new_price, saleszone_get_allowed_html('price')); ?>
                        </b>
                    </td>

                    <?php if(has_action('premmerce_price_spy_frontend_tablebody')) :?>
                        <td class="pricespy-table__col" data-title="<?php do_action( 'saleszone_price_spy_frontend_tableheader', $list )?>" >
                            <?php do_action( 'saleszone_price_spy_frontend_tablebody', $item )?>
                        </td>
                    <?php endif; ?>

                    <td class="pricespy-table__col" data-title="<?php esc_html_e( 'Remove', 'saleszone' )?>" >
                        <a class="btn btn-default btn-small" data-price-spy-table-remove aria-label="Remove this item" data-product_id="<?php echo esc_attr($item->product_id); ?>" data-price-spy-table-remove>
                            X
                        </a>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

        <?php else: ?>

            <h3>
                <?php esc_html_e( 'You do not spy any product', 'saleszone' ) ?>
            </h3>

        <?php endif;?>
    </div>
</div>