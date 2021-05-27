<?php
/**
 * Helper functions related to customizer and options.
 *
 * @package Restaurantz
 */

if ( ! function_exists( 'restaurantz_get_global_layout_options' ) ) :

	/**
	 * Returns global layout options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function restaurantz_get_global_layout_options() {

		$choices = array(
			'left-sidebar'  => esc_html__( 'Primary Sidebar - Content', 'restaurantz' ),
			'right-sidebar' => esc_html__( 'Content - Primary Sidebar', 'restaurantz' ),
			'three-columns' => esc_html__( 'Three Columns', 'restaurantz' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'restaurantz' ),
		);
		$output = apply_filters( 'restaurantz_filter_layout_options', $choices );
		return $output;

	}

endif;

if ( ! function_exists( 'restaurantz_get_pagination_type_options' ) ) :

	/**
	 * Returns pagination type options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function restaurantz_get_pagination_type_options() {

		$choices = array(
			'default' => esc_html__( 'Default (Older / Newer Post)', 'restaurantz' ),
			'numeric' => esc_html__( 'Numeric', 'restaurantz' ),
		);
		return $choices;

	}

endif;

if ( ! function_exists( 'restaurantz_get_breadcrumb_type_options' ) ) :

	/**
	 * Returns breadcrumb type options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function restaurantz_get_breadcrumb_type_options() {

		$choices = array(
			'disabled' => esc_html__( 'Disabled', 'restaurantz' ),
			'simple'   => esc_html__( 'Simple', 'restaurantz' ),
			'advanced' => esc_html__( 'Advanced', 'restaurantz' ),
		);
		return $choices;

	}

endif;


if ( ! function_exists( 'restaurantz_get_archive_layout_options' ) ) :

	/**
	 * Returns archive layout options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function restaurantz_get_archive_layout_options() {

		$choices = array(
			'full'    => esc_html__( 'Full Post', 'restaurantz' ),
			'excerpt' => esc_html__( 'Post Excerpt', 'restaurantz' ),
		);
		$output = apply_filters( 'restaurantz_filter_archive_layout_options', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;

if ( ! function_exists( 'restaurantz_get_image_sizes_options' ) ) :

	/**
	 * Returns image sizes options.
	 *
	 * @since 1.0.0
	 *
	 * @param bool  $add_disable True for adding No Image option.
	 * @param array $allowed Allowed image size options.
	 * @return array Image size options.
	 */
	function restaurantz_get_image_sizes_options( $add_disable = true, $allowed = array(), $show_dimension = true ) {

		global $_wp_additional_image_sizes;
		$get_intermediate_image_sizes = get_intermediate_image_sizes();
		$choices = array();
		if ( true === $add_disable ) {
			$choices['disable'] = esc_html__( 'No Image', 'restaurantz' );
		}
		$choices['thumbnail'] = esc_html__( 'Thumbnail', 'restaurantz' );
		$choices['medium']    = esc_html__( 'Medium', 'restaurantz' );
		$choices['large']     = esc_html__( 'Large', 'restaurantz' );
		$choices['full']      = esc_html__( 'Full (original)', 'restaurantz' );

		if ( true === $show_dimension ) {
			foreach ( array( 'thumbnail', 'medium', 'large' ) as $_size ) {
				$choices[ $_size ] = $choices[ $_size ] . ' (' . get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
			}
		}

		if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {
			foreach ( $_wp_additional_image_sizes as $key => $size ) {
				$choices[ $key ] = $key;
				if ( true === $show_dimension ){
					$choices[ $key ] .= ' ('. $size['width'] . 'x' . $size['height'] . ')';
				}
			}
		}

		if ( ! empty( $allowed ) ) {
			foreach ( $choices as $key => $value ) {
				if ( ! in_array( $key, $allowed ) ) {
					unset( $choices[ $key ] );
				}
			}
		}

		return $choices;

	}

endif;


if ( ! function_exists( 'restaurantz_get_image_alignment_options' ) ) :

	/**
	 * Returns image options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function restaurantz_get_image_alignment_options() {

		$choices = array(
			'none'   => _x( 'None', 'Alignment', 'restaurantz' ),
			'left'   => _x( 'Left', 'Alignment', 'restaurantz' ),
			'center' => _x( 'Center', 'Alignment', 'restaurantz' ),
			'right'  => _x( 'Right', 'Alignment', 'restaurantz' ),
		);
		return $choices;

	}

endif;
