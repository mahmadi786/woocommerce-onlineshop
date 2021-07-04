<?php
/**
 * Gallery Section options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add Gallery section
$wp_customize->add_section( 'food_restro_gallery_section', array(
	'title'             => esc_html__( 'Gallery','food-restro' ),
	'description'       => esc_html__( 'Gallery Section options.', 'food-restro' ),
	'panel'             => 'food_restro_front_page_panel',
) );

// Gallery content enable control and setting
$wp_customize->add_setting( 'food_restro_theme_options[gallery_section_enable]', array(
	'default'			=> 	$options['gallery_section_enable'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[gallery_section_enable]', array(
	'label'             => esc_html__( 'Gallery Section Enable', 'food-restro' ),
	'section'           => 'food_restro_gallery_section',
	'on_off_label' 		=> food_restro_switch_options(),
) ) );

// Add dropdown category setting and control.
$wp_customize->add_setting(  'food_restro_theme_options[gallery_content_category]', array(
	'sanitize_callback' => 'food_restro_sanitize_single_category',
) ) ;

$wp_customize->add_control( new Food_Restro_Dropdown_Taxonomies_Control( $wp_customize,'food_restro_theme_options[gallery_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'food-restro' ),
	'description'      	=> esc_html__( 'Note: Latest eight posts will be shown from selected category', 'food-restro' ),
	'section'           => 'food_restro_gallery_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'food_restro_is_gallery_section_enable',
) ) );
