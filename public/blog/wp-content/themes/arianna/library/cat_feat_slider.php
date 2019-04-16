<?php
    $arianna_option = arianna_global_var_declare('arianna_option');

	$entries_display = 5;
    $cat_id = $wp_query->get_queried_object_id();        
        
    $args = array(
		'post__in'  => get_option( 'sticky_posts' ),
        'cat' => $cat_id,
		'post_status' => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page' => $entries_display,
    );
    ?>


    <?php $query = new WP_Query( $args ); ?>
    <?php if($query->have_posts()):?>
		<div class="widget-slider arianna_category-slider">
            <div class="slider-wrap flexslider" >
				<ul class="slides">
					<?php $query = new WP_Query( $args ); ?>
					<?php while($query->have_posts()): $query->the_post(); $post_id = get_the_ID(); ?>				
                            <li class="type-in">
                                <div class="thumb hide-thumb">									
                                    <?php echo (arianna_get_thumbnail($post_id, 'arianna_1000_600'));?>		
                                    <?php 
                                        echo arianna_review_score($post_id);
                                    ?> 
                                </div>															
								<div class="post-info">
                                    <div class="post-cat">                                                 
                                    <?php
                                        $category = get_the_category( $post_id );
                                        $cat_link = get_category_link( get_cat_ID($category[0]->cat_name));
                                        echo '<a href="'; echo esc_url($cat_link); echo '">';
                                        echo esc_attr($category[0]->cat_name);
                                        echo '</a>';
                                    ?>                                           
                                    </div>								
									<h4 class="post-title">
										<a href="<?php the_permalink() ?>">
											<?php 
    											$title = get_the_title();
    											echo arianna_the_excerpt_limit($title, 12);
    										?>
										</a>
									</h4>
                                    
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
                                			<a href="<?php echo (get_permalink($post_id).'#comments');?>"><?php echo get_comments_number($post_id)?></a>
                                		</div>				   
                            		</div>
                                </div>
							
							</li>	
                        																				
					<?php endwhile; ?>
				</ul>
			</div>
        </div>
    <?php endif; ?>