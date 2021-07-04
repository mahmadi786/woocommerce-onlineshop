<?php
/**
 * Slider Section options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add Slider section
$wp_customize->add_section( 'food_restro_slider_section', array(
	'title'             => esc_html__( 'Main Slider','food-restro' ),
	'description'       => esc_html__( 'Slider Section options.', 'food-restro' ),
	'panel'             => 'food_restro_front_page_panel',
) );

// Slider content enable control and setting
$wp_customize->add_setting( 'food_restro_theme_options[slider_section_enable]', array(
	'default'			=> 	$options['slider_section_enable'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[slider_section_enable]', array(
	'label'             => esc_html__( 'Slider Section Enable', 'food-restro' ),
	'section'           => 'food_restro_slider_section',
	'on_off_label' 		=> food_restro_switch_options(),
) ) );

// Slider btn label setting and control
$wp_customize->add_setting( 'food_restro_theme_options[slider_btn_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['slider_btn_label'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'food_restro_theme_options[slider_btn_label]', array(
	'label'           	=> esc_html__( 'Slider Button Label', 'food-restro' ),
	'description'       => esc_html__( 'Button will not be visible on default design layout.', 'food-restro' ),
	'section'        	=> 'food_restro_slider_section',
	'active_callback' 	=> 'food_restro_is_slider_section_enable',
	'type'				=> 'text',
) );

for ( $i = 1; $i <= 5; $i++ ) :
	// slider pages drop down chooser control and setting
	$wp_customize->add_setting( 'food_restro_theme_options[slider_content_page_' . $i . ']', array(
		'sanitize_callback' => 'food_restro_sanitize_page',
	) );

	$wp_customize->add_control( new Food_Restro_Dropdown_Chooser( $wp_customize, 'food_restro_theme_options[slider_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'food-restro' ), $i ),
		'section'           => 'food_restro_slider_section',
		'choices'			=> food_restro_page_choices(),
		'active_callback'	=> 'food_restro_is_slider_section_enable',
	) ) );

endfor;
