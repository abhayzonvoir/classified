<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
?>
<?php
get_header(); 
$arianna_option = arianna_global_var_declare('arianna_option');
if (isset($arianna_option) && ($arianna_option != '')): 
    $arianna_layout = $arianna_option['arianna_archive-layout'];
    $cur_tag_id = $wp_query->get_queried_object_id();
    $cat_opt = get_option('arianna_cat_opt'); 
endif;
$arianna_layout = 'classic-content';   
if (isset($cat_opt[$cur_tag_id]) && is_array($cat_opt[$cur_tag_id]) && array_key_exists('cat_layout',$cat_opt[$cur_tag_id])) { $arianna_layout = $cat_opt[$cur_tag_id]['cat_layout'];};
?>
<div class="arianna_archive-content-wrap <?php if (!(($arianna_layout == 'big-classic') || ($arianna_layout == 'big-blog')  || ($arianna_layout == 'big-masonry'))): echo 'content-sb-section clear-fix'; endif;?>">
    <div class="arianna_archive-content <?php if (($arianna_layout == 'big-classic') || ($arianna_layout == 'big-blog') || ($arianna_layout == 'big-masonry')): echo 'fullwidth-section'; else : echo 'content-section'; endif;?>">
    		<div class="arianna_header">
                <div class="main-title">
                    <h3><?php
    
    				$var = get_query_var('post_format');
    				// POST FORMATS
    				if ($var == 'post-format-image') :
    					esc_html_e('Image ', 'arianna');
    				elseif ($var == 'post-format-gallery') :
    					esc_html_e('Gallery ', 'arianna');
    				elseif ($var == 'post-format-video') :
    					esc_html_e('Video ', 'arianna');
    				elseif ($var == 'post-format-audio') :
    					esc_html_e('Audio ', 'arianna');
    				endif;
    
    				if ( is_day() ) :
    					printf( esc_html__( 'Daily Archives: %s', 'arianna'), get_the_date() );
    				elseif ( is_month() ) :
    					printf( esc_html__( 'Monthly Archives: %s', 'arianna'), get_the_date( _x( 'F Y', 'monthly archives date format', 'arianna') ) );
    				elseif ( is_year() ) :
    					printf( esc_html__( 'Yearly Archives: %s', 'arianna'), get_the_date( _x( 'Y', 'yearly archives date format', 'arianna') ) );
    				elseif ( is_tag() ) :
                        printf( esc_html__( 'Tag: %s', 'arianna'), single_tag_title('',false) );
                    else :
    					esc_html_e( 'Archives', 'arianna');
    				endif;
    			?></h3>
                </div>
    		</div>
            <?php 
            if (have_posts()) { 
    
                if (($arianna_layout == 'big-blog') || ($arianna_layout == 'small-blog')) {
                    echo '<div class="module-large-blog">';
                    echo '<div class="large-blog-content-container">';
                        while (have_posts()): the_post();
                        echo arianna_large_blog_render(get_the_ID(), 40);
                        endwhile;
                    echo '</div></div>';
                    if (function_exists("arianna_paginate")) {
                        echo '<div class="arianna_page-pagination">';
                            arianna_paginate();
                        echo '</div>';
                    }
                } else if ($arianna_layout == 'big-classic') {
                    echo '<div class="classic-blog-content-container">';
                        while (have_posts()): the_post();
                        echo arianna_classic_blog_render(get_the_ID(), 25);
                        endwhile;
                    echo '</div>';
                    if (function_exists("arianna_paginate")) {
                        echo '<div class="arianna_page-pagination">';
                            arianna_paginate();
                        echo '</div>';
                    }
				} else if (($arianna_layout == 'big-masonry')||($arianna_layout == 'small-masonry')) {
                    echo '<div class="module-masonry-wrapper clear-fix"><div class="masonry-content-container">';
                        while (have_posts()): the_post();             				
        				    echo arianna_masonry_render(get_the_ID());
                        endwhile;
                    echo '</div></div>';
                    if (function_exists("arianna_paginate")) {
                        echo '<div class="arianna_page-pagination">';
                            arianna_paginate();
                        echo '</div>';
                    }
                } else if ($arianna_layout == 'small-classic') {
                    echo '<div class="classic-blog-content-container">';
                        while (have_posts()): the_post();
                        echo arianna_classic_blog_render(get_the_ID(), 18);
                        endwhile;
                    echo '</div>';
                    if (function_exists("arianna_paginate")) {
                        echo '<div class="arianna_page-pagination">';
                            arianna_paginate();
                        echo '</div>';
                    }
                 } else {
                    echo '<div class="module-large-blog">';
                    echo '<div class="large-blog-content-container">';
                        while (have_posts()): the_post();
                        echo arianna_large_blog_render(get_the_ID(), 40);
                        endwhile;
                    echo '</div></div>';
                    if (function_exists("arianna_paginate")) {
                        echo '<div class="arianna_page-pagination">';
                            arianna_paginate();
                        echo '</div>';
                    }
                }
            } else { esc_html_e('No post to display','arianna');} ?>
    </div>
    <?php
        if (!($arianna_layout == 'big-classic') && !($arianna_layout == 'big-blog') && !($arianna_layout == 'big-masonry')) {
            get_sidebar();
        }
    ?>
</div>
<?php get_footer(); ?>