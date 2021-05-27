<?php
/**
 * Common helper functions.
 *
 * @package Restaurantz
 */

if ( ! function_exists( 'restaurantz_the_excerpt' ) ) :

	/**
	 * Generate excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param int     $length Excerpt length in words.
	 * @param WP_Post $post_obj WP_Post instance (Optional).
	 * @return string Excerpt.
	 */
	function restaurantz_the_excerpt( $length = 40, $post_obj = null ) {

		global $post;
		if ( is_null( $post_obj ) ) {
			$post_obj = $post;
		}
		$length = absint( $length );
		if ( $length < 1 ) {
			$length = 40;
		}
		$source_content = $post_obj->post_content;
		if ( ! empty( $post_obj->post_excerpt ) ) {
			$source_content = $post_obj->post_excerpt;
		}
		$source_content = preg_replace( '`\[[^\]]*\]`', '', $source_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '...' );
		return $trimmed_content;

	}

endif;

if ( ! function_exists( 'restaurantz_simple_breadcrumb' ) ) :

	/**
	 * Simple breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_simple_breadcrumb() {

		if ( ! function_exists( 'breadcrumb_trail' ) ) {
			require_once get_template_directory() . '/lib/breadcrumbs/breadcrumbs.php';
		}

		$breadcrumb_args = array(
			'container'   => 'div',
			'show_browse' => false,
		);
		breadcrumb_trail( $breadcrumb_args );

	}

endif;

if ( ! function_exists( 'restaurantz_fonts_url' ) ) :

	/**
	 * Return fonts URL.
	 *
	 * @since 1.0.0
	 * @return string Font URL.
	 */
	function restaurantz_fonts_url() {

		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Tangerine, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Tangerine font: on or off', 'restaurantz' ) ) {
			$fonts[] = 'Tangerine:400,700';
		}

		/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'restaurantz' ) ) {
			$fonts[] = 'Open Sans:300,400,400i,600,600i,700,700i';
		}

		/* translators: If there are characters in your language that are not supported by Oswald, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Oswald font: on or off', 'restaurantz' ) ) {
			$fonts[] = 'Oswald:300,400,600,700';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), '//fonts.googleapis.com/css' );
		}

		return $fonts_url;

	}

endif;

if ( ! function_exists( 'restaurantz_get_sidebar_options' ) ) :

	/**
	 * Get sidebar options.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_get_sidebar_options() {

		global $wp_registered_sidebars;

		$output = array();

		if ( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ) {
			foreach ( $wp_registered_sidebars as $key => $sidebar ) {
				$output[ $key ] = $sidebar['name'];
			}
		}

		return $output;

	}

endif;

if ( ! function_exists( 'restaurantz_get_index_page_id' ) ) :

	/**
	 * Get front index page ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $type Type.
	 * @return int Corresponding Page ID.
	 */
	function restaurantz_get_index_page_id( $type = 'front' ) {

		$page = '';

		switch ( $type ) {
			case 'front':
				$page = get_option( 'page_on_front' );
				break;

			case 'blog':
				$page = get_option( 'page_for_posts' );
				break;

			default:
				break;
		}
		$page = absint( $page );
		return $page;

	}
endif;

if ( ! function_exists( 'restaurantz_content_is_pagebuilder' ) ) :

	/**
	 * SiteOrigin Page Builder Content Check.
	 *
	 * Conditionally check if the current page/post was created with
	 * the SiteOrigin Page Builder editor.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if builder page.
	 */
	function restaurantz_content_is_pagebuilder() {
		global $post;

		// Consider empty content the WP editor.
		if ( empty( $post ) ) {
			return false;
		}

		// Does pagebuilder content exist in custom fields?
		$panels_data = get_post_meta( $post->ID, 'panels_data', true );

		return ( empty( $panels_data ) ) ? false : true;
	}

endif;

if ( ! function_exists( 'restaurantz_the_custom_logo' ) ) :

	/**
	 * Render logo.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_the_custom_logo() {

		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}

	}

endif;
