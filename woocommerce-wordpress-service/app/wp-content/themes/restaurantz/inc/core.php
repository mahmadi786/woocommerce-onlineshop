<?php
/**
 * Core functions.
 *
 * @package Restaurantz
 */

/**
 * Get theme option.
 *
 * @since 1.0.0
 *
 * @param string $key Option key.
 * @return mixed Option value.
 */
function restaurantz_get_option( $key = '' ) {

	global $restaurantz_default_options;
	if ( empty( $key ) ) {
		return;
	}

	$default = ( isset( $restaurantz_default_options[ $key ] ) ) ? $restaurantz_default_options[ $key ] : '';
	$theme_options = get_theme_mod( 'theme_options', $restaurantz_default_options );
	$theme_options = array_merge( $restaurantz_default_options, $theme_options );
	$value = '';
	if ( isset( $theme_options[ $key ] ) ) {
		$value = $theme_options[ $key ];
	}
	return $value;

}

/**
 * Get all theme options.
 *
 * @since 1.0.0
 *
 * @return array Theme options.
 */
function restaurantz_get_options() {

	$value = array();
	$value = get_theme_mod( 'theme_options' );
	return $value;

}
