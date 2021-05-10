<div class="homepage-section section-widget-col">
	<div class="container">
		<div class="row">
			<?php 
				if (is_active_sidebar( 'front-page-widget-area-column') ){
					dynamic_sidebar( 'front-page-widget-area-column');
				}
			?>
		</div>
	</div>
</div>