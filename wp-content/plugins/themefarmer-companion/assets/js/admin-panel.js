jQuery(document).ready(function($) {

    function themefarmer_update_menu_icons() {
        $('li.menu-item').each(function(index, el) {
            var icon = $(this).find('input.menu-item-icon-field').val();
            var $icon_changer = $(this).find('span.tf-change-menu-icon');
            if ($icon_changer.length) {
                if (icon) {
                    $icon_changer.html('<i class="tf-menu-icon-show ' + icon + '"></i>');
                } else {
                    $icon_changer.html('<i class="tf-menu-icon-show dashicons dashicons-plus"></i>');
                }
            } else {
                if (icon) {
                    $(this).find('span.menu-item-title').before('<span class="tf-change-menu-icon"><i class="tf-menu-icon-show ' + icon + '"></i></sapn>');
                } else {
                    $(this).find('span.menu-item-title').before('<span class="tf-change-menu-icon"><i class="tf-menu-icon-show dashicons dashicons-plus"></i></sapn>');
                }
            }
        });


        $('#menu-to-edit > li.menu-item.menu-item-depth-0').each(function(index, el) {
            var switch_html = '<span class="themefarmer-admin-menu-switch"><label class="switch"><input class="themefarmer-mega-menu-checkbox" type="checkbox" value="1"><span class="slider"></span></label>Mega Menu</span>';
            var $switch_obj = $('<span/>').html(switch_html).contents();
            var $menu_title = $(this).find('.item-title');
            var is_switch = $menu_title.find('.themefarmer-admin-menu-switch').length;
            var $class_input = $(this).find('input[type=text].edit-menu-item-classes');
            var menu_item_classes = "" + $class_input.val();
            console.log(menu_item_classes);

            if (menu_item_classes.indexOf('tf-mega-menu') >= 0) {
                // console.log($switch_obj.find('input[type=checkbox]').is(':checked'));
                $switch_obj.find('input[type="checkbox"]').prop('checked', true);
                // console.log($switch_obj.find('input[type=checkbox]').is(':checked'));
            } else {
                $switch_obj.find('input[type="checkbox"]').prop('checked', false);
            }

            if (is_switch <= 0) {
                $menu_title.append($switch_obj);
            }

        });
    }
    themefarmer_update_menu_icons();


    $(document).on('change', '.themefarmer-mega-menu-checkbox', function(event) {
        var $class_input = $(this).parents('li.menu-item').find('input[type=text].edit-menu-item-classes');
        $class_input.val($class_input.val().replace('tf-mega-menu', '').trim());
        if ($(this).is(':checked')) {
            if ($class_input.val()) {
                $class_input.val($class_input.val() + ' tf-mega-menu');
            } else {
                $class_input.val('tf-mega-menu');
            }
        }

    });


    $(document).on('click', '.tf-change-menu-icon', function(event) {
        event.preventDefault();
        $('#themefarmer-icon-panel').show();
    });


    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            console.log(mutation);
            $(mutation.addedNodes).each(function(index, val) {
                if ($(this).is('li.menu-item')) {
                    console.log('found');
                    themefarmer_update_menu_icons();
                    themefarmer_update_menu_images();
                }
            });

        });
    });

    // configuration of the observer:
    var config = { childList: true }
    var target = document.querySelector('#menu-to-edit.menu.ui-sortable');
    // pass in the target node, as well as the observer options
    observer.observe(target, config);

    /*jQuery(document).on('DOMNodeInserted', '#menu-to-edit.menu.ui-sortable', function (event) {
        event.stopPropagation();
        // console.log(event);
        themefarmer_update_menu_icons();
    });*/

    var $the_menu_item;
    $(document).on('click', '.tf-change-menu-icon', function(event) {
        event.preventDefault();
        $the_menu_item = $(this).parents('li.menu-item');
        $('.themefarmer-basic-icon-panel-overlay').show();
    });

    $(document).on('click', '.themefarmer-icon-picker', function(event) {
        event.preventDefault();
        if ($the_menu_item.length) {
            var icon_class = $(this).data('icon');
            $the_menu_item.find('.menu-item-icon-field').val(icon_class);
            themefarmer_update_menu_icons();
        }
        $('.themefarmer-basic-icon-panel-overlay').hide();
    });

    $(document).on('click', '.themefarmer-basic-icon-panel .media-modal-close', function(event) {
        event.preventDefault();
        $(this).parents('.themefarmer-basic-icon-panel-overlay').hide();
    });

    $(document).on('keyup change', '#tf-search-menu-icon', function(event) {
        var val = $(this).val();
        setTimeout(function() {
            var newval = $('#tf-search-menu-icon').val();
            if (newval == val) {
                $('.themefarmer-icon-picker').hide();
                $('.themefarmer-icon-picker').each(function(index, el) {
                    var icon_string = "" + $(this).data('icon');
                    if (icon_string.indexOf(val) >= 0) {
                        $(this).show();
                    }
                });
            }
        }, 500);
        if (val === '') {
            $('.themefarmer-icon-picker').show();
        }
    });

    function themefarmer_update_menu_images() {
        $('li.menu-item').each(function(index, navel) {
        	
        	if($(this).find('p.menu-image-container.description.description-wide').length){
        		return;
        	}

        	var img_url = $(this).children('input.menu-item-image-field').data('src');
        	var $menu_title_field = $(this).find('input.widefat.edit-menu-item-title').parents('p.description.description-wide');
        	if(img_url){
        		$menu_title_field.after(
	        		'<p class="menu-image-container description description-wide">'+
	        			'<span class="image-preview-container"><img src="'+img_url+'" class="nav-img-preview"></span>'+
	        			'<button type="button" class="button nav-image-remove-button"> Remove Image </button>'+
						'<button type="button" class="button nav-image-select-button"> Select Image </button>'+
					'</p>');	
        	}else{
        		$menu_title_field.after(
	        		'<p class="menu-image-container description description-wide">'+
	        			'<span class="image-preview-container" style="display:none;"><img class="nav-img-preview"></span>'+
	        			'<button type="button" class="button nav-image-remove-button" style="display:none;"> Remove Image </button>'+
						'<button type="button" class="button nav-image-select-button"> Select Image </button>'+
					'</p>');
        	}
        	
        });
    }
    themefarmer_update_menu_images();

    $(document).on('click', '.nav-image-select-button', function() {
    	var $remove_button = $(this).siblings('.nav-image-remove-button');
        var url_selector = $(this).parents('.menu-item').children('.menu-item-image-field');
        var $preview = $(this).parents('.menu-item').find('.image-preview-container');
        var $preview_img = $preview.children('img.nav-img-preview');
        var wireframe = null;
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
            $preview.show();
            $remove_button.show();
            $preview_img.attr('src', attachment.url);
            url_selector.trigger('change');
        });
        wireframe.open();
    });

    $(document).on('click', '.nav-image-remove-button', function(event) {
        event.preventDefault();
        var $preview = $(this).parents('.menu-item').find('.image-preview-container');
        var $preview_img = $preview.children('img.nav-img-preview');
        $(this).parents('.menu-item').children('.menu-item-image-field').val('').trigger('change');
        $preview.hide();
        $(this).hide();
    });

    /*$(document).on('change', '.menu-item-image-field', function(event) {
        var image_view = $(this).siblings('.attachment-media-view');
        var value = $(this).val();
        if (value) {
            image_view.html('<div class="thumbnail thumbnail-image"><img class="attachment-thumb" src="' + value + '" draggable="false"></div>');
            $(this).siblings('.image-remove-button').show();
        } else {
            image_view.html('<div class="placeholder">No image selected</div>');
            $(this).siblings('.image-remove-button').hide();
        }
    });*/


});