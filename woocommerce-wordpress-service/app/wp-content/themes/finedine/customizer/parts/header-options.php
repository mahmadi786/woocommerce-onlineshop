<?php
/**
 * Header Options
 *
 * @since   finedine 1.0
 * @package finedine
 */

function finedine_customize_register_header( $wp_customize ) {

	$defaults = finedine_get_option_defaults();
	// header Option - Section.
	$wp_customize->add_section( 'header_section',
		array(
			'title'          => __( 'Header Options', 'finedine' ),
			'theme_supports' => 'custom-header',
			'priority'       => 2,
			'panel'          => 'finedine_theme_option_panel',
			'description'    => __( "If you don't want to show content in the Header Section, you can leave the fields blank in the template.", 'finedine' ),
		)
	);

	// left text - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_header_left_text]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_header_left_text]',
		array(
			'type'     => 'text',
			'label'    => __( 'Left Text', 'finedine' ),
			'section'  => 'header_section',
			'priority' => 2,
		)
	);

	// Right text - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_header_right_text]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_header_right_text]',
		array(
			'type'     => 'text',
			'label'    => __( 'Right Text', 'finedine' ),
			'section'  => 'header_section',
			'priority' => 4,
		)
	);

	// middle text - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_header_middle_text]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
		)
	);
	$wp_customize->add_control( 'finedine_theme_settings[finedine_header_middle_text]',
		array(
			'type'     => 'text',
			'label'    => __( 'Middle Text', 'finedine' ),
			'section'  => 'header_section',
			'priority' => 3,
		)
	);

	// reservation text - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_header_reservation_text]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
			'default'           => $defaults['finedine_header_reservation_text'],
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_header_reservation_text]',
		array(
			'type'     => 'text',
			'label'    => __( 'Button Text', 'finedine' ),
			'section'  => 'header_section',
			'priority' => 5,
		)
	);

	// reservation URL - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_header_reservation_url]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => $defaults['finedine_header_reservation_url'],
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_header_reservation_url]',
		array(
			'type'        => 'text',
			'label'       => __( 'Button URL', 'finedine' ),
			'description' => __( 'If you want to link to the Reservation Section in the footer section, please use "/#reservation-block". To link to a different page enter the full URL ( https:// )for the page.', 'finedine' ),
			'section'     => 'header_section',
			'priority'    => 6,
		)
	);

}

add_action( 'customize_register', 'finedine_customize_register_header' );
