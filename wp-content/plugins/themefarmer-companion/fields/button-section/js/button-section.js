jQuery(document).ready(function($) {
	$('.themefarmer-toggle-section').click(function(event) {
		event.stopPropagation();
		// event.preventDefault();
		if($(this).parent().is('.themefarmer-section-hidden')){
			$(this).parent().removeClass('themefarmer-section-hidden');			
		}else{
			$(this).parent().addClass('themefarmer-section-hidden');
		}

		$(this).children('.dashicons').toggleClass(function() {
			if($(this).is('.dashicons-visibility')){
				$(this).removeClass('dashicons-visibility');
				return 'dashicons-hidden';
			}else{
				$(this).removeClass('dashicons-hidden');
				return 'dashicons-visibility';
			}
		});
		$(document).trigger('section_toggle_clicked');
	});
});

/*sub-accordion-panel-mega_store_homepage*/