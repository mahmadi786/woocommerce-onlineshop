<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'restricted access' );
}

/*=======================================================================
 * Extra functions for customizer.
 *=======================================================================*/


/**
 * Finedine sidebar position layout.
 *
 * @return string
 */
function finedine_sidebar_position() {
	$finedine_sidebar_layout = finedine_get_option( 'finedine_sidebar_layout' );
	if ( ( is_front_page() && is_home() ) || is_author() || is_category() || is_tag() || is_404() || is_page() || is_single() || is_archive()
	) {
		if ( ! empty( $finedine_sidebar_layout ) ) {
			return $finedine_sidebar_layout;
		}
	}
}


/**
 * Print sidebar class
 *
 */
function finedine_sidebar_class() {
	// Get the sidebar output from function.
	echo esc_attr( finedine_sidebar_position() );
}


/**
 * Finedine content class
 *
 * @param array $classes
 */
function finedine_content_class( $classes = array() ) {
	$position = finedine_sidebar_position();
	$class    = '';
	if ( 'left' === $position ) {
		$class = 'col-md-9';
	} elseif ( 'right' === $position ) {
		$class = 'col-md-9';
	} else {
		$class = 'col-md-12';
	}
	if ( ! empty( $classes ) ) {
		if ( is_array( $classes ) ) {
			$class .= ' ' . implode( ' ', $classes );
		} else {
			$class .= ' ' . $classes;
		}
	}
	echo esc_html( $class );
}

/**
 * Finedine - Social Media Icons
 *
 * @param $location header / footer
 *
 * @return Social Media Links
 */
function finedine_social_media_icons() {
	global $finedine_settings;
	$finedine_settings = wp_parse_args( get_option( 'finedine_theme_settings', array() ), finedine_get_option_defaults() );

	// New customizer options.
	if ( finedine_get_option( 'finedine_socials_facebook' ) || finedine_get_option( 'finedine_socials_twitter' ) || finedine_get_option( 'finedine_socials_youtube' ) || finedine_get_option( 'finedine_socials_instagram' )
	) {
		$social_arr = array(
			'finedine_socials_facebook'  => 'facebook',
			'finedine_socials_twitter'   => 'twitter',
			'finedine_socials_youtube'   => 'youtube',
			'finedine_socials_instagram' => 'instagram',
		);

		foreach ( $social_arr as $key => $value ) {
			if ( $finedine_settings[ $key ] ) {

				echo '<a href="' . esc_url( $finedine_settings[ $key ] ) . '" target="_blank"
                   class="social-' . esc_attr( $value ) . '">
                    <i class="fab fa-' . esc_attr( $value ) . '"></i> </a>';

			}
		}
	}
}




