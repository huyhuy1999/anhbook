<?php if(get_previous_post_link() || get_next_post_link()) :?>
<div class="content__row">
    <div class="post-navigation">
        <ul class="row post-navigation__list">
            <li class="col-xs-6 post-navigation__item post-navigation__item--prev">
                <?php if ($loc_prev = get_previous_post_link()): ?>
                    <span class="post-navigation__caption"><?php esc_html_e('Previous', 'saleszone'); ?></span>
                    <?php echo wp_kses($loc_prev, saleszone_get_allowed_html('prev_next')); ?>
                <?php endif; ?>
            </li>
            <li class="col-xs-6 post-navigation__item post-navigation__item--next">
                <?php if ($loc_next = get_next_post_link()): ?>
                    <span class="post-navigation__caption"><?php esc_html_e('Next', 'saleszone'); ?></span>
                    <?php echo wp_kses($loc_next, saleszone_get_allowed_html('prev_next')); ?>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</div>
<?php endif; ?>