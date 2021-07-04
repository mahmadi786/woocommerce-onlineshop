<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'food_restro_single_post_section', array(
	'title'             => esc_html__( 'Single Post','food-restro' ),
	'description'       => esc_html__( 'Options to change the single posts globally.', 'food-restro' ),
	'panel'             => 'food_restro_theme_options_panel',
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[single_post_hide_date]', array(
	'default'           => $options['single_post_hide_date'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[single_post_hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'food-restro' ),
	'section'           => 'food_restro_single_post_section',
	'on_off_label' 		=> food_restro_hide_options(),
) ) );

// Archive author meta setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[single_post_hide_author]', array(
	'default'           => $options['single_post_hide_author'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[single_post_hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'food-restro' ),
	'section'           => 'food_restro_single_post_section',
	'on_off_label' 		=> food_restro_hide_options(),
) ) );

// Archive author category setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[single_post_hide_category]', array(
	'default'           => $options['single_post_hide_category'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[single_post_hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'food-restro' ),
	'section'           => 'food_restro_single_post_section',
	'on_off_label' 		=> food_restro_hide_options(),
) ) );

// Archive tag category setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[single_post_hide_tags]', array(
	'default'           => $options['single_post_hide_tags'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[single_post_hide_tags]', array(
	'label'             => esc_html__( 'Hide Tag', 'food-restro' ),
	'section'           => 'food_restro_single_post_section',
	'on_off_label' 		=> food_restro_hide_options(),
) ) );
