<?php
/**
 * The template for displaying Search Results pages.
 *
 */
 ?> 
<?php
get_header(); 
$arianna_option = arianna_global_var_declare('arianna_option');
if (isset($arianna_option) && ($arianna_option != '')): 
    $arianna_layout = $arianna_option['arianna_search-layout'];
endif;
?>
<div class="arianna_archive-content-wrap <?php if (!(($arianna_layout == 'big-classic') || ($arianna_layout == 'big-blog') || ($arianna_layout == 'big-masonry'))): echo 'content-sb-section clear-fix'; endif;?>">
    <div class="arianna_archive-content <?php if (($arianna_layout == 'big-classic') || ($arianna_layout == 'big-blog')  || ($arianna_layout == 'big-masonry')): echo 'fullwidth-section'; else : echo 'content-section'; endif;?>">
        <div class="arianna_header">
            <div class="main-title">
                <h3>
                    <?php printf( esc_html__( 'Search Results for: %s', 'arianna'), get_search_query() ); ?>
                </h3>
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
        } else { esc_attr_e('No post to display','arianna');} ?>
    </div>   
    <?php
    if (!($arianna_layout == 'big-classic') && !($arianna_layout == 'big-blog') && !($arianna_layout == 'big-masonry')) {
        get_sidebar();
    }
    ?>
</div>
<?php get_footer(); ?>