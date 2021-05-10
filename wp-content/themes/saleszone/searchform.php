<form action="<?php echo esc_url( home_url( '/' ) ) ?>" method="GET" role="search">
  <div class="input-group">
    <input class="form-control autocomplete__input"
           type="text"
           name="s"
           autocomplete="off"
           placeholder="Search by item name or number"
           value="<?php echo get_search_query() ?>"
           required
    >
    <div class="input-group-btn">
      <button class="btn btn-default" type="submit">
        <i class="btn-default__ico btn-default__ico--search">
          <?php saleszone_the_svg( "search" ); ?>
        </i>
      </button>
    </div>
  </div>
    <input type="hidden" name="post_type" value="post" />
</form>