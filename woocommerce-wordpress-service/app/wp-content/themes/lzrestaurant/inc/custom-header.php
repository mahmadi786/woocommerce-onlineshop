<?php
/**
 * Custom header implementation
 * 
 * @subpackage lzrestaurant
 * @since 1.0
 */

function lzrestaurant_custom_header_setup() {

	add_theme_support( 'custom-header', apply_filters( 'lzrestaurant_custom_header_args', array(
		'default-image'      => get_parent_theme_file_uri( '/assets/images/header.jpg' ),
		'width'              => 2000,
		'height'             => 1200,
		'flex-height'        => true,
		'video'              => true,
		'wp-head-callback'   => 'lzrestaurant_header_style',
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/assets/images/header.jpg',
			'thumbnail_url' => '%s/assets/images/header.jpg',
			'description'   => __( 'Default Header Image', 'lzrestaurant' ),
		),
	) );
}
add_action( 'after_setup_theme', 'lzrestaurant_custom_header_setup' );

if ( ! function_exists( 'lzrestaurant_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see lzrestaurant_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'lzrestaurant_header_style' );
function lzrestaurant_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$custom_css = "
        .main-top{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'lzrestaurant-style', $custom_css );
	endif;
}
endif; // lzrestaurant_header_style
