<?php
/**
 * Archive options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add archive section
$wp_customize->add_section( 'food_restro_archive_section', array(
	'title'             => esc_html__( 'Blog/Archive','food-restro' ),
	'description'       => esc_html__( 'Archive section options.', 'food-restro' ),
	'panel'             => 'food_restro_theme_options_panel',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'food_restro_theme_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'food-restro' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'food-restro' ),
	'section'           => 'food_restro_archive_section',
	'type'				=> 'text',
	'active_callback'   => 'food_restro_is_latest_posts'
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[hide_date]', array(
	'default'           => $options['hide_date'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'food-restro' ),
	'section'           => 'food_restro_archive_section',
	'on_off_label' 		=> food_restro_hide_options(),
) ) );

// Archive author category setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[hide_category]', array(
	'default'           => $options['hide_category'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'food-restro' ),
	'section'           => 'food_restro_archive_section',
	'on_off_label' 		=> food_restro_hide_options(),
) ) );
