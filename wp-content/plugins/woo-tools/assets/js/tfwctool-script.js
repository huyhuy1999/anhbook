jQuery(document).ready(function($) {

    
    $(document).on('click', '.add_to_wishlist_ajax', function(event) {
        event.preventDefault();
        var product_id = $(this).data('product_id');
        var this_button = $(this);
        add_to_wishlist_product(product_id);
        this_button.addClass('loading');
        
        $.ajax({
            url: TFWC_TOOL.ajax_url,
            type: 'POST',
            // dataType:'json',
            data: { action: TFWC_TOOL.add_to_wishlist_action, data:123442, product_id:product_id },
            success: function(data) {
            	if ( data && data.fragments ) {

                    $.each( data.fragments, function( key, value ) {
                        console.log(key);
                        $( key ).replaceWith( value );
                    });

                    $( document.body ).trigger( 'tfwctool_wishlist_fragments_refreshed' );
                }
                this_button.removeClass('loading');
            	this_button.addClass('added');
            },
            error:function(a,b,c) {
                console.log('a,b,c', a,b,c);

            },
            complete:function(res) {
            	
            }
        });
    });

    $(document).on('click', '.remove-from-wishlist', function(event) {
        event.preventDefault();
        var product_id = $(this).data('product_id');
        console.log(product_id);
        if(!product_id){
            return;
        }
        var this_button = $(this);
        remove_from_wishlist_product(product_id);
        this_button.addClass('tfwctool-loading');
        // this_button.parents('li.tfwctools-mini-wishlist-item.mini-wishlist-item').remove();
        $.ajax({
            url: TFWC_TOOL.ajax_url,
            type: 'POST',
            dataType:'json',
            data: { action: TFWC_TOOL.remove_from_wishlist_action, data:123442, product_id:product_id },
            success: function(data) {
                if ( data && data.fragments ) {

                    $.each( data.fragments, function( key, value ) {
                        console.log(key);
                        $( key ).replaceWith( value );
                    });

                    $( document.body ).trigger( 'tfwctool_wishlist_fragments_refreshed' );
                }
                this_button.removeClass('tfwctool-loading');
            },
            error:function(a,b,c) {
                console.log('a,b,c', a,b,c);

            },
            complete:function(res) {
                
            }
        });
    });

    function add_to_wishlist_product(product_id){
        $.cookie.json = true;
        var products = $.cookie(TFWC_TOOL.wishlist_cookie_name);
        if(products && products.length){
            if(products.indexOf(product_id) !== -1){
               return; 
            }
        }else{
            var products = [];
        }
        products.push(product_id);
        $.cookie(TFWC_TOOL.wishlist_cookie_name, products, { expires: 365, path: '/' });
    }

    function remove_from_wishlist_product(product_id){
        $.cookie.json = true;
        var products = $.cookie(TFWC_TOOL.wishlist_cookie_name);
        var index = products.indexOf(product_id);
        if (index > -1) {
          products.splice(index, 1);
        }
        // $.removeCookie(TFWC_TOOL.wishlist_cookie_name, { path: '/' });
        return $.cookie(TFWC_TOOL.wishlist_cookie_name, products, { expires: 365, path: '/' });
    }

    function get_wishlist_products(){
        $.cookie.json = true;
        return $.cookie(TFWC_TOOL.wishlist_cookie_name);
    }

});