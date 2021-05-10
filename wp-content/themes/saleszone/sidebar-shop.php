<?php
/**
 * This file output on woocommerce_sidebar hook
 * The reason of this file is override wp-includes\theme-compat\sidebar.php
 * if the file does not exist, you will need to remove the subscriber woocommerce_get_shedar from the woocommerce_sidebar hook
 * remove_action('woocommerce_sidebar','woocommerce_get_sidebar');
 */