<?php
/**
 * Show messages
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

defined('ABSPATH') || exit;

if (!$messages) {
    return;
}
?>

<div class="message message--success woocommerce-message" role="alert">
    <?php if (count($messages) == 1): ?>
        <?php echo wc_kses_notice($messages[0]); ?>
    <?php else: ?>
        <ul class="message__list">
            <?php foreach ($messages as $message) : ?>
                <li class="message__item"><?php echo wc_kses_notice($message); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>