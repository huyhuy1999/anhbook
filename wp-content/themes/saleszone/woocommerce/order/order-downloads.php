<?php
/**
 * Order Downloads.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="frame">
    <?php if ( isset( $show_title ) ) : ?>
    <div class="frame__header">
        <div class="frame__title">
            <?php esc_html_e( 'List of files to download', 'saleszone' ); ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="frame__inner">
        <section class="woocommerce-order-downloads">
            <table class="woocommerce-table woocommerce-table--order-downloads shop_table order_details <?php echo isset($table_modifiers) ? esc_attr($table_modifiers) : ''?>">
                <thead class="hidden-sm hidden-xs">
                <tr>
                    <?php foreach ( wc_get_account_downloads_columns() as $column_id => $column_name ) : ?>
                        <th class="<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <?php foreach ( $downloads as $download ) : ?>
                    <tr>
                        <?php foreach ( wc_get_account_downloads_columns() as $column_id => $column_name ) : ?>
                            <td class="<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>"><?php
                                if ( has_action( 'woocommerce_account_downloads_column_' . $column_id ) ) {
                                    do_action( 'woocommerce_account_downloads_column_' . $column_id, $download );
                                } else {
                                    switch ( $column_id ) {
                                        case 'download-product' :
                                            if ( $download['product_url'] ) {
                                                echo '<a href="' . esc_url( $download['product_url'] ) . '">' . esc_html( $download['product_name'] ) . '</a>';
                                            } else {
                                                echo esc_html( $download['product_name'] );
                                            }
                                            break;
                                        case 'download-file' : ?>
                                            <a class="btn btn-primary" href="<?php echo esc_url( $download['download_url'] ); ?>">
                                                <?php // echo esc_html( $download['download_name'] ); ?>
                                                <?php esc_html_e('Download','saleszone')?>
                                                <?php saleszone_the_svg('downloads', 'svg-icon--download')?>
                                            </a>
                                            <?php
                                            break;
                                        case 'download-remaining' :
                                            echo is_numeric( $download['downloads_remaining'] ) ? esc_html( $download['downloads_remaining'] ) : '&infin;';
                                            break;
                                        case 'download-expires' : ?>
                                            <?php if ( ! empty( $download['access_expires'] ) ) : ?>
                                                <time datetime="<?php echo esc_html(date( 'Y-m-d', strtotime( $download['access_expires'] ) )); ?>" title="<?php echo esc_attr( strtotime( $download['access_expires'] ) ); ?>">
                                                    <?php echo esc_html(date_i18n( get_option( 'date_format' ), strtotime( $download['access_expires'] ) )); ?>
                                                </time>
                                            <?php else : ?>
                                                <?php esc_html_e( 'Never', 'saleszone' ); ?>
                                            <?php endif;
                                            break;
                                    }
                                }
                                ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </div>
</div>