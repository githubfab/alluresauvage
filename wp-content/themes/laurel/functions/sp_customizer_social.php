<?php
// Social Media Customizer Settings

// Add section
$wp_customize->add_section( 'laurel_new_section_social' , array(
	'title'      => esc_html__( 'Social Media Settings', 'laurel' ),
	'description'=> 'Enter your social media usernames (not full URL). Icons will not show if left blank.',
	'priority'   => 95,
) );

// Add Settings
$wp_customize->add_setting(
	'laurel_facebook',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_twitter',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_instagram',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_pinterest',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_tumblr',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_bloglovin',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_tumblr',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_google',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_youtube',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_dribbble',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_soundcloud',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_vimeo',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_linkedin',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_snapchat',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_rss',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);

// Add Control
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'facebook',
		array(
			'label'      => esc_html__( 'Facebook', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_facebook',
			'type'		 => 'text',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'twitter',
		array(
			'label'      => esc_html__( 'Twitter', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_twitter',
			'type'		 => 'text',
			'priority'	 => 2
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'instagram',
		array(
			'label'      => esc_html__( 'Instagram', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_instagram',
			'type'		 => 'text',
			'priority'	 => 3
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'pinterest',
		array(
			'label'      => esc_html__( 'Pinterest', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_pinterest',
			'type'		 => 'text',
			'priority'	 => 4
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'bloglovin',
		array(
			'label'      => esc_html__( 'Bloglovin', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_bloglovin',
			'type'		 => 'text',
			'priority'	 => 5
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'google',
		array(
			'label'      => esc_html__( 'Google Plus', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_google',
			'type'		 => 'text',
			'priority'	 => 6
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'tumblr',
		array(
			'label'      => esc_html__( 'Tumblr', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_tumblr',
			'type'		 => 'text',
			'priority'	 => 7
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'youtube',
		array(
			'label'      => esc_html__( 'Youtube', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_youtube',
			'type'		 => 'text',
			'priority'	 => 8
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'dribbble',
		array(
			'label'      => esc_html__( 'Dribbble', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_dribbble',
			'type'		 => 'text',
			'priority'	 => 9
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'soundcloud',
		array(
			'label'      => esc_html__( 'Soundcloud', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_soundcloud',
			'type'		 => 'text',
			'priority'	 => 10
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'vimeo',
		array(
			'label'      => esc_html__( 'Vimeo', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_vimeo',
			'type'		 => 'text',
			'priority'	 => 11
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'linkedin',
		array(
			'label'      => esc_html__( 'Linkedin (Use full URL to your Linkedin profile)', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_linkedin',
			'type'		 => 'text',
			'priority'	 => 12
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'snapchat',
		array(
			'label'      => esc_html__( 'Snapchat', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_snapchat',
			'type'		 => 'text',
			'priority'	 => 13
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'rss',
		array(
			'label'      => esc_html__( 'RSS Link', 'laurel' ),
			'section'    => 'laurel_new_section_social',
			'settings'   => 'laurel_rss',
			'type'		 => 'text',
			'priority'	 => 14
		)
	)
);
