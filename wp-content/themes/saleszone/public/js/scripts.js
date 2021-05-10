;(function ($) {
  
  //register globals
  var loaderClass = 'spinner-circle';
  
  $.mlsAjax = {
    preloaderShow: function (options) {
      if (options.type === 'frame') {
        options.frame.attr('data-loader-frame', '1').append('<i class="' + loaderClass + '"></i>');
      }
      if (options.type === 'text') {
        options.frame.html(options.frame.data('loader'));
      }
    },
    
    preloaderHide: function () {
      $('[data-loader-frame]').removeAttr('data-loader-frame').find('.' + loaderClass).remove();
    },
    
    loadResponseFrame: function (data, frame) {
      var filterData = $(data).find(frame.selector).children();
      $(frame).html(filterData);
    },
    
    transferData: function (data, context) {
      context = context || $('html');
      $(data).find('[data-ajax-grab]').each(function () {
        var $this = $(this);
        var injectElement = $this.data('ajax-grab');
        var injectData = $this.html();
        context.find('[data-ajax-inject="' + injectElement + '"]').html(injectData);
      });
    }
  };
  
})(jQuery);
;(function ($) {
  
  $.mlsCart = {
    clearFragments: function () {
      sessionStorage.setItem(wc_cart_fragments_params.fragment_name, '');
    }
  };
  
})(jQuery);
;(function ($) {
  $.mlsLazzyload = {
    init: function (scope) {
      scope = scope || $('html');

      $('[data-lazy-load]', scope).lazyload({
        load: function () {
          var image = $(this);
            image.closest('[data-loader-frame-permanent]').find('.spinner-circle').hide();
            image.closest('[data-loader-frame-permanent]').removeAttr('data-loader-frame-permanent');
            image.attr('sizes', image.attr('data-sizes'));
            image.attr('srcset', image.attr('data-srcset'));
        }
      });

      $('[data-flip-img-lazy-load]', scope).lazyload({
          load: function () {
              $(this).closest('.flipper').addClass('flipper--back-image-loaded');
          }
      });

    },
    update: function () {
      $(document).trigger('scroll');
    }
  };
  
  /**
   * Init on load event
   */
  $(window).on('load', function () {
    $.mlsLazzyload.init();
  });

  $(document).on('ajaxStop', function(){
      $.mlsLazzyload.init();
  });
  
})(jQuery);
;(function ($) {
  
  if (typeof saleszoneLocalize === 'undefined') {
    return
  }
  
  var _ = saleszoneLocalize;
  
  /**
   * Localization for magnific popup
   */
  $.extend(true, $.magnificPopup.defaults, {
    tClose: _.tClose,
    tLoading: _.tLoading,
    gallery: {
      tPrev: _.tPrevious,
      tNext: _.tNext,
      tCounter: _.tOf
      
    }
  });
  
  
})(jQuery);
;(function ($) {
  
  $.mlsMedia = {
    zoomImage: function () {
      var selector = $('[data-zoom-image]');
      
      //Destroy previous zoom to prevent images duplication
      selector.trigger('zoom.destroy');
      
      //Init zoom to each element in list
      selector.each(function () {
        
        var zoomImage = $(this);
        var zoomedImageUrl = zoomImage.attr('data-zoom-image-url');
        var zoomedImageWrapper = zoomImage.siblings('[data-zoom-wrapper]');
        
        zoomImage.zoom({
          url: zoomedImageUrl,
          target: zoomedImageWrapper,
          touch: false,
          
          onZoomIn: function () {
            zoomedImageWrapper.removeClass('hidden');
          },
          onZoomOut: function () {
            zoomedImageWrapper.addClass('hidden');
          },
          callback: function () {
            var zoomedImage = $(this);
            
            if ((zoomImage.width() >= zoomedImage.width()) && (zoomImage.height() >= zoomedImage.height())) {
              selector.trigger('zoom.destroy');
            }
          }
        });
      });
    },
    magnificGalley: function (startIndex, outerGallery) {
      startIndex = startIndex || 0;
      outerGallery = outerGallery || $('[data-magnific-galley]');
      
      outerGallery.each(function () {
        
        var gallery = $(this);
        var mainImage = gallery.find('[data-magnific-galley-main]');
        var thumbList = gallery.find('[data-magnific-galley-thumb]');
        var imgStartArr = [];
        var imgPreArr;
        var imgShiftArr;
        
        if (thumbList.length > 0) {
          thumbList.each(function () {
            var imgSrc = {
              src: $(this).attr('href')
            };
            imgStartArr.push(imgSrc);
          });
          
          imgPreArr = imgStartArr.splice(0, startIndex);
          imgShiftArr = imgStartArr.concat(imgPreArr);
        }
        
        mainImage.magnificPopup({
          items: imgShiftArr,
          type: "image",
          gallery: {
            enabled: true
          },
          overflowY: "hidden",
          image: {
            titleSrc: 'data-magnific-galley-title'
          }
        });
        
      });
    }
  };
  
})(jQuery);
var mlsMegamenu = (function ($) {
  
  /* Activate callback function on resize event, but only if resize has been stopped */
  var _lazyResize = function (action, delay) {
    var resizeID;
    window.addEventListener('resize', function () {
      clearTimeout(resizeID);
      resizeID = setTimeout(action, delay);
    });
  };
  
  /* Find amount of coll in menu */
  var _findColsAmount = function (items) {
    return Array.prototype.reduce.call(items, function (count, item) {
      var value = item.dataset.megamenuCollItem;
      return (value > count) ? value : count;
    }, 1);
  };
  
  /* Create empty cols */
  var _createEmptyCols = function (coll, amount) {
    var emptyCols = [];
    for (var i = 2; i <= amount; i++) {
      emptyCols[i] = coll.cloneNode(false);
      emptyCols[i].dataset.megamenuColl = i;
    }
    return emptyCols;
  };
  
  /* Insert items into relative columns */
  var _moveItemsIntoCols = function (items, cols) {
    Array.prototype.forEach.call(items, function (item) {
      if (item.dataset.megamenuCollItem > 1) {
        cols[item.dataset.megamenuCollItem].appendChild(item);
      }
    });
  };
  
  /* Not allow sub menu go beyond parent menu container */
  var _fitHorizontal = function (selectors) {
    var menuContainer = document.querySelector(selectors.scope);
    var menuItems = menuContainer.querySelectorAll(selectors.items);
    var menuContainerWidth = menuContainer.offsetWidth;
    var menuPosition = menuContainer.getBoundingClientRect();
    
    Array.prototype.forEach.call(menuItems, function (item) {
      
      if (item.querySelectorAll(selectors.wrap).length === 0) {
        return;
      }
      
      /* Reset menu item styles to default */
      item.style.left = '0';
      item.querySelector(selectors.wrap).dataset.megamenuWrap = 'false';
      
      var itemPosition = item.getBoundingClientRect();
      
      /* move menu item to the left if it go beyond the container */
      if (itemPosition.right > menuPosition.right) {
        item.style.left = '-' + (itemPosition.right - menuPosition.right) + 'px';
        
        /* move menu items to next row if item width exceeds container */
        if (item.offsetWidth > menuContainerWidth) {
          item.style.left = '-' + (itemPosition.left - menuPosition.left) + 'px';
          item.style.minWidth = menuContainerWidth + 'px';
          item.querySelector(selectors.wrap).dataset.megamenuWrap = 'true';
        }
      }
    });
  };
  
  var _equalHeight = function (container, items) {
    var menuHeight = container.offsetHeight;
    
    if(items && items.length > 0){
      Array.prototype.forEach.call(items, function (item) {
        item.style.minHeight = menuHeight + 'px';
      });
    }
  };
  
  /* Move menu items in columns */
  var _renderCols = function (scope) {
    
    var subMenus = scope.querySelectorAll('[data-megamenu-item]');
    
    /* Iterate each sub menu */
    Array.prototype.forEach.call(subMenus, function (menuItem) {
      var colsWrapper = menuItem.querySelector('[data-megamenu-wrap]');
      var coll = menuItem.querySelector('[data-megamenu-coll]');
      var collItems = menuItem.querySelectorAll('[data-megamenu-coll-item]');
      
      /* Find how much columns is needed */
      var collNum = _findColsAmount(collItems);
      
      /* Exit if we have only one column */
      if (collNum <= 1)
        return;
      
      /* Create empty cols */
      var emptyColNodes = _createEmptyCols(coll, collNum);
      
      /* Insert items into relative columns */
      _moveItemsIntoCols(collItems, emptyColNodes);
      
      /* Add cols with items into DOM */
      emptyColNodes.forEach(function (item) {
        colsWrapper.appendChild(item);
      });
      
    });
    
  };
  
  var _fitContainer = function (options) {

    if(options.wrap && options.container && options.indent){
      var containerPosition = options.container.getBoundingClientRect();
      var menuPosition = options.wrap.getBoundingClientRect();
      var indent = menuPosition.left - containerPosition.left;
      var containerWidth = options.container.offsetWidth;
      var menuWidth = options.wrap.offsetWidth;
      var menuMaxWidth = containerWidth - indent;

      if (menuWidth > menuMaxWidth) {
        //'data-megamenu-wrap'
        options.wrap.style.width = menuMaxWidth + 'px';
        options.wrap.setAttribute('data-megamenu-wrap', 'true');
      } else {
        options.wrap.style.width = 'auto';
        options.wrap.setAttribute('data-megamenu-wrap', 'false');
      }
    }
  };
  
  /* Public methods */
  return {
    renderCols: function (scope) {
      _renderCols(scope);
    },
    fitHorizontal: function (selectors) {
      /* Initial menu loading */
      _fitHorizontal(selectors);
      /* Reloading menu while window resizing */
      _lazyResize(function () {
        return _fitHorizontal(selectors);
      }, 500);
    },
    equalHeight: function (container, items) {
      _equalHeight(container, items);
    },
    fitContainer: function (options) {
      _fitContainer(options);
      _lazyResize(function () {
        return _fitContainer(options);
      }, 500);
    }
  };
  
})(jQuery);
(function ($) {
  
  $.mlsModal = function (options) {
    $.magnificPopup.close();
    $.magnificPopup.open({
      items: {
        src: options.src
      },
      type: 'ajax',
      ajax: {
        settings: {
          data: options.data
        }
      },
      callbacks: {
        parseAjax: function (mfpResponse) {
          if (options.transferData) {
            $.mlsAjax.transferData(mfpResponse.data);
          }
        }
      },
      showCloseBtn: false,
      modal: false
    });
  };

  $.mlsCartModalInline = function (data) {
    $.magnificPopup.close();
    $.magnificPopup.open({
      items: {
        src: data,
        type: 'inline'
      },
      callbacks: {
          open: function () {
              $(document).trigger('cart_modal_open');
          }
      },
      showCloseBtn: false,
      modal: false
    });
  };

	$.mlsModalInline = function (data) {
		$.magnificPopup.close();
		$.magnificPopup.open({
			items: {
				src: data,
				type: 'inline'
			},
			showCloseBtn: false,
			modal: false
		});
	};

  /* Update current modal window content after it was replaced with woocommerce fragment */
  $(document.body).on('wc_fragments_loaded wc_fragments_refreshed', function () {
    var modalContent = $('.mfp-content');
    if (modalContent.length > 0) {
      $.magnificPopup.instance.content = modalContent.children();
    }
  });
  
})(jQuery);
(function ($) {
  
  /**
   *
   * @type {{showAddToCart: jQuery.mshProduct.showAddToCart, hideAddToCart: jQuery.mshProduct.hideAddToCart, editCartButtons: jQuery.mshProduct.editCartButtons}}
   */
  $.mshProduct = {
    setAddToCartState: function (state, products) {
      this.findOne(products, '[data-in-cart-state]').each(function (index, item) {
        if (item.getAttribute('data-in-cart-state') === state) {
          item.classList.add('hidden');
        } else {
          item.classList.remove('hidden');
        }
      });
    },
    findOne: function (product, selector) {
      return product.find(selector).filter(function () {
        return $(this).closest('[data-product]').is(product);
      });
    }
  };
})(jQuery);
;( function( $, window, document, undefined ) {

    "use strict";


    var pluginName = "showHidePart",
        defaults = {
            propertyName : "value",
            isOpen       : false,
            speed        : 500,
            hiddenClass  : 'hidden'
        };

    function ShowHidePart ( element, options ) {
        var _ = this;

        _.element = $(element);
        _.setting = $.extend( {}, defaults, options );
        _._defaults = defaults;
        _._name = pluginName;



        _.init();
    }

    // Avoid Plugin.prototype conflicts
    $.extend( ShowHidePart.prototype, {
        init: function() {
            var _ = this;
            var $this = $(_.element);

            _.setting.hideText   = $this.data('hide-html');
            _.setting.showText   = $this.data('show-html');
            _.setting.container  = $this.prev();
            _.setting.maxHeight = parseInt(_.setting.container.css('max-height'));
            _.setting.container.wrapInner('<div data-inner-wrap>');
            _.setting.innerHeight = _.setting.container.find('[data-inner-wrap]').height();

            if(_.setting.maxHeight < _.setting.innerHeight){
                $this.removeClass(_.setting.hiddenClass);
            }

            _.clickHandler = $.proxy(_.clickHandler, _ );

            $this.on('click', _.clickHandler);

        },
        clickHandler: function(e) {
            e.preventDefault();

            var _ = this;
            if(!_.setting.isOpen){
                _.open();
            } else {
                _.close();
            }
        },
        open: function () {
            var _ = this;
            _.setting.innerHeight = _.setting.container.find('[data-inner-wrap]').height();
            _.setting.container.css('height', this.setting.maxHeight);
            _.setting.container.css('max-height', 'none');
            _.setting.container.animate({
                height : _.setting.innerHeight
            }, _.setting.speed, function () {
                $(_.element).html(_.setting.hideText);
                _.setting.container.css('height', 'auto');
            });
            _.setting.isOpen = true;
        },
        close: function () {
            var _ = this;
            _.setting.container.animate({
                height : _.setting.maxHeight
            }, _.setting.speed, function () {
                $(_.element).html(_.setting.showText);
            });
            _.setting.isOpen = false;
        }
    } );

    $.fn[ pluginName ] = function( options ) {
        return this.each( function() {
            if ( !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" + pluginName, new ShowHidePart( this, options ));
            }
        } );
    };

} )( jQuery, window, document );

