<?php
$languages = null;
$active_lang = null;

if (function_exists('icl_get_languages')) {
    $languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
    foreach ($languages as $lang) {
        if ($lang['active']) {
            $active_lang = $lang;
        }
    }
}
?>

<?php if (!empty($languages)) : ?>
    <li class="mobile-nav__item mobile-nav__item--separator">
        <?php esc_html_e('Language', 'saleszone'); ?>
    </li>
    <?php foreach ($languages as $lang): ?>
        <li class="mobile-nav__item">
            <a class="mobile-nav__link"
               href="<?php echo esc_url($lang['url']); ?>"
               data-onclick-clear-fragments>
                <?php echo esc_html($lang['native_name']); ?>
            </a>
        </li>
    <?php endforeach; ?>
<?php endif; ?>