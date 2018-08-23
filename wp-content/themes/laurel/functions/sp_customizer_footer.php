<?php
// General Customizer Settings

// Add section
$wp_customize->add_section( 'laurel_new_section_footer' , array(
	'title'      => esc_html__( 'Footer Settings', 'laurel' ),
	'priority'   => 97,
) );

// Add Settings
$wp_customize->add_setting(
	'laurel_footer_copyright_text',
	array(
		'default'     => esc_html__( 'Copyright 2016 - Solo Pine. All Rights Reserved. Designed & Developed by <a href="http://solopine.com">Solo Pine</a>', 'laurel' ),
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_footer_share',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);

// Add Control
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'footer_copyright_text',
		array(
			'label'      => esc_html__( 'Footer Copyright Text', 'laurel' ),
			'section'    => 'laurel_new_section_footer',
			'settings'   => 'laurel_footer_copyright_text',
			'type'		 => 'text',
			'priority'	 => 1
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'footer_share',
		array(
			'label'      => esc_html__( 'Hide Footer Social Links', 'laurel' ),
			'section'    => 'laurel_new_section_footer',
			'settings'   => 'laurel_footer_share',
			'type'		 => 'checkbox',
			'priority'	 => 2
		)
	)
);