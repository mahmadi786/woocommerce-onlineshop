<?php
/**
 * Customizer default options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 * @return array An array of default values
 */

function food_restro_get_default_theme_options() {
	$food_restro_default_options = array(
		// Color Options
		'header_title_color'			=> '#fff',
		'header_tagline_color'			=> '#fff',
		'header_txt_logo_extra'			=> 'show-all',
		
		// breadcrumb
		'breadcrumb_enable'				=> true,
		'breadcrumb_separator'			=> '/',
		
		// layout 
		'site_layout'         			=> 'wide',
		'sidebar_position'         		=> 'right-sidebar',
		'post_sidebar_position' 		=> 'right-sidebar',
		'page_sidebar_position' 		=> 'right-sidebar',
		'nav_search_enable'				=> true,

		// excerpt options
		'long_excerpt_length'           => 25,
		
		// pagination options
		'pagination_enable'         	=> true,
		'pagination_type'         		=> 'default',

		// footer options
		'copyright_text'           		=> sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'food-restro' ), '[the-year]', '[site-link]' ),
		'scroll_top_visible'        	=> true,

		// reset options
		'reset_options'      			=> false,
		
		// homepage options
		'enable_frontpage_content' 		=> false,

		// blog/archive options
		'your_latest_posts_title' 		=> esc_html__( 'Blogs', 'food-restro' ),
		'hide_date' 					=> false,
		'hide_category'					=> false,

		// single post theme options
		'single_post_hide_date' 		=> false,
		'single_post_hide_author'		=> false,
		'single_post_hide_category'		=> false,
		'single_post_hide_tags'			=> false,

		/* Front Page */

		// Slider
		'slider_section_enable'			=> false,
		'slider_btn_label'				=> esc_html__( 'Learn More', 'food-restro' ),

		// service
		'service_section_enable'		=> false,
		'service_title'					=> esc_html__( 'How Good We Are', 'food-restro' ),

		// About
		'about_section_enable'			=> false,

		// Gallery
		'gallery_section_enable'		=> false,

		// testimonial
		'testimonial_section_enable'	=> false,
		'testimonial_title'				=> esc_html__( 'Our Foodie Fan Here', 'food-restro' ),

		// call to action
		'cta_section_enable'			=> false,

		// blog
		'blog_section_enable'			=> false,
		'blog_title'					=> esc_html__( 'Our Yummy Story', 'food-restro' ),

	);

	$output = apply_filters( 'food_restro_default_theme_options', $food_restro_default_options );

	// Sort array in ascending order, according to the key:
	if ( ! empty( $output ) ) {
		ksort( $output );
	}

	return $output;
}