/**
 * Init on load event
 */
jQuery(window).on('load', function () {
    jQuery('[data-show-hide-btn]').showHidePart();
});

;(function ($) {
  
  $.mlsSlider = {
    
    getCols: function (slide) {
      var breakpoints = [768, 992, 1200];
      var cols = slide ? slide.split(',') : false;
      
      if ($.isArray(cols)) {
        cols.shift();
        if (cols.length > 0) {
          return $.map(cols, function (value, index) {
            return {
              breakpoint: breakpoints[index],
              settings: {
                slidesToShow: parseInt(value)
              }
            };
          });
        } else {
          return false;
        }
      } else {
        return false;
      }
    },
    getFirstCol: function (slide) {
      var cols = slide ? slide.split(',') : false;
      if (cols) {
        return parseInt(slide.split(',')[0]);
      } else {
        return 2;
      }
    },
    thumbsSlider: function () {
      
      var sliders = $('[data-slider="thumbs-slider"]');
      
      sliders.each(function () {
        
        var scope = $(this);
        var slides = $('[data-slider-slides]', scope).attr('data-slider-slides');
        var breakpoints = $('[data-slider-breakpoints]', scope).attr('data-slider-breakpoints') || null;
        
        $('[data-slider-slides]', scope)
        .find('[data-slider-slide]')
        .css('float', 'left')
        .end()
        .slick({
          dots: false,
          arrows: true,
          adaptiveHeight: true,
          slidesToShow: $.mlsSlider.getFirstCol(slides),
          autoplay: false,
          autoplaySpeed: 3000,
          infinite: false,
          swipeToSlide: true,
          mobileFirst: true,
          rows: 1,
          prevArrow: $('[data-slider-arrow-left]', scope).removeClass('hidden'),
          nextArrow: $('[data-slider-arrow-right]', scope).removeClass('hidden'),
          responsive: $.mlsSlider.getCols(slides, breakpoints)
        });
      });
    }
  };
  
  $.mlsSlider.thumbsSlider();

  $(document).on('quick_view_modal_open', function () {
      $.mlsSlider.thumbsSlider();
  });

})(jQuery);
;(function ($) {
  
  $.mlsTime = {
    
    countdown: {
      init: function (settings) {
        
        /* get collection of all countdown html components on page */
        var timers = document.querySelectorAll(settings.scope);
        
        /* update each countdown date item till expiration date */
        var updateClock = function (expirationDate, timeFrames, timerId) {
          var remainTime = $.mlsTime.countdown.getTimeLeft(expirationDate);
          
          $.mlsTime.countdown.renderTimeLeft(remainTime, timeFrames);
          if (timerId && remainTime.total <= 0) {
            clearInterval(timerId);
          }
        };
        
        for (var i = 0; i < timers.length; i++) {
          (function () {
            var expireDate = timers[i].getAttribute(settings.expireDateAttribute);
            var timerElements = timers[i].querySelectorAll(settings.item);
            var timeInterval = setInterval(function () {
              updateClock(expireDate, timerElements, timeInterval);
            }, 1000);
          })();
        }
        
      },
      getTimeLeft: function (endtime) {
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        
        return {
          'total': t,
          'days': days,
          'hours': hours,
          'minutes': minutes,
          'seconds': seconds
        };
      },
      renderTimeLeft: function (time, elems) {
        var dataAttrName;
        var frameType;
        
        for (var i = 0; i < elems.length; i++) {
          dataAttrName = Object.keys(elems[i].dataset)[0];
          frameType = elems[i].dataset[dataAttrName];
          elems[i].innerHTML = (time[frameType] < 10) ? ("0" + time[frameType]) : time[frameType];
        }
      }
    }
  };
  
})(jQuery);
;(function ($) {
  $.mshButtons = {
    addLoader: function (button) {
      /* Use timeout to prevent bug in IE-11
       * User couldn't go to order page from modal cart in
       * */
      setTimeout(function () {
        button.attr('disabled', 'disabled').find('[data-button-loader="loader"]').removeClass('hidden');
      }, 0);
    },
    removeLoader: function (button) {
      button.removeAttr('disabled').find('[data-button-loader="loader"]').addClass('hidden');
    }
  };
  
})(jQuery);
(function ($) {
  
  /**
   * polyfill for html5 form attr
   */
  // detect if browser supports this
  var sampleElement = $('[form]').get(0);
  var isIE11 = !(window.ActiveXObject) && "ActiveXObject" in window;
  if (sampleElement && window.HTMLFormElement && sampleElement.form instanceof HTMLFormElement && !isIE11) {
    // browser supports it, no need to fix
    return;
  }
  
  /**
   * Append a field to a form
   *
   */
  $.fn.appendField = function (data) {
    // for form only
    if (!this.is('form')) return;
    
    // wrap data
    if (!$.isArray(data) && data.name && data.value) {
      data = [data];
    }
    
    var $form = this;
    
    // attach new params
    $.each(data, function (i, item) {
      $('<input/>')
      .attr('type', 'hidden')
      .attr('name', item.name)
      .val(item.value).appendTo($form);
    });
    
    return $form;
  };
  
  /**
   * Find all input fields with form attribute point to jQuery object
   *
   */
  $('form[id]').submit(function (e) {
    var $form = $(this);
    // serialize data
    var data = $('[form=' + $form.attr('id') + ']').serializeArray();
    // append data to form
    $form.appendField(data);
  }).each(function () {
    var form = this,
      $form = $(form),
      $fields = $('[form=' + $form.attr('id') + ']');
    
    $fields.filter('button, input').filter('[type=reset],[type=submit]').click(function () {
      var type = this.type.toLowerCase();
      if (type === 'reset') {
        // reset form
        form.reset();
        // for elements outside form
        $fields.each(function () {
          this.value = this.defaultValue;
          this.checked = this.defaultChecked;
        }).filter('select').each(function () {
          $(this).find('option').each(function () {
            this.selected = this.defaultSelected;
          });
        });
      } else if (type.match(/^submit|image$/i)) {
        $(form).appendField({name: this.name, value: this.value}).submit();
      }
    });
  });
  
  
})(jQuery);


/**
 * SVG sprite IE polyfill
 */
