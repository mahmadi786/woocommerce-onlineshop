<?php
/**
 * Appearance Settings
 *
 * @package Blossom_Feminine
 */

function blossom_feminine_customize_register_appearance( $wp_customize ) {
    
    /** Appearance Settings */
    $wp_customize->add_panel( 
        'appearance_settings',
         array(
            'priority'    => 50,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Appearance Settings', 'blossom-feminine' ),
            'description' => __( 'Customize Typography, Header Image & Background Image', 'blossom-feminine' ),
        ) 
    );
    
    /** Typography */
    $wp_customize->add_section(
        'typography_settings',
        array(
            'title'    => __( 'Typography', 'blossom-feminine' ),
            'priority' => 10,
            'panel'    => 'appearance_settings',
        )
    );
    
    /** Primary Font */
    $wp_customize->add_setting(
		'primary_font',
		array(
			'default'			=> 'Poppins',
			'sanitize_callback' => 'blossom_feminine_sanitize_select'
		)
	);

	$wp_customize->add_control(
		new Blossom_Feminine_Select_Control(
    		$wp_customize,
    		'primary_font',
    		array(
                'label'	      => __( 'Primary Font', 'blossom-feminine' ),
                'description' => __( 'Primary font of the site.', 'blossom-feminine' ),
    			'section'     => 'typography_settings',
    			'choices'     => blossom_feminine_get_all_fonts(),	
     		)
		)
	);
    
    /** Secondary Font */
    $wp_customize->add_setting(
		'secondary_font',
		array(
			'default'			=> 'Playfair Display',
			'sanitize_callback' => 'blossom_feminine_sanitize_select'
		)
	);

	$wp_customize->add_control(
		new Blossom_Feminine_Select_Control(
    		$wp_customize,
    		'secondary_font',
    		array(
                'label'	      => __( 'Secondary Font', 'blossom-feminine' ),
                'description' => __( 'Secondary font of the site.', 'blossom-feminine' ),
    			'section'     => 'typography_settings',
    			'choices'     => blossom_feminine_get_all_fonts(),	
     		)
		)
	);
    
    /** Font Size*/
    $wp_customize->add_setting( 
        'font_size', 
        array(
            'default'           => 16,
            'sanitize_callback' => 'blossom_feminine_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Feminine_Slider_Control( 
			$wp_customize,
			'font_size',
			array(
				'section'	  => 'typography_settings',
				'label'		  => __( 'Font Size', 'blossom-feminine' ),
				'description' => __( 'Change the font size of your site.', 'blossom-feminine' ),
                'choices'	  => array(
					'min' 	=> 10,
					'max' 	=> 50,
					'step'	=> 1,
				)                 
			)
		)
	);
    
    /** Move Header Image section to appearance panel */
    $wp_customize->get_section( 'header_image' )->panel    = 'appearance_settings';
    $wp_customize->get_section( 'header_image' )->priority = 20;
    $wp_customize->remove_control( 'header_textcolor' );
    
    /** Move Background Image section to appearance panel */
    $wp_customize->get_section( 'background_image' )->panel    = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->priority = 30;
}
add_action( 'customize_register', 'blossom_feminine_customize_register_appearance' );