<?php
/**
 * Plugin Name: Arianna: Social Widget
 * Plugin URI: http://demo.alonsa.info/arianna/
 * Description: Displays social widget in sidebar or footer.
 * Version: 1.0
 * Author: Arianna
 * Author URI: http://demo.alonsa.info/arianna/author/arianna
 *
 */
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'arianna_register_social_widget');

function arianna_register_social_widget(){
	register_widget('arianna_social_widget');
}

class arianna_social_widget extends WP_Widget {
    
/**
 * Widget setup.
 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget-social', 'description' => esc_html__('Displays social widget in sidebar or footer.', 'arianna') );

		/* Create the widget. */
		parent::__construct( 'arianna_social_widget', esc_html__('*arianna: Widget Social', 'arianna'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title'] );
        $fburl = strip_tags( $instance['fburl'] );
        $twurl = strip_tags( $instance['twurl'] );
        $gpurl = strip_tags( $instance['gpurl'] );
        $liurl = strip_tags( $instance['liurl'] );
        $piurl = strip_tags( $instance['piurl'] );
        $insurl = strip_tags( $instance['insurl'] );
        $driurl = strip_tags( $instance['driurl'] );
        $yourl = strip_tags( $instance['yourl'] );
        $viurl = strip_tags( $instance['viurl'] );
        $vkurl = strip_tags( $instance['vkurl'] );
        $rssurl = strip_tags( $instance['rssurl'] );
		echo ($before_widget);
        if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo ($before_title . esc_html($title) . $after_title);?>
            </div>
        <?php }?>
            <div class="social-wrapper">
    			<ul class="clearfix">
					<?php if ($fburl){ ?>
						<li class="social-icon fb"><a href="<?php echo esc_url($fburl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<?php } ?>
					
					<?php if ($twurl){ ?>
						<li class="social-icon twitter"><a href="<?php echo esc_url($twurl); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
					<?php } ?>
					
					<?php if ($gpurl){ ?>
						<li class="social-icon gplus"><a href="<?php echo esc_url($gpurl); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
					<?php } ?>
					
					<?php if ($liurl){ ?>
						<li class="social-icon linkedin"><a href="<?php echo esc_url($liurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
					<?php } ?>
					
					<?php if ($piurl){ ?>
						<li class="social-icon pinterest"><a href="<?php echo esc_url($piurl); ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
					<?php } ?>
					
					<?php if ($insurl){ ?>
						<li class="social-icon instagram"><a href="<?php echo esc_url($insurl); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
					<?php } ?>
					
					<?php if ($driurl){ ?>
						<li class="social-icon dribbble"><a href="<?php echo esc_url($driurl); ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li>
					<?php } ?>
					
					<?php if ($yourl){ ?>
						<li class="social-icon youtube"><a href="<?php echo esc_url($yourl); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
					<?php } ?>      							
					                                    
                    <?php if ($viurl){ ?>
						<li class="social-icon vimeo"><a href="<?php echo esc_url($viurl); ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>
					<?php } ?>
                    
                    <?php if ($vkurl){ ?>
						<li class="social-icon vk"><a href="<?php echo esc_url($vkurl); ?>" target="_blank"><i class="fa fa-vk"></i></a></li>
					<?php } ?>
                    
                    <?php if ($rssurl){ ?>
						<li class="social-icon rss"><a href="<?php echo esc_url($rssurl); ?>" target="_blank"><i class="fa fa-rss"></i></a></li>
					<?php } ?>                    						
				</ul>
            </div>
		<?php

		echo ($after_widget);
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, $this->default );
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['fburl'] = strip_tags( $new_instance['fburl'] );
        $instance['twurl'] = strip_tags( $new_instance['twurl'] );
        $instance['gpurl'] = strip_tags( $new_instance['gpurl'] );
        $instance['liurl'] = strip_tags( $new_instance['liurl'] );
        $instance['piurl'] = strip_tags( $new_instance['piurl'] );
        $instance['insurl']= strip_tags( $new_instance['insurl'] );
        $instance['driurl']= strip_tags( $new_instance['driurl'] );
        $instance['yourl'] = strip_tags( $new_instance['yourl'] );
        $instance['viurl'] = strip_tags( $new_instance['viurl'] );
        $instance['vkurl'] = strip_tags( $new_instance['vkurl'] );
        $instance['rssurl']= strip_tags( $new_instance['rssurl'] );


		return $instance;
	}

