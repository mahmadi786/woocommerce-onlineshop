<?php
/**
 * Sanitization callback for  type controls
 *
 * @param  string               $input   Slug to sanitize.
 * @param  WP_Customize_Setting $setting Setting instance
 *
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default
 */


function finedine_sanitize_checkboxes( $values ) {

	$multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;

	return ! empty( $multi_values ) ? array_map( 'sanitize_text_field',
		$multi_values ) : array();
}

/**
 * Sanitization callback for 'select' and 'radio' type controls
 *
 * @param  string               $input   Slug to sanitize.
 * @param  WP_Customize_Setting $setting Setting instance
 *
 * @return string           Sanitized slug if it is a valid choice; otherwise, the setting default
 */
function finedine_sanitize_select_radio( $input, $setting ) {

	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input
		: $setting->default );
}

/**
 * Sanitization callback for checkbox as a boolean value, either TRUE or FALSE.
 *
 * @param  bool $checked Whether the checkbox is checked
 *
 * @return bool          Whether the checkbox is checked
 */
function finedine_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Sanitazation callback for textarea as allowed HTML tags for post content
 *
 * @param  string $input Content to filter
 *
 * @return string        Filtered content
 */
function finedine_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
 * send back the filename, otherwise, return the setting default
 *
 * @param  string $image Image File Path
 * @param  WP_Customize_Setting $setting Setting Instance
 *
 * @return string                            Image file path if the extension is allowed; otherwise, the setting default
 */
function finedine_sanitize_image( $image, $setting ) {
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'png'          => 'image/png',
		'bmp'          => 'image/bmp',
		'tif|tiff'     => 'image/tiff',
		'ico'          => 'image/x-icon',
	);
	$file  = wp_check_filetype( $image, $mimes );

	return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Sanitize the Multiple checkbox values.
 *
 * @param string $values Values.
 *
 * @return array Checked values.
 */
function finedine_sanitize_multiple_checkbox( $values ) {
	$multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;

	return ! empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}


/**
 * Select sanitization function.
 *
 * @param $input
 *
 * @param $setting
 *
 * @return string
 */
function finedine_sanitize_select( $input, $setting ) {

	// Input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only.
	$input = sanitize_key( $input );

	// Get the list of possible select options.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// Return input if valid or return default option.
	return ( array_key_exists( $input, $choices ) ? $input
		: $setting->default );

}

