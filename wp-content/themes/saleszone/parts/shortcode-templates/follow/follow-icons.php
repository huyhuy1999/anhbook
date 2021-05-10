<ul class="soc-groups">
    <?php foreach ($follow_icons as $icon) :?>
        <?php $mod = get_theme_mod('follow-'.$icon['name']); ?>
        <?php if($mod) :?>
            <li><a class="fa fa-<?php echo $icon['fa'] ?>" target="_blank" href="<?php echo $mod ?>"><?php echo $icon['label'] ?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>