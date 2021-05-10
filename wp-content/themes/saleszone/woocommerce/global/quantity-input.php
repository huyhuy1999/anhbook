<?php
/**
 * Product quantity inputs
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */


defined( 'ABSPATH' ) || exit;

$data_attributes = '';
$params = isset($params) ? $params : array();

foreach ($params as $key => $val) {
    $data_attributes .= $key . '="' . $val . '" ';
}

$i18nValidation = array(
        'max' => __('Max quantity: ','saleszone'),
        'min' => __('Min quantity: ','saleszone'),
        'onlyNumber' => __('Numbers only','saleszone'),
);

?>

<div class="quantity <?php echo isset($modifier) ? esc_attr($modifier) : '' ; ?>" data-quantity data-product-quantity="<?php echo htmlspecialchars( wp_json_encode($i18nValidation)); ?>">
    <button class="quantity__btn" type="button" data-quantity-control="minus">-</button>
    <label class="quantity__label screen-reader-text"
           for="<?php echo esc_attr($input_id); ?>"><?php esc_html_e('Quantity', 'saleszone'); ?></label>
    <div class="quantity__middle">
        <input class="quantity__input input-text qty text"
               autocomplete="off"
               type="<?php echo esc_attr($input_type) ?>"
               id="<?php echo esc_attr($input_id); ?>"
               data-quantity-min="<?php echo esc_attr($min_value); ?>"
               data-quantity-max="<?php echo esc_attr(0 < $max_value ? $max_value : ''); ?>"
               name="<?php echo esc_attr($input_name); ?>"
               value="<?php echo esc_attr($input_value); ?>"
               title="<?php echo esc_attr_x('Qty', 'Product quantity input tooltip', 'saleszone') ?>"
               pattern="<?php echo esc_attr($pattern); ?>"
            <?php echo wp_kses_post($data_attributes); ?>
        >
    </div>
    <button class="quantity__btn" type="button" data-quantity-control="plus">+</button>
</div>
