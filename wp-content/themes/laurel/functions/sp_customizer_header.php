<?php
// Header Customizer Settings

// Add section
$wp_customize->add_section( 'laurel_new_section_logo_header' , array(
	'title'      => esc_html__( 'Header & Logo Settings', 'laurel' ),
	'priority'   => 91,
) );

// Add Settings
$wp_customize->add_setting(
	'laurel_logo',
	array(
		'sanitize_callback'     => 'esc_url_raw'
	)
);
$wp_customize->add_setting(
	'laurel_logo_width',
	array(
		'default'     => '100',
		'sanitize_callback'     => 'laurel_sanitize_number'
	)
);
$wp_customize->add_setting(
	'laurel_text_logo',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_secondary_header',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_secondary_header_top',
	array(
		'default'     => '52',
		'sanitize_callback'     => 'laurel_sanitize_number'
	)
);
$wp_customize->add_setting(
	'laurel_secondary_header_bottom',
	array(
		'default'     => '60',
		'sanitize_callback'     => 'laurel_sanitize_number'
	)
);

$wp_customize->add_setting(
	'laurel_text_logo_size',
	array(
		'default'     => '26',
		'sanitize_callback'     => 'laurel_sanitize_number'
	)
);
$wp_customize->add_setting(
	'laurel_text_logo_weight',
	array(
		'default'     => 'normal',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_text_logo_color',
	array(
		'default'     => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_setting(
	'laurel_header_hide_social',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);

$wp_customize->add_setting(
	'laurel_header_hide_search',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);

// Add Control
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'upload_logo',
		array(
			'label'      => esc_html__( 'Upload Logo', 'laurel' ),
			'section'    => 'laurel_new_section_logo_header',
			'settings'   => 'laurel_logo',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new Customize_NumberMax_Control(
		$wp_customize,
		'logo_width',
		array(
			'label'      => esc_html__( 'Logo Max Width in %', 'laurel' ),
			'section'    => 'laurel_new_section_logo_header',
			'settings'   => 'laurel_logo_width',
			'type'		 => 'numbermax',
			'priority'	 => 3
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'secondary_header',
		array(
			'label'      => esc_html__( 'Use Secondary Header Layout', 'laurel' ),
			'description' => 'Display the logo below the top bar',
			'section'    => 'laurel_new_section_logo_header',
			'settings'   => 'laurel_secondary_header',
			'type'		 => 'checkbox',
			'priority'	 => 5
		)
	)
);

$wp_customize->add_control(
	new Customize_Number_Control(
		$wp_customize,
		'secondary_header_top',
		array(
			'label'      => esc_html__( 'Secondary Header Logo Padding Top', 'laurel' ),
			'section'    => 'laurel_new_section_logo_header',
			'settings'   => 'laurel_secondary_header_top',
			'type'		 => 'number',
			'priority'	 => 6
		)
	)
);
$wp_customize->add_control(
	new Customize_Number_Control(
		$wp_customize,
		'secondary_header_bottom',
		array(
			'label'      => esc_html__( 'Secondary Header Logo Padding Bottom', 'laurel' ),
			'section'    => 'laurel_new_section_logo_header',
			'settings'   => 'laurel_secondary_header_bottom',
			'type'		 => 'number',
			'priority'	 => 7
		)
	)
);


$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'text_logo',
		array(
			'label'      => esc_html__( 'Use Text Logo', 'laurel' ),
			'description' => 'Enter your site title under the Site Identity tab.',
			'section'    => 'laurel_new_section_logo_header',
			'settings'   => 'laurel_text_logo',
			'type'		 => 'checkbox',
			'priority'	 => 8
		)
	)
);
$wp_customize->add_control(
	new Customize_NumberMax_Control(
		$wp_customize,
		'text_logo_size',
		array(
			'label'      => esc_html__( 'Text Logo Size (px)', 'laurel' ),
			'section'    => 'laurel_new_section_logo_header',
			'settings'   => 'laurel_text_logo_size',
			'type'		 => 'numbermax',
			'priority'	 => 9
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'text_logo_weight',
		array(
			'label'          => esc_html__( 'Text Logo Font Weight', 'laurel' ),
			'section'        => 'laurel_new_section_logo_header',
			'settings'       => 'laurel_text_logo_weight',
			'type'           => 'radio',
			'priority'	 => 10,
			'choices'        => array(
				'normal'   => esc_html__( 'Normal', 'laurel' ),
				'bold'  => esc_html__( 'Bold', 'laurel' ),
			)
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'text_logo_color',
		array(
			'label'      => esc_html__( 'Text Logo Color', 'laurel' ),
			'section'    => 'laurel_new_section_logo_header',
			'settings'   => 'laurel_text_logo_color',
			'priority'	 => 11
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'header_hide_social',
		array(
			'label'      => esc_html__( 'Hide Social Icons', 'laurel' ),
			'section'    => 'laurel_new_section_logo_header',
			'settings'   => 'laurel_header_hide_social',
			'type'		 => 'checkbox',
			'priority'	 => 12
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'header_hide_search',
		array(
			'label'      => esc_html__( 'Hide Search Icon', 'laurel' ),
			'section'    => 'laurel_new_section_logo_header',
			'settings'   => 'laurel_header_hide_search',
			'type'		 => 'checkbox',
			'priority'	 => 13
		)
	)
);