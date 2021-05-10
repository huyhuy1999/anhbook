/** 
 * Opstore Custom Scripts
 */

(function($) {
    'use strict';
    var win = $(window),
        doc = $(document);

    //Preloader section
    win.load(function() {
        $('.opstore-loader').fadeOut('slow');
    });

    //Sticky Header
    win.on('scroll', function() {
        // shrink the navbar
        if ($(this).scrollTop() > 150) { //Adjust 150
            $('header').addClass('shrinked');
            $('.cd-nav-icon').addClass('icon-blk');
        } else {
            $('header').removeClass('shrinked');
            $('.cd-nav-icon').removeClass('icon-blk');
        }

        // toggles the display of scroll to top button
        if ($(this).scrollTop() > 400) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }

    });

    //Full Screen Search
    $('.searchbox-icon').on('click', function() {
        $('.full-search-container').addClass('search_on');
    });
    $('.closebtn').on('click', function() {
        $('.full-search-container').removeClass('search_on');
    });

/**
* responsive menu for mobiles
* @since 1.2.1
*/
function opstore_mobileMenus(){

    if (win.width() < 766) {

        $('<div class="opmob-sub-toggle"></div>').insertBefore('li.menu-item-has-children ul');
        $('<div class="opmob-sub-toggle-children"></div>').insertBefore('li.page_item_has_children ul');

        $('body').on('vclick touchstart','.opmob-sub-toggle', function()  {
          $(this).next('ul.sub-menu').slideToggle();
          $(this).parent('li').toggleClass('opmob-mob-menu-toggle');
        });

        $('body').on('vclick touchstart','.opmob-sub-toggle-children',function() {
            $(this).next('ul').slideToggle();
        });

    }else{
        $('.opmob-sub-toggle,.opmob-sub-toggle-children').remove();
    }

}
    
opstore_mobileMenus();


    /* For Off Camvas Cart */
    jQuery(document).ready(function($) {
        
        $('body').on('added_to_cart', function() {
            $('.off-canvas-cart').addClass('show');

            $(".scroll-wrap").niceScroll({
                cursorborder: "0px solid #1e1e1e",
            });
        });
        $('.site-header-cart a[title="cart"]').on('click', function() {
            $('.off-canvas-cart').addClass('show');

            $(".scroll-wrap").niceScroll({
                cursorborder: "0px solid #1e1e1e",
            });
        });
        $('.off-canvas-close').on('click', function() {
            $('.off-canvas-cart').removeClass('show');
        });
    });


    /* Icon Wrap */
    $('body').on('mouseover', '.products li', function() {
        var dis = $(this);
        dis.find('.icons').addClass('icon-triggred');
    });
    $('body').on('mouseleave', '.products li', function() {
        var dis = $(this);
        dis.find('.icons').removeClass('icon-triggred');
    });

    //Add to cart
    doc.on('click', '.add', function(e) {
        var $qty = $(this).closest('div').find('.qty');
        var maxVal = parseInt($qty.attr('max'));
        var step = parseInt($qty.attr('step'));
        var currentVal = parseInt($qty.val());
        if (!step) {
            step = 1;
        }
        $qty.val(currentVal + step);
        $qty.trigger('change');
    });

    doc.on('click', '.minus', function(e) {
        var $qty = $(this).closest('div').find('.qty');
        var minVal = parseInt($qty.attr('min'));
        var step = parseInt($qty.attr('step'));
        var currentVal = parseInt($qty.val());
        if (!step) {
            step = 1;
        }

        if (currentVal > 0 && currentVal !== minVal) {
            $qty.val(currentVal - step);
        }
        $qty.trigger('change');
    });

    // Sticky Sidebar
    if (opstore_params.sidebar_sticky == 'show') {
        $('.primary-content, .sidebar').theiaStickySidebar();
    }

    //Post format Gallery
    var gal_items = $('.opstore-gallery-items');
    if(gal_items.length > 0){
        gal_items.slick();
    }

    //Fix audio and video size
    $(".opstore-single-content").fitVids();
    $(".opstore-single-content").fitVids({
        customSelector: "iframe[src^='https://w.soundcloud.com']"
    });

    //Sticky Cart
    var lastScrollTop = 0;
    $(window).scroll(function() {
        var el = $("button[name='add-to-cart'], .wc-variation-selection-needed");
        if (el.length) {
            var btn_top = el.offset().top;
            var btn_bottom = btn_top + el.outerHeight();
        }

        var st = $(this).scrollTop();
        var scroll_bottom = st + $(this).height();
        if (typeof btn_bottom != 'undefined' && typeof btn_top != 'undefined') {
            if (!(btn_bottom > st) && (btn_top < scroll_bottom)) {
                $('.opstore-sticky-cart').slideDown('slow');
            } else {
                $('.opstore-sticky-cart').slideUp('slow');
            }
        } else
            $('.opstore-sticky-cart').slideDown('slow');
        lastScrollTop = st;
    });
    $('.closebtn').on('click', function() {
        $('.opstore-sticky-cart').addClass('hidden');
    });

    // scroll to top
    $('.scrollup').on("click", function() {
        $("html, body").animate({
            scrollTop: 0
        }, 1500);
        return false;
    });

})(jQuery);