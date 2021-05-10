(function ($) {
    'use strict';
    wp.customizerRepeater = {

        init: function () {
            $(document).on('click', '.iconpicker-items>i', function () {
                var iconClass = $(this).attr('class').slice(3);
                var classInput = $(this).parents('.iconpicker-popover').prev().find('.icon-select-field');
                classInput.val(iconClass);
                classInput.attr('value', iconClass);

                var iconPreview = classInput.parents('.icon-field-group').find('.icon-show');
                var iconElement = '<i class="fa '.concat(iconClass, '"><\/i>');
                iconPreview.empty();
                iconPreview.append(iconElement);

                // var th = $(this).parent().parent().parent();
                $(this).parents('.iconpicker-popover').removeClass('iconpicker-visible');
                classInput.trigger('change');
                //themefarmer-repeater  themefarmer-repeater-data
                //customizer_repeater_refresh_social_icons(th);
                return false;
            });
        },
        search: function ($searchField) {
            var itemsList = $searchField.parent().next().find('.iconpicker-items');
            var searchTerm = $searchField.val().toLowerCase();
            if (searchTerm.length > 0) {
                itemsList.children().each(function () {
                    if ($(this).filter('[title*='.concat(searchTerm)).length > 0 || searchTerm.length < 1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            } else {
                itemsList.children().show();
            }
        },
        iconPickerToggle: function ($input) {
            var iconPicker = $input.parent().next();
            iconPicker.addClass('iconpicker-visible');
        }
    };

    $(document).ready(function () {
        wp.customizerRepeater.init();
        

        $(document).on('keyup', '.iconpicker-search', function () {
            // console.log('search');
            wp.customizerRepeater.search($(this));
        });

        $(document).on('click', '.icon-select-field', function(event) {
            // console.log('clicked');
            wp.customizerRepeater.iconPickerToggle($(this));
        });


        /*$('.icon-select-field').on('click', function () {
            
            
        });*/

        $(document).mouseup( function (e) {
            var container = $('.iconpicker-popover');

            if (!container.is(e.target)
                && container.has(e.target).length === 0)
            {
                container.removeClass('iconpicker-visible');
            }
        });

    });

})(jQuery);
