<?php
/**
 * Plugin Name: Arianna: Video Post Slider Widget
 * Plugin URI: http://demo.alonsa.info/arianna/
 * Description: Video posts slider widget in sidebar
 * Version: 1.0
 * Author: Arianna
 * Author URI: http://demo.alonsa.info/arianna/author/arianna
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'arianna_register_video_widget');

function arianna_register_video_widget(){
	register_widget('arianna_video');
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */ 
class arianna_video extends WP_Widget {
	
	/**
	 * Widget setup.
	 */
	function __construct(){
		/* Widget settings. */	
		$widget_ops = array('classname' => 'widget-video', 'description' => esc_html__('[Sidebar widget] Displays a video post list slider in sidebar.', 'arianna'));
		
		/* Create the widget. */
		parent::__construct('arianna_video', esc_html__('*arianna: Widget Video','arianna'), $widget_ops);
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
                'tax_query' => array(
                        array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array('post-format-video')
                        )
                    )
                );  
        } else if ($cat_id[0] == 'all'){ 
      		    $args = array(
    				'post_status' => 'publish',
    				'ignore_sticky_posts' => 1,
    				'posts_per_page' => $entries_display,
                    'tax_query' => array( array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array('post-format-video')
                        ) )
                );
        } else {
		$args = array(
				'category__in' => $cat_id,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $entries_display,
                'tax_query' => array( array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-video')
                    ) )
                );
        }
        
        $query = new WP_Query( $args );
        if ( !($query -> have_posts()) ) return;
        echo $before_widget; 
        if ( $title ) {
            echo $before_title .esc_html($title). $after_title;
        }
        ?>
			<div class="slider-wrap flexslider">
				<ul class="slides">
					<?php $query = new WP_Query( $args ); ?>
					<?php while($query->have_posts()): $query->the_post(); $post_id = get_the_ID(); ?>				
                            <li <?php post_class('type-in'); ?>>
                                <div class="thumb hide-thumb">									
                                    <?php echo (arianna_get_thumbnail($post_id, 'arianna_570_570'));?>
                                    <a href="<?php the_permalink() ?>">
                                        <span class="post-format-icon"></span> 
                                    </a>
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
                                </div>
							
							</li>	
                        																				
					<?php endwhile; ?>
				</ul>
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
		$defaults = array('title' => '', 'category' => 'feat', 'entries_display' => 5);
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