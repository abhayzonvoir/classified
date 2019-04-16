(function($) {
  "use strict";
    $=jQuery;
    $(document).ready(function(){
        var widget_id, offset;
        
        $('.masonry-ajax').on('click','.ajax-load-btn.active',function(){
            var $this = $(this);
            if($this.hasClass('nomore')){
                $this.text(ajax_btn_str['nomore']);
                return;
            }
            var module_id = $this.parents('.module-masonry-wrapper').attr('id');
            var entries = arianna_ajax[module_id]['entries']; console.log('entries');
            var args =  arianna_ajax[module_id]['args']; console.log('args');
                    
            $('.ajax-load-btn').removeClass('active');
            $this.css("display", "none");
            $this.siblings('.loading-animation').css("display", "block");
             
            var $container = $this.parent('.masonry-ajax').siblings('.masonry-content-container');     
            var offset = parseInt($container.find('.post-wrapper').length)+ parseInt(arianna_ajax[module_id]['offset']);

            var data = {
    				action			: 'masonry_load',
                    post_offset     : offset,
                    entries         : entries,
                    args            : args,
    			};
    		$.post( ajaxurl, data, function( respond ){
                var el = $(respond).hide().fadeIn('1500');
                var respond_length = el.find('.post-wrapper').length;
                $container.append(el).masonry( 'appended', el );
                $container.imagesLoaded(function(){
                    setTimeout(function() {
            			var postionscroll = $(window).scrollTop();
                            $container.masonry('destroy');
                            $container.masonry({
                                itemSelector: '.one-col',
                                columnWidth: 1,
                                isAnimated: true,
                                isFitWidth: true,
                             });
            			window.scrollTo(0,postionscroll);
                        $($container).find('.post-details').removeClass('opacity-zero');
                        $($container).find('.post-meta').removeClass('opacity-zero');
                        $($container).find('.arianna_share-box').removeClass('opacity-zero');
                        $($container).find('.thumb').removeClass('hide-thumb');
                        $('.ajax-load-btn').addClass('active');
                        $this.find('.ajax-load-btn').text(ajax_btn_str['loadmore']);
                        if(respond_length < entries){
                            $this.text(ajax_btn_str['nomore']);
                            $this.addClass('no-more');
                            $this.removeClass('active');
                        } 
                        $this.css("display", "block");
                        $this.siblings('.loading-animation').css("display", "none");
                    }, 500);
                });
    
            });
        });
    });
})(jQuery);