jQuery(document).ready(function($) {
    jQuery('li.dropdown').find('.mobile-nav').each(function() {
        jQuery(this).on('click', function(event) {
            event.preventDefault();
            if (jQuery(window).width() < 768) {
                var nav = $(this).parent().parent();
                var dropdown = $(this).parent().siblings('.dropdown-menu');
                if (nav.hasClass('show')) {
                    nav.removeClass('show');
                    dropdown.removeClass('show');
                } else {
                    nav.addClass('show');
                    dropdown.addClass('show');
                }
            }
            return false;
        });
    });

    var add_sticky_header = newstore_script_obj.sticky_header;
    $(window).scroll(function() {
        if ($(window).width() > 768) {
            if ($(this).scrollTop() > 100) {
                $('body').addClass('tf-newstore-sticky-head-show');
                $('.site-header').addClass('sticky-head');
                var branding = $('.site-branding').clone().wrap("<div />").parent().html();
                var nav_items = $('#site-navigation').clone().find('.header-my-account-btn').remove().end().wrap("<div />").parent().html();
                var cart_items = $('.header-cart-withlist-links-container').clone().wrap("<div />").parent().html();
                var html = '<div class="container"><div class="row align-items-center"><div class="col-2">'+branding+'</div><div class="col">'+nav_items+'</div>'+cart_items+'</div></div>';
                if(add_sticky_header){
                    $('#sticky-header-container').html(html);
                    add_sticky_header = false;
                }
            } else {
                $('body').removeClass('tf-newstore-sticky-head-show');
                $('.site-header').removeClass('sticky-head');
            }
        } else {
            if ($(this).scrollTop() > 100) {
                $('body').addClass('tf-newstore-sticky-head-show');
                $('.site-header').addClass('sticky-head');
            } else {
                $('body').removeClass('tf-newstore-sticky-head-show');
                $('.site-header').removeClass('sticky-head');
            }
        }
    });

    $(document).on('click', '.product-categories .cat-parent', function(event) {
        if (event.target.tagName.toLowerCase() !== 'a') {
            event.preventDefault();
            if ($(this).hasClass('show-cat-child')) {
                $(this).removeClass('show-cat-child');
            } else {
                $(this).addClass('show-cat-child');
            }
        }
    });
    var is_rtl = newstore_script_obj.rtl;
    is_rtl = (is_rtl) ? true : false;
    window.home_carousel = $('.main-slider-carousel').owlCarousel({
        rtl: is_rtl,
        nav: true,
        loop: true,
        margin: 10,
        responsiveClass: true,
        smartSpeed: 1000,
        items: 1,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        dots: true,
        autoplay: true,
        autoplaySpeed: 2000,
    });

    $('.shop-swiper').owlCarousel({
        rtl: is_rtl,
        nav: true,
        loop: true,
        margin: 10,
        responsiveClass: true,
        items: 1,
        lazyLoad: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
    });

    $('.home-blog-carousel').owlCarousel({
        rtl: is_rtl,
        nav: false,
        dots: false,
        loop: true,
        margin: 10,
        responsiveClass: true,
        items: 3,
        lazyLoad: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots: true,
            },
            578: {
                items: 2,
            },
            768: {
                items: 3,
            },
        },
        autoplay: true,
        autoplaySpeed: 2000,
    });

    var homeSliderHeight = $('.home-swiper').height();
    $('.home-swiper').find('.carousel-caption').each(function(index, el) {
        var captionHeight = $(this).outerHeight();
        var top = 0;
        if (homeSliderHeight > captionHeight) {
            top = ((homeSliderHeight - captionHeight) / 2);
        } else {
            top = 1;
        }
        top = parseInt(top);
        $(this).css('top', top + 'px');
    });

    var shopSliderHeight = $('.shop-swiper').height();
    $('.shop-swiper').find('.carousel-caption').each(function(index, el) {
        var captionHeight = $(this).outerHeight();
        var top = 0;
        if (shopSliderHeight > captionHeight) {
            top = ((shopSliderHeight - captionHeight) / 2);
        } else {
            top = 1;
        }
        top = parseInt(top);
        $(this).css('top', top + 'px');
    });

    var blogSliderHeight = $('.blog-swiper').height();
    $('.blog-swiper').find('.carousel-caption').each(function(index, el) {
        var captionHeight = $(this).outerHeight();
        var top = 0;
        if (blogSliderHeight > captionHeight) {
            top = ((blogSliderHeight - captionHeight) / 2);
        } else {
            top = 1;
        }
        top = parseInt(top);
        $(this).css('top', top + 'px');
    });


    var product_carasol = $('.product-carasol').owlCarousel({
        rtl: is_rtl,
        nav: true,
        loop: true,
        margin: 15,
        responsiveClass: true,
        items: 4,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            500: {
                items: 2,
                nav: false
            },
            768: {
                items: 3,
            },
            992: {
                items: 4,
            },
        },
        autoplay: true,
        autoplaySpeed: 1500,
    });

    $('.widget-product-carousel').each(function(index, el) {
        var items = $(this).data('items');
        
        var show_nav = false;
        if($(this).hasClass('show-carousel-nav')){
            var show_nav = true;
        }

        $(el).owlCarousel({
            rtl: is_rtl,
            nav: show_nav,
            loop: true,
            margin: 15,
            responsiveClass: true,
            items: items,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: show_nav
                },
                500: {
                    items: 2,
                    nav: show_nav
                },
                768: {
                    items: 3,
                },
                992: {
                    items: items,
                },
            },
            autoplay: true,
            autoplaySpeed: 1500,
            smartSpeed:1500,
            autoplayHoverPause:true,
        });
    });
    // var widget_product_carousel = $('.widget-product-carousel')

    window.brand_carousel = $('.brand-carousel').owlCarousel({
        rtl: is_rtl,
        nav: true,
        loop: true,
        margin: 15,
        responsiveClass: true,
        items: 5,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        dots: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            500: {
                items: 2,
                nav: false
            },
            768: {
                items: 3,
            },
            992: {
                items: 5,
            },
        }
    });



    window.testimonial_carousel = $('.testimonial-carousel').owlCarousel({
        rtl: is_rtl,
        items: 1,
        loop: true,
        center: true,
        margin: 15,
        autoplayHoverPause: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        nav: true,
        dots: false,
    });

    $('.nav-pills a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });


    /* Lignt Box*/
    var gallery = $('.posts-index .the-post-img').simpleLightbox();
    var gallery = $('.blog-details .the-post-img').simpleLightbox();


    // new WOW().init();

    /* Scroll Top */
    var amountScrolled = 500;
    jQuery(window).scroll(function() {
        if (jQuery(window).scrollTop() > amountScrolled) {
            jQuery('a#scroll-top').fadeIn('fast');
        } else {
            jQuery('a#scroll-top').fadeOut('fast');
        }
    });

    jQuery('a#scroll-top').click(function(e) {
        e.preventDefault();
        jQuery('html, body').animate({
            scrollTop: 0
        }, 700);
        return false;
    });
    /* Scroll Top */


    $(document).on('click', '#primary-menu a', function(event) {
        var sec_id = $(this).attr('href');
        if (sec_id.indexOf('#') !== -1) {
            event.preventDefault();
            if ($(sec_id).length) {
                jQuery('html, body').animate({
                    scrollTop: sec_id
                }, 700);
            } else {
                var sec_class = sec_id.replace("#", ".section-");
                if ($(sec_class).length) {
                    jQuery('html, body').animate({
                        scrollTop: $(sec_class).offset().top - 50
                    }, 700);
                }
            }
        }
    });

    $(function() {
        $('[data-toggle="tooltip"]').tooltip({
            html: true,
        })
    });

    $(".woocommerce div.product .woocommerce-product-gallery__image a img").hover(function(event) {
        $(this).ezPlus({
            cursor: 'move',
            zoomWindowHeight: 650,
            zoomWindowWidth: 650,
            zoomWindowOffsetX: 10,
            zoomWindowOffsetY: 0,
            borderColour: '#888',
            zoomWindowBgColour: '#000',
            borderSize: 1,
            attrImageZoomSrc: 'large_image',
            zoomLevel:0.5,
            // zoomType:'window',
        });
    });

    /*$('.woocommerce div.product .woocommerce-product-gallery__image a img').imageZoom({

    // image magnifier background color
    cursorcolor:'255,255,255',

    // opacity
    opacity:0.5, 

    // cursor type
    cursor:'crosshair', 

    // z-index
    zindex:2147483647, 

    // zoom view size
    zoomviewsize:[500,500],

    // zoom view position. left or right
    zoomviewposition:'right', 

    // zoom view margin
    zoomviewmargin:10, 

    // zoom view border
    zoomviewborder:'1px solid #000',

    // zoom level
    magnification:3 

    });*/

});


