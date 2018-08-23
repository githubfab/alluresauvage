<?php
// General Customizer Settings

// Add section
$wp_customize->add_section( 'laurel_new_section_post' , array(
	'title'      => esc_html__( 'Post Settings', 'laurel' ),
	'priority'   => 96,
) );

// Add Settings
$wp_customize->add_setting(
	'laurel_post_layout',
	array(
		'default'     => 'default',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_truefull_height',
	array(
		'default'     => '660',
		'sanitize_callback'     => 'laurel_sanitize_number'
	)
);
$wp_customize->add_setting(
	'laurel_post_thumb',
	array(
		'default'     => 'display',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_post_cat',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_post_date',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_post_share_author',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_post_share',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_post_comment_link',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_post_tags',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_post_share',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_post_author',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_post_related',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_post_pagination_hide',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);

// Add Control
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'post_layout',
		array(
			'label'          => esc_html__( 'Set default post layout', 'laurel' ),
			'section'        => 'laurel_new_section_post',
			'settings'       => 'laurel_post_layout',
			'type'           => 'radio',
			'priority'	 => 1,
			'choices'        => array(
				'default'   => esc_html__( 'Standard Layout', 'laurel' ),
				'container-width'  => esc_html__( 'Full Width Layout', 'laurel' ),
				'default-fullimage'   => esc_html__( 'Standard Layout w/ Full Width Image', 'laurel' ),
				'fullwidth-fullimage'   => esc_html__( 'Full Width Layout w/ Full Width Image', 'laurel' ),
			)
		)
	)
);
$wp_customize->add_control(
	new Customize_Number_Control(
		$wp_customize,
		'truefull_height',
		array(
			'label'      => esc_html__( 'Set default height for Full Width Featured Image', 'laurel' ),
			'section'    => 'laurel_new_section_post',
			'settings'   => 'laurel_truefull_height',
			'type'		 => 'number',
			'priority'	 => 2
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'post_thumb',
		array(
			'label'          => esc_html__( 'Featured Image (On Top of Post)', 'laurel' ),
			'section'        => 'laurel_new_section_post',
			'settings'       => 'laurel_post_thumb',
			'type'           => 'radio',
			'priority'	 => 2,
			'choices'        => array(
				'display'   => esc_html__( 'Display Standard Featured Image', 'laurel' ),
				'no_display'  => esc_html__( 'Hide Standard Featured Image', 'laurel' ),
				'ho_display'  => esc_html__( 'Hide Standard Featured Image only on single post pages', 'laurel' ),
			)
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'post_cat',
		array(
			'label'      => esc_html__( 'Hide Category', 'laurel' ),
			'section'    => 'laurel_new_section_post',
			'settings'   => 'laurel_post_cat',
			'type'		 => 'checkbox',
			'priority'	 => 3
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'post_date',
		array(
			'label'      => esc_html__( 'Hide Date', 'laurel' ),
			'section'    => 'laurel_new_section_post',
			'settings'   => 'laurel_post_date',
			'type'		 => 'checkbox',
			'priority'	 => 4
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'post_share_author',
		array(
			'label'      => esc_html__( 'Hide Author Name', 'laurel' ),
			'section'    => 'laurel_new_section_post',
			'settings'   => 'laurel_post_share_author',
			'type'		 => 'checkbox',
			'priority'	 => 5
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'post_share',
		array(
			'label'      => esc_html__( 'Hide Share Buttons', 'laurel' ),
			'section'    => 'laurel_new_section_post',
			'settings'   => 'laurel_post_share',
			'type'		 => 'checkbox',
			'priority'	 => 6
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'post_comment_link',
		array(
			'label'      => esc_html__( 'Hide Comment Link', 'laurel' ),
			'section'    => 'laurel_new_section_post',
			'settings'   => 'laurel_post_comment_link',
			'type'		 => 'checkbox',
			'priority'	 => 7
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'post_tags',
		array(
			'label'      => esc_html__( 'Hide Tags', 'laurel' ),
			'section'    => 'laurel_new_section_post',
			'settings'   => 'laurel_post_tags',
			'type'		 => 'checkbox',
			'priority'	 => 8
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'post_author',
		array(
			'label'      => esc_html__( 'Hide Author Box', 'laurel' ),
			'section'    => 'laurel_new_section_post',
			'settings'   => 'laurel_post_author',
			'type'		 => 'checkbox',
			'priority'	 => 9
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'post_related',
		array(
			'label'      => esc_html__( 'Hide Related Posts Box', 'laurel' ),
			'section'    => 'laurel_new_section_post',
			'settings'   => 'laurel_post_related',
			'type'		 => 'checkbox',
			'priority'	 => 10
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'post_pagination_hide',
		array(
			'label'      => esc_html__( 'Hide Post Pagination', 'laurel' ),
			'section'    => 'laurel_new_section_post',
			'settings'   => 'laurel_post_pagination_hide',
			'type'		 => 'checkbox',
			'priority'	 => 11
		)
	)
);