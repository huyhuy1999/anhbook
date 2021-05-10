<?php

if ( ! defined( 'WPINC' ) ) die;

?>
<div class="frame">
    <div class="frame__header">
        <div class="typo">
            <?php esc_html_e("You'll receive a one email when this product arrives in stock", 'saleszone'); ?>
        </div>
    </div>
    <div class="frame__inner">
        <?php if( !empty($list) ) :?>
            <table class="product-wait-table"
                   data-unsubscribe_nonce="<?php echo $nonce; ?>"
            >
                <thead class="product-wait-table__thead">
                    <tr class="product-wait-table__thead-row">
                        <th class="product-wait-table__col">
                            <?php esc_html_e('Product', 'saleszone' ); ?>
                        </th>
                        <th class="product-wait-table__col product-wait-table__col--remove">
                            <?php esc_html_e( 'Remove', 'saleszone' ); ?>
                        </th>
                    </tr>
                </thead>
                <tbody class="product-wait-table__body">
                <?php foreach($list as $item):?>

                    <tr class="product-wait-table__body-row">
                        <td class="product-wait-table__col">
                            <?php $query = new WP_Query(array(
                                'post_type' => array('product_variation', 'product'),
                                'post__in' => array($item['product_id']),
                                'posts_per_page' => 1
                            )); ?>
                            <?php while ($query->have_posts()) : ?>
                                <?php $query->the_post(); ?>
                                    <?php wc_get_template('content-product_thumb.php', array(
                                        'modifiers' => 'product-thumb--lg'
                                    )); ?>
                            <?php endwhile; ?>
                        </td>

                        <td class="product-wait-table__col product-wait-table__col--remove">
                            <a class="btn btn-default btn-small"
                               aria-label="Remove this item"
                               product-wait-subscription-remove
                               data-entry-hash="<?php echo esc_attr($item['entry_hash']); ?>"
                            >
                                X
                            </a>
                        </td>

                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="typo">
                <p>
                    <?php esc_html_e('You do not wait for any product', 'saleszone'); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>