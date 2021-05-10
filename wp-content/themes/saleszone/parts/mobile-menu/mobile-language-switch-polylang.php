<?php

$active_lang = null;
$languages = null;

if (function_exists('pll_the_languages')) {
    $languages = pll_the_languages(array('raw' => 1));
    foreach ($languages as $lang) {
        if ($lang['current_lang']) {
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
                <?php echo esc_html($lang['name']); ?>
            </a>
        </li>
    <?php endforeach; ?>
<?php endif; ?>