jQuery(document).ready(function($) {
	$(document).on('submit', '#themefarmer-simple-contact-form', function(event) {
		event.preventDefault();
		var formdata = $(this).serializeArray();
		var the_data = {};
		$('#simple-contact-form-submit-buton').prop('disabled', true);
		$('#submit-buton-icon').addClass('fa-refresh fa-spin').removeClass('fa-paper-plane');
		$.each(formdata, function(index, val) {
			 the_data[val.name] = val.value;
		});
		
		$.ajax({
			url: themefarmer_companion_obj.ajax_url,
			type: 'POST',
			dataType: 'json',
			data: the_data,
		})
		.done(function(res) {
			$('#simple-contact-form-reseponse88').text(res.message);
		})
		.fail(function(error) {
			console.log("error", error);
		})
		.always(function() {
			$('#submit-buton-icon').removeClass('fa-refresh fa-spin').addClass('fa-paper-plane');			
		});
	});
});