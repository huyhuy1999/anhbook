jQuery(document).ready(function($) {
    $(document).on('change', '.tfwctool-varation-trigger', function() {
        $('select[name="'+$(this).attr('name')+'"]').val($(this).val()).trigger('change');
    });
    $(document).on('click', '.reset_variations', function(event) {
        // event.preventDefault();
        $('.tfwctool-varation-trigger').prop('checked', false);
    });
    //$(document).on('hover', 'label.tfwctool-varation-swatch', function(event) {
    //    // event.preventDefault();
    //    /* Act on the event */
    //    var variations = $(this).parents('form.variations_form').data('product_variations');
    //    // console.log(variations);
    //});
    
});