(function () {
  svg4everybody();
})();
;(function ($) {
  
  var selectors = {
    scope: '[data-accordion-tabs]',
    item: '[data-accordion-tabs-item]',
    link: '[data-accordion-tabs-link]',
    content: '[data-accordion-tabs-content]'
  };

  var screenTabSize = 768;
  var tabAll = $(selectors.scope);
  var screenSize = $(window).width();
  var timerId;
  
  /**
   * Loop all tab components on the page
   * Set active state for first tab item
   */
  tabAll.each(function () {
    var $this = $(this);
    var firstTab = $this.find(selectors.item).first();
    
    firstTab.find(selectors.link).addClass('js-active');
    firstTab.find(selectors.content).addClass('js-open');
    
    $this.find('.js-init-active').removeClass('js-init-active');
  });
  
  
  /**
   * Tab click event handler.
   * Show tab content of current item and hide other on large screen
   */
  tabAll.on('click', selectors.link, function (event) {
    event.preventDefault();
    
    var tabContainer = $(event.delegateTarget);
    var tabLink = $(this);
    var tabCurrent = tabLink.closest(selectors.item)
    var currentTabHash = tabLink.attr('href').replace('#','');

    if (tabLink.hasClass('js-active') && screenSize > screenTabSize){
        return;
    }

    // Close on mobile
    if (screenSize < screenTabSize && tabLink.hasClass('js-active')){
        tabLink.removeClass('js-active');
        tabLink.next().toggleClass('js-open');

        return;
    }

    if (screenSize > screenTabSize){
        tabContainer.find('.js-open').removeClass('js-open');
        tabContainer.find('.js-active').removeClass('js-active');
    }

    tabLink.next().toggleClass('js-open');
    tabLink.addClass('js-active');
    tabContainer.find('.js-open').find('[data-slider-slides]').slick('setPosition');

    // Remove hash for first tab , first tab open by default
    if(tabCurrent.is(':first-child')){
        removeHash();
    } else {
        setHash(currentTabHash);
    }

    tabContainer.find('.slick-slider').slick('setPosition');
    
    $.mlsLazzyload.update();
  });
  
  /**
   * Activate tab when clicing on star rating reviews
   */
  $(document).on('click', '[data-product-reviews-link]', function (e) {
    var target = $('#product-reviews');

    if(target.length !== 0){
        e.preventDefault();

        // Prevent click if target open
        if(!target.hasClass('js-init-active') && !target.hasClass('js-active')){
            target.trigger('click');
        }

        scrollTo(target);
    }
  });

  $(window).on('resize', resizeHandler);

  $(window).on('load', hashOpen);

  $(window).on('hashchange', hashOpen);

  function convertToTabs() {
      var activeLinks = tabAll.find(selectors.link).filter('.js-active');
      if(activeLinks.length !== 1){
          tabAll.find(selectors.link).removeClass('js-active');
          tabAll.find(selectors.content).removeClass('js-open');

          var firstTab = tabAll.find(selectors.item).first();
          firstTab.find(selectors.link).addClass('js-active');
          firstTab.find(selectors.content).addClass('js-open');

          return;
      }
  }

  function hashOpen() {
      var hash = window.location.hash;
      var hahPrefix = '#tab=';

      if(hash.indexOf(hahPrefix) === -1){
          var tabLink = $(selectors.item).filter(':first-child').find(selectors.link);

          if(!tabLink.hasClass('js-active')){
              tabLink.trigger('click');
          }

          return;
      }

      var tabsItem = $('#' + hash.replace(hahPrefix,''));

      // Prevent click if target open
      if(!tabsItem.hasClass('js-init-active') && !tabsItem.hasClass('js-active')){
          scrollTo(tabsItem);

          tabsItem.trigger( "click" );
      }
  }

  function scrollTo(element){
      $('html, body').animate({scrollTop: element.offset().top}, 800);
  }

  function resizeHandler() {
      screenSize = $(window).width();
      if (screenSize > screenTabSize){
          clearTimeout(timerId);

          timerId = setTimeout(function () {
              convertToTabs();
          }, 500);
      }
  }

  function setHash(hash) {
      location.hash = 'tab=' + hash;
  }

  function removeHash() {
        history.pushState("", document.title, window.location.pathname + window.location.search);
  }

}(jQuery));
;(function ($) {
  
  var sliders = $('[data-slider="bargain"]');
  
  sliders.each(function () {
    
    var scope = $(this);
    var slides = $('[data-slider-slides]', scope).attr('data-slider-slides');
    
    $('[data-slider-slides]', scope).find('[data-slider-slide]').css('float', 'left').end().slick({
      dots: false,
      arrows: true,
      infinite: false,
      adaptiveHeight: true,
      slidesToShow: $.mlsSlider.getFirstCol(slides),
      autoplay: false,
      autoplaySpeed: 3000,
      swipeToSlide: true,
      mobileFirst: true,
      rows: 1,
      prevArrow: $('[data-slider-arrow-left]', scope).removeClass('hidden'),
      nextArrow: $('[data-slider-arrow-right]', scope).removeClass('hidden'),
      responsive: $.mlsSlider.getCols(slides)
    });
    
  });
  
})(jQuery);
;(function ($) {
  $(document).on('click', '[data-button-loader="button"]', function () {
    $(this).addClass('disabled');
    $.mshButtons.addLoader($(this));
  });
})(jQuery);
;
(function ($) {
  
  /**
   * Change "Add to Cart" to "View in Cart" when WP cache is on
   */
  $(document.body).on('wc_fragments_refreshed', function () {
    var fragments = JSON.parse(sessionStorage.getItem(wc_cart_fragments_params.fragment_name));
    var inCartIds = JSON.parse(fragments['[data-cart-products-fragment]']);
    
    $.mshProduct.setAddToCartState('visible', $('[data-product-variation]'));
    
    if (inCartIds.length < 1) {
      return;
    }
    
    var inCartItems = [];
    for (var item in inCartIds) {
      if (inCartIds.hasOwnProperty(item)) {
        inCartItems.push('[data-product-variation="' + item + '"]');
      }
    }
    var inCartSelector = inCartItems.join(',');
    
    $.mshProduct.setAddToCartState('hidden', $(inCartSelector));
  });
  
  /**
   * Open Cart in modal window after adding item to cart
   */
  $(document.body).on('added_to_cart', function (event, fragments, cart_hash, button) {
    if (typeof woocs_loading_first_time === 'undefined') {
      $.mlsCartModalInline(fragments['[data-cart-modal-fragment]']);
    } else {
      /* Magic if Woocommerce Currency switcher plugin is active */
      var openCartModal = function () {
        $.mlsCartModalInline(fragments['[data-cart-modal-fragment]']);
        $(document.body).off('wc_fragments_refreshed', openCartModal);
      };
      $(document.body).on('wc_fragments_refreshed', openCartModal);
    }
  });
  
  
  /**
   * Open cart in modal window
   */
  $(document.body).on('click', '[data-cart-modal]', function (e) {
      e.preventDefault();
    
      $.magnificPopup.open({
          items: {
              src: wc_cart_fragments_params.wc_ajax_url.toString().replace('%%endpoint%%', 'get_refreshed_fragments')
          },
          type: 'ajax',
          callbacks: {
              parseAjax: function (mfpResponse) {
                  mfpResponse.data = mfpResponse.data.fragments['[data-cart-modal-fragment]']
              },
              ajaxContentAdded: function () {
                  $(document).trigger('cart_modal_open');
              }
          },
          modal: false,
          showCloseBtn: false
      });
  });
  
  
  /**
   * Delete item from cart
   */
  $(document).on('click', '.remove_from_cart_button', function () {
    $.mlsAjax.preloaderShow({
      type: 'frame',
      frame: $('[data-cart-summary]')
    });
  });
  
  /**
   * Toggle "Add to cart" and "View in Cart" buttons on product item
   */
  /* Product has been added to cart */
  $(document.body).on('wc_cart_button_updated', function (event, $addToCartBtn) {
    var addedProductId = $addToCartBtn.closest('[data-product-variation]').attr('data-product-variation');
    var addedProducts = $('[data-product-variation="' + addedProductId + '"]');
    $.mshProduct.setAddToCartState('hidden', addedProducts);
  });
  
  /* Product has been removed to cart */
  $(document.body).on('removed_from_cart', function (event, fragment) {
    $.mshProduct.setAddToCartState('visible', findRemovedProducts(fragment['[data-cart-products-fragment]']));
    $(document.body).trigger('wc_fragment_refresh');
    $(document.body).trigger('update_checkout');
  });
  
  function findRemovedProducts(inCartIds) {
    var cartItems = JSON.parse(inCartIds);
    return $('.added_to_cart').not('.hidden').closest('[data-product-variation]').filter(function (index, item) {
      return !cartItems[$(item).attr('data-product-variation')];
    });
  }
  
  
  /**
   * Adjust request data before adding items to cart
   */
  $(document.body).on('adding_to_cart', function (event, button, data) {
    
    var wrapForm = button.closest('[data-loop-add-to-cart-form]');
    var separateForm = $(document.getElementById(button.attr('form')));
    
    var addToCartForm = ( wrapForm.length > 0 ) ? wrapForm : separateForm;
    
    addToCartForm.serializeArray().forEach(function (item) {
      data[item['name']] = item['value'];
    });
    
    /* Use WC_AJAX handler instead of default to add variation to cart */
    delete data['add-to-cart'];
    
    /* Variation product */
    if (Number(data['variation_id'])) {
      data['product_id'] = data['variation_id'];
    }
  });
  
  /**
   * Change cart product quantity on cart page
   */
  $(document).on('change', '[data-cart-summary-quantity]', function (e) {
    e.preventDefault();
    var quantityField = $(this);
    var form = quantityField.closest('.woocommerce-cart-form');
    var modalWindow = quantityField.closest('[data-cart-summary="modal"]');
    if (!modalWindow.length) {
      form.find('input[name="update_cart"]').attr('disabled', false).trigger('click');
    }
  });
  
  /**
   * Change product quantity on modal window
   */
  $(document).on('change', '[data-cart-summary="modal"] [data-cart-summary-quantity]', function (e) {
    
    var quantityField = $(this);
    var form = quantityField.closest('.woocommerce-cart-form');
    var max = quantityField.attr('max') ? quantityField.attr('max') : Infinity;
    var current = quantityField.val();
    
    if (current > max) {
      quantityField.val(max);
    }
    
    var params = form.serialize();
    
    $.ajax({
      url: form.attr('action'),
      type: 'post',
      data: params,
      beforeSend: function () {
        $.mlsAjax.preloaderShow({
          type: 'frame',
          frame: $('[data-cart-summary]')
        });
      },
      success: function () {
        $(document.body).trigger('wc_fragment_refresh');
        // update checkout on pag checkout
        $(document.body).trigger('update_checkout');
        // update cart totals on page cart
        $('select.shipping_method, input[name^=shipping_method]').first().trigger('change');
      }
    });
  });
  
  /**
   * update cart totals on page cart
   */
  $(document.body).on('removed_from_cart', function () {
    $('select.shipping_method, input[name^=shipping_method]').first().trigger('change');
  });
  
  
  /**
   * Cart coupone preloader
   */
  $(document).on('submit', '.woocommerce-cart-form', function (e) {
    e.preventDefault();
    $.mlsAjax.preloaderShow({
      type: 'frame',
      frame: $('[data-cart-frame-fragment]')
    });
  });

  /**
   * Removed last product from cart on page cart
   */
  $(document).on('removed_from_cart', function (event, fragments) {
    if (Object.keys(JSON.parse(fragments['[data-cart-products-fragment]'])).length === 0) {
      location.reload();
    }
  });
  
  /**
   * Add preloader to shipping block
   */
  $(document).on('update_checkout', function () {
    $('[data-checkout-shipping-fragments]').block({
      message: null,
      overlayCSS: {
        background: '#fff',
        opacity: 0.6
      }
    });
  });
  
})(jQuery);
;
(function ($) {
  /**
   * Change Catalog View
   */
  $(document).on('click', '[data-catalog-view-item]', function (e) {
    var cookieValue = $(this).attr('data-catalog-view-item');
  
    e.preventDefault();
    document.cookie = 'catalog_view=' + cookieValue + ';path=/';
    window.location.reload();
  });
  
  /**
   * Order form onchange
   */
  $(document).on('change', '[data-catalog-order-select]', function () {
    $('#catalog-form').submit();
    $('[form="catalog-form"]').attr('disabled', true);
  });
  /**
   * Per page form onchange
   */
  $(document).on('change', '[data-catalog-perpage-select]', function () {
    $('#catalog-form').submit();
    $('[form="catalog-form"]').attr('disabled', true);
  });
  
})(jQuery);
;(function () {
  var BREAKPOINT = 991;
  
  var catalog = document.querySelector('[data-catalog-btn]');
  var overlay = document.querySelector('[data-catalog-btn-overlay]');
  var subMenu = document.querySelector('[data-catalog-btn-menu]');
  
  var subMenuHiddenClass = "is-hidden";
  
  
  if (!subMenu) return;
  
  function showMenu() {
    subMenu.classList.remove(subMenuHiddenClass);
    overlay.classList.remove('hidden');
  }
  
  function closeMenu() {
    subMenu.classList.add(subMenuHiddenClass);
    overlay.classList.add('hidden');
  }
  
  function toggleMenu() {
    subMenu.classList.toggle(subMenuHiddenClass);
    overlay.classList.toggle('hidden');
  }
  
  catalog.addEventListener('click', function () {
    toggleMenu();
  });
  
  overlay.addEventListener('click', function () {
    closeMenu();
  });
  
  function resizeHandler(breakpoint) {
    var width = window.innerWidth;
    
    if (width < breakpoint) {
      closeMenu();
    }
  }
  
  var resizeID = null;
  window.addEventListener("resize", function () {
    clearTimeout(resizeID);
    resizeID = setTimeout(resizeHandler.bind(null, BREAKPOINT), 300);
    
  });
  
})();
;
(function ($) {
  /**
   * Adding new comment
   */
  $(document).on('submit', '[data-comments-form]', function (e) {
        e.preventDefault();

        var form = $(this);
        var context = form.closest('[data-comments]');
        var formType = form.attr('data-comments-form');
        var currentForm = '[data-comments-form="' + formType + '"]';
        var successMessage = currentForm + ' [data-comments-success]';
        var errorMessageFrame = currentForm + ' [data-comments-error-frame]';
        var errorMessageList = currentForm + ' [data-comments-error-list]';

        /* Request to submit form */
        $.ajax({
            url: form.attr('data-comments-form-url'),
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function () {
                /* Show loader before ajax response */
                $.mlsAjax.preloaderShow({
                    type: 'frame',
                    frame: context
                });
            },
            success: function (data) {
                if (data.answer == 'error') {
                    /* Error Message */
                    context.find(successMessage).addClass('hidden');
                    context.find(errorMessageList).html(data.validation_errors);
                    context.find(errorMessageFrame).removeClass('hidden');
                    /* Change captcha image */
                    context.find(currentForm + ' [data-captcha-img]').html(data.cap_image);
                } else {
                    /* Request to update comments list*/
                    $.ajax({
                        url: form.attr('data-comments-form-list-url'),
                        method: 'post',
                        dataType: 'json',
                        success: function (data) {
                            /* Insert response into document */
                            context.html(data.comments);
                            /* Success Message */
                            context.find(errorMessageFrame).addClass('hidden');
                            context.find(successMessage).removeClass('hidden');
                        }
                    });
                }
            }
        });
    });
  
  /**
   * Reply for existing comment
   */
  $(document).on('click', '[data-comments-reply-link]', function (e) {
    e.preventDefault();
    
    var replyLink = $(this);
    var url = replyLink.attr('data-comments-reply-link');
    var parentComment = replyLink.closest('[data-comments-post]');
    var placeholder = parentComment.find('[data-comments-reply-form-placeholder]').first();
    var parentId = replyLink.attr('data-comments-reply-parent-id');
    var is_replay_form = placeholder.find('[data-comments-reply-form]').length;
    
    if (is_replay_form) {
      placeholder.toggleClass('hidden');
    } else {
      $.ajax({
        url: url,
        type: 'get',
        beforeSend: function () {
          $.mlsAjax.preloaderShow({
            type: 'frame',
            frame: parentComment
          });
        },
        success: function (responseData) {
          var responseDOM = $(responseData);
          responseDOM.find('form').removeAttr('novalidate');
          
          placeholder.removeClass('hidden');
          
          responseDOM.find('#comment_parent').attr('value', parentId);
          placeholder.html(responseDOM);
        }
      });
    }
  });
  
  /**
   * Rate comment
   */
  $(document).on('click', '[data-comments-vote-url]', function (e) {
    e.preventDefault();
    
    var voteLink = $(this);
    var href = voteLink.attr('data-comments-vote-url');
    var commentId = voteLink.closest('[data-comments-post]').attr('data-comments-post');
    var voteValue = voteLink.find('[data-comments-vote-value]');
    
    $.ajax({
      url: href,
      type: 'post',
      data: {comid: commentId},
      dataType: 'json',
      success: function (data) {
        voteValue.html(data.y_count ? data.y_count : data.n_count);
      }
    });
  });
  
})(jQuery);
;
(function ($) {
  
  /**
   * Add to compare button and change total items in compare
   * scope - "add_to"
   */
  $(document).on('click', '[data-add-to-compare-btn="add"]', function (e) {

        e.preventDefault();
        var button = $(this);
        var scope = button.closest('[data-add-to-compare]');
        var params = JSON.parse(scope.find('[data-add-to-compare-data]').attr('data-add-to-compare-data'));

        $.ajax({
            url: params.url,
            type: 'post',
            data: params,
            beforeSend: function () {
                if(button.attr('data-add-to-compare-btn-type') === 'link'){
                    $.mlsAjax.preloaderShow({
                        type: 'text',
                        frame: button
                    });
                }
            },
            success: function () {
                scope.find('[data-add-to-compare-btn]').toggleClass('hidden');
                $(document.body).trigger('wc_fragment_refresh');

            }
        });

    });

    /**
     * Delete item or list
     */
    $(document).on('click', '[data-compare-delete-button]', function () {
        $.mlsCart.clearFragments();
    });
})(jQuery);
(function ($) {
  $.mlsTime.countdown.init({
    scope: '[data-countdown]',
    item: '[data-countdown-item]',
    expireDateAttribute: 'data-countdown'
  });
})(jQuery);
/* Ajax form submit */
(function ($) {
  
  $(document).on('submit', '[data-form-ajax]', function (e) {
    e.preventDefault();
    
    var target = $(this);
    
    //frames in which response data will be inputted
    var responseFrame = $('[data-form-ajax="' + target.attr('data-form-ajax') + '"]');
    
    $.ajax({
      url: target.attr('action'),
      type: target.attr('method') ? target.attr('method') : 'get',
      data: target.serialize(),
      beforeSend: function () {
        /* Loader visible before ajax response */
        $.mlsAjax.preloaderShow({
          type: 'frame',
          frame: target
        });
      },
      success: function (data) {
        /* Insert response into document */
        $.mlsAjax.loadResponseFrame(data, responseFrame);
        
        /* Grab extra data from response frame and insert it into remote places */
        $.mlsAjax.transferData(data);
      }
    });
    
  });
  
  $(document).on('change', '[data-form-self-submit]', function () {
    var formControl = $(this);
    formControl.closest('form').submit();
    formControl.attr('disabled', true);
  });
  
  $(function(){
    $('#comment_form').removeAttr('novalidate');
  });
  
})(jQuery);
;
(function ($) {
    
    $('.gallery').magnificPopup({
        delegate: ".gallery-icon a[href*='wp-content/uploads'], .gallery-icon a[href*='/gallery/']",
        type: "image",
        gallery: {
            enabled: true,
            tCounter: '%curr% of %total%'
        },
        overflowY: "hidden"
    });
})(jQuery);
;
(function ($) {
  
  /**
   * Open modal window
   */
  $(document).on('click', '[data-modal]', function (e) {
    e.preventDefault();
    
    var $this = $(this);
    var modalUrl = $this.data('modal');
    modalUrl = modalUrl ? modalUrl : $this.attr('href');
    
    $.mlsModal({
      src: modalUrl
    });
    
  });
  
  
  /**
   * Close modal window
   */
  $(document).on('click', '[data-modal-close]', function (e) {
    e.preventDefault();
    $.magnificPopup.close();
  });
  
})(jQuery);
;
(function ($) {
  /**
   * Tree navigation menu
   * Right to left direction if menu doesn't fit to window size
   **/
  
  /**
   * global mlsMegamenu
   */
  $('[data-nav-hover-item]').on('mouseenter', function () {
    
    var dropList = this.querySelectorAll('[data-nav-direction]');
    var windowWidth = document.documentElement.clientWidth;
    var remoteItemPos = windowWidth;
    
    /* find max right coordinate among all drop-down menus within current hover item */
    for (var i = 0; i < dropList.length; i++) {
      var dropItem = dropList[i];
      dropItem.setAttribute('data-nav-direction', 'ltr');
      var itemPos = dropItem.getBoundingClientRect().right;
      remoteItemPos = itemPos > windowWidth ? itemPos : remoteItemPos;
    }
    
    /* apply right direction if max right coordinate is bigger then window width */
    if (remoteItemPos > windowWidth) {
      for (var j = 0; j < dropList.length; j++) {
        dropList[j].setAttribute('data-nav-direction', 'rtl');
      }
    }
    
  });
  
  /**
   * Mega menu
   * Make menu fit to container width
   **/
  var verticalMenu = document.querySelectorAll('[data-megamenu-vertical]');
  var horizontalMenu = document.querySelectorAll('[data-megamenu-horizontal]');
  
  if (horizontalMenu !== null) {
    
      Array.prototype.forEach.call(horizontalMenu, function(menu){
          mlsMegamenu.renderCols(menu);
          mlsMegamenu.fitHorizontal({
              scope: '[data-megamenu-horizontal]',
              items: '[data-megamenu-item]',
              wrap: '[data-megamenu-wrap]'
          });
      });
    
  }
  
  if (verticalMenu !== null) {
    
      Array.prototype.forEach.call(verticalMenu, function(menu){
        
          mlsMegamenu.renderCols(menu);
          mlsMegamenu.equalHeight(menu, menu.querySelector('[data-megamenu-wrap]'));
          mlsMegamenu.fitContainer({
              container: document.querySelector('[data-megamenu-container]'),
              wrap: menu.querySelector('[data-megamenu-wrap]'),
              indent: document.querySelector('[data-megamenu-vertical]')
          });
      });
    
  }
})(jQuery);
;
(function ($) {

	/* global woocommerce_params */

	/**
	 * Change image on reset data
	 */
	$(document).on('reset_data', '.variations_form', function () {

		var product = $(this).closest('[data-product]');

		/* Set data for single product image gallery */
		var gallery = product.find('[data-product-photo-scope]');
		var productPhoto = gallery.find('[data-product-photo]');
		var mainImageSrc = productPhoto.attr('src');
		var originImageSrc = productPhoto.attr('data-product-photo-origin');

		/* Break if image didn't change */
		if (mainImageSrc !== originImageSrc) {
			/* Change main image */
			if (originImageSrc) {
				productPhoto.attr('src', originImageSrc);
				productPhoto.closest('[data-product-photo-link]').attr('href', originImageSrc);
			} else {
				productPhoto.attr('src', productPhoto.attr('data-src-placeholder'));
				productPhoto.closest('[data-product-photo-link]').attr('href', '');
			}

			/* Set default sku */
			var skuContainer = $.mshProduct.findOne(product, '[data-product-sku]');
			skuContainer.html(skuContainer.attr('data-default-sku'));


			/* Change first thumbnail */
			gallery.find('[data-product-photo-main-thumb]').each(function () {
				gallery.find('[data-product-photo-thumb]').removeAttr('data-product-photo-thumb-active');
				$(this).attr('src', originImageSrc)
						.closest('[data-product-photo-thumb]')
						.attr('href', originImageSrc)
						.attr('data-product-photo-thumb', originImageSrc)
						.attr('data-product-photo-thumb-active', '');
			});

			/* Change cloud zoom */
			gallery.find('[data-zoom-image]').each(function () {
				$(this).attr('data-zoom-image-url', originImageSrc);
				$.mlsMedia.zoomImage();
			});
		}
		/* Reinit magnific popup */
		$.mlsMedia.magnificGalley();

	});

	$(document).on('reset_data', '.variations_form', function () {

		var product = $(this).closest('[data-product]');

        /**
         * Hide status
         */
		$.mshProduct.findOne(product, '[data-product-availability-html]').addClass('hidden');
        /**
		 * Hide countdown timer
         */
        $.mshProduct.findOne(product, '[data-product-single-action-counter]').remove();
	});

	/**
	 * Handle change variation on single product and loop product
	 */
	$(document).on('show_variation', '.single_variation', function (event, variation, purchasable) {

		var product = $(this).closest('[data-product]');

		if (!variation) {
			$.mshProduct.findOne(product, 'input[name="variation_id"]').val(0);
			$.mshProduct.findOne(product, '.add_to_cart_button').removeClass('ajax_add_to_cart').addClass('disabled');
			return;
		}

		$(this).closest('.variations_form').find('[data-product-availability-html]').removeClass('hidden');

		$.mshProduct.findOne(product, '[data-product-loop-action-counter]').remove();

		if (variation.end_date && variation.end_date !== '') {

			$(variation.end_date).appendTo($.mshProduct.findOne(product, '[data-loop-before-title]'));
		}

		$.mshProduct.findOne(product, '[data-product-single-action-counter]').remove();


		if (variation.end_single_date && variation.end_single_date !== '') {

			$(variation.end_single_date).appendTo($.mshProduct.findOne(product, '[data-single-after-add-to-cart]'));

			$.mlsTime.countdown.init({
				scope: '[data-countdown]',
				item: '[data-countdown-item]',
				expireDateAttribute: 'data-countdown'
			});
		}

		product.attr('data-product-variation', variation.variation_id);

		$.mshProduct.findOne(product, '[data-product-permalink]').attr('href', variation.permalink).html(variation.variation_name);
		$.mshProduct.findOne(product, '[data-product-photo-permalink]').attr('href', variation.permalink);


		$.mshProduct.findOne(product, '.add_to_cart_button').attr('href', variation.add_to_cart_url);

		$.mshProduct.findOne(product, '[data-product-add-to-cart-text]').html(variation.add_to_cart_text);

		$.mshProduct.findOne(product, 'input[name="variation_id"]').val(variation.variation_id);

		if (purchasable) {
			$.mshProduct.findOne(product, '.add_to_cart_button').addClass('ajax_add_to_cart').removeClass('disabled');
		} else {
			$.mshProduct.findOne(product, '.add_to_cart_button').removeClass('ajax_add_to_cart').addClass('disabled');
		}

		var discount = Math.round(((variation.display_regular_price - variation.display_price) / variation.display_regular_price) * 100);
		if (discount > 0) {
			$.mshProduct.findOne(product, '[data-product-discount-percent]').removeClass('hidden');
			$.mshProduct.findOne(product, '[data-product-discount-percent-value]').html(discount);
		} else {
			$.mshProduct.findOne(product, '[data-product-discount-percent]').addClass('hidden');
		}


		$.mshProduct.findOne(product, '[data-product-medium-photo]').removeAttr('srcset', false);

		if (variation.image.medium_src) {
			$.mshProduct.findOne(product, '[data-product-medium-photo]').attr('src', variation.image.medium_src);
		} else {
			$.mshProduct.findOne(product, '[data-product-medium-photo]').attr('src', $.mshProduct.findOne(product, '[data-product-medium-photo]').attr('data-src-placeholder'));
		}

		if (variation.image.thumb_src) {
			$.mshProduct.findOne(product, '[data-product-thumbnail]').attr('src', variation.image.thumb_src);
		} else {
			$.mshProduct.findOne(product, '[data-product-thumbnail]').attr('src', $.mshProduct.findOne(product, '[data-product-medium-photo]').attr('data-src-placeholder'));
		}

		$.mshProduct.findOne(product, '[data-product-price]').html(variation.price_html);

		$.mshProduct.findOne(product, '[data-product-availability-html]').html(variation.availability_html);
		$.mshProduct.findOne(product, '[data-product-variation-description]').html(variation.variation_description);


		if (variation.in_cart) {
			$.mshProduct.setAddToCartState('hidden', product);
		} else {
			$.mshProduct.setAddToCartState('visible', product);
		}

		var skuContainer = $.mshProduct.findOne(product, '[data-product-sku]');
		if (variation.sku) {
			var originalSku = skuContainer.text();
			if (typeof skuContainer.attr('data-default-sku') === "undefined") {
				skuContainer.attr('data-default-sku', originalSku);
			}

			$.mshProduct.findOne(product, '[data-product-sku]').html(variation.sku);
		} else {
			skuContainer.text(skuContainer.attr('data-default-sku'));
		}

		/* Set data for single product image gallery */
		var gallery = product.find('[data-product-photo-scope]');
		var mainImageSrc = gallery.find('[data-product-photo]').attr('src');
		var productPhoto = gallery.find('[data-product-photo]');

		/* Break if image didn't change */
		if (mainImageSrc === variation.image.src) {
			return;
		}

		/* Change main image */
		if (variation.image.src) {
			productPhoto.attr('src', variation.image.src);
			productPhoto.closest('[data-product-photo-link]').attr('href', variation.image.full_src);
		} else {
			productPhoto.attr('src', productPhoto.attr('data-src-placeholder'));
			productPhoto.closest('[data-product-photo-link]').attr('href', '');
		}

		/* Change first thumbnail */
		gallery.find('[data-product-photo-main-thumb]').each(function () {
			gallery.find('[data-product-photo-thumb]').removeAttr('data-product-photo-thumb-active');
			$(this).attr('src', variation.image.thumb_src)
					.closest('[data-product-photo-thumb]')
					.attr('href', variation.image.full_src)
					.attr('data-product-photo-thumb', variation.image.src)
					.attr('data-product-photo-thumb-active', '');
		});

		/* Change cloud zoom */
		gallery.find('[data-zoom-image]').each(function () {
			$(this).attr('data-zoom-image-url', variation.image.full_src);
			$.mlsMedia.zoomImage();
		});

		/* Reinit magnific popup */
		$.mlsMedia.magnificGalley();
	});

	$(document).on('hide_variation', '.single_variation', function () {
		var product = $(this).closest('[data-product]');
		$.mshProduct.findOne(product, '.add_to_cart_button').removeClass('ajax_add_to_cart');
	});

})(jQuery);
;
(function ($) {
  $(document).on('submit', '[data-profile-ajax="login_form"]', function (e) {
    e.preventDefault();
    
    var form = $(this);
    
    $.ajax({
      url: form.attr('action'),
      type: form.attr('method') ? form.attr('method') : 'get',
      data: form.serialize(),
      beforeSend: function () {
        /* Submit button ico loader */
        $.mlsAjax.preloaderShow({
          type: 'frame',
          frame: form
        });
      },
      success: function (data) {
        
        //* If authentification was successful show loading button and redierct to current page */
        if ($(data).find('[data-profile-ajax-form--notices]').length === 0) {
          $.mshButtons.addLoader(form.find('[data-profile-button]'));
          // insert user name intro validation success message
          form.find('[data-profile-ajax-form--user-name]').html(form.find('input[name="username"]').val());
          form.find('[data-profile-ajax-form--content] , [data-profile-ajax-form--success-message]').toggleClass('hidden');
          location.assign(location.href);
        } else {
          /* Grab extra data from response frame and insert it into remote places */
          $.mlsAjax.transferData(data, form);
        }
        
      }
    });
    
  });
})(jQuery);
;
(function ($) {

  var pushy = $('[ data-page-pushy-mobile]'), //menu css class
      container = $('[ data-page-pushy-container]'), //container css class
      siteOverlay = $('[data-page-pushy-overlay]'), //site overlay
      html = $('html'),
      pushyClass = "page__mobile--js-open", //menu position & menu open class
      containerClass = "page__body--js-pushed", //container open class
      menuBtn = $('[data-page-mobile-btn]'), //css classes to toggle the menu
      touchstartCoordY,
      touchmoveCoordY;

  /**
   * Open mobile frame when clicking site mobile button
   */
  menuBtn.on('click', togglePushy);

  /**
   * close mobile frame when clicking site overlay
   */
  siteOverlay.on('click', togglePushy);

  /**
   * Prevent overlay scrolling
   */
  siteOverlay.on('touchmove', function (event) {
      event.preventDefault();
  });


  pushy.on('touchstart', trackTouchStart);

  pushy.on('touchmove', trackScroll);


  /**
   * Track start position
   * @param event
   */
  function trackTouchStart(event) {
    touchstartCoordY = event.originalEvent.changedTouches[0].clientY;
  }

  /**
   * Track touchmove
   * Disable out scrolling , track scroll positions and if the menu is scroll to the end, we are cancel the scrolling event
   * @param event
   */
  function trackScroll(event) {
    touchmoveCoordY = event.originalEvent.changedTouches[0].clientY;

    var listElement = $('[data-mobile-nav-list]:not(.hidden):not(.mobile-nav__list--is-moving)');
    var scrollBarFullHeight = listElement.get(0).scrollHeight;
    var scrollBarHeight = listElement.height();
    var scrollOffsetTop = listElement.scrollTop();
    var bottom = (scrollBarFullHeight - scrollBarHeight) - scrollOffsetTop;

    // cancel top scrolling
    if(touchstartCoordY < touchmoveCoordY && scrollOffsetTop === 0){
        event.preventDefault();
    }

    // cancel bottom scrolling
    if(touchmoveCoordY < touchstartCoordY && bottom === 0){
        event.preventDefault();
    }
  }

  /**
   * Toogle mobile menu
   */
  function togglePushy() {
      siteOverlay.toggleClass('hidden'); //toggle site overlay
      pushy.toggleClass(pushyClass);
      container.toggleClass(containerClass);
      menuBtn.toggleClass('hidden');
      html.toggleClass('html--js-pushed');
  }
  
})(jQuery);
;
(function ($) {
  var searchOverlay = {
    showSearch: function () {
      
      var $scope = $(this).closest('[data-search-overlay-scope]');
      var $overlay = $scope.find('[data-search-overlay-overlay]');
      var $search = $scope.find('[data-search-overlay-search]');
      
      $overlay.removeClass('hidden');
      $search.removeClass('hidden');
    },
    
    hideSearch: function () {
      
      var $scope = $(this).closest('[data-search-overlay-scope]');
      var $overlay = $scope.find('[data-search-overlay-overlay]');
      var $search = $scope.find('[data-search-overlay-search]');
      
      $overlay.addClass('hidden');
      $search.addClass('hidden');
    }
  };
  
  /* Show search input and overlay if search button is clicked*/
  $(document).on('click', '[data-search-overlay-btn]', searchOverlay.showSearch);
  
  /* Hide search input and overlay if overlay clicked*/
  $(document).on('click', '[data-search-overlay-overlay]', searchOverlay.hideSearch);
  
  /* Hide search if Esc button is pressed*/
  $(document).on('keyup', function (e) {
    if (e.keyCode == 27) {
      searchOverlay.hideSearch();
    }
  });
  
})(jQuery);
;(function ($) {
  
  var selectors = {
    scope: '[data-pc-tab-scope]',
    link: '[data-pc-tab-target]',
    content: '[data-pc-tab-content]'
  };

  $('[data-pc-tab-scope] [data-pc-tab-target]').removeClass('js-init-active');
  $('[data-pc-tab-scope] [data-pc-tab-target]').first().addClass('is-active');

  $(document).on('click', selectors.link, function (e) {
      e.preventDefault();

    var $this = $(this);
    var target = $this.next();
    var scope = $this.closest(selectors.scope);
    var container = $('[data-pc-tab-content="'+ target +'"]', scope);
    
    $(selectors.link, scope).removeClass('is-active');
    $this.addClass('is-active');
  
    $(selectors.content, scope).removeClass('is-active');
    container.addClass('is-active');
  
    container.find('.slick-slider').slick('setPosition');
  });
  
})(jQuery);
;
(function ($) {
  
  /**
   * Focusing text field if relative radio is checked
   */
  $(document).on('click', '[data-premmerce-wishlist-new-input]', function () {
    var radioNew = $(this).closest('[data-wishlist-new-scope]').find('[data-premmerce-wishlist-new-radio]');
    $(radioNew).trigger('click');
  });
  
  $(document).on('click', '[data-premmerce-wishlist-new-radio]', function () {
    var inputNew = $(this).closest('[data-wishlist-new-scope]').find('[data-premmerce-wishlist-new-input]');
    $(inputNew).trigger('focus');
  });
  
  /**
   * Add to wishlist form
   */
  $(document).on('submit', '[data-premmerce-wishlist-ajax]', function (e) {
    e.preventDefault();
    
    var form = $(this);
    var responceFrame = $('[data-premmerce-wishlist-ajax]');
    
    $.ajax({
      url: form.attr('action'),
      type: form.attr('method') ? form.attr('method') : 'get',
      data: form.serialize(),
      dataType: 'json',
      beforeSend: function () {
        
        $.mlsAjax.preloaderShow({
          type: 'frame',
          frame: form
        });
        
      },
      success: function (data) {
        if (data.reload) {
          location.reload();
          
          return
        }
        
        $.mlsAjax.loadResponseFrame(data.html, responceFrame);
        
        $.mlsAjax.transferData(data.html);
        
        $(document.body).trigger('wc_fragment_refresh');
      }
    });
    
  });
  
  /**
   * Open wishlist modal
   */
  $(document).on('click', '[data-premmerce-wishlist-edit-modal]', function () {
    event.preventDefault();
    
    var button = $(this);
    var url = button.attr('data-premmerce-wishlist-edit-modal--url');
    
    $.mlsModal({
      src: url
    });
    
  });
  
  /**
   * Delete item or list
   */
  $(document).on('click', '[data-premmerce-wishlist-delete-button]', function () {
    $.mlsCart.clearFragments();
  });
  
})(jQuery);
;(function ($) {
  
  /* Remove ajax loader */
  $(document).on('ajaxStop', function () {
    $.mlsAjax.preloaderHide();
  });
  
  /* Hover to click on touch devices. Double click to link */
  $('[data-global-doubletap]').doubleTapToGo();
  
  $(document).on('click', '[data-onclick-clear-fragments]', function () {
      $.mlsCart.clearFragments();
  });
  
})(jQuery);
;(function ($) {
  
  $('[data-slider="banner-simple"]').each(function () {
    
    var el = $(this);
    
    el.find('[data-slider-slides]').removeAttr('data-slider-nojs').slick({
      adaptiveHeight: false,
      slidesToShow: 1,
      dots: el.data('dots'),
      arrows: el.data('arrows'),
      speed: el.data('speed'),
      autoplay: el.data('autoplay'),
      autoplaySpeed: el.data('autoplayspeed'),
      fade: el.data('fade'),
      infinite: el.data('infinite'),
      prevArrow: el.find('[data-slider-arrow-left]').removeClass('hidden'),
      nextArrow: el.find('[data-slider-arrow-right]').removeClass('hidden'),
      responsive: [
        {
          breakpoint: 992,
          settings: {
            dots: false
          }
        }
      ]
    });
    
  });
  
})(jQuery);
;(function ($) {
  
  var scope = $('[data-slider="mainpage-brands"]');
  var slides = $('[data-slider-slides]', scope).attr('data-slider-slides');
  
  $('[data-slider-slides]', scope).find('[data-slider-slide]').css('float', 'left').end().slick({
    dots: false,
    arrows: true,
    adaptiveHeight: false,
    slidesToShow: $.mlsSlider.getFirstCol(slides),
    autoplay: false,
    autoplaySpeed: 3000,
    swipeToSlide: true,
    mobileFirst: true,
    prevArrow: $('[data-slider-arrow-left]', scope).removeClass('hidden'),
    nextArrow: $('[data-slider-arrow-right]', scope).removeClass('hidden'),
    responsive: $.mlsSlider.getCols(slides)
  });
  
})(jQuery);
;
(function ($) {
  function crossSellsSlider() {
    $('[data-slider="cross-sells"]').each(function () {
      
      var scope = $(this);
      var slider = scope.find('[data-slider-slides]');
      var responsiveCols = slider.attr('data-slider-slides');
      
      /* Exit if slider is already initialized after Ajax request */
      if (typeof event !== 'undefined' && event.type === 'ajaxComplete' && slider.hasClass('slick-initialized')) {
        return;
      }
      
      slider.slick({
        dots: false,
        arrows: true,
        infinite: false,
        adaptiveHeight: true,
        slidesToShow: $.mlsSlider.getFirstCol(responsiveCols),
        autoplay: false,
        autoplaySpeed: 3000,
        swipeToSlide: true,
        mobileFirst: true,
        rows: 1,
        prevArrow: scope.find('[data-slider-arrow-left]').removeClass('hidden'),
        nextArrow: scope.find('[data-slider-arrow-right]').removeClass('hidden'),
        responsive: $.mlsSlider.getCols(responsiveCols)
      });
    });
  }
  
  $(document).on('ajaxComplete', crossSellsSlider);
  
  crossSellsSlider();
  
})(jQuery);
(function ($) {
    $(document).on('change','[data-payments-radio--control]', function () {
        var $this = $(this);
        var btnPay = $('#place_order');
        var btnPaymentCustomText = $this.attr('data-order_button_text');

        if(btnPaymentCustomText.length > 0){
            btnPay.val(btnPaymentCustomText);
        } else {
            btnPay.val(btnPay.attr('data-value'));
        }

    });
})(jQuery);
jQuery(function ($) {

    /**
     * Reinit after filter updated
     */
    $(document).on('premmerce-filter-updated', function () {

        $( '.variations_form' ).each( function() {
            $( this ).wc_variation_form();
        });

    });

});
(function ($) {
  
  var selector = {
    btn: '[data-load-more-product--button]',
    container: '[data-load-more-product--container]',
    pagination: '[data-load-more-product--pagination]',
    next: '.next.page-numbers',
    totals: '[data-load-more-product--result-count]'
  };
  
  function LoadMore() {
    
    $(document).on('click', selector.btn, this.loadMorebtnClickHandler.bind(this));
    //AJAX pagination
    //$(document).on('click','.page-numbers:not(.current)', this.paginationHandler.bind(this));
    
  }
  
  LoadMore.prototype.loadMorebtnClickHandler = function (e) {
    e.preventDefault();
    
    var button = $(e.target).closest(selector.btn);
    var href = $(selector.next).attr('href');
    
    this.loadProduct(href);
    
    if (typeof this.pageStartNumber === 'undefined') {
      this.pageStartNumber = button.attr('data-load-more-product-current-page');
    }
  };
  
  LoadMore.prototype.btnBeforeSend = function () {
    // add preloader
    this.btnAddLoader($(selector.btn));
  };
  
  LoadMore.prototype.btnAddLoader = function (button) {
    
    setTimeout(function () {
      button.attr('disabled', 'disabled').addClass('is-active');
    }, 0);
  };
  
  LoadMore.prototype.btnRemoveLoader = function (button) {
    $.mshButtons.removeLoader(button);
  };
  
  LoadMore.prototype.btnUpdateState = function (data) {
    if (!data.has_next_page) {
      $(selector.btn).addClass('hidden');
    }
  };
  
  LoadMore.prototype.successHandler = function (data) {
    
    this.currentPage = data.current_page;
    
    // append products
    // append pagination
    this.updateHtml(data);
    
    // remove preloader
    // unblock the button
    this.btnRemoveLoader($(selector.btn));
    
    // hide button if no more products
    this.btnUpdateState(data);
    
    // show more on scroll
  };
  
  LoadMore.prototype.updateHtml = function (data) {
    var productScope = $(selector.container).append(data.products);

    $.mlsLazzyload.init(productScope);

    // reinit variation
    $( '.variations_form' ).each( function() {
			$( this ).wc_variation_form();
		});

    $(selector.pagination).replaceWith(
      this.updatePagination(data.pagination)
    );
    
    $(selector.totals).replaceWith(data.resultCount);
  };
  
  LoadMore.prototype.updatePagination = function (pagination) {
    
    var pageStartNumber = this.pageStartNumber;
    var currentPage = this.currentPage;

    pagination = $(pagination);
    
    pagination.find('.page-numbers').each(function () {
      
      var paginateItem = $(this);
      var thisNumber = parseInt(paginateItem.text());
      
      if (!isNaN(thisNumber) && thisNumber >= pageStartNumber && thisNumber <= currentPage) {
        paginateItem.addClass('current');
      }
      
    });
    
    return pagination;
  };
  
  LoadMore.prototype.loadProduct = function (url) {
    
    $.ajax({
      url: url,
      type: 'get',
      data: {
        ajaxCatalog: true
      },
      beforeSend: this.btnBeforeSend.bind(this),
      success: this.successHandler.bind(this)
    })
    
  };
  
  LoadMore.prototype.paginationHandler = function (e) {
    e.preventDefault();
    
    var href = $(e.target).attr('href');
    
    this.loadProduct(href);
    
  };
  
  new LoadMore();
  
  
})(jQuery);
;( function( $, window, document, undefined ) {

    "use strict";

    // Create the defaults once
    var pluginName = "productQuantity",
        defaults = {
            control: '[data-quantity-control]',
            input: '[data-quantity-field]',
            checkNotNumberReg: /[\D]/g,
            checkNotNumberFloatReg: /[^\d\.]/g,
            decimalSeparatorReg: /[.]/g,
            tooltipTimeout: 3000
        };

    // The actual plugin constructor
    function Plugin ( element, options ) {
        this.element = element;

        this.settings = $.extend( {}, defaults, options );

        this.settings.validationMessage = $(this.element).data('product-quantity');

        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    // Avoid Plugin.prototype conflicts
    $.extend( Plugin.prototype, {
        init: function() {

            this.input = $(this.element).find(this.settings.input);

            $(this.element).find(this.settings.control).on('click', $.proxy(this.changeQuantity,this));
            $(this.input).on('input', $.proxy(this.inputHandler, this));
            $(this.input).on('keypress', $.proxy(this.keypressHandler, this));

            this.tooltip = $('<div/>',{
                class: 'quantity__tooltip',
                text: 'Maximum quantity is 5'
            }).appendTo($(this.element));

            var input = $(this.input);
            var step = input.data('quantity-step');
            var toFixed = String(step).substring(String(step).indexOf('.')).length - 1;
            this.settings.float = toFixed !== 0;

        },
        changeQuantity: function( e ) {
            e.preventDefault();

            var scope = $(this.element);
            var button = $(e.target);
            //text field element and value
            var textField = scope.find('[data-quantity-field]');

            var currentValue = Number(textField.val().replace(',', '.'));
            // "+" and "-" controls
            var currentControl = $(button).attr('data-quantity-control');
            //amount on which value should increase or decrease
            var step = scope.find('[data-quantity-step]').attr('data-quantity-step');
            var stepValue = (Boolean(step) !== false) ? Number(step.replace(',', '.')) : 1;

            var newValue;

            //Calculating result value depending on "+" or "-" button was clicked
            if (currentControl === 'minus') {
                newValue = currentValue - stepValue;
            }
            if (currentControl === 'plus') {
                newValue = currentValue + stepValue;
            }

            var validatedValue = this.validateInput(newValue);

            // if value pass the validation we triggered change for other scripts
            if(validatedValue !== currentValue){
                textField.trigger('change');
            }
        },
        keypressHandler: function(e){
            e = e || event;
            var chr = this.getChar(e);
            var onlyNumber = this.settings.validationMessage.onlyNumber;
            var decimalSeparatorReg = this.settings.decimalSeparatorReg;
            var inputVal = $(this.input).val();
            var checkNotNumberReg;

            if(this.settings.float){
                checkNotNumberReg = this.settings.checkNotNumberFloatReg;
            } else {
                checkNotNumberReg = this.settings.checkNotNumberReg;
            }

            if (e.ctrlKey || e.altKey || chr == null){
                this.showMessage(onlyNumber);
                return false;
            }

            if (checkNotNumberReg.test(chr)){
                this.showMessage(onlyNumber);
                return false;
            }

            if(inputVal.match(decimalSeparatorReg) && !/[\d]/.test(chr)){
                this.showMessage(onlyNumber);
                return false;
            }

        },
        inputHandler: function(e){
            var input = $(this.input);
            var value = input.val();

            return this.validateInput(value);

        },
        validateInput: function (nextValue) {

            var input = $(this.input);
            var max = input.data('quantity-max') || Infinity;
            var min = input.data('quantity-min') || -Infinity;
            var maxMessage = this.settings.validationMessage.max;
            var minMessage = this.settings.validationMessage.min;
            var onlyNumber = this.settings.validationMessage.onlyNumber;
            var checkNotNumberReg;

            if(this.settings.float){
                checkNotNumberReg = this.settings.checkNotNumberFloatReg;
            } else {
                checkNotNumberReg = this.settings.checkNotNumberReg;
            }

            if(nextValue > max){
                this.showMessage(maxMessage + max);
                return this.setInputValue(max);
            }

            if(nextValue < min){
                this.showMessage(minMessage + min);
                return  this.setInputValue(min);
            }

            if(isNaN(nextValue) || checkNotNumberReg.test(nextValue)){
                this.showMessage(onlyNumber);
                return  this.setInputValue(min);
            }

            return this.setInputValue(nextValue);

        },
        setInputValue: function (newValue){
            var input = $(this.input);
            var step = input.data('quantity-step');
            var toFixed = String(step).substring(String(step).indexOf('.')).length - 1;

            // replace value if 1.0 === 1
            if(Number(newValue) !== +Number(newValue).toFixed(0)){
                //value = Number(value).toFixed(0);
                newValue = Number(newValue).toFixed(toFixed);
            }

            input.val(newValue);

            return newValue;
        },
        showMessage: function (message) {

            var self = this;
            var tooltipTimeout = this.settings.tooltipTimeout;

            $(this.tooltip).html(message).addClass('is-active');

            clearTimeout(this.timerId);

            this.timerId = setTimeout(function(){
                self.removeMessage();
            },tooltipTimeout);

        },
        removeMessage: function () {
            $(this.tooltip).removeClass('is-active');
        },
        getChar: function (event) {
            if (event.which == null) {
                if (event.keyCode < 32) return null;
                return String.fromCharCode(event.keyCode) // IE
            }

            if (event.which != 0 && event.charCode != 0) {
                if (event.which < 32) return null;
                return String.fromCharCode(event.which) // other
            }

            return null;
        }
    } );

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[ pluginName ] = function( options ) {
        return this.each( function() {
            if ( !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" +
                    pluginName, new Plugin( this, options ) );
            }
        } );
    };

    function initQuantityInput(){

        $('[data-product-quantity]').productQuantity();
    }

    $(document).on('quick_view_modal_open', initQuantityInput );

    $(document).on('cart_modal_open', initQuantityInput);

    $(document).on('wc_fragments_refreshed', initQuantityInput);

    $(document).on('wc_fragments_loaded', initQuantityInput);

    $(document).on('ajaxStop', initQuantityInput);

    initQuantityInput();

} )( jQuery, window, document );
;
(function ($) {

  function socialWindow(url) {
    var left = (screen.width - 570) / 2;
    var top = (screen.height - 570) / 2;
    var width = '570px';
    var height = '570px';

    var option = 'scrollbars=yes, width=' + width + ', height=' + height + ', top=' + top + ', left=' + left;
    window.open(url,"NewWindow",option);
  }

  $(document).on('click','[data-social-share-link]',function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    socialWindow(url);
  });

})(jQuery);
;
(function ($) {
    $.mlsTime.countdown.init({
        scope: '[data-sales-timer]',
        item: '[data-sales-timer-item]'
    });
})(jQuery);
;(function ($) {

    //Move mobile menu to the left
    $('[data-mobile-nav-link]', '[data-mobile-nav]').on('click', function (e) {
        e.preventDefault();

        var targetLink = $(this);
        var childList = targetLink.closest('[data-mobile-nav-item]').find(' > [data-mobile-nav-list]');
        var parentLists = targetLink.parents('[data-mobile-nav-list]');
        var currentList = targetLink.closest('[data-mobile-nav-list]')

        //make fitst child list visible
        childList.removeClass('hidden');

        //move all parent lists to left
        parentLists.addClass('mobile-nav__list--is-moving');

        $('.page__mobile').scrollTop(0);

    });


    //Move mobile menu to the right
    $('[data-mobile-nav-go-back]', '[data-mobile-nav]').on('click', function (e) {
        e.preventDefault();

        var targetLink = $(this);
        var parentList = targetLink.closest('[data-mobile-nav-list]').parent().closest('[data-mobile-nav-list]');
        var childLists = parentList.find('[data-mobile-nav-list]');

        //move first parent list to right
        parentList.removeClass('mobile-nav__list--is-moving');

        //hide all children lists
        setTimeout(function () {
            childLists.addClass('hidden');
        }, 300);

    });

    /* Make "View all" link */
    $('[data-mobile-nav-viewAll]').each(function () {

        var viewAllLink = $(this);

        /* get parent category url */
        var parentCategoryUrl = viewAllLink
        .closest('[data-mobile-nav-list]')
        .closest('[data-mobile-nav-item]')
        .find('[data-mobile-nav-link]')
        .attr('href');

        /* set parent category URL as View All link */
        viewAllLink.attr('href', parentCategoryUrl);

        /* Make View All link visible when href has been set */
        viewAllLink.closest('[data-mobile-nav-item]').removeClass('hidden');
    });

})(jQuery);
/**
 * Changing main photo after clicking on thumb image
 */
