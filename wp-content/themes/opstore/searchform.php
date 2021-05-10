<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div>
        <span class="screen-reader-text"><?php esc_html_e('Search for:','opstore')?></span>
        <input type="search" autocomplete="off" class="search-field" placeholder="<?php esc_attr_e( 'Search ...', 'opstore' ); ?>" value="" name="s">
    </div>
    <input type="submit" class="search-submit" value="<?php esc_attr_e( 'Search', 'opstore' ); ?>">
    <?php 
    if( function_exists('WC') ):
        ?>
        <input type="hidden" name="post_type" value="product">
        <?php
    endif;
    ?>
</form>