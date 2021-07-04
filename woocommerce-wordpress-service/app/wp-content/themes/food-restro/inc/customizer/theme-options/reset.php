<?php
/**
 * Reset options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

/**
* Reset section
*/
// Add reset enable section
$wp_customize->add_section( 'food_restro_reset_section', array(
	'title'             => esc_html__('Reset all settings','food-restro'),
	'description'       => esc_html__( 'Caution: All settings will be reset to default. Refresh the page after clicking Save & Publish.', 'food-restro' ),
) );

// Add reset enable setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[reset_options]', array(
	'default'           => $options['reset_options'],
	'sanitize_callback' => 'food_restro_sanitize_checkbox',
	'transport'			  => 'postMessage',
) );

$wp_customize->add_control( 'food_restro_theme_options[reset_options]', array(
	'label'             => esc_html__( 'Check to reset all settings', 'food-restro' ),
	'section'           => 'food_restro_reset_section',
	'type'              => 'checkbox',
) );
