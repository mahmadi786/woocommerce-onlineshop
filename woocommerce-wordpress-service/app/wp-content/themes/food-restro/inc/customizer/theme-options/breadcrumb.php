<?php
/**
 * Breadcrumb options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

$wp_customize->add_section( 'food_restro_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','food-restro' ),
	'description'       => esc_html__( 'Breadcrumb section options.', 'food-restro' ),
	'panel'             => 'food_restro_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[breadcrumb_enable]', array(
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
	'default'          	=> $options['breadcrumb_enable'],
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[breadcrumb_enable]', array(
	'label'            	=> esc_html__( 'Enable Breadcrumb', 'food-restro' ),
	'section'          	=> 'food_restro_breadcrumb',
	'on_off_label' 		=> food_restro_switch_options(),
) ) );

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
) );

$wp_customize->add_control( 'food_restro_theme_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'food-restro' ),
	'active_callback' 	=> 'food_restro_is_breadcrumb_enable',
	'section'          	=> 'food_restro_breadcrumb',
) );
