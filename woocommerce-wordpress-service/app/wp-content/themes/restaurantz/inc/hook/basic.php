<?php
/**
 * Basic theme functions.
 *
 * This file contains hook functions attached to core hooks.
 *
 * @package Restaurantz
 */

if ( ! function_exists( 'restaurantz_custom_body_class' ) ) :
	/**
	 * Custom body class
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $input One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function restaurantz_custom_body_class( $input ) {

		// Global layout.
		global $post;
		$global_layout = restaurantz_get_option( 'global_layout' );
		$global_layout = apply_filters( 'restaurantz_filter_theme_global_layout', $global_layout );

		// Check if single.
		if ( $post  && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'restaurantz_theme_settings', true );
			if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
				$global_layout = $post_options['post_layout'];
			}
		}

		$input[] = 'global-layout-' . esc_attr( $global_layout );

		// Add common class for sidebar enabled condition.
		if ( 'no-sidebar' !== $global_layout ) {
			$input[] = 'sidebar-enabled';
		}

		// Common class for three columns.
		switch ( $global_layout ) {
			case 'three-columns':
				$input[] = 'three-columns-enabled';
		    break;

			default:
		    break;
		}

		// Overlap class.
		$overlap_class = 'builder-overlap';
		if ( is_front_page() && 'posts' === get_option( 'show_on_front' ) ) {
			$overlap_class = '';
		} else if ( is_home() && ( $blog_page_id = restaurantz_get_index_page_id( 'blog' ) ) > 0 ) {
			// Function is_home() specific.
			$disable_overlap = absint( get_post_meta( $blog_page_id, 'restaurantz-disable-overlap', true ) );
			if ( 1 === $disable_overlap ) {
				$overlap_class = '';
			}
		} else if ( $post ) {
			// Post specific.
			$disable_overlap = absint( get_post_meta( $post->ID, 'restaurantz-disable-overlap', true ) );
			if ( 1 === $disable_overlap ) {
				$overlap_class = '';
			}
		}
		if ( ! empty( $overlap_class ) ) {
			$input[] = $overlap_class;
		} else {
			$input[] = 'builder-overlap-disabled';
		}

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$input[] = 'group-blog';
		}

		return $input;

	}
endif;

add_filter( 'body_class', 'restaurantz_custom_body_class' );

if ( ! function_exists( 'restaurantz_featured_image_instruction' ) ) :

	/**
	 * Message to show in the Featured Image Meta box.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content Admin post thumbnail HTML markup.
	 * @param int    $post_id Post ID.
	 * @return string HTML.
	 */
	function restaurantz_featured_image_instruction( $content, $post_id ) {

		$allowed = array( 'post', 'page' );
		if ( in_array( get_post_type( $post_id ), $allowed ) ) {
			$content .= '<strong>' . __( 'Recommended Image Sizes', 'restaurantz' ) . ':</strong><br/>';
			$content .= __( 'Banner Image', 'restaurantz' ) . ' : 1400px X 320px';
		}

		return $content;

	}

endif;
add_filter( 'admin_post_thumbnail_html', 'restaurantz_featured_image_instruction', 10, 2 );

if ( ! function_exists( 'restaurantz_custom_content_width' ) ) :

	/**
	 * Custom content width.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_custom_content_width() {

		global $post, $content_width;

		$global_layout = restaurantz_get_option( 'global_layout' );
		$global_layout = apply_filters( 'restaurantz_filter_theme_global_layout', $global_layout );

		// Check if single.
		if ( $post && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'restaurantz_theme_settings', true );
			if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
				$global_layout = esc_attr( $post_options['post_layout'] );
			}
		}

		switch ( $global_layout ) {

			case 'no-sidebar':
				$content_width = 1220;
				break;

			case 'three-columns':
				$content_width = 570;
				break;

			case 'left-sidebar':
			case 'right-sidebar':
				$content_width = 895;
				break;

			default:
				break;
		}

	}
endif;

add_action( 'template_redirect', 'restaurantz_custom_content_width' );

if ( ! function_exists( 'restaurantz_implement_read_more' ) ) :

	/**
	 * Implement read more in excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The excerpt.
	 */
	function restaurantz_implement_read_more( $more ) {

		if ( 0 !== strpos( $more, '<a' ) ) {
			$more = sprintf( ' <a href="%s" class="more-link">%s</a>', esc_url( get_permalink() ), trim( $more ) );
		}

		return $more;

	}

endif;

add_filter( 'excerpt_more', 'restaurantz_implement_read_more' );
