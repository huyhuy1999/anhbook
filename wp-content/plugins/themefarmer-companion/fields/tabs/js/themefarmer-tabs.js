jQuery(document).ready(function($) {
	var update = function() {
		$(document).find('.themefarmer-tab-radio').each(function(index, item) {
			var $parent = $(this).parents('.themefarmer-tab-control');
			var controls = $(this).data('controls');
			if($parent.hasClass('active')){
				$.each(controls, function(i, val) {
					 $('#customize-control-'+val).css('display', 'list-item');
				});
			}else{
				$.each(controls, function(i, val) {
					 $('#customize-control-'+val).css('display', 'none');
				});
			}
		});
	}
	update();
	$(document).on('click', '.themefarmer-tab-control', function(event) {
		var id = $(this).parents('.themefarmer-tabs').attr('id');
		$('.themefarmer-tab-control-'+id).removeClass('active');
		$(this).addClass('active');
		update();
	});
});