<?php
/**
 * pagination options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'food_restro_pagination', array(
	'title'               => esc_html__('Pagination','food-restro'),
	'description'         => esc_html__( 'Pagination section options.', 'food-restro' ),
	'panel'               => 'food_restro_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[pagination_enable]', array(
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
	'default'             => $options['pagination_enable'],
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[pagination_enable]', array(
	'label'               => esc_html__( 'Pagination Enable', 'food-restro' ),
	'section'             => 'food_restro_pagination',
	'on_off_label' 		=> food_restro_switch_options(),
) ) );

// Site layout setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[pagination_type]', array(
	'sanitize_callback'   => 'food_restro_sanitize_select',
	'default'             => $options['pagination_type'],
) );

$wp_customize->add_control( 'food_restro_theme_options[pagination_type]', array(
	'label'               => esc_html__( 'Pagination Type', 'food-restro' ),
	'section'             => 'food_restro_pagination',
	'type'                => 'select',
	'choices'			  => food_restro_pagination_options(),
	'active_callback'	  => 'food_restro_is_pagination_enable',
) );
