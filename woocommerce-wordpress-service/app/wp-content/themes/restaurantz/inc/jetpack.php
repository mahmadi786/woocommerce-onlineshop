<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Restaurantz
 */

/**
 * Add theme support for Jetpack.
 *
 * @since 1.0.0
 */
function restaurantz_jetpack_setup() {

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add support for the Nova CPT (menu items).
	add_theme_support( 'nova_menu_item' );

}
add_action( 'after_setup_theme', 'restaurantz_jetpack_setup' );
