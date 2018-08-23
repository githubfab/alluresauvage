<?php
// Header Customizer Settings

// Add section
$wp_customize->add_section( 'laurel_new_section_featured' , array(
	'title'      => esc_html__( 'Featured Area Settings', 'laurel' ),
	'priority'   => 94,
) );

// Add Settings
$wp_customize->add_setting(
	'laurel_featured_slider',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_featured_cat',
	array(
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_featured_id',
	array(
		'default'     => '',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_featured_slider_slides',
	array(
		'default'     => '5',
		'sanitize_callback'     => 'laurel_sanitize_number'
	)
);

// Add Control
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'featured_slider',
		array(
			'label'      => esc_html__( 'Enable Featured Area', 'laurel' ),
			'section'    => 'laurel_new_section_featured',
			'settings'   => 'laurel_featured_slider',
			'type'		 => 'checkbox',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Category_Control(
		$wp_customize,
		'featured_cat',
		array(
			'label'    => esc_html__( 'Select Featured Category', 'laurel' ),
			'settings' => 'laurel_featured_cat',
			'section'  => 'laurel_new_section_featured',
			'priority'	 => 2
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'featured_id',
		array(
			'label'      => esc_html__( 'Select featured post/page IDs', 'laurel' ),
			'section'    => 'laurel_new_section_featured',
			'settings'   => 'laurel_featured_id',
			'type'		 => 'text',
			'priority'	 => 4
		)
	)
);

$wp_customize->add_control(
	new Customize_Number_Control(
		$wp_customize,
		'featured_slider_slides',
		array(
			'label'      => esc_html__( 'Amount of slides', 'laurel' ),
			'section'    => 'laurel_new_section_featured',
			'settings'   => 'laurel_featured_slider_slides',
			'type'		 => 'number',
			'priority'	 => 5
		)
	)
);