<?php
/**
 * Customizer active callbacks
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

if ( ! function_exists( 'food_restro_is_breadcrumb_enable' ) ) :
	/**
	 * Check if breadcrumb is enabled.
	 *
	 * @since Food Restro 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function food_restro_is_breadcrumb_enable( $control ) {
		return $control->manager->get_setting( 'food_restro_theme_options[breadcrumb_enable]' )->value();
	}
endif;

if ( ! function_exists( 'food_restro_is_pagination_enable' ) ) :
	/**
	 * Check if pagination is enabled.
	 *
	 * @since Food Restro 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function food_restro_is_pagination_enable( $control ) {
		return $control->manager->get_setting( 'food_restro_theme_options[pagination_enable]' )->value();
	}
endif;

/**
 * Front Page Active Callbacks
 */

/**
 * Check if slider section is enabled.
 *
 * @since Food Restro 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function food_restro_is_slider_section_enable( $control ) {
	return ( $control->manager->get_setting( 'food_restro_theme_options[slider_section_enable]' )->value() );
}

/**
 * Check if service section is enabled.
 *
 * @since Food Restro 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function food_restro_is_service_section_enable( $control ) {
	return ( $control->manager->get_setting( 'food_restro_theme_options[service_section_enable]' )->value() );
}

/**
 * Check if about section is enabled.
 *
 * @since Food Restro 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function food_restro_is_about_section_enable( $control ) {
	return ( $control->manager->get_setting( 'food_restro_theme_options[about_section_enable]' )->value() );
}

/**
 * Check if gallery section is enabled.
 *
 * @since Food Restro 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function food_restro_is_gallery_section_enable( $control ) {
	return ( $control->manager->get_setting( 'food_restro_theme_options[gallery_section_enable]' )->value() );
}

/**
 * Check if testimonial section is enabled.
 *
 * @since Food Restro 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function food_restro_is_testimonial_section_enable( $control ) {
	return ( $control->manager->get_setting( 'food_restro_theme_options[testimonial_section_enable]' )->value() );
}

/**
 * Check if cta section is enabled.
 *
 * @since Food Restro 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function food_restro_is_cta_section_enable( $control ) {
	return ( $control->manager->get_setting( 'food_restro_theme_options[cta_section_enable]' )->value() );
}

/**
 * Check if blog section is enabled.
 *
 * @since Food Restro 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function food_restro_is_blog_section_enable( $control ) {
	return ( $control->manager->get_setting( 'food_restro_theme_options[blog_section_enable]' )->value() );
}
