/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($) {

    // Site title and description.
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title a').text(to);
        });
    });
    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description').text(to);
        });
    });

    // Header text color.
    wp.customize('header_textcolor', function(value) {
        value.bind(function(to) {
            if ('blank' === to) {
                $('.site-title, .site-description').css({
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                });
            } else {
                $('.site-title, .site-description').css({
                    'clip': 'auto',
                    'position': 'relative'
                });
                $('.site-title a, .site-description').css({
                    'color': to
                });
            }
        });
    });

    //Top header enable disable
    wp.customize("opstore_top_header_show", function(value) {
        value.bind(function(to) {
            if (to == 'show') {
                $(".top-bar").css('display', 'block');
            } else {
                $(".top-bar").css('display', 'none');
            }
        });
    });
    //top header colors
    wp.customize('top_header_bg_color', function(value) {
        value.bind(function(to) {
            $('.top-bar').css({
                'background-color': to
            });
        });
    });
    wp.customize('top_header_text_color', function(value) {
        value.bind(function(to) {
            $('.top-bar ul li a').css({
                'color': to
            });
        });
    });

    //Search enable disable
    wp.customize("opstore_search_enable", function(value) {
        value.bind(function(to) {
            if (to == 'show') {
                $(".searchbox-icon").css('display', 'block');
            } else {
                $(".searchbox-icon").css('display', 'none');
            }
        });
    });
    //Wishlist enable disable
    wp.customize("opstore_wishlist_enable", function(value) {
        value.bind(function(to) {
            if (to == 'show') {
                $(".wishlist-icon").css('display', 'block');
            } else {
                $(".wishlist-icon").css('display', 'none');
            }
        });
    });
    //Cart enable disable
    wp.customize("opstore_cart_enable", function(value) {
        value.bind(function(to) {
            if (to == 'show') {
                $(".cart-icon").css('display', 'block');
            } else {
                $(".cart-icon").css('display', 'none');
            }
        });
    });
    //Login enable disable
    wp.customize("opstore_login_enable", function(value) {
        value.bind(function(to) {
            if (to == 'show') {
                $(".login").css('display', 'block');
            } else {
                $(".login").css('display', 'none');
            }
        });
    });

})(jQuery);