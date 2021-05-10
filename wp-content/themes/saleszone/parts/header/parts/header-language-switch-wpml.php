<?php

    $active_lang = null;
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );

    foreach ($languages as $lang) {
        if($lang['active']){
            $active_lang = $lang;
        }
    }

?>

<?php if(!empty($languages)) :?>
    <?php if(saleszone_option('header_layout') == 'layout_3') :?>
        <li class="list-nav__item">
            <div class="list-nav__link">
                <span class="user-panel__ico">
                    <i class="icon-flag">
                        <img src="<?php echo esc_url($active_lang['country_flag_url']); ?>"/>
                    </i>
                </span>
                <span class="list-nav__text-el">
                    <?php echo esc_html($active_lang['native_name']); ?>
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
                                        <img src="<?php echo esc_url($lang['country_flag_url']); ?>"/>
                                    </i>
                                </i>
                                <?php echo esc_html($lang['native_name']); ?>
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
            <i class="icon-flag"><img src="<?php echo esc_url($active_lang['country_flag_url']); ?>"/></i>
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
                                        <img src="<?php echo esc_url($lang['country_flag_url']); ?>"/>
                                    </i>
                                </i>
                                <?php echo esc_html($lang['native_name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>