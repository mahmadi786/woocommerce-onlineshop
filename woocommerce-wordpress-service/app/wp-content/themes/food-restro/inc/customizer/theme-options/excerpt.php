<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'food_restro_excerpt_section', array(
	'title'             => esc_html__( 'Excerpt','food-restro' ),
	'description'       => esc_html__( 'Excerpt section options.', 'food-restro' ),
	'panel'             => 'food_restro_theme_options_panel',
) );


// long Excerpt length setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[long_excerpt_length]', array(
	'sanitize_callback' => 'food_restro_sanitize_number_range',
	'validate_callback' => 'food_restro_validate_long_excerpt',
	'default'			=> $options['long_excerpt_length'],
) );

$wp_customize->add_control( 'food_restro_theme_options[long_excerpt_length]', array(
	'label'       		=> esc_html__( 'Blog Page Excerpt Length', 'food-restro' ),
	'description' 		=> esc_html__( 'Total words to be displayed in archive page/search page.', 'food-restro' ),
	'section'     		=> 'food_restro_excerpt_section',
	'type'        		=> 'number',
	'input_attrs' 		=> array(
		'style'       => 'width: 80px;',
		'max'         => 100,
		'min'         => 5,
	),
) );

