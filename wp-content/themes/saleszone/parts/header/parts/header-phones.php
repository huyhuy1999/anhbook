<?php if(strip_tags(saleszone_option('header-phone')) != '') :?>
    <div class="pc-header-phones">
        <div class="pc-header-phones__ico pc-header-phones__ico--phone-big">
            <?php saleszone_the_svg("phone-big"); ?>
        </div>
        <div class="pc-header-phones__content">
            <div class="pc-header-phones__label">
                <?php esc_html_e('Call us:', 'saleszone'); ?>
            </div>
            <div class="pc-header-phones__phones">
                <?php echo nl2br(saleszone_option('header-phone')); ?>
            </div>
        </div>
    </div>
<?php endif; ?>