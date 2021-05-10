<?php if ($description = saleszone_archive_description()): ?>
    <div class="content__row <?php echo !saleszone_option('category-show-description-on-top') ? 'content__row--top-md':''; ?>">
        <?php if(saleszone_option('category-show-hide-bth-for-description')): ?>
            <div class="show-hide-text">
                <div class="show-hide-text__container">
                    <div class="typo">
                        <?php echo $description; ?>
                    </div>
                </div>
                <a class="show-hide-text__btn hidden"
                   href="#"
                   data-show-hide-btn
                   data-show-html="<?php esc_html_e('Read more','saleszone'); ?> →"
                   data-hide-html="<?php esc_attr_e('Hide','saleszone'); ?> ↑"
                   data-show-hide-speed="500"
                >


                    <?php esc_html_e('Read more','saleszone'); ?> →
                </a>
            </div>
        <?php else: ?>
            <div class="typo">
                <?php echo $description; ?>
            </div>
        <?php endif; ?>
        <noscript>
            <style>
                .show-hide-text__container {max-height: none;}
            </style>
        </noscript>
    </div>
<?php endif; ?>
