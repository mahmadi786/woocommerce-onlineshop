<?php
/**
 * Feature Slider Options
 *
 * @since   finedine 1.0
 * @package finedine
 **/


function finedine_customize_register_feature_slider( $wp_customize ) {

	// Get default values.
	$defaults = finedine_get_option_defaults();

	// Blog - Section.
	$wp_customize->add_section( 'finedine_feature_slider_section',
		array(
			'title'    => __( 'Featured Slider', 'finedine' ),
			'priority' => 3,
			'panel'    => 'finedine_theme_option_panel',
		)
	);

	// Feature slider  - Setting.
	$wp_customize->add_setting( 'finedine_theme_settings[select_post_feature_slider]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'sanitize_callback' => 'finedine_sanitize_select',
			'default'           => $defaults['select_post_feature_slider'],
		)
	);

	// Get the default category list.
	$default_post_list = array();
	$categories        = get_categories();
	foreach ( $categories as $category ) {

		$default_post_list[ $category->cat_ID ] = esc_attr( $category->name ) . ' (' . esc_attr( $category->count ) . ')';

	}

	$wp_customize->add_control( 'finedine_theme_settings[select_post_feature_slider]',
		array(
			'label'       => __( 'Default Category Lists with Post Count', 'finedine' ),
			'description' => __( "The Featured Slider in Finedine shows posts based on a category that you have selected from the dropdown list below. For best results, we recommend that the posts have Featured Images set. Please note that you'll need to add the excerpt text to your posts in order for the slider to display the second heading.", 'finedine' ),
			'section'     => 'finedine_feature_slider_section',
			'choices'     => $default_post_list,
			'priority'    => 2,
			'type'        => 'select',
		)
	);


	// Featured slider effect.
	$wp_customize->add_setting( 'finedine_theme_settings[transition_effects]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'default'           => $defaults['transition_effects'],
			'sanitize_callback' => 'finedine_sanitize_select',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[transition_effects]',
		array(
			'label'       => __( 'Transition Effects', 'finedine' ),
			'description' => esc_html__( 'Control transition effect in slider', 'finedine' ),
			'section'     => 'finedine_feature_slider_section',
			'priority'    => 4,
			'type'        => 'select',
			'capability'  => 'manage_options',
			'choices'     => array(
				'1' => __( 'Fade In', 'finedine' ),
				'0' => __( 'Slide In', 'finedine' ),
			),
		)
	);

	// Hide featured slider.
	$wp_customize->add_setting( 'finedine_theme_settings[hide_feature_slider_1]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'default'           => $defaults['hide_feature_slider_1'],
			'sanitize_callback' => 'finedine_sanitize_select',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[hide_feature_slider_1]',
		array(
			'label'       => __( 'Hide Slider ', 'finedine' ),
			'description' => esc_html__( 'Enable to hide slider', 'finedine' ),
			'section'     => 'finedine_feature_slider_section',
			'priority'    => 4,
			'type'        => 'select',
			'capability'  => 'manage_options',
			'choices'     => array(
				'1' => __( 'Enable', 'finedine' ),
				'0' => __( 'Disable', 'finedine' ),
			),
		)
	);

	// Limit featured slider.
	$wp_customize->add_setting( 'finedine_theme_settings[feature_slider_count]',
		array(
			'capability'        => 'manage_options',
			'type'              => 'option',
			'default'           => $defaults['feature_slider_count'],
			'sanitize_callback' => 'finedine_sanitize_text',
		)
	);

	$wp_customize->add_control( 'finedine_theme_settings[feature_slider_count]',
		array(
			'label'       => __( 'Number of slides', 'finedine' ),
			'description' => __( 'You can control the number of slides to be shown here. To show all the posts under your selected category, type -1', 'finedine' ),
			'section'     => 'finedine_feature_slider_section',
			'priority'    => 3,
			'type'        => 'text',
		)
	);

}

add_action( 'customize_register', 'finedine_customize_register_feature_slider' );



