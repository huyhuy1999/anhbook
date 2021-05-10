;
(function($) {
  
  /**
   * Import demo data
   */
    function DemoDataImport (){

      this.submitBtn = '#premmerceImport';
      this.form = '#premmerceImportForm';
      this.preloader = '[data-import-preloader]';
      this.importAction = $('input[name="action"]').val();
      this.allPostsCount = 0;
      this.currentStateBlockSector = '';
      this.statusSeparator = ' : ';
      this.postProgressBar = '[data-post-progress-bar]';
      this.infoBlock = '[data-import-info]';
      this.prevElementSelector = '';

      this.loc = {
        importEnd : PremmerceAdminLocalize.importEnd
      };

      $(this.submitBtn).on('click', function(event){
        event.preventDefault();

        var userComfirm = confirm(PremmerceAdminLocalize.confirmImport);
        if(userComfirm){
          this.ajaxImport();
        }
      }.bind(this));
    }


    DemoDataImport.prototype.ajaxImport = function(data){
      $(this.preloader).attr('data-import-preloader', 'show');

      if(!data){
        data = $(this.form).serialize();
      }

      $.post(ajaxurl, data, function(response){

        // Import posts
        if(response.stage === 'insertPost'){

          this.importPosts(response);

        } else if(response.stateBlockSelector !== 'none'){

          this.doImport(response);

        }

        // continue import
        if(response.stage !== 'deleteTempOptions'){

          data = {action: this.importAction};
          this.ajaxImport(data);
        } else {
          // import end
          this.importEnd(response);
        }

      }.bind(this));

    };

    DemoDataImport.prototype.importEnd = function(response){

      $('.'+ this.prevElementSelector).html(response.action + this.statusSeparator + response.status);

      $(this.submitBtn).attr('disabled','disabled');
      $(this.preloader).attr('data-import-preloader', false);

      alert(this.loc.importEnd);
    };

    DemoDataImport.prototype.importPosts = function(response){

      if(this.allPostsCount === 0){
        this.allPostsCount = response.status;
      }

      if(this.currentStateBlockSector === ''){
        this.currentStateBlockSector = response.stateBlockSelector;
      }

      var percent = this.getPostPercent(response);
      if(this.currentStateBlockSector !== ''){
        $('.' + this.currentStateBlockSector).html(response.action + this.statusSeparator + percent + '%');
      }

      this.updateProgressbar(percent);

      if(response.stateBlockSelector !== 'insertPost'){
        // save previus status
        this.prevElementSelector = response.stateBlockSelector;

        this.addInfoBlock({
          'element': '<p>',
          'class' : response.stateBlockSelector,
          'text' : response.nextStatus + this.statusSeparator + ' ...'
        });
      }

    };

    DemoDataImport.prototype.doImport = function(response){

      // First update previos status
      if(this.prevElementSelector !== ''){
        $('.'+ this.prevElementSelector).html(response.action + this.statusSeparator + response.status);
      }

      this.addInfoBlock({
        'element': '<p>',
        'class' : response.stateBlockSelector,
        'text' : response.nextStatus + this.statusSeparator + ' ...'
      });


      // save previus status
      this.prevElementSelector = response.stateBlockSelector;

    };

    DemoDataImport.prototype.getPostPercent = function(response){
      var postPercentage = parseInt(response.status - 1) / parseInt(this.allPostsCount);
      postPercentage = 100 - (postPercentage.toFixed(2) * 100);
      return Math.ceil(postPercentage);
    };

    DemoDataImport.prototype.updateProgressbar = function(percent){
      $(this.postProgressBar).progressbar({
        value: percent
      });
    };

    DemoDataImport.prototype.addInfoBlock = function(data){

      var newStatus = $(data['element'], {
        'class': data['class'],
        'text' : data['text']
      });

      $(this.infoBlock).append(newStatus);
    };

    new DemoDataImport();
  
  /**
   * Ignore Get started notice handler
   */
  $(document).on('click', '[data-get-started-notice--ignore]', function(e){
    e.preventDefault();
    
    var $this = $(this);
    var notice = $this.closest('[data-get-started-notice]');
  
    notice.slideUp();
    
    $.get($this.attr('href'));
    
  });
  
  /**
   *
   */
  $(document).on('change','[data-set-task-state]', function () {
    var $this = $(this);
    var optionName = $this.attr('data-set-task-state');
    var newState = $this.is(':checked');
    
    $.get(ajaxurl,{
      action: 'premmerce_task_state',
      setState: newState,
      task: optionName
    });
    
  });
  
  //="pc-wizzard-1"
    
})( jQuery );

