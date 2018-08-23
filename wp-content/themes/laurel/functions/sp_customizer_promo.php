<?php
// Header Customizer Settings

// Add section
$wp_customize->add_section( 'laurel_new_section_promo' , array(
	'title'      => esc_html__( 'Promo Box Settings', 'laurel' ),
	'priority'   => 94,
) );

// Add Settings
$wp_customize->add_setting(
	'laurel_promo',
	array(
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_promo1_title',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_promo1_image',
	array(
		'sanitize_callback'     => 'esc_url_raw'
	)
);
$wp_customize->add_setting(
	'laurel_promo1_url',
	array(
		'sanitize_callback'     => 'esc_url_raw'
	)
);
$wp_customize->add_setting(
	'laurel_promo2_title',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_promo2_image',
	array(
		'sanitize_callback'     => 'esc_url_raw'
	)
);
$wp_customize->add_setting(
	'laurel_promo2_url',
	array(
		'sanitize_callback'     => 'esc_url_raw'
	)
);
$wp_customize->add_setting(
	'laurel_promo3_title',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_promo3_image',
	array(
		'sanitize_callback'     => 'esc_url_raw'
	)
);
$wp_customize->add_setting(
	'laurel_promo3_url',
	array(
		'sanitize_callback'     => 'esc_url_raw'
	)
);

// Add Control
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'promo',
		array(
			'label'      => esc_html__( 'Enable Promo Boxes', 'laurel' ),
			'section'    => 'laurel_new_section_promo',
			'settings'   => 'laurel_promo',
			'type'		 => 'checkbox',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'promo1_title',
		array(
			'label'      => esc_html__( 'Promo Box #1 Title', 'laurel' ),
			'section'    => 'laurel_new_section_promo',
			'settings'   => 'laurel_promo1_title',
			'type'		 => 'text',
			'priority'	 => 2
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'promo1_image',
		array(
			'label'      => esc_html__( 'Promo Box #1 Image', 'laurel' ),
			'section'    => 'laurel_new_section_promo',
			'settings'   => 'laurel_promo1_image',
			'priority'	 => 3
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'promo1_url',
		array(
			'label'      => esc_html__( 'Promo Box #1 URL', 'laurel' ),
			'section'    => 'laurel_new_section_promo',
			'settings'   => 'laurel_promo1_url',
			'type'		 => 'text',
			'priority'	 => 4
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'promo2_title',
		array(
			'label'      => esc_html__( 'Promo Box #2 Title', 'laurel' ),
			'section'    => 'laurel_new_section_promo',
			'settings'   => 'laurel_promo2_title',
			'type'		 => 'text',
			'priority'	 => 5
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'promo2_image',
		array(
			'label'      => esc_html__( 'Promo Box #2 Image', 'laurel' ),
			'section'    => 'laurel_new_section_promo',
			'settings'   => 'laurel_promo2_image',
			'priority'	 => 6
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'promo2_url',
		array(
			'label'      => esc_html__( 'Promo Box #2 URL', 'laurel' ),
			'section'    => 'laurel_new_section_promo',
			'settings'   => 'laurel_promo2_url',
			'type'		 => 'text',
			'priority'	 => 7
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'promo3_title',
		array(
			'label'      => esc_html__( 'Promo Box #3 Title', 'laurel' ),
			'section'    => 'laurel_new_section_promo',
			'settings'   => 'laurel_promo3_title',
			'type'		 => 'text',
			'priority'	 => 8
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'promo3_image',
		array(
			'label'      => esc_html__( 'Promo Box #3 Image', 'laurel' ),
			'section'    => 'laurel_new_section_promo',
			'settings'   => 'laurel_promo3_image',
			'priority'	 => 9
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'promo3_url',
		array(
			'label'      => esc_html__( 'Promo Box #3 URL', 'laurel' ),
			'section'    => 'laurel_new_section_promo',
			'settings'   => 'laurel_promo3_url',
			'type'		 => 'text',
			'priority'	 => 10
		)
	)
);