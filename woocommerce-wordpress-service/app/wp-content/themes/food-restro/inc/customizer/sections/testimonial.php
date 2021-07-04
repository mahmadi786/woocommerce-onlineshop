<?php
/**
 * Testimonial Section options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add Testimonial section
$wp_customize->add_section( 'food_restro_testimonial_section', array(
	'title'             => esc_html__( 'Testimonial','food-restro' ),
	'description'       => esc_html__( 'Testimonial Section options.', 'food-restro' ),
	'panel'             => 'food_restro_front_page_panel',
) );

// Testimonial content enable control and setting
$wp_customize->add_setting( 'food_restro_theme_options[testimonial_section_enable]', array(
	'default'			=> 	$options['testimonial_section_enable'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[testimonial_section_enable]', array(
	'label'             => esc_html__( 'Testimonial Section Enable', 'food-restro' ),
	'section'           => 'food_restro_testimonial_section',
	'on_off_label' 		=> food_restro_switch_options(),
) ) );

// testimonial title setting and control
$wp_customize->add_setting( 'food_restro_theme_options[testimonial_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['testimonial_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'food_restro_theme_options[testimonial_title]', array(
	'label'           	=> esc_html__( 'Title', 'food-restro' ),
	'section'        	=> 'food_restro_testimonial_section',
	'active_callback' 	=> 'food_restro_is_testimonial_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'food_restro_theme_options[testimonial_title]', array(
		'selector'            => '#client-testimonial .section-header h2.section-title',
		'settings'            => 'food_restro_theme_options[testimonial_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'food_restro_testimonial_title_partial',
    ) );
}

// Add dropdown category setting and control.
$wp_customize->add_setting(  'food_restro_theme_options[testimonial_content_category]', array(
	'sanitize_callback' => 'food_restro_sanitize_single_category',
) ) ;

$wp_customize->add_control( new Food_Restro_Dropdown_Taxonomies_Control( $wp_customize,'food_restro_theme_options[testimonial_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'food-restro' ),
	'description'      	=> esc_html__( 'Note: Latest four posts will be shown from selected category', 'food-restro' ),
	'section'           => 'food_restro_testimonial_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'food_restro_is_testimonial_section_enable'
) ) );
