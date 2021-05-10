<div class="modal__header">
    <div class="modal__header-title">
        <?php echo wp_kses_post($title); ?>
    </div>
    <div class="modal__header-close" data-modal-close>
        <i class="modal__header-close-ico">
            <?php saleszone_the_svg('close')?>
        </i>
    </div>
</div>