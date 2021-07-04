<?php
/**
* Homepage (Static ) options
*
* @package Theme Palace
* @subpackage Food Restro
* @since Food Restro 1.0.0
*/

// Homepage (Static ) setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[enable_frontpage_content]', array(
	'sanitize_callback'   => 'food_restro_sanitize_checkbox',
	'default'             => $options['enable_frontpage_content'],
) );

$wp_customize->add_control( 'food_restro_theme_options[enable_frontpage_content]', array(
	'label'       	=> esc_html__( 'Enable Content', 'food-restro' ),
	'description' 	=> esc_html__( 'Check to enable content on static front page only.', 'food-restro' ),
	'section'     	=> 'static_front_page',
	'type'        	=> 'checkbox',
) );