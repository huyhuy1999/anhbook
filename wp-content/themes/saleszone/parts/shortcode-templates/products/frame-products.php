<div class="frame-products">
    <?php if (!empty($attributes['title'])): ?>
        <div class="frame-products__header">
            <div class="frame-products__title">
                <?php echo esc_html($attributes['title']); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="frame-products__inner">
        <?php echo $content; ?>
    </div>
</div>