<?php
/**
 * Default theme options.
 *
 * @package Online_News
 */

if ( ! function_exists( 'finedine_get_option_defaults' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function finedine_get_option_defaults() {

		global $finedine_array_of_default_settings;
		$finedine_array_of_default_settings = array(
			'finedine_header_reservation_text' => '',
			'finedine_header_reservation_url'  => '',
			'finedine_form_shortcode'          => '',
			'finedine_socials_facebook'        => '',
			'finedine_socials_instagram'       => '',
			'finedine_socials_twitter'         => '',
			'finedine_socials_youtube'         => '',
			'finedine_sidebar_layout'          => '',
			'feature_slider_count'             => '',
			'testimonial_slider_count'         => '',
			'finedine_remove_copyright_text'   => '',
			'hide_reservation_footer_section'  => '',
			'select_post_feature_slider'       => '',
			'transition_effects'               => '',
			'hide_feature_slider_1'            => '',
			'testimonial_image_hide'           => '',


			// Add all the default value here.
		);

		return apply_filters( 'finedine_get_option_defaults', $finedine_array_of_default_settings );
	}

endif;
