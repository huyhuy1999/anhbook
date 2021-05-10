<div class="brand-meta">
    <?php esc_html_e('Brand', 'saleszone'); ?>:
    <a href="<?php echo esc_url(get_term_link($brand->slug, 'product_brand')); ?>">
        <?php echo esc_html($brand->name); ?>
    </a>
</div>