jQuery(document).ready(function($) {

    $(document).on('click', '.product-view-type-item', function(event) {
        var viewtype = $(this).data('item');
        $('.product-view-type-item').removeClass('active');
        $(this).addClass('active');
        $('#tf-product-loop-container').removeClass(function(index, className) {
            return (className.match(/(^|\s)product-view-\S+/g) || []).join(' ');
        });
        $('#tf-product-loop-container').addClass('product-view-'.concat(viewtype));
    });

    $('.woocommerce-widget.woocommerce.widget_product_categories').find('li.cat-item.cat-parent').children('ul.children').before('<span class="cat-toggle"></span>');

    $(document).on('click', '.woocommerce-widget.woocommerce.widget_product_categories .cat-toggle', function(event) {
        event.preventDefault();
        var parent = $(this).parent('.cat-parent');
        if (parent.hasClass('open')) {
            parent.removeClass('open');
            $(this).siblings('ul.children').slideUp('400');
        } else {
            parent.addClass('open');
            $(this).siblings('ul.children').slideDown('400');
        }

    });

    $(document).on('change', 'select#woocommerce_product_count_select', function(event) {
        var url = $(this).val();
        window.location.href = url;
    });

    /* ============== Quantity buttons ============== */
    // $('div.quantity:not(.has_qty_btn), td.quantity:not(.has_qty_btn)').addClass('has_qty_btn').append('<button type="button" class="tf-qty-button plus"><i class="fa fa-plus" aria-hidden="true"></i></button>').prepend('<button type="button" class="tf-qty-button minus"><i class="fa fa-minus" aria-hidden="true"></i></button>');

    // Target quantity inputs on product pages
    $('input.qty:not(.product-quantity input.qty)').each(function() {
        var min = parseFloat($(this).attr('min'));

        if (min && min > 0 && parseFloat($(this).val()) < min) {
            $(this).val(min);
        }
    });

    $(document).on('click', '.plus, .minus', function() {

        // Get values
        var $qty = $(this).closest('.quantity').find('.qty'),
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
        if ($(this).is('.plus')) {

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
    });

    $(document).on('click', '.woocommerce-review-link', function(event) {
        var $sect_id = $(this).attr('href');
        jQuery('html, body').animate({
            scrollTop: $($sect_id).offset().top - 50
        }, 500);
    });

    $(document).on('click', '.woocommerce-widget .wc-sidebar-toggle', function(event) {
        event.preventDefault();
        var $wc_widget = $(this).parents('.woocommerce-widget.sidebar-widget.widget');
        if ($wc_widget.hasClass('open')) {
            $(this).parent().siblings().slideUp(function() {
                $wc_widget.removeClass('open');
            });
        } else {
            $wc_widget.addClass('open');
            $(this).parent().siblings().slideDown(function() {});
        }
        /*if(!$wc_widget.hasClass('open')){
            $wc_widget.addClass('open');
        }*/
        // $(this).parent().siblings().slideToggle();
    });

    /*$('ol.flex-control-nav.flex-control-thumbs').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel"
    });

    $('ol.flex-control-nav.flex-control-thumbs').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 210,
        itemMargin: 5,
        asNavFor: '#slider'
      });*/

});

jQuery(function($) {

    jQuery('body').on('init', '.wc-tabs-wrapper, .woocommerce-tabs', function() {
        var hash = window.location.hash;
        var $tabs = jQuery(this).find('.wc-tabs, ul.tabs').first();

        if (hash === '#review_form') {
            setTimeout(function() {
                $tabs.find('li.reviews_tab a').click();
            }, 100);
        }
    });

});


jQuery(document).ready(function($) {
    window.initSingleProductImages = function() {

        $(document).on('change', '.tfwctool-varation-trigger', function(event) {
            single_product_slider.trigger('to.owl.carousel', [0, 1000]);
        });
        var single_product_slider = $('.woocommerce-single-product-slider').owlCarousel({
            nav: true,
            loop: false,
            margin: 10,
            responsiveClass: true,
            smartSpeed: 1000,
            items: 1,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            dots: false,
            autoplay: false,
            autoplaySpeed: 2000,
            lazyLoad: true,
            responsiveRefreshRate: 200,
            thumbs: true,
            thumbsPrerendered: true
        }).on('changed.owl.carousel', syncPositionFromMain);;

        var single_product_carousel = $('.woocommerce-single-product-nav-carousel').owlCarousel({
            nav: true,
            loop: false,
            margin: 10,
            responsiveClass: true,
            smartSpeed: 1000,
            items: 4,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            dots: false,
            autoplay: false,
            autoplaySpeed: 2000,
            lazyLoad: true,
            slideBy: 1,
            rewind: false,
            is_nav: true,
            // center:true,
        }).on('changed.owl.carousel', syncPositionFromNav).on("click", ".owl-item", function(e) {
            e.preventDefault();
            var number = $(this).index();
            // console.log(number);
            single_product_carousel.data('owl.carousel').to(number, 1000, true);
            single_product_slider.data('owl.carousel').to(number, 1000, true);
        });

        function syncPositionFromMain(element) {
            // console.log(element);
            var index = element.item.index;
            var count = element.item.count;
            var position = 0
            if (index > count) {
                position = index - count;
            } else {
                position = index;
            }
            single_product_carousel
                .find(".owl-item")
                .removeClass("current")
                .eq(position)
                .addClass("current");
            single_product_carousel.data('owl.carousel').to(position, 1000, true);
            // window.home_carousel.trigger('to.owl.carousel', [focusIndex, 0]);
        }

        function syncPositionFromNav(element) {
            // console.log(element);
            var index = element.item.index;
            var count = element.item.count;
            var position = 0
            if (index > count) {
                position = index - count;
            } else {
                position = index;
            }
            // $(element).data('index')
            // console.log(position);
            single_product_slider.data('owl.carousel').to(position, 1000, true);
        }

        var syncedSecondary = true;

        function syncPosition(el) {
            //if you set loop to false, you have to restore this next line
            //var current = el.item.index;

            //if you disable loop you have to comment this block
            var count = el.item.count - 1;
            var current = Math.round(el.item.index - (el.item.count / 2) - .5);

            if (current < 0) {
                current = count;
            }
            if (current > count) {
                current = 0;
            }

            //end block

            single_product_carousel
                .find(".owl-item")
                .removeClass("current")
                .eq(current)
                .addClass("current");
            var onscreen = single_product_carousel.find('.owl-item.active').length - 1;
            var start = single_product_carousel.find('.owl-item.active').first().index();
            var end = single_product_carousel.find('.owl-item.active').last().index();

            if (current > end) {
                single_product_carousel.data('owl.carousel').to(current, 1000, true);
            }
            if (current < start) {
                single_product_carousel.data('owl.carousel').to(current - onscreen, 1000, true);
            }
        }

    };
    window.initSingleProductImages();
    $(document).on('quick-view-loaded', function(event) {
        // alert('triggerd');
        setTimeout(function() {
            window.initSingleProductImages();
            $('.woocommerce-single-product-slider .woocommerce-product-gallery__image a').simpleLightbox();
        }, 100);
    });
    
    $(document).on('focusin', 'li.menu-item a', function(event) {
        $(this).siblings('ul').addClass('nav-link-focus');
        $(this).parent().siblings('li.menu-item').children('ul').removeClass('nav-link-focus');
        // jQuery('li#menu-item-3446').siblings('li.menu-item').children('ul').removeClass('nav-link-focus')
    });

    $(document).on('focusin', 'a, button', function(event) {
        if(!$(this).is('ul li a')){
            $('li').children('ul').removeClass('nav-link-focus');
        }
    });
});