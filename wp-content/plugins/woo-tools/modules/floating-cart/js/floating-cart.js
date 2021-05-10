jQuery(document).ready(function($) {
    // alert('asdf');
    $(document).on('click', '#tf-f-cart-icon', function(event) {
        $('body').toggleClass('tfwctool-floating-cart-show');
    });

    /*$(document).on('click', '.ajax_add_to_cart', function(event) {
    	var product_img = $(this).parents('li.product').find('img.attachment-woocommerce_thumbnail').first();
    	var product_img_clone = product_img.clone();
    	var img_position = product_img.position(); 
    	var cart_position = $('#tf-f-cart-icon').position();
    	console.log(img_position);
    	console.log(cart_position);
    });*/
    $(document).on('click', '.floating-cart-overlay', function(event) {
        $('body').removeClass('tfwctool-floating-cart-show');
    });

    var scroll_val = 0;
    $(document).on('click', '.tfwctool-f-cart-decrease, .tfwctool-f-cart-increase', function(e) {
        var $this_button = $(this);
        var $product_con = $(this).parents('.tfwctool-floating-cart-porducts');
        scroll_val = $product_con.scrollTop();
        // Get values
        var $qty = $(this).closest('.tfwctool-f-cart-quantity').find('.tfwctool-f-cart-quantity'),
            currentVal = parseFloat($qty.val()),
            max = parseFloat($qty.attr('max')),
            min = parseFloat($qty.attr('min')),
            step = $qty.attr('step');

        // Format values
        if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
        if (max === '' || max === 'NaN') max = '';
        if (min === '' || min === 'NaN') min = 0;
        if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

        // Change the value
        if ($(this).is('.tfwctool-f-cart-increase')) {

            if (max && (max == currentVal || currentVal > max)) {
                $qty.val(max);
            } else {
                $qty.val(currentVal + parseFloat(step));
            }

        } else {

            if (min && (min == currentVal || currentVal < min)) {
                $qty.val(min);
            } else if (currentVal > 0) {
                $qty.val(currentVal - parseFloat(step));
            }

        }

        // Trigger change event
        $qty.trigger('change');
        var cart_item_key = $qty.data('item_key');
        var cart_item_qty = $qty.val();
        tfwctool_f_cart_update_qty(e, cart_item_key, cart_item_qty);
    });

    function tfwctool_f_cart_update_qty(e, cart_item_key, cart_item_qty) {
        var data = {
            action: 'tfwctool_floating_cart_update_qty',
            cart_item_key: cart_item_key,
            cart_item_qty: cart_item_qty,
            tfwctoolfcrtnonce: TFWCTOOL_FCART.nonce,
        };

        jQuery.post(TFWCTOOL_FCART.ajax_url, data, function(response) {
            tfwctool_floating_cart_update_fragments(e, response.fragments);
        });
    }


    var tfwctool_floating_cart_update_fragments = function(e, fragments) {
        if (fragments) {
            $.each(fragments, function(key) {
                $(key)
                    .addClass('updating')
                    .fadeTo('400', '0.6')
                    .block({
                        message: null,
                        overlayCSS: {
                            opacity: 0.6
                        }
                    });
            });

            $.each(fragments, function(key, value) {
                $(key).replaceWith(value);
                $(key).stop(true).css('opacity', '1').unblock();
            });
            $(document.body).trigger('wc_fragments_loaded');
            tfwc_fcart_scroll_back();
        }
    };

    $(document).on('added_to_cart', function(event) {
    	$('#tf-f-cart-icon').addClass('swing animated');
    	setTimeout(function() {
    		$('#tf-f-cart-icon').removeClass('swing animated');	
    	},1000);
    });

    var tfwc_fcart_scroll_back = function() {
    	console.log(scroll_val);
    	var $product_con = $('.tfwctool-floating-cart-porducts');
        $product_con.scrollTop(scroll_val);
        scroll_val = 0;
    }

});