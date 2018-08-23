<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://metabox.io/docs/registering-meta-boxes/
 */
 
add_filter( 'rwmb_meta_boxes', 'laurel_register_meta_boxes' );
function laurel_register_meta_boxes( $meta_boxes )
{
	
	$get_default_fullimage_height = get_theme_mod('laurel_truefull_height') ?: 660;
	
	$prefix = 'laurel_meta_';
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Gallery Post Format Options', 'laurel' ),
		'visible' => array('post_format', '=', 'gallery'),
		'priority'   => 'high',
		'fields' => array(
			array(
				'name'             => esc_html__( 'Select Gallery Images', 'laurel' ),
				'desc'			   => esc_html__( 'Description goes here...', 'laurel' ),
				'id'               => "{$prefix}gallery",
				'type'             => 'image_advanced',
				'max_file_uploads' => 0,
			),
			
		)
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Video Post Format Options', 'laurel' ),
		'visible' => array('post_format', '=', 'video'),
		'priority'   => 'high',
		'fields' => array(
			array(
				'name' => esc_html__( 'Video URL', 'laurel' ),
				'id'   => "{$prefix}oembed",
				'desc' => esc_html__( 'Insert video URL, supports all oembed', 'laurel' ),
				'type' => 'oembed',
			),
			array(
				'name'             => esc_html__( 'Custom Video Background Image', 'laurel' ),
				'desc'			   => esc_html__( 'If you leave this blank, the featured image will be set as the video background image.', 'laurel' ),
				'id'               => "{$prefix}custom_video_bg",
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),
		)
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Audio Post Format Options', 'laurel' ),
		'visible' => array('post_format', '=', 'audio'),
		'priority'   => 'high',
		'fields' => array(
			array(
				'name' => esc_html__( 'Audio URL', 'laurel' ),
				'id'   => "{$prefix}audio_oembed",
				'desc' => esc_html__( 'Insert audio URL, supports all oembed', 'laurel' ),
				'type' => 'oembed',
			),
			array(
				'name'             => esc_html__( 'Custom Audio Background Image', 'laurel' ),
				'desc'			   => esc_html__( 'If you leave this blank, the featured image will be set as the video background image.', 'laurel' ),
				'id'               => "{$prefix}custom_audio_bg",
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),
			array(
				'id'   => 'checkbox',
				'name' => esc_html__( 'Spotify Link', 'laurel' ),
				'id'               => "{$prefix}audio_spotify",
				'type' => 'checkbox',
				'desc' => __( 'Check this option if you are using a Spotify URL', 'laurel' ),
			),
		)
	);
	
	$meta_boxes[] = array(
		'id'         => 'standard',
		'title'      => esc_html__( 'Post Settings', 'laurel' ),
		'post_types' => array( 'post', 'page' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'autosave'   => true,
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Post Layout', 'laurel' ),
				'id'      => "{$prefix}post_layout",
				'type'    => 'image_select',
				'desc'	  => esc_html__('Select a post layout. If "Customizer Default Setting" is selected, the post layout chosen via the Customizer > Post Settings will be selected.', 'laurel'),
				'std' => 'customizer',
				'options' => array(
					'customizer' => get_template_directory_uri() . '/img/admin/' . esc_html__( 'layout-customizer.png', 'laurel' ),
					'default' => get_template_directory_uri() . '/img/admin/' . esc_html__( 'layout-default.png', 'laurel' ),
					'container-width' => get_template_directory_uri() . '/img/admin/' . esc_html__( 'layout-fullwidth.png', 'laurel' ),
					'default-fullimage' => get_template_directory_uri() . '/img/admin/' . esc_html__( 'layout-default-fullimage.png', 'laurel' ),
					'fullwidth-fullimage' => get_template_directory_uri() . '/img/admin/' . esc_html__( 'layout-fullwidth-fullimage.png', 'laurel' ),
				),
				'hidden' => array('post_type', '=', 'page')
			),
			array(
				'name'             => esc_html__( 'Custom Background Image', 'laurel' ),
				'desc'			   => esc_html__( 'If you leave this blank, the featured image will be set as the background image.', 'laurel' ),
				'id'               => "{$prefix}custom_bg_image",
				'class'			   => 'custom_bg_image',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'visible' => array("{$prefix}post_layout", 'in', array('default-fullimage', 'fullwidth-fullimage')),
				'hidden' => array('post_format', 'in', array('gallery', 'video', 'audio'))
			),
			array(
				'name' => esc_html__( 'Featured Image Height (pixels)', 'laurel' ),
				'id'   => "{$prefix}fullimage_height",
				'desc' => esc_html__( 'Set your desired height of the full width featured image.', 'laurel' ),
				'type' => 'number',
				'min'  => 1,
				'std' => $get_default_fullimage_height,
				'step' => 1,
				'visible' => array("{$prefix}post_layout", 'in', array('default-fullimage', 'fullwidth-fullimage'))
			),

			array(
				'name'             => esc_html__( 'Custom Slider Image', 'laurel' ),
				'desc'			   => esc_html__( 'If you leave this blank, the featured image will be set as the slider image.', 'laurel' ),
				'id'               => "{$prefix}custom_slider",
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				
			),
			array(
				'name' => esc_html__( 'Custom Slider Excerpt', 'laurel' ),
				'desc' => esc_html__( 'Custom Slider excerpt text.', 'laurel' ),
				'id'   => "{$prefix}custom_slider_excerpt",
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 2,
			),
		)
	);
	return $meta_boxes;
}

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
		.rwmb-image-select { width:160px; height:140px; padding:0; border-color:#d5d5d5; border-radius:0;}
		.rwmb-label { width:15%; }
		.rwmb-field { border-bottom:1px solid #e8e8e8; padding: 20px 0; }
		.rwmb-field:last-child { border-bottom:none; }
		.rwmb-field.rwmb-number-wrapper, .custom_bg_image { padding: 15px 0 15px 15%; }
    } 
  </style>';
}