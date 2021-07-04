<?php
/**
 * Footer options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

// Footer Section
$wp_customize->add_section( 'food_restro_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'food-restro' ),
		'priority'   			=> 900,
		'panel'      			=> 'food_restro_theme_options_panel',
	)
);

// footer text
$wp_customize->add_setting( 'food_restro_theme_options[copyright_text]',
	array(
		'default'       		=> $options['copyright_text'],
		'sanitize_callback'		=> 'food_restro_santize_allow_tag',
		'transport'				=> 'postMessage',
	)
);
$wp_customize->add_control( 'food_restro_theme_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Copyright Text', 'food-restro' ),
		'section'    			=> 'food_restro_section_footer',
		'type'		 			=> 'textarea',
    )
);

// scroll top visible
$wp_customize->add_setting( 'food_restro_theme_options[scroll_top_visible]',
	array(
		'default'       		=> $options['scroll_top_visible'],
		'sanitize_callback' => 'food_restro_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Food_Restro_Switch_Control( $wp_customize, 'food_restro_theme_options[scroll_top_visible]',
    array(
		'label'      			=> esc_html__( 'Display Scroll Top Button', 'food-restro' ),
		'section'    			=> 'food_restro_section_footer',
		'on_off_label' 		=> food_restro_switch_options(),
    )
) );