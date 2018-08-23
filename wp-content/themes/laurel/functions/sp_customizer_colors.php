<?php
// General Customizer Settings

// Add section
$wp_customize->add_section( 'laurel_new_section_custom_css' , array(
	'title'      => esc_html__( 'Custom CSS', 'laurel' ),
	'description'=> esc_html__( 'Add your custom CSS which will overwrite the theme CSS', 'laurel' ),
	'priority'   => 98,
) );

$wp_customize->add_panel( 'panel_color', array(
	'priority'       => 97,
	'capability'     => 'edit_theme_options',
	'title'          => esc_html__( 'Color and Style Settings', 'laurel' ),
) );

	$wp_customize->add_section( 'laurel_new_section_color_background' , array(
		'title'      => esc_html__( 'Background Color/Image', 'laurel' ),
		'description'=> '',
		'priority'   => 1,
		'panel'  => 'panel_color',
	) );
	
	$wp_customize->add_section( 'laurel_new_section_color_wrapper' , array(
		'title'      => esc_html__( 'Wrapper Shadow', 'laurel' ),
		'description'=> '',
		'priority'   => 2,
		'panel'  => 'panel_color',
	) );
	
	$wp_customize->add_section( 'laurel_new_section_color_header' , array(
		'title'      => esc_html__( 'Header Colors', 'laurel' ),
		'description'=> '',
		'priority'   => 3,
		'panel'  => 'panel_color',
	) );
	$wp_customize->add_section( 'laurel_new_section_color_secondary_header' , array(
		'title'      => esc_html__( 'Secondary Header Layout Colors', 'laurel' ),
		'description'=> '',
		'priority'   => 4,
		'panel'  => 'panel_color',
	) );
	
	$wp_customize->add_section( 'laurel_new_section_color_mobile_menu' , array(
		'title'      => esc_html__( 'Mobile Menu Colors', 'laurel' ),
		'description'=> '',
		'priority'   => 5,
		'panel'  => 'panel_color',
	) );
	$wp_customize->add_section( 'laurel_new_section_color_promo' , array(
		'title'      => esc_html__( 'Promo Box Area Colors', 'laurel' ),
		'description'=> '',
		'priority'   => 6,
		'panel'  => 'panel_color',
	) );
	$wp_customize->add_section( 'laurel_new_section_color_sidebar' , array(
		'title'      => esc_html__( 'Sidebar Colors', 'laurel' ),
		'description'=> '',
		'priority'   => 7,
		'panel'  => 'panel_color',
	) );
	$wp_customize->add_section( 'laurel_new_section_color_footer' , array(
		'title'      => esc_html__( 'Footer Colors', 'laurel' ),
		'description'=> '',
		'priority'   => 8,
		'panel'  => 'panel_color',
	) );
	
	$wp_customize->add_section( 'laurel_new_section_color_post' , array(
		'title'      => esc_html__( 'Post Colors', 'laurel' ),
		'description'=> '',
		'priority'   => 9,
		'panel'  => 'panel_color',
	) );
	
	$wp_customize->add_section( 'laurel_new_section_color_newsletter_color' , array(
		'title'      => esc_html__( 'Newsletter Colors', 'laurel' ),
		'description'=> '',
		'priority'   => 10,
		'panel'  => 'panel_color',
	) );
	
	$wp_customize->add_section( 'laurel_new_section_color_misc' , array(
		'title'      => esc_html__( 'MISC Colors', 'laurel' ),
		'description'=> '',
		'priority'   => 11,
		'panel'  => 'panel_color',
	) );

	
// Add Settings

