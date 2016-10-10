/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        $('.brand-form-submit').click(function(event) {
          $('#gform_submit_button_3').click();
        });
      
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    'prova_produttore':{
      init:function(){
        
        $('.gfield.hidden').hide();

        var max_rows=$('.gfield_list_group').first().find('option').length;

        gform.addFilter( 'gform_list_item_pre_add', function ( clone ) {
          
            clone.find('.datepicker').removeClass('hasDatepicker').removeAttr('id');
            set_max_rows(clone.find('.gfield_list_icons img'));
            return clone;
        });
                          
        function set_max_rows(buttons){

          if(buttons){
            buttons.first().attr('onclick',"gformAddListItem(this, "+max_rows+")");
            buttons.first().attr('onkeypress',"gformAddListItem(this, "+max_rows+")");
            buttons.last().attr('onclick',"gformDeleteListItem(this, "+max_rows+")");
            buttons.last().attr('onkeypress',"gformDeleteListItem(this, "+max_rows+")");      
          }
        }
        
        $('.gfield_list_icons').each(function(index, el) {

              var buttons = $(el).children('img');
              set_max_rows(buttons);
        });

        function disable_option(){
          var rows=$('.gfield_list_group');
          var options=rows.find('option');
          var selected=[];
          var disabled=[];

          rows.each(function(index, el) {
            var val =$(this).find('select').val();              
            if(val)selected.push(val);
          });
          
          options.each(function(index) {            
            if($(this).attr('disabled')==='disabled') disabled.push($(this).val());
          });

          options.each(function(index, el) {
            if(selected.indexOf($(el).val())!==-1 && $(el).parent().val() !== $(el).val()){
              $(el).attr('disabled','disabled');
            }else if( disabled.indexOf($(el).val())!==-1 ){
              $(el).attr('disabled',null);
            }
          });
        }

        disable_option();

        $('.ginput_list').on('click','.gfield_list_icons img',function(event) { disable_option(); });
        $('.ginput_list').on('focus','.datepicker',function(e){ gformInitDatepicker(); })
        $('.ginput_list').on('change focus mousedown keydown touchstart','.gfield_list_group select',function(event) { disable_option(); });    
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
