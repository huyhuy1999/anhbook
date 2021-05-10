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
    <?php if (saleszone_option('header_layout') == 'layout_3') : ?>
        <li class="list-nav__item">
            <div class="list-nav__link">
                <span class="user-panel__ico">
                    <i class="icon-flag">
                        <img src="<?php echo esc_url($active_lang['flag']); ?>"/>
                    </i>
                </span>
                <span class="list-nav__text-el">
                    <?php echo esc_html($lang['name']); ?>
                </span>
                <i class="list-nav__arrow list-nav__arrow--down">
                    <?php saleszone_the_svg('arrow-down'); ?>
                </i>
            </div>
            <div class="list-nav__drop">
                <ul class="overlay">

                    <?php foreach ($languages as $lang): ?>
                        <li class="overlay__item">
                            <a class="overlay__link"
                               href="<?php echo esc_url($lang['url']); ?>"
                               data-onclick-clear-fragments>
                                <i class="overlay__icon">
                                    <i class="icon-flag">
                                        <img src="<?php echo esc_url($lang['flag']); ?>"/></i>
                                </i>
                                <?php echo esc_html($lang['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </li>
    <?php else: ?>
        <div class="user-panel__item">
            <div class="user-panel__link">
                <span class="user-panel__ico">
                    <i class="icon-flag"><img src="<?php echo esc_attr($active_lang['flag']); ?>"/></i>
                </span>
                <i class="user-panel__arrow user-panel__arrow--down">
                    <?php saleszone_the_svg('arrow-down'); ?>
                </i>
            </div>
            <div class="user-panel__drop user-panel__drop--rtl">
                <ul class="overlay">

                    <?php foreach ($languages as $lang): ?>
                        <li class="overlay__item">
                            <a class="overlay__link"
                               href="<?php echo esc_url($lang['url']); ?>"
                               data-onclick-clear-fragments>
                                <i class="overlay__icon">
                                    <i class="icon-flag">
                                        <img src="<?php echo esc_url($lang['flag']); ?>"/></i>
                                </i>
                                <?php echo esc_html($lang['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>
    <?php endif; ?>
<?php endif;
