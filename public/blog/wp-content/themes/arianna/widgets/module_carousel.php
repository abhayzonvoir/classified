<?php
/**
 * Plugin Name: Arianna: Carousel Module
 * Plugin URI: http://demo.alonsa.info/arianna/
 * Description: This module display posts in carousel
 * Version: 1.0
 * Author: Arianna
 * Author URI: http://demo.alonsa.info/arianna/author/arianna
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'arianna_register_carousel_module');

function arianna_register_carousel_module(){
	register_widget('arianna_carousel');
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */ 
class arianna_carousel extends WP_Widget {
	
	/**
	 * Widget setup.
	 */
	function __construct(){
		/* Widget settings. */	
		$widget_ops = array('classname' => 'module-carousel', 'description' => esc_html__('[Full-width module] Display a carousel in full-width section.','arianna'));
		
		/* Create the widget. */
		parent::__construct('arianna_carousel', esc_html__('*arianna: Module Carousel', 'arianna'), $widget_ops);
	}
	
	/**
	 * display the widget on the screen.
	 */
	function widget($args, $instance){
        $arianna_option = arianna_global_var_declare('arianna_option');
		extract($args);
        $title = apply_filters('widget_title', $instance['title'] );
        $entries_display = esc_attr($instance['entries_display']);
		$cat_id = $instance['category'];
        if ($cat_id[0] == 'feat') {    
            $args = array(
				'post__in'  => get_option( 'sticky_posts' ),
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $entries_display,
                );  
        } else if ($cat_id[0] == 'all'){ 
      		    $args = array(
    				'post_status' => 'publish',
    				'ignore_sticky_posts' => 1,
    				'posts_per_page' => $entries_display,
                );
        } else {
		$args = array(
				'category__in' => $cat_id,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $entries_display,
                );
        }
        
        $query = new WP_Query( $args );
        if ( !($query -> have_posts()) ) return;
        echo $before_widget; 
        if ( $title ) {
            echo $before_title .esc_html($title). $after_title;
        }
        ?>	
        <div class="arianna_carousel-container">		
            <div class="arianna_carousel-wrap flexslider clear-fix">            
				<ul class="slides">
					<?php while($query->have_posts()): $query->the_post(); $post_id = get_the_ID(); ?>						
                        <li <?php post_class('type-out'); ?>>
							<div class="thumb hide-thumb">
								<a href="<?php echo get_permalink( $post_id );?>">								
									<?php echo (arianna_get_thumbnail($post_id, 'arianna_570_380'));?>
								</a>
								<a href="<?php echo get_permalink( $post_id );?>">
									<span class="post-format-icon"></span> 
								</a>
							</div>
                            <div class="post-details">  
                                <div class="post-cat">                                                 
                                    <?php echo arianna_get_category_link($post_id);?>                                      
                                </div>                       	
								<h3 class="post-title">
									<a href="<?php the_permalink() ?>">
										<?php 
											$arianna_title = get_the_title();
											echo arianna_the_excerpt_limit($arianna_title, 10);
										?>
									</a>
								</h3>
                                <div class="post-meta">
    								<div class="post-author">
    									<span class="avatar">
    										By
    									</span>
    									<?php the_author_posts_link();?>                            
    								</div>
                                    <div class="date">
                        				<?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?>
                        			</div>
                                </div>
                                <div class="entry-excerpt">
                                    <?php 
                                        $string = get_the_excerpt();
                                        echo arianna_the_excerpt_limit($string, 10); 
                                    ?>
                                </div>
                            </div> 
						</li>																
					<?php endwhile; ?>
				</ul>	
             </div>	
        </div>	
		<?php
		echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance){
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = $new_instance['category'];
        $instance['entries_display'] = $new_instance['entries_display'];
  
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */	
	function form($instance){
        $widget_cat_id = $this->get_field_id( 'category' );
		$defaults = array('title' => '', 'category' => 'feat', 'entries_display' => 8);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<!-- Title: Text Input -->     
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php esc_attr_e('Title: ', 'arianna'); ?></strong></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widget-option" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

        <!-- Categories
        --------------------------------------------->
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><strong><?php esc_attr_e('Post Source:', 'arianna'); ?></strong></label> 
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>[]" class="widget-option widefat categories tn-category-field" size="5" multiple='multiple' >
				<option value='feat'><?php esc_attr_e( 'Featured Posts', 'arianna' ); ?></option>
                <option value='all'><?php esc_attr_e( 'All Categories', 'arianna' ); ?></option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>'><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>
        
        
		<p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><strong><?php esc_attr_e('Number of entries to display (Min 4 entries)', 'arianna'); ?></strong></label>
		<input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" class="widget-option" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo $instance['entries_display']; ?>" /></p>
       
        <script>
        jQuery(document).ready(function($){
                <?php
                    $cat_array = json_encode($instance['category']);
                    echo "var instant = ". $cat_array . ";\n";
                ?>
                var status = 0;
                var widget_cat_id = "<?php echo $widget_cat_id; ?>";
                $("#"+widget_cat_id).find("option").each(function(){
                    $this = $(this);
                    if (($(instant).length == 0) && ($this.attr('value') == 'all')) {
                        $this.attr('selected','selected');
                        return false;
                    }
                    $(instant).each(function(index, value){
                        if(value == $this.attr('value')){
                            $this.attr('selected','selected');
                        }
                    });
                    if ((($this.attr('value') == 'feat') || ($this.attr('value') == 'all')) && ($this.is(':selected'))){
                        return false;
                    }
                });

        });
        </script>
	<?php }
}
?>