<div class="content__row">
    <?php if (is_search()) : ?>
        <div class="content__row content__row--sm typo">
            <?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'saleszone'); ?>
        </div>
        <div class="content__row">
            <?php get_search_form(); ?>
        </div>
    <?php else: ?>
        <div class="typo">
            <?php esc_html_e('No products were found matching your selection.', 'saleszone'); ?>
        </div>
    <?php endif; ?>
</div>