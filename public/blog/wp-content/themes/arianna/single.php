<?php get_header();?>
<?php 
    $arianna_option = arianna_global_var_declare('arianna_option');
    $social_share = array();
    $share_box = $arianna_option['arianna_sharebox-sw'];
    if ($share_box){
        $social_share['fb'] = $arianna_option['arianna_fb-sw'];
        $social_share['tw'] = $arianna_option['arianna_tw-sw'];
        $social_share['gp'] = $arianna_option['arianna_gp-sw'];
        $social_share['pi'] = $arianna_option['arianna_pi-sw'];
        $social_share['li'] = $arianna_option['arianna_li-sw'];
    }
    $authorbox_sw = $arianna_option['arianna_authorbox-sw'];
    $postnav_sw = $arianna_option['arianna_postnav-sw'];
    $related_sw = $arianna_option['arianna_related-sw'];
    $comment_sw = $arianna_option['arianna_comment-sw'];
?>
    
<?php if (have_posts()) : while (have_posts()) : the_post();?>
        <?php 
            $ariannaPostID = get_the_ID();
            $ariannaReviewSW = get_post_meta($ariannaPostID,'arianna_review_checkbox',true);
            if($ariannaReviewSW == '1') {
                $reviewPos = get_post_meta($ariannaPostID,'arianna_review_box_position',true);
            }
            $arianna_layout = get_post_meta($ariannaPostID,'arianna_post_layout',true);
        ?>
        <div class="single-page clear-fix">
            <div class="article-content-wrap">
                <?php 
                    if(($arianna_layout == 'feat-fw') || ($arianna_layout == 'no-sidebar')) {
                        echo arianna_post_format_display($ariannaPostID, $arianna_layout);
                    }
                ?>  
                <div class="<?php if ($arianna_layout != 'no-sidebar') { echo 'content-sb-section clear-fix'; } else {echo 'content-wrap';}?>">
                    <div class="main <?php if($arianna_layout == 'no-sidebar') {echo 'post-without-sidebar';}?>">
                        <div class="singletop">
    						<div class="post-cat">
    							<?php echo arianna_get_category_link($ariannaPostID);?>
    						</div>					
                            <h3 class="post-title">
    							<?php 
    								echo get_the_title();
    							?>
        					</h3>     
                            <div class="post-meta clear-fix">      
                                <div class="post-author">
                                    <span class="avatar">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <?php the_author_posts_link();?>                            
                                </div>                                                
                                <div class="date">
                                    <span><i class="fa fa-clock-o"></i></span>
                                    <a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')); ?>">
                    				    <?php echo get_the_date(); ?>
                                    </a>
                    			</div>		
                                <div class="meta-comment">
                        			<span><i class="fa fa-comments-o"></i></span>
                        			<a href="<?php echo (get_permalink($ariannaPostID).'#comments');?>"><?php echo get_comments_number($ariannaPostID)?></a>
                        		</div>				   
                    		</div>   
                        </div>
                        <?php if(($arianna_layout != 'feat-fw') && ($arianna_layout != 'no-sidebar')) {?>
                        <?php echo arianna_post_format_display($ariannaPostID, $arianna_layout);?>
                        <?php }?>
                        <div class="article-content">
                            <?php if(isset($reviewPos) && ($reviewPos != 'below')) {?>
                            <?php echo arianna_post_review_boxes($ariannaPostID, $reviewPos);?>
                            <?php }?>
                            <?php echo arianna_single_content($ariannaPostID);?>
                            <?php if(isset($reviewPos) && ($reviewPos == 'below')) {?>
                            <?php echo arianna_post_review_boxes($ariannaPostID, $reviewPos);?>
                            <?php }?>
                        </div>
                        <?php 
                            wp_link_pages( array(
    							'before' => '<div class="post-page-links">',
    							'pagelink' => '<span>%</span>',
    							'after' => '</div>',
    						)
    					 );?>
    <!-- TAGS -->
                        <?php
                			$tags = get_the_tags();
                            if ($tags): 
                                echo arianna_single_tags($tags);
                            endif; 
                        ?>
    <!-- SHARE BOX -->
                        <?php if ($share_box) {?>                                                                    
                            <?php echo arianna_share_box($ariannaPostID, $social_share);?>
                        <?php }?>
    <!-- NAV -->
                        <?php
                        if($postnav_sw) {   
                            $next_post = get_next_post();
                            $prev_post = get_previous_post();
                            if (!empty($prev_post) || !empty($next_post)): ?> 
                                <?php echo arianna_single_post_nav($next_post, $prev_post);?>
                            <?php endif; ?>
                        <?php }?>
    <!-- AUTHOR BOX -->
                        <?php $arianna_author_id = $post->post_author;?>
                        <?php if ($authorbox_sw) {?>
                        <?php
                            echo arianna_author_details($arianna_author_id);
                        ?>
                        <?php }?>
                        <?php echo arianna_get_article_info(get_the_ID(), $arianna_author_id);?>
    <!-- RELATED POST -->
                        <?php if ($related_sw){?>  
                            <div class="related-box">
                                <?php $arianna_related_num = 2; echo (arianna_related_posts($arianna_related_num));?>
                            </div>
                        <?php }?>
    <!-- COMMENT BOX -->
                        <?php if($comment_sw  && (comments_open())) {?>
                            <div class="comment-box clear-fix">
                                <?php comments_template(); ?>
                            </div> <!-- End Comment Box -->
                        <?php }?>
                    </div>
                    <!-- Sidebar -->
                    <?php if ($arianna_layout != 'no-sidebar') {?>
                        <?php get_sidebar(); ?>        
                    <?php }?>
                </div>
            </div>
        </div>
<?php endwhile; endif; ?>    
        

<?php get_footer();?>