// Background
$wp_customize->add_setting(
	'laurel_bg_color',
	array(
		'default'     => '#F2F2F2',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_bg_image',
	array(
	'sanitize_callback'     => 'esc_url_raw'
	)
);

$wp_customize->add_setting(
	'laurel_bg_repeat',
	array(
		'default'     => 'repeat',
		'sanitize_callback'     => 'wp_kses_post'
	)
);

$wp_customize->add_setting(
	'laurel_bg_size',
	array(
		'default'     => 'auto',
		'sanitize_callback'     => 'wp_kses_post'
	)
);

$wp_customize->add_setting(
	'laurel_bg_position',
	array(
		'default'     => 'center center',
		'sanitize_callback'     => 'wp_kses_post'
	)
);

$wp_customize->add_setting(
	'laurel_bg_attachment',
	array(
		'default'     => 'scroll',
		'sanitize_callback'     => 'wp_kses_post'
	)
);

// Wrapper Shadow
$wp_customize->add_setting(
	'laurel_wrapper_color',
	array(
		'default'     => '#C8C8C8',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_wrapper_opacity',
	array(
		'default'     => '0.14',
		'sanitize_callback'     => 'laurel_sanitize_number',
	)
);

// Header
$wp_customize->add_setting(
	'laurel_header_bg_color',
	array(
		'default'     => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_setting(
	'laurel_menu_color',
	array(
		'default'     => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_menu_color_hover',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_menu_dropdown_arrow',
	array(
		'default'     => '#c5c5c5',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_setting(
	'laurel_menu_dropdown_bg',
	array(
		'default'     => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_menu_dropdown_border',
	array(
		'default'     => '#eeeeee',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_menu_dropdown_text_color',
	array(
		'default'     => '#333333',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_menu_dropdown_text_hover_bg',
	array(
		'default'     => '#f7f7f7',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_menu_dropdown_text_hover_color',
	array(
		'default'     => '#333333',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_setting(
	'laurel_header_social_color',
	array(
		'default'     => '#111111',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_header_social_color_hover',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_header_search_icon',
	array(
		'default'     => '#111111',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_header_search_icon_hover',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_header_search_input_bg',
	array(
		'default'     => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_header_search_input_text',
	array(
		'default'     => '#a5a5a5',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_header_search_input_close',
	array(
		'default'     => '#111111',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_header_search_input_close_hover',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

// Secondary Header Layout
$wp_customize->add_setting(
	'laurel_2header_bg_color',
	array(
		'default'     => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_2header_bg_image',
	array(
	'sanitize_callback'     => 'esc_url_raw'
	)
);

$wp_customize->add_setting(
	'laurel_2header_bg_repeat',
	array(
		'default'     => 'repeat',
		'sanitize_callback'     => 'wp_kses_post'
	)
);

$wp_customize->add_setting(
	'laurel_2header_bg_size',
	array(
		'default'     => 'auto',
		'sanitize_callback'     => 'wp_kses_post'
	)
);

$wp_customize->add_setting(
	'laurel_2header_bg_position',
	array(
		'default'     => 'center center',
		'sanitize_callback'     => 'wp_kses_post'
	)
);

$wp_customize->add_setting(
	'laurel_2header_bg_attachment',
	array(
		'default'     => 'scroll',
		'sanitize_callback'     => 'wp_kses_post'
	)
);


// Mobile menu
$wp_customize->add_setting(
	'laurel_mobile_show',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_mobile_show_hover',
	array(
		'default'     => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_mobile_burger',
	array(
		'default'     => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_setting(
	'laurel_mobile_dropdown_bg',
	array(
		'default'     => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_mobile_dropdown_border',
	array(
		'default'     => '#eeeeee',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_mobile_dropdown_text',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_mobile_dropdown_text_hover',
	array(
		'default'     => '#333333',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_mobile_dropdown_text_bg_hover',
	array(
		'default'     => '#f7f7f7',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

// Promo Box Area Colors
$wp_customize->add_setting(
	'laurel_promo_color_bg',
	array(
		'default'     => '#f5f5f5',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_promo_color_overlay_bg',
	array(
		'default'     => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_promo_color_overlay_text',
	array(
		'default'     => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

// Sidebar Colors
$wp_customize->add_setting(
	'laurel_sidebar_color_border',
	array(
		'default'     => '#e5e5e5',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_sidebar_color_title',
	array(
		'default'     => '#222222',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_sidebar_social_color',
	array(
		'default'     => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_sidebar_social_color_hover',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

// Footer Colors
$wp_customize->add_setting(
	'laurel_footer_color_social_bg',
	array(
		'default'     => '#f4f4f4',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_footer_color_social_text',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_footer_color_social_text_hover',
	array(
		'default'     => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_footer_color_copy_bg',
	array(
		'default'     => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_footer_color_copy_text',
	array(
		'default'     => '#a5a5a5',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

// Post Colors
$wp_customize->add_setting(
	'laurel_post_color_title',
	array(
		'default'     => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_post_color_cat',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_post_color_text',
	array(
		'default'     => '#444444',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_post_color_text_heading',
	array(
		'default'     => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_post_color_more_bg',
	array(
		'default'     => '#8db392',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_post_color_more_text',
	array(
		'default'     => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_setting(
	'laurel_post_tag_bg',
	array(
		'default'     => '#f2f2f2',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_post_tag_text',
	array(
		'default'     => '#777777',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_post_tag_bg_hover',
	array(
		'default'     => '#8db392',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_post_tag_text_hover',
	array(
		'default'     => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_post_share_color',
	array(
		'default'     => '#aaaaaa',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_post_quote_border',
	array(
		'default'     => '#dddddd',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_post_quote_text',
	array(
		'default'     => '#888888',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);


// Newsletter colors
$wp_customize->add_setting(
	'laurel_newsletter_bg',
	array(
		'default'     => '#f7f7f7',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_newsletter_title',
	array(
		'default'     => '#222222',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_newsletter_text',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_newsletter_input_bg',
	array(
		'default'     => '#fefefe',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_newsletter_input_text',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_newsletter_submit_bg',
	array(
		'default'     => '#8db392',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_newsletter_submit_text',
	array(
		'default'     => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_newsletter_submit_bg_hover',
	array(
		'default'     => '#222222',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_newsletter_submit_text_hover',
	array(
		'default'     => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
			

// MISC Colors
$wp_customize->add_setting(
	'laurel_misc_color_accent',
	array(
		'default'     => '#8db392',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_misc_color_archive_bg',
	array(
		'default'     => '#f6f6f6',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_misc_color_archive_border',
	array(
		'default'     => '#eeeeee',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_misc_color_archive_browsing',
	array(
		'default'     => '#999999',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_setting(
	'laurel_misc_color_archive_title',
	array(
		'default'     => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

// Custom CSS
$wp_customize->add_setting(
	'laurel_custom_css',
	array(
		'sanitize_callback'     => 'wp_kses_post'
	)
);

// Add Control

// Background
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'bg_color',
		array(
			'label'      => esc_html__( 'Background Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_background',
			'settings'   => 'laurel_bg_color',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'bg_image',
		array(
			'label'      => esc_html__( 'Background Image', 'laurel' ),
			'section'    => 'laurel_new_section_color_background',
			'settings'   => 'laurel_bg_image',
			'priority'	 => 2
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'bg_repeat',
		array(
			'label'          => esc_html__( 'Background Repeat', 'laurel' ),
			'section'        => 'laurel_new_section_color_background',
			'settings'       => 'laurel_bg_repeat',
			'type'           => 'select',
			'priority'	 => 3,
			'choices'        => array(
				'repeat'   => esc_html__( 'Repeat', 'laurel' ),
				'no-repeat'  => esc_html__( 'No Repeat', 'laurel' ),
				'repeat-y'  => esc_html__( 'Repeat Y', 'laurel' ),
				'repeat-x'  => esc_html__( 'Repeat X', 'laurel' ),
			)
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'bg_size',
		array(
			'label'          => esc_html__( 'Background Size', 'laurel' ),
			'section'        => 'laurel_new_section_color_background',
			'settings'       => 'laurel_bg_size',
			'type'           => 'select',
			'priority'	 => 5,
			'choices'        => array(
				'auto'   => esc_html__( 'Auto', 'laurel' ),
				'cover'  => esc_html__( 'Cover', 'laurel' ),
				'contain'  => esc_html__( 'Contain', 'laurel' ),
			)
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'bg_position',
		array(
			'label'          => esc_html__( 'Background Position', 'laurel' ),
			'section'        => 'laurel_new_section_color_background',
			'settings'       => 'laurel_bg_position',
			'type'           => 'select',
			'priority'	 => 6,
			'choices'        => array(
				'center center'   => esc_html__( 'Center Center', 'laurel' ),
				'center top'  => esc_html__( 'Center Top', 'laurel' ),
				'center bottom'  => esc_html__( 'Center Bottom', 'laurel' ),
				'right center'  => esc_html__( 'Right Center', 'laurel' ),
				'right top'  => esc_html__( 'Right Top', 'laurel' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'laurel' ),
				'left center'  => esc_html__( 'Left Center', 'laurel' ),
				'left top'  => esc_html__( 'Left Top', 'laurel' ),
				'left bottom'  => esc_html__( 'Left Bottom', 'laurel' ),
			)
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'bg_attachment',
		array(
			'label'          => esc_html__( 'Background Attachment', 'laurel' ),
			'section'        => 'laurel_new_section_color_background',
			'settings'       => 'laurel_bg_attachment',
			'type'           => 'select',
			'priority'	 => 7,
			'choices'        => array(
				'scroll'   => esc_html__( 'Scroll', 'laurel' ),
				'fixed'  => esc_html__( 'Fixed', 'laurel' ),
			)
		)
	)
);

// Wrapper Shadow
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'wrapper_color',
		array(
			'label'      => esc_html__( 'Wrapper Shadow Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_wrapper',
			'settings'   => 'laurel_wrapper_color',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new Customize_Number2_Control(
		$wp_customize,
		'wrapper_opacity',
		array(
			'label'      => esc_html__( 'Wrapper Shadow Opacity', 'laurel' ),
			'section'    => 'laurel_new_section_color_wrapper',
			'settings'   => 'laurel_wrapper_opacity',
			'type'		 => 'number2',
			'priority'	 => 2
		)
	)
);

// Header
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'header_bg_color',
		array(
			'label'      => esc_html__( 'Header BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_header_bg_color',
			'priority'	 => 1
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'menu_color',
		array(
			'label'      => esc_html__( 'Menu Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_menu_color',
			'priority'	 => 2
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'menu_color_hover',
		array(
			'label'      => esc_html__( 'Menu Text Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_menu_color_hover',
			'priority'	 => 3
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'menu_dropdown_arrow',
		array(
			'label'      => esc_html__( 'Menu Dropdown Arrow Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_menu_dropdown_arrow',
			'priority'	 => 4
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'menu_dropdown_bg',
		array(
			'label'      => esc_html__( 'Menu Dropdown BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_menu_dropdown_bg',
			'priority'	 => 5
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'menu_dropdown_border',
		array(
			'label'      => esc_html__( 'Menu Dropdown Border Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_menu_dropdown_border',
			'priority'	 => 6
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'menu_dropdown_text_color',
		array(
			'label'      => esc_html__( 'Menu Dropdown Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_menu_dropdown_text_color',
			'priority'	 => 7
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'menu_dropdown_text_hover_bg',
		array(
			'label'      => esc_html__( 'Menu Dropdown Text Hover BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_menu_dropdown_text_hover_bg',
			'priority'	 => 8
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'menu_dropdown_text_hover_color',
		array(
			'label'      => esc_html__( 'Menu Dropdown Text Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_menu_dropdown_text_hover_color',
			'priority'	 => 9
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'header_social_color',
		array(
			'label'      => esc_html__( 'Header Social Icon Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_header_social_color',
			'priority'	 => 10
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'header_social_color_hover',
		array(
			'label'      => esc_html__( 'Header Social Icon Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_header_social_color_hover',
			'priority'	 => 10
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'header_search_icon',
		array(
			'label'      => esc_html__( 'Header Search Icon Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_header_search_icon',
			'priority'	 => 11
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'header_search_icon_hover',
		array(
			'label'      => esc_html__( 'Header Search Icon Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_header_search_icon_hover',
			'priority'	 => 12
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'header_search_input_bg',
		array(
			'label'      => esc_html__( 'Header Search Input BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_header_search_input_bg',
			'priority'	 => 13
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'header_search_input_text',
		array(
			'label'      => esc_html__( 'Header Search Input Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_header_search_input_text',
			'priority'	 => 14
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'header_search_input_close',
		array(
			'label'      => esc_html__( 'Header Search Close Icon Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_header_search_input_close',
			'priority'	 => 15
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'header_search_input_close_hover',
		array(
			'label'      => esc_html__( 'Header Search Close Icon Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_header',
			'settings'   => 'laurel_header_search_input_close_hover',
			'priority'	 => 16
		)
	)
);

// Secondary Header Colors
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'2header_bg_color',
		array(
			'label'      => esc_html__( 'Background Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_secondary_header',
			'settings'   => 'laurel_2header_bg_color',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'2header_bg_image',
		array(
			'label'      => esc_html__( 'Background Image', 'laurel' ),
			'section'    => 'laurel_new_section_color_secondary_header',
			'settings'   => 'laurel_2header_bg_image',
			'priority'	 => 2
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'2header_bg_repeat',
		array(
			'label'          => esc_html__( 'Background Repeat', 'laurel' ),
			'section'        => 'laurel_new_section_color_secondary_header',
			'settings'       => 'laurel_2header_bg_repeat',
			'type'           => 'select',
			'priority'	 => 3,
			'choices'        => array(
				'repeat'   => esc_html__( 'Repeat', 'laurel' ),
				'no-repeat'  => esc_html__( 'No Repeat', 'laurel' ),
				'repeat-y'  => esc_html__( 'Repeat Y', 'laurel' ),
				'repeat-x'  => esc_html__( 'Repeat X', 'laurel' ),
			)
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'2header_bg_size',
		array(
			'label'          => esc_html__( 'Background Size', 'laurel' ),
			'section'        => 'laurel_new_section_color_secondary_header',
			'settings'       => 'laurel_2header_bg_size',
			'type'           => 'select',
			'priority'	 => 5,
			'choices'        => array(
				'auto'   => esc_html__( 'Auto', 'laurel' ),
				'cover'  => esc_html__( 'Cover', 'laurel' ),
				'contain'  => esc_html__( 'Contain', 'laurel' ),
			)
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'2header_bg_position',
		array(
			'label'          => esc_html__( 'Background Position', 'laurel' ),
			'section'        => 'laurel_new_section_color_secondary_header',
			'settings'       => 'laurel_2header_bg_position',
			'type'           => 'select',
			'priority'	 => 6,
			'choices'        => array(
				'center center'   => esc_html__( 'Center Center', 'laurel' ),
				'center top'  => esc_html__( 'Center Top', 'laurel' ),
				'center bottom'  => esc_html__( 'Center Bottom', 'laurel' ),
				'right center'  => esc_html__( 'Right Center', 'laurel' ),
				'right top'  => esc_html__( 'Right Top', 'laurel' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'laurel' ),
				'left center'  => esc_html__( 'Left Center', 'laurel' ),
				'left top'  => esc_html__( 'Left Top', 'laurel' ),
				'left bottom'  => esc_html__( 'Left Bottom', 'laurel' ),
			)
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'2header_bg_attachment',
		array(
			'label'          => esc_html__( 'Background Attachment', 'laurel' ),
			'section'        => 'laurel_new_section_color_secondary_header',
			'settings'       => 'laurel_2header_bg_attachment',
			'type'           => 'select',
			'priority'	 => 7,
			'choices'        => array(
				'scroll'   => esc_html__( 'Scroll', 'laurel' ),
				'fixed'  => esc_html__( 'Fixed', 'laurel' ),
			)
		)
	)
);


// Mobile menu
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_show',
		array(
			'label'      => esc_html__( 'Show Menu Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_mobile_menu',
			'settings'   => 'laurel_mobile_show',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_show_hover',
		array(
			'label'      => esc_html__( 'Show Menu Text Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_mobile_menu',
			'settings'   => 'laurel_mobile_show_hover',
			'priority'	 => 2
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_burger',
		array(
			'label'      => esc_html__( 'Mobile Menu Toggle Icon Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_mobile_menu',
			'settings'   => 'laurel_mobile_burger',
			'priority'	 => 3
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_dropdown_bg',
		array(
			'label'      => esc_html__( 'Mobile Menu Dropdown BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_mobile_menu',
			'settings'   => 'laurel_mobile_dropdown_bg',
			'priority'	 => 4
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_dropdown_border',
		array(
			'label'      => esc_html__( 'Mobile Menu Dropdown Border Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_mobile_menu',
			'settings'   => 'laurel_mobile_dropdown_border',
			'priority'	 => 5
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_dropdown_text',
		array(
			'label'      => esc_html__( 'Mobile Menu Dropdown Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_mobile_menu',
			'settings'   => 'laurel_mobile_dropdown_text',
			'priority'	 => 6
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_dropdown_text_hover',
		array(
			'label'      => esc_html__( 'Mobile Menu Dropdown Text Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_mobile_menu',
			'settings'   => 'laurel_mobile_dropdown_text_hover',
			'priority'	 => 7
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_dropdown_text_bg_hover',
		array(
			'label'      => esc_html__( 'Mobile Menu Dropdown Text BG Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_mobile_menu',
			'settings'   => 'laurel_mobile_dropdown_text_bg_hover',
			'priority'	 => 8
		)
	)
);

// Promo Box Colors
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'promo_color_bg',
		array(
			'label'      => esc_html__( 'Promo Box Area BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_promo',
			'settings'   => 'laurel_promo_color_bg',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'promo_color_overlay_bg',
		array(
			'label'      => esc_html__( 'Promo Box Area Overlay BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_promo',
			'settings'   => 'laurel_promo_color_overlay_bg',
			'priority'	 => 2
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'promo_color_overlay_text',
		array(
			'label'      => esc_html__( 'Promo Box Area Overlay Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_promo',
			'settings'   => 'laurel_promo_color_overlay_text',
			'priority'	 => 3
		)
	)
);

// Sidebar Colors
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'sidebar_color_border',
		array(
			'label'      => esc_html__( 'Sidebar Widget Border Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_sidebar',
			'settings'   => 'laurel_sidebar_color_border',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'sidebar_color_title',
		array(
			'label'      => esc_html__( 'Sidebar Widget Title Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_sidebar',
			'settings'   => 'laurel_sidebar_color_title',
			'priority'	 => 2
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'sidebar_social_color',
		array(
			'label'      => esc_html__( 'Sidebar Social Widget Icon Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_sidebar',
			'settings'   => 'laurel_sidebar_social_color',
			'priority'	 => 3
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'sidebar_social_color_hover',
		array(
			'label'      => esc_html__( 'Sidebar Social Widget Icon Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_sidebar',
			'settings'   => 'laurel_sidebar_social_color_hover',
			'priority'	 => 3
		)
	)
);

// Footer Colors
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_color_social_bg',
		array(
			'label'      => esc_html__( 'Footer Social BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_footer',
			'settings'   => 'laurel_footer_color_social_bg',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_color_social_text',
		array(
			'label'      => esc_html__( 'Footer Social Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_footer',
			'settings'   => 'laurel_footer_color_social_text',
			'priority'	 => 2
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_color_social_text_hover',
		array(
			'label'      => esc_html__( 'Footer Social Text Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_footer',
			'settings'   => 'laurel_footer_color_social_text_hover',
			'priority'	 => 3
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_color_copy_bg',
		array(
			'label'      => esc_html__( 'Footer Copyright BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_footer',
			'settings'   => 'laurel_footer_color_copy_bg',
			'priority'	 => 4
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_color_copy_text',
		array(
			'label'      => esc_html__( 'Footer Copyright Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_footer',
			'settings'   => 'laurel_footer_color_copy_text',
			'priority'	 => 4
		)
	)
);

// Post Colors
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_color_title',
		array(
			'label'      => esc_html__( 'Post Title Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_color_title',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_color_cat',
		array(
			'label'      => esc_html__( 'Post Category Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_color_cat',
			'priority'	 => 2
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_color_text',
		array(
			'label'      => esc_html__( 'Post Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_color_text',
			'priority'	 => 3
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_color_text_heading',
		array(
			'label'      => esc_html__( 'Post Headings (H1-H6) Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_color_text_heading',
			'priority'	 => 4
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_color_more_bg',
		array(
			'label'      => esc_html__( 'Read More Button BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_color_more_bg',
			'priority'	 => 5
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_color_more_text',
		array(
			'label'      => esc_html__( 'Read More Button Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_color_more_text',
			'priority'	 => 6
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_tag_bg',
		array(
			'label'      => esc_html__( 'Tag BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_tag_bg',
			'priority'	 => 7
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_tag_text',
		array(
			'label'      => esc_html__( 'Tag Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_tag_text',
			'priority'	 => 8
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_tag_bg_hover',
		array(
			'label'      => esc_html__( 'Tag BG Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_tag_bg_hover',
			'priority'	 => 9
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_tag_text_hover',
		array(
			'label'      => esc_html__( 'Tag Text Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_tag_text_hover',
			'priority'	 => 10
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_share_color',
		array(
			'label'      => esc_html__( 'Post Share Icon Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_share_color',
			'priority'	 => 11
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_quote_border',
		array(
			'label'      => esc_html__( 'Blockquote Border Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_quote_border',
			'priority'	 => 12
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'post_quote_text',
		array(
			'label'      => esc_html__( 'Blockquote Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_post',
			'settings'   => 'laurel_post_quote_text',
			'priority'	 => 13
		)
	)
);


// Newsletter Colors
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'newsletter_bg',
		array(
			'label'      => esc_html__( 'Newsletter BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_newsletter_color',
			'settings'   => 'laurel_newsletter_bg',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'newsletter_title',
		array(
			'label'      => esc_html__( 'Newsletter Title Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_newsletter_color',
			'settings'   => 'laurel_newsletter_title',
			'priority'	 => 2
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'newsletter_text',
		array(
			'label'      => esc_html__( 'Newsletter Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_newsletter_color',
			'settings'   => 'laurel_newsletter_text',
			'priority'	 => 3
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'newsletter_input_bg',
		array(
			'label'      => esc_html__( 'Newsletter Input BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_newsletter_color',
			'settings'   => 'laurel_newsletter_input_bg',
			'priority'	 => 4
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'newsletter_input_text',
		array(
			'label'      => esc_html__( 'Newsletter Input Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_newsletter_color',
			'settings'   => 'laurel_newsletter_input_text',
			'priority'	 => 5
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'newsletter_submit_bg',
		array(
			'label'      => esc_html__( 'Newsletter Submit BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_newsletter_color',
			'settings'   => 'laurel_newsletter_submit_bg',
			'priority'	 => 6
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'newsletter_submit_text',
		array(
			'label'      => esc_html__( 'Newsletter Submit Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_newsletter_color',
			'settings'   => 'laurel_newsletter_submit_text',
			'priority'	 => 7
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'newsletter_submit_bg_hover',
		array(
			'label'      => esc_html__( 'Newsletter Submit BG Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_newsletter_color',
			'settings'   => 'laurel_newsletter_submit_bg_hover',
			'priority'	 => 8
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'newsletter_submit_text_hover',
		array(
			'label'      => esc_html__( 'Newsletter Submit Text Hover Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_newsletter_color',
			'settings'   => 'laurel_newsletter_submit_text_hover',
			'priority'	 => 9
		)
	)
);

// MISC Colors
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'misc_color_accent',
		array(
			'label'      => esc_html__( 'Accent Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_misc',
			'settings'   => 'laurel_misc_color_accent',
			'priority'	 => 1
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'misc_color_archive_bg',
		array(
			'label'      => esc_html__( 'Category/Archive Box BG Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_misc',
			'settings'   => 'laurel_misc_color_archive_bg',
			'priority'	 => 2
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'misc_color_archive_border',
		array(
			'label'      => esc_html__( 'Category/Archive Box Border Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_misc',
			'settings'   => 'laurel_misc_color_archive_border',
			'priority'	 => 2
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'misc_color_archive_browsing',
		array(
			'label'      => esc_html__( 'Category/Archive Box Browsing Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_misc',
			'settings'   => 'laurel_misc_color_archive_browsing',
			'priority'	 => 3
		)
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'misc_color_archive_title',
		array(
			'label'      => esc_html__( 'Category/Archive Box Title Text Color', 'laurel' ),
			'section'    => 'laurel_new_section_color_misc',
			'settings'   => 'laurel_misc_color_archive_title',
			'priority'	 => 4
		)
	)
);

// Custom CSS
$wp_customize->add_control(
	new Customize_CustomCss_Control(
		$wp_customize,
		'custom_css',
		array(
			'label'      => esc_html__( 'Custom CSS', 'laurel' ),
			'section'    => 'laurel_new_section_custom_css',
			'settings'   => 'laurel_custom_css',
			'type'		 => 'custom_css',
			'priority'	 => 1
		)
	)
);