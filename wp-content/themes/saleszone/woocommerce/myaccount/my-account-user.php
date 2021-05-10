<?php
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
?>

<div class="profile-photo">
	<div class="profile-photo__frame">
	    <?php echo get_avatar( $user_id, 90 );  ?>
	</div>
	<div class="profile-photo__title">

        <?php echo esc_html($current_user->display_name); ?>

		<span class="profile-photo__user-id">
            <?php echo '#'.esc_html($user_id);?>
        </span>
	</div>
</div>