jQuery(document).ready(function($) {
    
    var wireframe;
    $(document).on('click', '.tfwctool-image-select-button', function(e) {
        e.preventDefault();

        var url_selector = $(this).siblings('.tfwctool-image-select-field');

        if (wireframe) {
            wireframe.open();
            return;
        }

        wireframe = wp.media.frames.wireframe = wp.media({
            title: 'Select Image',
            button: {
                text: 'Select Image'
            },
            multiple: false
        });

        wireframe.on('select', function() {
            attachment = wireframe.state().get('selection').first().toJSON();
            url_selector.val(attachment.id);
            url_selector.data('imgsrc', attachment.sizes.thumbnail.url);
            url_selector.trigger('change');
        });
        wireframe.open();
    });

    $(document).on('click', '.tfwctool-image-remove-button', function(event) {
        event.preventDefault();
        $(this).siblings('.tfwctool-image-select-field').val('').data('imgsrc', '').trigger('change');
        $(this).hide();
    });
    var tfwcvari_wc_placeholder_img = TFWCTOOL_VARITION.tfwcvari_wc_placeholder_img;
    $(document).on('change', '.tfwctool-image-select-field', function(event) {
        var $image_view = $(this).siblings('.tfwctool-product-attributeimage').children('img.attachment-thumb');
        var value = $(this).data('imgsrc');
        if (value) {
            $image_view.attr('src', value);
            $(this).siblings('.tfwctool-image-remove-button').show();
        } else {
            $image_view.attr('src', tfwcvari_wc_placeholder_img);
            $(this).siblings('.tfwctool-image-remove-button').hide();
        }
    });



    jQuery(document).ajaxComplete(function(event, request, options) {
        if (request && 4 === request.readyState && 200 === request.status &&
            options.data && 0 <= options.data.indexOf('action=add-tag')) {

            var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
            if (!res || res.errors) {
                return;
            }
            // Clear Thumbnail fields on submit
            var $image_view = $('.tfwctool-product-attributeimage').children('img.attachment-thumb');
            $image_view.attr('src', tfwcvari_wc_placeholder_img);
            $('.tfwctool-text-atr-input tfwctool-image-select-field').val('');
            $('.tfwctool-image-remove-button').hide();
            return;
        }
    });
    
    $('.tfwctool-color-field').wpColorPicker();

});