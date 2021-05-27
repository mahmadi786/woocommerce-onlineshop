<?php
/**
 * Default theme options.
 *
 * @package Restaurantz
 */

if ( ! function_exists( 'restaurantz_get_default_theme_options' ) ) :

	/**
	 * Get default theme options
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function restaurantz_get_default_theme_options() {

		$defaults = array();

		// Header.
		$defaults['show_title']   = true;
		$defaults['show_tagline'] = true;

		// Layout.
		$defaults['global_layout']           = 'right-sidebar';
		$defaults['archive_layout']          = 'excerpt';
		$defaults['archive_image']           = 'large';
		$defaults['archive_image_alignment'] = 'center';
		$defaults['single_image']            = 'large';

		// Pagination.
		$defaults['pagination_type'] = 'default';

		// Footer.
		$defaults['footer_background_image'] = get_template_directory_uri() . '/images/footer-widget-bg.jpg';
		$defaults['copyright_text']          = esc_html__( 'Copyright &copy; All rights reserved.', 'restaurantz' );

		// Breadcrumb.
		$defaults['breadcrumb_type'] = 'simple';

		// Pass through filter.
		$defaults = apply_filters( 'restaurantz_filter_default_theme_options', $defaults );
		return $defaults;
	}

endif;
