(function($){"use strict";

  /**
   * Copyright 2012, Digital Fusion
   * Licensed under the MIT license.
   * http://teamdf.com/jquery-plugins/license/
   *
   * @author Sam Sehnert
   * @desc A small plugin that checks whether elements are within
   *     the user visible viewport of a web browser.
   *     only accounts for vertical position, not horizontal.
   */

  $.fn.visible = function(partial) { 
    
      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;
    
    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };
    
})(jQuery);

jQuery(document).ready(function($) {
    
    var ariannaWindow = $(window),
    ariannaRatingBars = $('.arianna_overlay').find('.arianna_zero-trigger');
    $('.page-wrap').imagesLoaded(function(){
        setTimeout(function() {
            var arianna_thumbnail = $('.page-wrap').find('.thumb');
            $.each(arianna_thumbnail, function(i, value) {
                var arianna_Value = $(value);
                if (( arianna_Value.visible(true) )&& ( arianna_Value.hasClass('hide-thumb'))) {
                    arianna_Value.removeClass('hide-thumb');
                } 
            });
        },800);
    });
    setTimeout(function() {
        ariannaWindow.scroll(function(event) {
            var arianna_thumbnail = $('.page-wrap').find('.thumb');
            $.each(arianna_thumbnail, function(i, value) {
                var arianna_Value = $(value);
                if (( arianna_Value.visible(true) )&& ( arianna_Value.hasClass('hide-thumb'))) {
                    arianna_Value.removeClass('hide-thumb');
                } 
            });
        });
    },2000);  
});