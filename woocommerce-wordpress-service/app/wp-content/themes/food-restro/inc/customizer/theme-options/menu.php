<?php
/**
 * Menu options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'food_restro_menu', array(
	'title'             => esc_html__('Header Menu','food-restro'),
	'description'       => esc_html__( 'Header Menu options.', 'food-restro' ),
	'panel'             => 'nav_menus',
) );

// search enable setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[nav_search_enable]', array(
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
	'default'           => $options['nav_search_enable'],
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[nav_search_enable]', array(
	'label'             => esc_html__( 'Enable search', 'food-restro' ),
	'section'           => 'food_restro_menu',
	'on_off_label' 		=> food_restro_switch_options(),
) ) );