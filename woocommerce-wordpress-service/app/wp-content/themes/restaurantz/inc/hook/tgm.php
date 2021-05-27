<?php
/**
 * Recommended plugins.
 *
 * @package Restaurantz
 */

add_action( 'tgmpa_register', 'restaurantz_activate_recommended_plugins' );

/**
 * Register recommended plugins.
 *
 * @since 1.0.0
 */
function restaurantz_activate_recommended_plugins() {

	$plugins = array(

		array(
			'name'     => __( 'Page Builder by SiteOrigin', 'restaurantz' ),
			'slug'     => 'siteorigin-panels',
			'required' => false,
		),
		array(
			'name'     => __( 'Jetpack', 'restaurantz' ),
			'slug'     => 'jetpack',
			'required' => false,
		),
		array(
			'name'     => __( 'SiteOrigin Widgets Bundle', 'restaurantz' ),
			'slug'     => 'so-widgets-bundle',
			'required' => false,
		),
		array(
			'name'     => __( 'Open Table Widget', 'restaurantz' ),
			'slug'     => 'open-table-widget',
			'required' => false,
		),
	);

	$config = array();

	tgmpa( $plugins, $config );

}
