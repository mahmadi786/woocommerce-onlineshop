<?php
/**
 * Layout options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'food_restro_layout', array(
	'title'               => esc_html__('Layout','food-restro'),
	'description'         => esc_html__( 'Layout section options.', 'food-restro' ),
	'panel'               => 'food_restro_theme_options_panel',
) );

// Site layout setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[site_layout]', array(
	'sanitize_callback'   => 'food_restro_sanitize_select',
	'default'             => $options['site_layout'],
) );

$wp_customize->add_control(  new Food_Restro_Custom_Radio_Image_Control ( $wp_customize, 'food_restro_theme_options[site_layout]', array(
	'label'               => esc_html__( 'Site Layout', 'food-restro' ),
	'section'             => 'food_restro_layout',
	'choices'			  => food_restro_site_layout(),
) ) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[sidebar_position]', array(
	'sanitize_callback'   => 'food_restro_sanitize_select',
	'default'             => $options['sidebar_position'],
) );

$wp_customize->add_control(  new Food_Restro_Custom_Radio_Image_Control ( $wp_customize, 'food_restro_theme_options[sidebar_position]', array(
	'label'               => esc_html__( 'Global Sidebar Position', 'food-restro' ),
	'section'             => 'food_restro_layout',
	'choices'			  => food_restro_global_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'food_restro_sanitize_select',
	'default'             => $options['post_sidebar_position'],
) );

$wp_customize->add_control(  new Food_Restro_Custom_Radio_Image_Control ( $wp_customize, 'food_restro_theme_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Position', 'food-restro' ),
	'section'             => 'food_restro_layout',
	'choices'			  => food_restro_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'food_restro_sanitize_select',
	'default'             => $options['page_sidebar_position'],
) );

$wp_customize->add_control( new Food_Restro_Custom_Radio_Image_Control( $wp_customize, 'food_restro_theme_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Position', 'food-restro' ),
	'section'             => 'food_restro_layout',
	'choices'			  => food_restro_sidebar_position(),
) ) );