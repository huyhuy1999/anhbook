jQuery(document).ready(function($) {
    $(document).on('click', '.tfwctool-quick-view-button', function(event) {
        var product_id = $(this).data('product_id');
        var progress_img = '<div class="wcaqv-progress"></div>';
        event.preventDefault();
        $('#themefarmer-wcaqv-body').html(progress_img);
        $('.wcaqv-overlay').show('fast', function() {
            console.log(TFWC_TOOL.ajax_url);
            $.ajax({
                url: TFWC_TOOL.ajax_url,
                type: 'POST',
                data: { action: 'tfwctool_show_product', product_id: product_id },
                success: function(data) {
                	$('#themefarmer-wcaqv-body').html(data);
                },
                error: function() {
                    $('#themefarmer-wcaqv-body').html('some problem please try again');
                },
                complete: function() {
                    $(document).trigger('quick-view-loaded');
                }
            });
        });
    });

    $(document).on('click', '.wcaqv-overlay', function(event) {
        if ($(event.target).hasClass('wcaqv-overlay')) {
            $('.wcaqv-overlay').hide();
            $('#themefarmer-wcaqv-body').html('');
        }
    });

    $(document).on('click', '.wcaqv-overlay .wcaqv-close', function(event) {
        $('.wcaqv-overlay').hide();
        $('#themefarmer-wcaqv-body').html('');
    });

});
