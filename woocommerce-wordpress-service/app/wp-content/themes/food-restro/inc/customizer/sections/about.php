<?php
/**
 * About Section options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add About section
$wp_customize->add_section( 'food_restro_about_section', array(
	'title'             => esc_html__( 'About Us','food-restro' ),
	'description'       => esc_html__( 'About Section options.', 'food-restro' ),
	'panel'             => 'food_restro_front_page_panel',
) );

// About content enable control and setting
$wp_customize->add_setting( 'food_restro_theme_options[about_section_enable]', array(
	'default'			=> 	$options['about_section_enable'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[about_section_enable]', array(
	'label'             => esc_html__( 'About Section Enable', 'food-restro' ),
	'section'           => 'food_restro_about_section',
	'on_off_label' 		=> food_restro_switch_options(),
) ) );

// about pages drop down chooser control and setting
$wp_customize->add_setting( 'food_restro_theme_options[about_content_page]', array(
	'sanitize_callback' => 'food_restro_sanitize_page',
) );

$wp_customize->add_control( new Food_Restro_Dropdown_Chooser( $wp_customize, 'food_restro_theme_options[about_content_page]', array(
	'label'             => esc_html__( 'Select Page', 'food-restro' ),
	'section'           => 'food_restro_about_section',
	'choices'			=> food_restro_page_choices(),
	'active_callback'	=> 'food_restro_is_about_section_enable',
) ) );


// about btn title setting and control
$wp_customize->add_setting( 'food_restro_theme_options[about_btn_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'food_restro_theme_options[about_btn_title]', array(
	'label'           	=> esc_html__( 'Button Label', 'food-restro' ),
	'section'        	=> 'food_restro_about_section',
	'active_callback' 	=> 'food_restro_is_about_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'food_restro_theme_options[about_btn_title]', array(
		'selector'            => '#about-us .read-more a',
		'settings'            => 'food_restro_theme_options[about_btn_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'food_restro_about_btn_title_partial',
    ) );
}
