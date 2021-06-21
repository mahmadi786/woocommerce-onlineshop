<?php
/**
 * @package Food Restaurant
 * Setup the WordPress core custom header feature.
 *
 * @uses food_restaurant_header_style()
*/
function food_restaurant_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'food_restaurant_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1055,
		'height'                 => 85,
		'flex-width'         	=> true,
        'flex-height'        	=> true,
		'wp-head-callback'       => 'food_restaurant_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'food_restaurant_custom_header_setup' );

if ( ! function_exists( 'food_restaurant_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see food_restaurant_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'food_restaurant_header_style' );
function food_restaurant_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$food_restaurant_custom_css = "
        .header{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'food-restaurant-basic-style', $food_restaurant_custom_css );
	endif;
}
endif; // food_restaurant_header_style