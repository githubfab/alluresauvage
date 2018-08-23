<?php
// General Customizer Settings

// Add section
$wp_customize->add_section( 'laurel_new_section_page' , array(
	'title'      => esc_html__( 'Page Settings', 'laurel' ),
	'priority'   => 97,
) );

// Add Settings
$wp_customize->add_setting(
	'laurel_page_title',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_page_share',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);

// Add Control
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'page_title',
		array(
			'label'      => esc_html__( 'Hide Page Title', 'laurel' ),
			'section'    => 'laurel_new_section_page',
			'settings'   => 'laurel_page_title',
			'type'		 => 'checkbox',
			'priority'	 => 1
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'page_share',
		array(
			'label'      => esc_html__( 'Hide Page Share', 'laurel' ),
			'section'    => 'laurel_new_section_page',
			'settings'   => 'laurel_page_share',
			'type'		 => 'checkbox',
			'priority'	 => 1
		)
	)
);