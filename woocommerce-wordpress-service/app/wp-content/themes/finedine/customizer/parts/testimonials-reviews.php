<?php
/**
 * Testimonial Options
 *
 * @since   finedine 1.0
 * @package finedine
 **/

function finedine_customize_register_testimonial( $wp_customize ) {

	$defaults = finedine_get_option_defaults();
	// Testimonial - Section.
	$wp_customize->add_section( 'finedine_testimonnial_section',
		array(
			'title'    => __( 'Testimonial & Reviews', 'finedine' ),
			'priority' => 4,
			'panel'    => 'finedine_theme_option_panel',
		)
	);

	// Feature slider  - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[select_testimonial_pagelist]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_select',
			'default'           => '',
		)
	);

	// get the default category list.
	$default_post_list = array();
	$categories        = get_categories();
	foreach ( $categories as $category ) {

		$default_post_list[ $category->cat_ID ] = esc_attr( $category->name ) . ' (' . esc_attr( $category->count ) . ')';

	}

	$wp_customize->add_control( 'finedine_theme_settings[select_testimonial_pagelist]',
		array(
			'label'       => __( 'Default Category Lists', 'finedine' ),
			'description' => __( 'Select category to show as testimonial and reviews.', 'finedine' ),
			'section'     => 'finedine_testimonnial_section',
			'choices'     => $default_post_list,
			'priority'    => 3,
			'type'        => 'select',
		)
	);

	// Testimonial image hide.
	$wp_customize->add_setting( 'finedine_theme_settings[testimonial_image_hide]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'default'           => $defaults['testimonial_image_hide'],
			'sanitize_callback' => 'finedine_sanitize_select',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[testimonial_image_hide]',
		array(
			'label'       => __( 'Testimonial Image ', 'finedine' ),
			'description' => esc_html__( 'Hide or show testimonial image', 'finedine' ),
			'section'     => 'finedine_testimonnial_section',
			'priority'    => 4,
			'type'        => 'select',
			'capability'  => 'manage_options',
			'choices'     => array(
				0 => __( 'Hide', 'finedine' ),
				1 => __( 'Show', 'finedine' ),
			),
		)
	);


	// Testimonial  - Title Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[section_testimonial_title]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
			'default'           => '',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[section_testimonial_title]',
		array(
			'label'    => __( 'Section Title', 'finedine' ),
			'section'  => 'finedine_testimonnial_section',
			'settings' => 'finedine_theme_settings[section_testimonial_title]',
			'priority' => 2,
			'type'     => 'text',
		)
	);

	// Testimonial slider count.
	$wp_customize->add_setting( 'finedine_theme_settings[testimonial_slider_count]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
			'default'           => $defaults['testimonial_slider_count'],
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[testimonial_slider_count]',
		array(
			'label'    => __( 'Slider Limit', 'finedine' ),
			'section'  => 'finedine_testimonnial_section',
			'settings' => 'finedine_theme_settings[testimonial_slider_count]',
			'priority' => 6,
			'type'     => 'text',
		)
	);


}

add_action( 'customize_register', 'finedine_customize_register_testimonial' );
