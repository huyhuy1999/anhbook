/** 
 * Opstore Custom Scripts
 */

(function($) {
    'use strict';

    var opstore_products = function($scope, $) {
        var $slider_elem = $scope.find('.wpopea-opstore-products').eq(0),
            $slider_main = $slider_elem.find('.products.product-slide'),
            $slideNo = $slider_elem.data('slide-no'),
            $tslideNo = $slider_elem.data('tslide-no'),
            $mslideNo = $slider_elem.data('mslide-no'),
            $slideItem = $slider_elem.data('slide-item'),
            $tslideItem = $slider_elem.data('tslide-item'),
            $mslideItem = $slider_elem.data('mslide-item'),
            $autoPlay = $slider_elem.data('auto-slide'),
            $pager = $slider_elem.data('show-pager'),
            $arrow = $slider_elem.data('show-arrow'),
            $infiniteSlide = $slider_elem.data('infinite-slide');
        if ($slider_main.length > 0) {
            $slider_main.slick({
                dots: $pager,
                infinite: $infiniteSlide,
                autoplay: $autoPlay,
                arrows: $arrow,
                slidesToShow: $slideNo,
                slidesToScroll: $slideItem,
                responsive: [{
                        breakpoint: 992,
                        settings: {
                            slidesToShow: $tslideNo,
                            slidesToScroll: $tslideItem
                        }
                    }, {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: $mslideNo,
                            slidesToScroll: $mslideItem
                        }
                    }

                ]
            });
        }
    };

    var opstore_isotopes = function($scope, $) {
        if(!isEditMode){
            var tab_element = $scope.find('.product-tab').eq(0);
            if (tab_element.length > 0) {
                var $grid = tab_element.imagesLoaded(function() {
                    // init Isotope after all images have loaded
                    $grid.isotope({
                        itemSelector: '.type-product',
                        layoutMode: 'fitRows'
                    });
                });
                var filter_tab = $scope.find('.product-tab-filter').eq(0);
                filter_tab.on('click', '.filter', function() {
                    $('.product-tab-filter .filter').removeClass('active');
                    $(this).addClass('active');
                    var filterValue = $(this).attr('data-filter');
                    $('.product-tab').isotope({
                        filter: filterValue
                    });
                });
            }
        }
    };


    var opstore_sale_count = function($scope, $) {
        var $saleTimer = $scope.find('.salecount-timer').eq(0);

        if ($saleTimer.length) {
            var salesEnd = $saleTimer.data('date');

            // we need to confirm for the date
            if (salesEnd) {
                var saleCounter = new Countdown($saleTimer[0], {
                    date: salesEnd,
                    render: function(data) {
                        $(this.el).html(
                            '<div><span class="no rounded-crcl">' + this.leadingZeros(data.days, 2) + '</span> DAYS</div>' +
                            '<div><span class="no rounded-crcl">' + this.leadingZeros(data.hours, 2) + '</span> HOURS</div>' +
                            '<div><span class="no rounded-crcl">' + this.leadingZeros(data.min, 2) + '</span> MINUTES</div>' +
                            '<div><span class="no rounded-crcl">' + this.leadingZeros(data.sec, 2) + '</span> SEC</div>'
                        );
                    }
                });
            }

        }
    };

    var isEditMode = false;
    $(window).on('elementor/frontend/init', function() {
        if (elementorFrontend.isEditMode()) {
            isEditMode = true;
        }
        elementorFrontend.hooks.addAction('frontend/element_ready/opstore-products.default', opstore_products);
        elementorFrontend.hooks.addAction('frontend/element_ready/opstore-products.default', opstore_isotopes);
        elementorFrontend.hooks.addAction('frontend/element_ready/opstore-products-sale.default', opstore_sale_count);
    });


})(jQuery);