	function form( $instance ) {
        $defaults = array('title' => esc_html__('Follow us', 'arianna'), 'fburl' => '', 'twurl' => '', 'gpurl' => '', 'liurl' => '', 'piurl' => '', 
                            'insurl' => '', 'driurl' => '', 'yourl' => '', 'viurl' => '', 'vkurl' => '', 'rssurl' => '');
		$instance = wp_parse_args((array) $instance, $defaults);

		$fburl = strip_tags( $instance['fburl'] );
        $twurl = strip_tags( $instance['twurl'] );
        $gpurl = strip_tags( $instance['gpurl'] );
        $liurl = strip_tags( $instance['liurl'] );
        $piurl = strip_tags( $instance['piurl'] );
        $insurl = strip_tags( $instance['insurl'] );
        $driurl = strip_tags( $instance['driurl'] );
        $yourl = strip_tags( $instance['yourl'] );
        $viurl = strip_tags( $instance['viurl'] );
        $vkurl = strip_tags( $instance['vkurl'] );
        $rssurl = strip_tags( $instance['rssurl'] );
?>
		<!-- Ads Image URL -->
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php esc_html_e('Title:', 'arianna'); ?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" class="widget-option" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- Facebook url -->
		<p>
			<label for="<?php echo $this->get_field_id('fburl'); ?>"><?php esc_html_e('Facebook Url:', 'arianna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('fburl'); ?>" name="<?php echo $this->get_field_name('fburl'); ?>" type="text" value="<?php echo esc_attr($fburl); ?>" />
		</p>
        
        <!-- Twitter url -->
		<p>
			<label for="<?php echo $this->get_field_id('twurl'); ?>"><?php esc_html_e('Twitter Url:', 'arianna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twurl'); ?>" name="<?php echo $this->get_field_name('twurl'); ?>" type="text" value="<?php echo esc_attr($twurl); ?>" />
		</p>
        
        <!-- Google Plus url -->
		<p>
			<label for="<?php echo $this->get_field_id('gpurl'); ?>"><?php esc_html_e('Google Plus Url:', 'arianna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('gpurl'); ?>" name="<?php echo $this->get_field_name('gpurl'); ?>" type="text" value="<?php echo esc_attr($gpurl); ?>" />
		</p>
        
        <!-- Linkedin url -->
		<p>
			<label for="<?php echo $this->get_field_id('liurl'); ?>"><?php esc_html_e('Linkedin Url:', 'arianna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('liurl'); ?>" name="<?php echo $this->get_field_name('liurl'); ?>" type="text" value="<?php echo esc_attr($liurl); ?>" />
		</p>
        
        <!-- Pinterest url -->
		<p>
			<label for="<?php echo $this->get_field_id('piurl'); ?>"><?php esc_html_e('Pinterest Url:', 'arianna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('piurl'); ?>" name="<?php echo $this->get_field_name('piurl'); ?>" type="text" value="<?php echo esc_attr($piurl); ?>" />
		</p>
        
        <!-- Instagram url -->
		<p>
			<label for="<?php echo $this->get_field_id('insurl'); ?>"><?php esc_html_e('Instagram Url:', 'arianna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('insurl'); ?>" name="<?php echo $this->get_field_name('insurl'); ?>" type="text" value="<?php echo esc_attr($insurl); ?>" />
		</p>

        <!-- Dribbble url -->
		<p>
			<label for="<?php echo $this->get_field_id('driurl'); ?>"><?php esc_html_e('Dribbble Url:', 'arianna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('driurl'); ?>" name="<?php echo $this->get_field_name('driurl'); ?>" type="text" value="<?php echo esc_attr($driurl); ?>" />
		</p>

        <!-- Youtube url -->
		<p>
			<label for="<?php echo $this->get_field_id('yourl'); ?>"><?php esc_html_e('Youtube Url:', 'arianna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('yourl'); ?>" name="<?php echo $this->get_field_name('yourl'); ?>" type="text" value="<?php echo esc_attr($yourl); ?>" />
		</p>

        <!-- Vimeo url -->
		<p>
			<label for="<?php echo $this->get_field_id('viurl'); ?>"><?php esc_html_e('Vimeo Url:', 'arianna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('viurl'); ?>" name="<?php echo $this->get_field_name('viurl'); ?>" type="text" value="<?php echo esc_attr($viurl); ?>" />
		</p>

        <!-- VKontakte url -->
		<p>
			<label for="<?php echo $this->get_field_id('vkurl'); ?>"><?php esc_html_e('VKontakte Url:', 'arianna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('vkurl'); ?>" name="<?php echo $this->get_field_name('vkurl'); ?>" type="text" value="<?php echo esc_attr($vkurl); ?>" />
		</p>
        
        <!-- RSS url -->
		<p>
			<label for="<?php echo $this->get_field_id('rssurl'); ?>"><?php esc_html_e('RSS Url:', 'arianna'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('rssurl'); ?>" name="<?php echo $this->get_field_name('rssurl'); ?>" type="text" value="<?php echo esc_attr($rssurl); ?>" />
		</p>
<?php
	}
}
