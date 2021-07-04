<?php
/**
 * Default Theme Option.
 *
 * @since   finedine 1.0
 * @package finedine
 */

/**
 * Remove default unwanted setting for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function finedine_customize_register_default( $wp_customize ) {

	/** Default Settings */
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_section( 'title_tagline' )->description = __( 'Recommended logo width size is 200 pixels.', 'finedine' );
	$wp_customize->get_setting( 'site_icon' )->description     = __( 'Recommended logo width size is 200 pixels.', 'finedine' );
	$wp_customize->get_section( 'colors' )->description        = __( 'In Finedine you can set the background colour and Header Text Colour of your site to customize your theme better to suit your business.', 'finedine' );
	$wp_customize->get_section( 'header_image' )->description  = __( 'Click "Add new image" to upload an image file from your computer. Your theme works best with an image with a header size of 1366 x 400 pixels - you will be able to crop your image once you upload it for a perfect fit.', 'finedine' );

	/** Add selective part pencil tool here */
	require get_template_directory() . '/customizer/inc/selective-part.php';

}

add_action( 'customize_register', 'finedine_customize_register_default' );
