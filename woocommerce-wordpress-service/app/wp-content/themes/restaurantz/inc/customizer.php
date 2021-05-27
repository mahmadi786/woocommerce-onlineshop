<?php
/**
 * Theme Customizer.
 *
 * @package Restaurantz
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function restaurantz_customize_register( $wp_customize ) {

	// Load custom controls.
	require get_template_directory() . '/inc/customizer/control.php';

	// Load customize helpers.
	require get_template_directory() . '/inc/helper/options.php';

	// Load customize sanitize.
	require get_template_directory() . '/inc/customizer/sanitize.php';

	// Load customize callback.
	require get_template_directory() . '/inc/customizer/callback.php';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// Load customize option.
	require get_template_directory() . '/inc/customizer/option.php';

	// Register custom section types.
	$wp_customize->register_section_type( 'Restaurantz_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new Restaurantz_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'Restaurantz Pro', 'restaurantz' ),
				'pro_text' => esc_html__( 'Buy Pro', 'restaurantz' ),
				'pro_url'  => 'https://themepalace.com/downloads/restaurantz-pro/',
				'priority'  => 1,
			)
		)
	);

}
add_action( 'customize_register', 'restaurantz_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since 1.0.0
 */
function restaurantz_customize_preview_js() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'restaurantz-customizer', get_template_directory_uri() . '/js/customizer' . $min . '.js', array( 'customize-preview' ), '1.1', true );

}
add_action( 'customize_preview_init', 'restaurantz_customize_preview_js' );

/**
 * Load styles for Customizer.
 *
 * @since 1.0.0
 */
function restaurantz_load_customizer_styles() {

	global $pagenow;

	if ( 'customize.php' === $pagenow ) {

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_style( 'restaurantz-customizer-style', get_template_directory_uri() . '/css/customizer' . $min . '.css', false, '1.4.0' );

	}

}

add_action( 'admin_enqueue_scripts', 'restaurantz_load_customizer_styles' );

/**
 * Customizer control scripts and styles.
 *
 * @since 1.4.0
 */
function restaurantz_customizer_control_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'restaurantz-customize-controls', get_template_directory_uri() . '/js/customize-controls' . $min . '.js', array( 'customize-controls' ) );

	wp_enqueue_style( 'restaurantz-customize-controls', get_template_directory_uri() . '/css/customize-controls' . $min . '.css' );

}

add_action( 'customize_controls_enqueue_scripts', 'restaurantz_customizer_control_scripts', 0 );
