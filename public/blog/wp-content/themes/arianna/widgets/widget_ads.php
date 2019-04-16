<?php
/**
 * Plugin Name: Arianna: Ads Widget
 * Plugin URI: http://demo.alonsa.info/arianna/
 * Description: Displays ads in any section.
 * Version: 1.0
 * Author: Arianna
 * Author URI: http://demo.alonsa.info/arianna/author/arianna
 *
 */
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'arianna_register_ads_widget');

function arianna_register_ads_widget(){
	register_widget('arianna_ads_widget');
}

class arianna_ads_widget extends WP_Widget {
            
/**
 * Widget setup.
 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget-ads', 'description' => __('Displays Ads in any section.', 'arianna') );

		/* Create the widget. */
		parent::__construct('widget-ads', __('*arianna: Widget Ads', 'arianna'), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title'] );
		echo ($before_widget);
        if ( $title ) {?>
                <?php echo ($before_title . esc_html($title) . $after_title);?>
        <?php }
		?>
        <div class="ads-wrap">
			<a class="ads-link" target="_blank" href="<?php echo esc_attr( $instance['linkurl'] ); ?>">
				<img class="ads" src="<?php echo esc_attr( $instance['imgurl'] ); ?>" alt="">
			</a>
        </div>
		<?php

		echo ($after_widget);
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, $this->default );
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['imgurl'] = strip_tags( $new_instance['imgurl'] );
		$instance['linkurl'] = strip_tags( $new_instance['linkurl'] );

		return $instance;
	}

	function form( $instance ) {
        $defaults = array('title' => __('Ads','arianna'), 'imgurl' => 'http://', 'linkurl' => 'http://');
		$instance = wp_parse_args((array) $instance, $defaults);

		$imgurl = strip_tags( $instance['imgurl'] );
		$linkurl = strip_tags( $instance['linkurl'] );
?>
		<!-- Ads Image URL -->
        <p>
			<label for="<?php echo ($this->get_field_id( 'title' )); ?>"><strong><?php esc_html_e('Title:', 'arianna'); ?></strong></label>
			<input type="text" id="<?php echo ($this->get_field_id('title')); ?>" name="<?php echo ($this->get_field_name('title')); ?>" value="<?php echo ($instance['title']); ?>" class="widget-option" />
		</p>
        
        
		<p>
			<label for="<?php echo ($this->get_field_id('imgurl')); ?>"><?php esc_html_e('Ads Image Url:','arianna'); ?></label>
			<input class="widefat" id="<?php echo ($this->get_field_id('imgurl')); ?>" name="<?php echo ($this->get_field_name('imgurl')); ?>" type="text" value="<?php echo esc_attr($imgurl); ?>" />
		</p>

		<!-- link url -->
		<p>
			<label for="<?php echo ($this->get_field_id('linkurl')); ?>"><?php esc_html_e('Link Url:','arianna'); ?></label>
			<input class="widefat" id="<?php echo ($this->get_field_id('linkurl')); ?>" name="<?php echo ($this->get_field_name('linkurl')); ?>" type="text" value="<?php echo esc_attr($linkurl); ?>" />
		</p>
<?php
	}
}