(function ($) {
  
  $.mlsMedia.magnificGalley();
  $.mlsMedia.zoomImage();
  
  var videoStream = null;
  var loadVideo = function (selector, data, target) {
    selector.html(data);
    videoStream.on('load', function () {
      target.removeAttr('data-loader-frame-permanent').find('.spinner-circle').remove();
      target.addClass('hidden');
      selector.removeClass('hidden');
    });
  };
  
  $(document).on('click', '[data-product-photo-thumb]', function (e) {
    e.preventDefault();
    
    var currThumb = $(this);
    var context = currThumb.closest('[data-product-photo-scope]');
    
    var allThumbs = '[data-product-photo-thumb]';
    var activeThumb = '[data-product-photo-thumb-active]';
    var activeThumbPosition;
    var currGallery = currThumb.closest('[data-magnific-galley]');
    
    var largePhotoUrl = currThumb.attr('href');
    var mainPhotoUrl = currThumb.attr('data-product-photo-thumb');
    var targetLink = context.find('[data-product-photo-link]');
    var targetImg = context.find('[data-product-photo]');
    var zoomedImageLink = context.find('[data-zoom-image]');
    var videoFame = context.find('[data-product-photo-video-frame]');
    
    targetLink.removeClass('product-photo__item--no-photo');
    
    /* Toggle thumbs activity */
    context.find(allThumbs).removeAttr('data-product-photo-thumb-active');
    currThumb.attr('data-product-photo-thumb-active', '');
    
    /* Setting link to large photo in the main photo */
    targetLink.attr('href', largePhotoUrl);
    targetImg.attr('src', mainPhotoUrl);
    
    targetLink.removeClass('hidden');
    videoFame.addClass('hidden');
    
    if (currThumb.is('[data-product-photo-thumb-video]')) {
      targetLink.attr('data-loader-frame-permanent', '1').append('<i class="spinner-circle"></i>');

			$.get(woocommerce_params.ajax_url, {
				action: 'premmerce_ajax_get_video',
				src: currThumb.attr('data-product-photo-thumb-video')
			}, function (video) {
				videoStream = $(video);
				loadVideo(videoFame, videoStream, targetLink);
			});

    } else {
      zoomedImageLink.attr('data-zoom-image-url', largePhotoUrl);
      $.mlsMedia.zoomImage();
      
      /* Calculate index of active thumb among all thumbs */
      activeThumbPosition = context.find(allThumbs).index(context.find(activeThumb));
      
      /* Call magnific gallery and set active image */
      $.mlsMedia.magnificGalley(activeThumbPosition, currGallery);
      
      /* Remove youtube video after switching to image */
      videoFame.html('');
    }
    
  });
  
})(jQuery);
/* global woocommerce_params */
(function ($) {
    $(document).on('click', '[data-product-quick-view-button]', function (e) {
        e.preventDefault();

        var currProduct = $(this);
        var productBlock = currProduct.closest('[data-product]');
        var data = JSON.parse(currProduct.attr('data-product-quick-view-button'));

        $.ajax({
            url: woocommerce_params.wc_ajax_url.toString().replace('%%endpoint%%', 'saleszone_ajax_get_quick_view'),
            data: data,
            beforeSend: function () {
                $.mlsAjax.preloaderShow({
                    type: 'frame',
                    frame: productBlock
                });
            },
            success: function (response) {
                var $response =  $(response);
                $.magnificPopup.open({
                    items: {
                        src: $response,
                        type: 'inline'
                    },
                    showCloseBtn: false,
                    callbacks: {
                        ajaxContentAdded: function () {
                            $(document).trigger('quick_view_modal_open');
                        }
                    }
                });

                var magnificLink = $response.find('[data-magnific-galley-main]');
                
                magnificLink.on('click', function (e) {
                    e.preventDefault();
                });
                
                magnificLink.removeAttr('data-magnific-galley-main');

                $response.find('.variations_form').wc_variation_form();

                $.mlsMedia.zoomImage();

                $.mlsTime.countdown.init({
                    scope: '[data-countdown]',
                    item: '[data-countdown-item]',
                    expireDateAttribute: 'data-countdown'
                });
            }
        });
    });
})(jQuery);
;
jQuery(function ($) {
    $('[data-slider="section-primary"]').each(function () {
        
        var scope = $(this);
        var slider = scope.find('[data-slider-slides]');
        var responsiveCols = slider.attr('data-slider-slides');
        
        /* Exit if slider is already initialized after Ajax request */
        if (typeof event !== 'undefined' && event.type === 'ajaxComplete' && slider.hasClass('slick-initialized')) {
            return;
        }
        
        if(slider.find('.grid-list').length > 0){
            slider = slider.find('.grid-list');
        }
        
        slider.slick({
            dots: false,
            arrows: true,
            infinite: false,
            adaptiveHeight: true,
            slidesToShow: $.mlsSlider.getFirstCol(responsiveCols),
            autoplay: false,
            autoplaySpeed: 3000,
            swipeToSlide: true,
            mobileFirst: true,
            rows: 1,
            prevArrow: scope.find('[data-slider-arrow-left]').removeClass('hidden'),
            nextArrow: scope.find('[data-slider-arrow-right]').removeClass('hidden'),
            responsive: $.mlsSlider.getCols(responsiveCols)
        });
        
        slider.on('afterChange', function () {
            $.mlsLazzyload.update();
        });
    });
});
;
jQuery(function($){
    
    $(document).on('click','[data-premmerce-change-currency]', function () {
    
        var currencyId = $(this).attr('data-currency-id');
        var url = new URL(document.location.href);
    
        url.searchParams.set('currency_id', currencyId);
        
        $.mlsCart.clearFragments();
        
        document.location = url.toString();
        
    });
    
});
;
(function ($) {
  /**
   * Open social network login page on popup window
   */
  $(document).on('click', '[data-socauth-popup]', function (e) {
    e.preventDefault();
    
    
    var link = $(this);
    var popupWindow = {
      href: link.attr('href'),
      title: link.attr('title'),
      width: 500,
      height: 600
    };
    var left = (window.innerWidth / 2) - (popupWindow.width / 2);
    var top = (window.innerHeight / 2) - (popupWindow.height / 2);
    
    
    window.open(popupWindow.href, popupWindow.title, 'width=' + popupWindow.width + ',height=' + popupWindow.height + ',left=' + left + ',top=' + top);
    
  });
})(jQuery);
/**
 * @var jQuery
 * Toogle widget visibility on mobile screen
 */
