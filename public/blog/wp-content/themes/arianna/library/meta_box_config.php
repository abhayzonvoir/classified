<?php
/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = 'arianna_';

$meta_boxes = array();

// Post Layout Options
$meta_boxes[] = array(
    'id' => "{$prefix}post_fullwidth",
    'title' => esc_html__( 'Arianna Post Option', 'arianna'),
    'pages' => array( 'post' ),
    'context' => 'normal',
    'priority' => 'high',

    'fields' => array(
        array(
			'id' => "{$prefix}post_layout",
            'name' => esc_html__( 'Post Layout Option', 'arianna'),
			'desc' => esc_html__('Setup Post Layout', 'arianna'),
            'type' => 'select', 
			'options'  => array(
                            'standard' => esc_html__( 'Standard', 'arianna'),
                            'feat-fw' => esc_html__( 'Feature Image Full Width', 'arianna'),
                            'no-sidebar' => esc_html__('No Sidebar', 'arianna'), 
    				    ),
			// Select multiple values, optional. Default is false.
			'multiple'    => false,
			'std'         => 'standard',
		),
    )
);
// Page Layout Options
$meta_boxes[] = array(
    'id' => "{$prefix}page_fullwidth",
    'title' => esc_html__( 'Arianna Page Option', 'arianna'),
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',

    'fields' => array(
        // Enable Review
        array(
            'name' => esc_html__( 'Make this page full-width', 'arianna'),
            'id' => "{$prefix}page_fullwidth_checkbox",
            'type' => 'checkbox',
            'std'  => 0,
        ),
    )
);
// 2nd meta box
$meta_boxes[] = array(
    'id' => "{$prefix}format_options",
    'title' => esc_html__( 'Arianna Post Format Options', 'arianna'),
    'pages' => array( 'post' ),
    'context' => 'normal',
    'priority' => 'high',
	'fields' => array(        
        //Video
        array(
            'name' => esc_html__( 'Format Options: Video, Audio', 'arianna'),
            'desc' => esc_html__('Support Youtube, Vimeo, SoundCloud, DailyMotion, ... iframe embed code', 'arianna'),
            'id' => "{$prefix}media_embed_code_post",
            'type' => 'textarea',
            'placeholder' => esc_html__('Link ...', 'arianna'),
            'std' => ''
        ),
		// PLUPLOAD IMAGE UPLOAD (WP 3.3+)
		array(
			'name'             => esc_html__( 'Format Options: Image', 'arianna'),
            'desc'             => esc_html__('Image Upload', 'arianna'),
			'id'               => "{$prefix}image_upload",
			'type'             => 'plupload_image',
			'max_file_uploads' => 1,
		),
        //Gallery
        array(
            'name' => esc_html__( 'Format Options: Gallery', 'arianna'),
            'desc' => esc_html__('Gallery Images', 'arianna'),
            'id' => "{$prefix}gallery_content",
            'type' => 'image_advanced',
            'std' => ''
        )
    )
);

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
if ( ! function_exists( 'arianna_register_meta_boxes' ) ) {
    function arianna_register_meta_boxes() {
    	// Make sure there's no errors when the plugin is deactivated or during upgrade
    	if ( !class_exists( 'RW_Meta_Box' ) )
    		return;
    
    	global $meta_boxes;
    	foreach ( $meta_boxes as $meta_box )
    	{
    		new RW_Meta_Box( $meta_box );
    	}
    }
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'arianna_register_meta_boxes' );
