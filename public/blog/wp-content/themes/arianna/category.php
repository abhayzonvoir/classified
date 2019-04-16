<?php 
/**
 * The template for displaying Category pages.
 *
 */

get_header(); 
$arianna_option = arianna_global_var_declare('arianna_option');
if (isset($arianna_option) && ($arianna_option != '')):
    $arianna_cat_layout = $arianna_option['arianna_category-layout'];
endif;
$cat_id = $wp_query->get_queried_object_id();
$cat_layout = '';
$cat_feat = '';
$cat_opt = array();
$meta = array();
$meta = get_option('arianna_cat_opt');
if (isset($meta) && is_array($meta) && (array_key_exists($cat_id,$meta))) {$cat_opt = $meta[$cat_id]; };
if (isset($cat_opt) && is_array($cat_opt) && (array_key_exists('cat_layout',$cat_opt))) { $cat_layout = $cat_opt['cat_layout'];};
if (isset($cat_opt) && is_array($cat_opt) && (array_key_exists('cat_feat',$cat_opt))) { $cat_feat = $cat_opt['cat_feat'];};

if (($cat_layout == '')||($cat_layout == 'global')) { $cat_layout = $arianna_cat_layout;};
?>
<div class="arianna_archive-content-wrap <?php if (!(($cat_layout == 'big-classic') || ($cat_layout == 'big-blog') || ($cat_layout == 'big-masonry'))): echo 'content-sb-section clear-fix'; endif;?>">
    <div class="arianna_archive-content content <?php if (($cat_layout == 'big-classic') || ($cat_layout == 'big-blog') || ($cat_layout == 'big-masonry')): echo 'fullwidth-section'; else : echo 'content-section'; endif;?>">
    		<div class="arianna_header-wrapper">
                <div class="arianna_header">
                    <div class="main-title">
                        <h3>
                            <?php single_cat_title();?>
                        </h3>
                    </div>
        		</div>
                <?php if ( category_description() ) : // Show an optional category description ?>
    				<div class="sub-title"><p><?php echo category_description(); ?></p></div>
    			<?php endif;?>                
            </div>            
            <?php 
            if (have_posts()) {
                if ($cat_feat) {get_template_part('/library/cat_feat_slider');}
    
                 if (($cat_layout == 'big-blog') || ($cat_layout == 'small-blog')) {
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
                } else if ($cat_layout == 'big-classic') {
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
				} else if (($cat_layout == 'big-masonry')||($cat_layout == 'small-masonry')) {
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
                } else if ($cat_layout == 'small-classic') {
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
        if (!($cat_layout == 'big-classic') && !($cat_layout == 'big-blog') && !($cat_layout == 'big-masonry')) {
            get_sidebar();
        }
    ?>
</div>

<?php get_footer(); ?>