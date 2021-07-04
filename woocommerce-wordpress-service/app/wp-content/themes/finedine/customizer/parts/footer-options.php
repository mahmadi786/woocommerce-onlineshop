<?php
/**
 * Footer Options
 *
 * @since   finedine 1.0
 * @package finedine
 */

function finedine_customize_register_footer( $wp_customize ) {
	// Get default values.
	$defaults = finedine_get_option_defaults();

	/** Footer Settings */
	$wp_customize->add_section( 'footer_options',
		array(
			'title'       => __( 'Footer Options', 'finedine' ),
			'description' => __( 'You can customise the footer of your site here.', 'finedine' ),
			'priority'    => 10,
			'panel'       => 'finedine_theme_option_panel',
		)
	);

	// Copyright Text - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_copyright_text]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_copyright_text]',
		array(
			'label'       => __( 'Copyright Text', 'finedine' ),
			'description' => __( 'You can enter your copyright information in the text box below. Please note that you need to check the "Hide Default Copyright Text" box to view your customised Copyright Text.', 'finedine' ),
			'section'     => 'footer_options',
			'priority'    => 2,
			'type'        => 'text',
		)
	);

	// Remove Copyright Text - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_remove_copyright_text]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_checkbox',
			'default'           => $defaults['finedine_remove_copyright_text'],
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_remove_copyright_text]',
		array(
			'label'    => __( 'Hide Default Copyright Text.', 'finedine' ),
			'section'  => 'footer_options',
			'priority' => 3,
			'type'     => 'checkbox',
		)
	);

	// Form title - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_form_title]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
			'default'           => '',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_form_title]',
		array(
			'label'    => __( 'Form Title', 'finedine' ),
			'section'  => 'footer_options',
			'priority' => 4,
			'type'     => 'text',
		)
	);

	// Form shortcode - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_form_shortcode]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
			'default'           => $defaults['finedine_form_shortcode'],
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_form_shortcode]',
		array(
			'label'       => __( 'Form Shortcode', 'finedine' ),
			'section'     => 'footer_options',
			'description' => __( 'Use contact form 7 shortcode', 'finedine' ),
			'priority'    => 5,
			'type'        => 'text',
		)
	);

	// address - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_contact_details_address]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
			'default'           => '',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_contact_details_address]',
		array(
			'label'    => __( 'Contact Address', 'finedine' ),
			'section'  => 'footer_options',
			'priority' => 7,
			'type'     => 'text',
		)
	);

	// Phone setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_contact_details_phone]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
			'default'           => '',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_contact_details_phone]',
		array(
			'label'    => __( 'Phone', 'finedine' ),
			'section'  => 'footer_options',
			'priority' => 8,
			'type'     => 'text',
		)
	);

	// fax setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_contact_details_fax]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_text',
			'default'           => '',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_contact_details_fax]',
		array(
			'label'    => __( 'Fax', 'finedine' ),
			'section'  => 'footer_options',
			'priority' => 9,
			'type'     => 'text',
		)
	);

	// Email setting.
	$wp_customize->add_setting( 'finedine_theme_settings[finedine_contact_details_email]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_email',
			'default'           => '',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[finedine_contact_details_email]',
		array(
			'label'    => __( 'Email', 'finedine' ),
			'section'  => 'footer_options',
			'priority' => 10,
			'type'     => 'text',
		)
	);

	// Hide reservation setting.
	$wp_customize->add_setting( 'finedine_theme_settings[hide_reservation_footer_section]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'default'           => $defaults['hide_reservation_footer_section'],
			'sanitize_callback' => 'finedine_sanitize_select',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[hide_reservation_footer_section]',
		array(
			'label'       => __( 'Hide Reservation?', 'finedine' ),
			'description' => esc_html__( 'It will hide reservation in footer section. Widget can be added.', 'finedine' ),
			'section'     => 'footer_options',
			'priority'    => 3,
			'type'        => 'select',
			'capability'  => 'manage_options',
			'choices'     => array(
				'1' => __( 'Yes', 'finedine' ),
				'0' => __( 'No', 'finedine' ),
			),
		)
	);
	/** Footer Settings Ends */

}

add_action( 'customize_register', 'finedine_customize_register_footer' );
