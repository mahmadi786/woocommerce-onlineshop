<?php
/**
 * CSS related hooks.
 *
 * This file contains hook functions which are related to CSS.
 *
 * @package Restaurantz
 */

if ( ! function_exists( 'restaurantz_trigger_custom_css_action' ) ) :

	/**
	 * Do action theme custom CSS.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_trigger_custom_css_action() {

		/**
		 * Hook - restaurantz_action_theme_custom_css.
		 */
		do_action( 'restaurantz_action_theme_custom_css' );

	}

endif;

add_action( 'wp_head', 'restaurantz_trigger_custom_css_action', 99 );
