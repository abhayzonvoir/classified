<?php
add_action('wp_head','custom_css',20);
if ( ! function_exists( 'custom_css' ) ) {
    function custom_css() {
        $arianna_option = arianna_global_var_declare('arianna_option');
        if ( isset($arianna_option)):
            $primary_color = $arianna_option['arianna_primary-color'];
            $page_color = $arianna_option['arianna_page-color'];
            $bg_switch = $arianna_option['arianna_site-layout'];
            $meta_author = $arianna_option['arianna_meta-author-sw'];
            $meta_date = $arianna_option['arianna_meta-date-sw'];
            $meta_comments = $arianna_option['arianna_meta-comments-sw'];
            $custom_css = $arianna_option['arianna_css-code'];
            $sb_responsive_sw = $arianna_option['arianna_sb-responsive-sw'];
            $single_feat_img = $arianna_option['arianna_single-featimg'];
            ?>
            <style type='text/css' media="all">
            <?php
            if ( ($meta_author) == 0) echo ('.post-author, .post-meta .post-author {display: none !important;}'); 
            if ( ($meta_date) == 0) echo ('.post-meta .date {display: none !important;}'); 
            if ( ($meta_comments) == 0) echo ('.post-meta .meta-comment {display: none !important;}');
            if ( ($single_feat_img) == 0) echo ('.single-page .feature-thumb {display: none !important;}'); 
    
            if ( (esc_attr($primary_color)) != null) {?> 

                
                #arianna_gallery-slider .flex-control-paging li a.flex-active, .rating-wrap,
                 h3.ticker-header, .post-cat-main-slider, .module-main-slider .carousel-ctrl .slides li.flex-active-slide,
                .ajax-load-btn span, .s-tags a:hover,.post-page-links > span, .post-page-links a span:hover, #comment-submit,
                .arianna_review-box .arianna_overlay span, #back-top, .contact-form .wpcf7-submit, .searchform-wrap .search-icon,
                .arianna_score-box, #pagination .current, .widget_archive ul li:hover, .widget_categories ul li:hover, span.discount-label,
                .widget_tag_cloud a:hover, .archive-share-but i:hover, .widget .searchform-wrap .search-icon,
                .flex-control-paging li a.flex-active, .woocommerce #respond input#submit, .woocommerce a.button,
                .woocommerce button.button, .woocommerce input.button, .woocommerce nav.woocommerce-pagination ul li a:focus,
                .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,
                .widget_product_search input[type="submit"], .woocommerce #respond input#submit.alt,
                .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,
                .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled[disabled], .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled[disabled], .woocommerce input.button.alt:disabled[disabled]:hover
                .article-content button, .textwidget button, .article-content input[type="button"], .textwidget input[type="button"],
                .article-content input[type="reset"], .textwidget input[type="reset"], .article-content input[type="submit"], .textwidget input[type="submit"],
                .post-cat-main-slider, .s-tags a:hover, .post-page-links > span, .post-page-links a span:hover, #comment-submit, .arianna_score-box,
                #pagination .current, .widget .searchform-wrap .search-icon, .woocommerce ul.products li.product .onsale,
                .arianna_mega-menu .flexslider:hover .flex-next:hover, .arianna_mega-menu .flexslider:hover .flex-prev:hover, .arianna_review-box .arianna_overlay span,
                #arianna_gallery-slider .flex-control-paging li a.flex-active, .wcps-container .owl-nav.middle-fixed .owl-next:hover,
                .wcps-container .owl-nav.middle-fixed .owl-prev:hover, .arianna_mega-menu .flex-direction-nav a,
                .module-main-slider .slider-wrap .slides .post-info .post-cat a,
                .module-main-grid .post-cat a,
                .module-post-two .large-post .post-cat a,
                .module-post-three .large-post .post-cat a,
                .module-post-four .large-post .post-cat a,
                .module-post-one .sub-posts .post-cat a,
                .post-jaro-type .post-cat a,
                .post-three-type .post-cat a,
                .post-four-type .post-cat a,
                .type-in .post-cat a,
                .singletop .post-cat a, .module-carousel .flex-direction-nav a
                {background-color: <?php echo esc_attr(esc_attr($primary_color)); ?>}
                
                
                .arianna_author-box .author-info .arianna_author-page-contact a:hover, .error-number h1, #arianna_404-wrap .arianna_error-title,
                .page-404-wrap .redirect-home, .article-content p a, .read-more:hover, .header-social li a:hover, #footer-menu ul li:hover,
                .woocommerce .star-rating, .woocommerce ul.products li.product .onsale:before, .woocommerce span.onsale:before, 
                .wcps-items-price del, .wcps-items-price ins, .wcps-items-price span, .woocommerce ul.products li.product .price,
                .widget_recently_viewed_products ins, .widget_recently_viewed_products del, .widget_products ins, .widget_products del,
                .widget_top_rated_products ins, .widget_top_rated_products del, .arianna_author-box .author-info .arianna_author-page-contact a:hover,
                #arianna_404-wrap .arianna_error-title, .page-404-wrap .redirect-home, .article-content p a, .error-number h1,
                .woocommerce div.product p.price, .woocommerce div.product span.price, .widget_top_rated_products .product_list_widget li span.woocommerce-Price-amount,
                .widget_products .product_list_widget li span.woocommerce-Price-amount, .post-author a, h3.post-title:hover, .widget-posts-list .post-title:hover,
                .main-nav #main-menu .menu > li:hover a, .main-nav #main-menu .menu > li.current-menu-item a, .woocommerce-info:before,
                .woocommerce a.added_to_cart:hover, .woocommerce .woocommerce-breadcrumb a:hover,
                .sticky.classic-blog-style .post-title, .sticky.large-blog-style .post-title, .sticky.grid-1-type .post-title
                {color: <?php echo esc_attr($primary_color); ?>}
                
                ::selection
                {background-color: <?php echo esc_attr($primary_color); ?>}
                ::-moz-selection 
                {background-color: <?php echo esc_attr($primary_color); ?>}
                
                body::-webkit-scrollbar-thumb
                {background-color: <?php echo esc_attr($primary_color); ?>}
                
                .article-content blockquote, .textwidget blockquote, #arianna_gallery-slider .flex-control-paging li a.flex-active,
                .widget_flickr li a:hover img, .post-page-links > span, .post-page-links a span:hover,
                #comment-submit, #pagination .current, .widget_archive ul li:hover, #arianna_gallery-slider .flex-control-paging li a.flex-active,
                .widget_tag_cloud a:hover, .article-content blockquote, .textwidget blockquote, .read-more:hover, .widget_flickr li a:hover img,
                .post-page-links > span, .post-page-links a span:hover, #comment-submit, #pagination .current
                {border-color: <?php echo esc_attr($primary_color); ?>}
                 
                .arianna_header .main-title h3, .footer .arianna_header .main-title h3
                {border-bottom-color: <?php echo esc_attr($primary_color); ?>}
                
                .woocommerce-info 
                {border-top-color: <?php echo esc_attr($primary_color); ?>}
        
            <?php }
            if ( (esc_attr($page_color)) != null) {?>
                .page-wrap.clear-fix
                {
                    background-color:  <?php echo esc_attr($page_color);?>
                }
            <?php }
            if ( $bg_switch == 1) {?>
                body {background: none !important}
            <?php };
            if ( $sb_responsive_sw == 0) {?>
            @media screen and (max-width: 1079px) {
                .sidebar {display: none !important}
            }
            <?php };
            if ($custom_css != '') echo esc_attr($custom_css);
            ?>
            </style>
            <?php
        endif;
    }
}