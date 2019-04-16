(function($) {
  "use strict";
    $=jQuery;
    jQuery(document).ready(function(){
        var blog_widget_id, blog_offset;
            
        jQuery('.classic-blog-ajax').on('click','.ajax-load-btn.active',function(){
            if(jQuery(this).hasClass('no-more')){
                jQuery(this).find('.load-more-text').text(loadbuttonstring.nomoreString);
                return;
            }
            var $this = jQuery(this);
            var module_id = $this.parents('.arianna_classic-blog-wrapper').attr('id');
            var entries = arianna_ajax[module_id]['entries'];
            var excerpt_length = arianna_ajax[module_id]['excerpt_length'];
            var args =  arianna_ajax[module_id]['args'];
    
            $('.ajax-load-btn').removeClass('active');
            $this.css("display", "none");
            $this.siblings('.loading-animation').css("display", "block");
         
            var $container = $this.parent('.classic-blog-ajax').siblings('.classic-blog-content-container');     
            var offset = parseInt($container.find('.classic-blog-style').length)+ parseInt(arianna_ajax[module_id]['offset']);
            var data = {
    				action			: 'classic_blog_load',
                    post_offset     : offset,
                    entries         : entries,
                    args            : args,
                    excerpt_length  : excerpt_length
    			};
    
    		jQuery.post( ajaxurl, data, function( respond ){
                var el = jQuery(respond);
                var respond_length = el.find('.post-details').length;
                $container.append(el);
                $container.imagesLoaded(function(){
                    setTimeout(function() {
                        $container.find('.thumb').removeClass('hide-thumb');
                        $('.ajax-load-btn').addClass('active');
                        $this.find('.ajax-load-btn').text(ajax_btn_str['loadmore']);
                        if(respond_length < entries){
                            $this.text(ajax_btn_str['nomore']);
                            $this.addClass('no-more');
                            $this.removeClass('active');
                            $this.append("<span></span>");
                        }
                        $this.css("display", "inline-block");
                        $this.siblings('.loading-animation').css("display", "none");
                    }, 500);
                    
                 });
                
            });
       });
    });
})(jQuery);       