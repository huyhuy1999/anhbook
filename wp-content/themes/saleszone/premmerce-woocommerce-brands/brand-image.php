<?php $imageURL = $imageURL ? $imageURL : plugins_url('premmerce-woocommerce-brands/assets/frontend/img/placeholder.png'); ?>
<div class="content__sidebar-item">
    <div class="brand-sidebar">
        <div class="brand-sidebar__photo">
            <img src="<?php echo esc_url($imageURL); ?>" alt="<?php echo esc_attr($brand->name); ?>" class="brand-sidebar__img">
        </div>
    </div>
</div>