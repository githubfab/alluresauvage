<?php
// WooCommerce Customizer Settings

// Add section
$wp_customize->add_section( 'laurel_new_section_woo' , array(
	'title'      => esc_html__( 'WooCommerce Settings', 'laurel' ),
	'description'=> esc_html__( 'WooCommerce theme related settings.', 'laurel' ),
	'priority'   => 100,
) );

// Add Settings

$wp_customize->add_setting(
	'laurel_woo_cart_icon',
	array(
		'default'     => false,
		'sanitize_callback'     => 'laurel_sanitize_checkbox'
	)
);
$wp_customize->add_setting(
	'laurel_woo_layout',
	array(
		'default'     => 'fullwidth',
		'sanitize_callback'     => 'wp_kses_post'
	)
);
$wp_customize->add_setting(
	'laurel_woo_per_page',
	array(
		'default'     => 9,
		'sanitize_callback'     => 'laurel_sanitize_number'
	)
);

// Add Control

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woo_cart_icon',
		array(
			'label'      => esc_html__( 'Hide Cart Icon in Header', 'laurel' ),
			'section'    => 'laurel_new_section_woo',
			'settings'   => 'laurel_woo_cart_icon',
			'type'		 => 'checkbox',
			'priority'	 => 1
		)
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woo_layout',
		array(
			'label'          => esc_html__( 'Shop Page Layout', 'laurel' ),
			'section'        => 'laurel_new_section_woo',
			'settings'       => 'laurel_woo_layout',
			'type'           => 'radio',
			'priority'	 => 2,
			'choices'        => array(
				'sidebar'   => esc_html__( 'Sidebar Layout', 'laurel' ),
				'fullwidth'  => esc_html__( 'Full Width Layout', 'laurel' ),
			)
		)
	)
);

$wp_customize->add_control(
	new Customize_NumberMax_Control(
		$wp_customize,
		'woo_per_page',
		array(
			'label'      => esc_html__( 'Products Per Page', 'laurel' ),
			'section'    => 'laurel_new_section_woo',
			'settings'   => 'laurel_woo_per_page',
			'type'		 => 'numbermax',
			'priority'	 => 3
		)
	)
);