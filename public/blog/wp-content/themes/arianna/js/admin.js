/* -----------------------------------------------------------------------------
 * Page Template Meta-box
 * -------------------------------------------------------------------------- */
;(function( $, window, document, undefined ){
	"use strict";
	
	$( document ).ready( function () {
        $(function() {
            if ($('input[name=post_format]:checked', '#post-formats-select').val() == 0) {
                $("#arianna_format_options").hide();
            }else {
                var value = $('input[name=post_format]:checked', '#post-formats-select').val(); 
                $("#arianna_format_options").show();
                if (value == "gallery"){
                    $("#arianna_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_gallery_content_description").parents(".rwmb-field").css("display", "block");
                    $("#arianna_popup_frame_description").parents(".rwmb-field").css("display", "none");
                }else if ((value == "video")||(value == "audio")){
                    $("#arianna_media_embed_code_post_description").parents(".rwmb-field").css("display", "block");
                    $("#arianna_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_gallery_content_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_popup_frame_description").parents(".rwmb-field").css("display", "block");
                }else if (value == "image"){
                    $("#arianna_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_image_upload_description").parents(".rwmb-field").css("display", "block");
                    $("#arianna_gallery_content_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_popup_frame_description").parents(".rwmb-field").css("display", "none");
                }
            }
            $('#post-formats-select input').on('change', function() { 
                var value = $('input[name=post_format]:checked', '#post-formats-select').val(); 
                if (value == 0){
                    $("#arianna_format_options").hide();
                }else {
                    $("#arianna_format_options").show();
                } 
                if (value == "gallery"){
                    $("#arianna_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_gallery_content_description").parents(".rwmb-field").css("display", "block");
                    $("#arianna_popup_frame_description").parents(".rwmb-field").css("display", "none");
                }else if ((value == "video")||(value == "audio")){
                    $("#arianna_media_embed_code_post_description").parents(".rwmb-field").css("display", "block");
                    $("#arianna_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_gallery_content_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_popup_frame_description").parents(".rwmb-field").css("display", "block");
                }else if (value == "image"){
                    $("#arianna_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_image_upload_description").parents(".rwmb-field").css("display", "block");
                    $("#arianna_gallery_content_description").parents(".rwmb-field").css("display", "none");
                    $("#arianna_popup_frame_description").parents(".rwmb-field").css("display", "none");
                }
            });
        });
	} );
})( jQuery, window , document );