<?php
/**
 * Default Theme Option.
 *
 * @since   finedine 1.0
 * @package finedine
 */

/**
 * Add theme options for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function finedine_customize_register_theme_option( $wp_customize ) {

	/** Add selective part pencil tool */
	require get_template_directory() . '/customizer/inc/selective-part.php';

	// General Setting - Panel.
	$wp_customize->add_panel( 'finedine_theme_option_panel', array(
		'priority'       => 2,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __( 'Theme Options', 'finedine' ),
		'description'    => __( 'Theme Option is packed full of theme setting, styles of your website, including header options, featured slider, testimonial and reviews, social media and so much more.', 'finedine' ),
	) );

}

add_action( 'customize_register', 'finedine_customize_register_theme_option' );
