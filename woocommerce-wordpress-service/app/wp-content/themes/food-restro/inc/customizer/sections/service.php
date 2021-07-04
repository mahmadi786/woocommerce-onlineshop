<?php
/**
 * Service Section options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add Service section
$wp_customize->add_section( 'food_restro_service_section', array(
	'title'             => esc_html__( 'Services','food-restro' ),
	'description'       => esc_html__( 'Services Section options.', 'food-restro' ),
	'panel'             => 'food_restro_front_page_panel',
) );

// Service content enable control and setting
$wp_customize->add_setting( 'food_restro_theme_options[service_section_enable]', array(
	'default'			=> 	$options['service_section_enable'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[service_section_enable]', array(
	'label'             => esc_html__( 'Service Section Enable', 'food-restro' ),
	'section'           => 'food_restro_service_section',
	'on_off_label' 		=> food_restro_switch_options(),
) ) );

// service title setting and control
$wp_customize->add_setting( 'food_restro_theme_options[service_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['service_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'food_restro_theme_options[service_title]', array(
	'label'           	=> esc_html__( 'Title', 'food-restro' ),
	'section'        	=> 'food_restro_service_section',
	'active_callback' 	=> 'food_restro_is_service_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'food_restro_theme_options[service_title]', array(
		'selector'            => '#our-services .section-header h2.section-title',
		'settings'            => 'food_restro_theme_options[service_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'food_restro_service_title_partial',
    ) );
}

for ( $i = 1; $i <= 3; $i++ ) :

	// service note control and setting
	$wp_customize->add_setting( 'food_restro_theme_options[service_content_icon_' . $i . ']', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new Food_Restro_Icon_Picker( $wp_customize, 'food_restro_theme_options[service_content_icon_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Icon %d', 'food-restro' ), $i ),
		'section'           => 'food_restro_service_section',
		'active_callback'	=> 'food_restro_is_service_section_enable',
	) ) );

	// service pages drop down chooser control and setting
	$wp_customize->add_setting( 'food_restro_theme_options[service_content_page_' . $i . ']', array(
		'sanitize_callback' => 'food_restro_sanitize_page',
	) );

	$wp_customize->add_control( new Food_Restro_Dropdown_Chooser( $wp_customize, 'food_restro_theme_options[service_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'food-restro' ), $i ),
		'section'           => 'food_restro_service_section',
		'choices'			=> food_restro_page_choices(),
		'active_callback'	=> 'food_restro_is_service_section_enable',
	) ) );

	// service hr setting and control
	$wp_customize->add_setting( 'food_restro_theme_options[service_hr_'. $i .']', array(
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new Food_Restro_Customize_Horizontal_Line( $wp_customize, 'food_restro_theme_options[service_hr_'. $i .']',
		array(
			'section'         => 'food_restro_service_section',
			'active_callback' => 'food_restro_is_service_section_enable',
			'type'			  => 'hr'
	) ) );
endfor;
