jQuery(document).ready(function($) {
    
    $(document).on('click', '.tfwctool-add-to-compare-ajax', function(event) {
        event.preventDefault();
        var product_id = $(this).data('product_id');
        if($('.tfwc-comp-product.the-product-'+product_id).length){
            return;
        }
        
        event.preventDefault();
        add_compare_product(product_id);
        var $cmpr_btn = $(this);
        var remove_link = '<a href="#" data-product_id="'+product_id+'" class="tfwctool-remove-quick-compare"><i class="fa fa-times"></i></a>';
        var image        = $('<div class="tfwc-prd-image">').append($(this).parents('li.product').find('img').first().clone()).html();
        if(!image){
            image = $('<div class="tfwc-prd-image">').append($(this).parents('div.product').find('.woocommerce-product-gallery__image img.wp-post-image').first().clone()).html();
        }
        var title        = $(this).parents('li.product').find('.woocommerce-loop-product__title').first().html();
        if(!title){
            title = $(this).parents('div.product').find('.product_title').first().html();
        }
        var $phtml       = '<div class="tfwc-comp-product the-product-'+product_id+'">'+remove_link+image+'<div class="tfwc-prd-title">'+title+'</div></div>';
        $('.tfwctool-compare-quickinfo-inner .tfwctool-quick-porducts').append($phtml);
        var pcount       = $('.tfwctool-quick-porducts .tfwc-comp-product').length;
        $('.tfwctool-quick-button span.count').text(pcount);
        if(pcount > 0){
            $('.tfwctool-compare-quickinfo').show();
        }
    });
    $(document).on('click', 'button.tfwctool-quick-button', function(event) {
        var $cmpr_btn = $(this);
        $cmpr_btn.addClass('tfwctool-loading');
        var progress_img = '<div class="wcaqv-progress"></div>';
        $.ajax({
            url: TFWC_TOOL.ajax_url,
            type: 'POST',
            data: { action: 'tfwctool_show_compare_porducts'},
            success: function(data) {
                $('#tfwctool-compare-body').html(data);
                $('body,html').css('overflow', 'hidden');
                $('.tfwctool-compare-overlay').show('fast');
            },
            error: function() {
                $('#tfwctool-compare-body').html('Some problem please try again');
            },
            complete: function() {
                $cmpr_btn.removeClass('tfwctool-loading');
                
            }
        });
    });
    $(document).on('click', '.tfwctool-remove-compare-product', function(event) {
        event.preventDefault();
        var $ele = $(this);
        var index = $(this).parent().index();
        var product_id = $(this).data('product_id');
        var $table = $(this).parents('table');
        $ele.children('i.fa').addClass('fa-refresh fa-spin').removeClass('fa-times');
        var removed  = remove_compare_products(product_id);
        if(removed){
           $table.find('tr').find('td:eq('+(index-1)+')').remove();
        }
        $ele.children('i.fa').addClass('fa-times').removeClass('fa-refresh fa-spin');
    });

    $(document).on('click', 'a.tfwctool-remove-quick-compare', function(event) {
        event.preventDefault();

        var product_id = $(this).data('product_id');
        var removed  = remove_compare_products(product_id);
        if(removed){
           $(this).parent().remove();
        }
        var pcount = $('.tfwctool-quick-porducts .tfwc-comp-product').length;
        $('.tfwctool-quick-button span.count').text(pcount);
        if(pcount == 0){
            $('.tfwctool-compare-quickinfo').hide();
        }
        // $ele.children('i.fa').addClass('fa-times').removeClass('fa-refresh fa-spin');
    });

    $(document).on('click', '.tfwctool-compare-overlay', function(event) {
        if ($(event.target).hasClass('tfwctool-compare-overlay')) {
            $('body,html').css('overflow', 'auto');
            $('.tfwctool-compare-overlay').hide();
            $('#tfwctool-compare-body').html('');
        }
    });

    $(document).on('click', '.tfwctool-compare-close', function(event) {
        event.preventDefault();
        $('body,html').css('overflow', 'auto');
        $('.tfwctool-compare-overlay').hide();
        $('#tfwctool-compare-body').html('');
    });

    function add_compare_product(product_id){
        $.cookie.json = true;
        var products = $.cookie(TFWC_TOOL.compare_cookie_name);
        if(products && products.length){
            if(products.indexOf(product_id) !== -1){
               return; 
            }
        }else{
            var products = [];
        }
        products.push(product_id);
        $.cookie(TFWC_TOOL.compare_cookie_name, products, { expires: 365, path: '/' });
    }

    function remove_compare_products(product_id){
        $.cookie.json = true;
        var products = $.cookie(TFWC_TOOL.compare_cookie_name);
        var index = products.indexOf(product_id);
        if (index > -1) {
          products.splice(index, 1);
        }
        // $.removeCookie(TFWC_TOOL.compare_cookie_name, { path: '/' });
        return $.cookie(TFWC_TOOL.compare_cookie_name, products, { expires: 365, path: '/' });
    }

    function get_compare_products(){
        $.cookie.json = true;
        return $.cookie(TFWC_TOOL.compare_cookie_name);
    }

});