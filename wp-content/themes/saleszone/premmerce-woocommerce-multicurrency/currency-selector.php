<?php
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>

<select class="form-control premmerce-multicurrency">
    <?php foreach($currencies as $currency): ?>
        <option value="<?php echo esc_attr($currency['id']); ?>"
            <?php selected($currency['id'], $usersCurrency); ?> >
            <?php echo esc_html($currency['code']); ?>
        </option>
    <?php endforeach; ?>
</select>
