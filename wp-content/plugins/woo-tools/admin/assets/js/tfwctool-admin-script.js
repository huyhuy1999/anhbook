jQuery(document).ready(function($) {
    $(document).on('change', '.tfwctool-module-switch', function(event) {
        var id = $(this).attr('id');
        var value = ($(this).is(":checked")) ? 'on' : 'off';
        $('.tfwctool-module-switch').prop('disabled', 'disabled');
        $(this).parents('.wctool-item').children('.wctool-name').append('<span class="update-icon-spin dashicons dashicons-update updating"></span>');
        $.ajax({
                url: woocommerce_tools_js_opt.ajax_url,
                type: 'POST',
                data: { action: 'woocommerce_tool_toggle_module', id: id, value: value },
            })
            .done(function(data) {
                console.log("success", data);
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
                $('.update-icon-spin').remove();
                $('.tfwctool-module-switch').removeAttr('disabled');
            });
    });

    $('.select2').select2();

});