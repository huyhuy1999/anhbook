/**
 * Customizer scripts
 */
jQuery(function($){
  
  /**
   * Customizer window
   * @type {Window}
   */
  var parent = window.parent;

  /**
   * Hot replace style
   */
  if (wp.customize.selectiveRefresh) {
    wp.customize.selectiveRefresh.bind('partial-content-rendered', function (placement) {

      if(placement.partial.id === 'refresh_custom_css'){
        // Replace custom css tag
        var style = $(placement.addedContent)[1];
        $('[data-customizer-css]').remove();
        $('[data-customizer-css-required]').after(style);
      }

    });
  }

  /**
   * Handle header_layout change
   */
  wp.customize('header_layout',function () {
    clearCartFragments();
  });


  /**
   * Handle site max width change
   */
  wp.customize('site-page-width',function (e) {
    e.bind(function (value) {
      var value = parseInt(value);

      if(typeof value === 'undefined'){
        return
      }

      if(!isNaN(value) && value > 300){
        // add gutter width
        value = value + 30;
        insertStyle('site-page-width', function () {
          return '.page__container{max-width: '+ value +'px;}'
        });

      }

    });
  });

  /**
   * Handle Site content width change
   */
  wp.customize('site-content-width',function (e) {
    e.bind(function (value) {
      
      var value = parseInt(value);
      
      if(typeof value === 'undefined'){
        return
      }

      if(!isNaN(value) && value > 300){
        // add gutter width
        value = value + 30;
        insertStyle('site-content-width', function () {
          return '.start-page__container > * {max-width:'+ value +'px;} .start-page__container{max-width:'+ value +'px;}.content__container{max-width: '+ value +'px;}'
        });

      }

    });
  });

  /**
   * Handle Site boxed container width change
   */
  wp.customize('site-boxed-width',function (e) {
    e.bind(function (value) {
      var value = parseInt(value);

      if(typeof value === 'undefined'){
        return
      }

      if(!isNaN(value) && value > 300){
        insertStyle('site-boxed-width', function () {
          return '.page__boxed-layout{max-width:'+ value +'px;}.content__container{max-width: '+ value +'px;}'
        });

      }

    });
  });
  
  //header-phone-icon-size
  //pc-header-phones__ico
  /**
   * Handle header phones icon size change
   */
  wp.customize('header-phone-icon-size',function (e) {
    e.bind(function (value) {
      var value = parseInt(value);
      
      if(typeof value === 'undefined'){
        return
      }
      
      if(!isNaN(value)){
        insertStyle('header-phone-icon-size', function () {
          return '.pc-header-phones-drop__icon,.pc-header-phones__ico{width:'+ value +'px!important; height:'+ value +'px!important;}';
        });
        
      }
      
    });
  });
  
  /**
   * Handle header phones font size change
   */
  wp.customize('header-phone-font-size',function (e) {
    e.bind(function (value) {
      var value = parseInt(value);
      
      if(typeof value === 'undefined'){
        return
      }
      
      if(!isNaN(value)){
        insertStyle('header-phone-font-size', function () {
          return '.pc-header-phones-drop,.pc-header-phones-drop__phone,.pc-header-phones .pc-header-phones__link{font-size:'+ value +'px!important;}';
        });
        
      }
      
    });
  });

  /**
   *  Handle logo padding change
   */
  wp.customize('logo-padding',function (e) {
    e.bind(function (value) {
      var value = parseInt(value);
      
      if(typeof value === 'undefined'){
        return
      }
      
      if(!isNaN(value)){
        insertStyle('logo-padding', function () {
          return '.site-logo__image{padding:'+ value +'px 0 !important;}';
        });
        
      }
      
    });
  });

  /**
   * Handle logo container width change
   */
  wp.customize('logo-container-max-width',function (e) {
      e.bind(function (value) {
          var value = parseInt(value);

          if(typeof value === 'undefined'){
              return;
          }

          if(!isNaN(value)){

              insertStyle('logo-container-max-width', function () {
                  return '.site-logo{max-width: '+ value +'px;}'
              });

          }

      });
  });

  /**
   * Show notice if kirki is disabled
   */
  if (!customzierLocalize['kirkiActive']) {
    parent.wp.customize.notifications.add('warning', new parent.wp.customize.Notification('info', {
      isDismissible: true,
      message: customzierLocalize['kirkiMessage'],
      type: 'warning',
      code: 'warning'
    }));
  }

  /**
   * Clear woo cart fragments
   */
  function clearCartFragments() {
    sessionStorage.setItem(wc_cart_fragments_params.fragment_name,'');
  }

  /**
   * Insert style intro the DOM
   * @param optionName
   * @param callback
   */
  function insertStyle(optionName, callback) {
    var tagSelector = "style#customizer-preview-" + optionName;
    var value = callback();
    
    if($(tagSelector).length){
      $(tagSelector).text(value);
    } else {
      $("head").append('<style id="customizer-preview-' + optionName + '">' + value + "</style>");
    }
  }

});