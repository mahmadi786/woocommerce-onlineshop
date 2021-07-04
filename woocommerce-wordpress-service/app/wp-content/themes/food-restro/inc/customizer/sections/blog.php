<?php
/**
 * Blog Section options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Add Blog section
$wp_customize->add_section( 'food_restro_blog_section', array(
	'title'             => esc_html__( 'Blog','food-restro' ),
	'description'       => esc_html__( 'Blog Section options.', 'food-restro' ),
	'panel'             => 'food_restro_front_page_panel',
) );

// Blog content enable control and setting
$wp_customize->add_setting( 'food_restro_theme_options[blog_section_enable]', array(
	'default'			=> 	$options['blog_section_enable'],
	'sanitize_callback' => 'food_restro_sanitize_switch_control',
) );

$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[blog_section_enable]', array(
	'label'             => esc_html__( 'Blog Section Enable', 'food-restro' ),
	'section'           => 'food_restro_blog_section',
	'on_off_label' 		=> food_restro_switch_options(),
) ) );

// blog title setting and control
$wp_customize->add_setting( 'food_restro_theme_options[blog_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['blog_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'food_restro_theme_options[blog_title]', array(
	'label'           	=> esc_html__( 'Title', 'food-restro' ),
	'section'        	=> 'food_restro_blog_section',
	'active_callback' 	=> 'food_restro_is_blog_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'food_restro_theme_options[blog_title]', array(
		'selector'            => '#latest-posts .section-header h2.section-title',
		'settings'            => 'food_restro_theme_options[blog_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'food_restro_blog_title_partial',
    ) );
}

// Add dropdown categories setting and control.
$wp_customize->add_setting( 'food_restro_theme_options[blog_category_exclude]', array(
	'sanitize_callback' => 'food_restro_sanitize_category_list',
) ) ;

$wp_customize->add_control( new Food_Restro_Dropdown_Category_Control( $wp_customize,'food_restro_theme_options[blog_category_exclude]', array(
	'label'             => esc_html__( 'Select Excluding Categories', 'food-restro' ),
	'description'      	=> esc_html__( 'Note: Select categories to exclude. Press Shift key select multilple categories.', 'food-restro' ),
	'section'           => 'food_restro_blog_section',
	'type'              => 'dropdown-categories',
	'active_callback'	=> 'food_restro_is_blog_section_enable'
) ) );