(function ($) {

  $(document).on('click', '[data-sidebar-widget--button]', function () {
    
    var scope = $(this).closest('[data-sidebar-widget--scope]');
    var toggleElements = scope.find('[data-sidebar-widget--toggle]');
    var body = scope.find('[data-sidebar-widget--toggle-body]');
    
    toggleElements.toggleClass('hidden');
    body.toggleClass('hidden-xs');
  });

  $(document).on('ready premmerce-filter-updated', function () {

      $('[data-sidebar-widget--header]').each(function () {
          var widgetHeader = $(this);

          widgetHeader.next().wrap('<div class="hidden-xs" data-sidebar-widget--toggle-body></div>');

      });
  });

})(jQuery);
;
jQuery(function ($) {

    if(typeof jQueryFormStyler === 'undefined'){
        return;
    }

    var stylerSelect = '[data-select-styler]';

    $(document).on('show_variation reset_data', function () {
        $(stylerSelect).trigger('refresh');
    });

    $(document).on('ajaxStop', initCustomSelect);

    function initCustomSelect() {
        if(!jQueryFormStyler.isMobile){
            $(stylerSelect).styler();
        }
    }

    $(window).on('load', initCustomSelect);
});
;
(function ($) {
  
  //Selectors init
  var scope = $('.widget_price_filter');
  var form = scope.find('form');
  
  var fieldMin = '#min_price';
  var fieldMax = '#max_price';
  
  var sliderScope = '.price_slider_wrapper .clear'; //'data-range-slider';
  
  //Default valued at start
  var initialMinVal = parseFloat(scope.find(fieldMin).attr('data-min'));
  var initialMaxVal = parseFloat(scope.find(fieldMax).attr('data-max'));
  
  //Values after applying filter
  var curMinVal = parseFloat(scope.find(fieldMin).val());
  var curMaxVal = parseFloat(scope.find(fieldMax).val());
  
  //Setting value into form inputs when slider is moving
  $(sliderScope).slider({
    min: initialMinVal,
    max: initialMaxVal,
    values: [curMinVal, curMaxVal],
    range: true,
    slide: function (event, elem) {
      var instantMinVal = elem.values[0];
      var instantMaxVal = elem.values[1];
      
      scope.find(fieldMin).val(instantMinVal);
      scope.find(fieldMax).val(instantMaxVal);
      
    },
    change: function () {
      form.trigger('submit');
      scope.find(fieldMin + ',' + fieldMax).attr('readOnly', true);
    }
  });
  
  //Setting value slider ranges when form inputs are changing
  scope.find(fieldMin + ',' + fieldMax).on('change', function () {
    $(sliderScope).slider('values', [
      scope.find(fieldMin).val(),
      scope.find(fieldMax).val()
    ]);
  });
    
})(jQuery);