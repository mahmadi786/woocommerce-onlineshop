<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package finedine_Theme_Starter
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function finedine_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}

add_action( 'wp_head', 'finedine_pingback_header' );

/**
 * Recommended plugins
 */
function finedine_register_required_plugins() {

	$plugins = array(

		array(
			'name' => esc_html__( 'Contact Form 7', 'finedine' ),
			'slug' => 'contact-form-7',
		),

		array(
			'name' => esc_html__( 'One click demo import', 'finedine' ),
			'slug' => 'one-click-demo-import',
		),
	);
	tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'finedine_register_required_plugins' );
