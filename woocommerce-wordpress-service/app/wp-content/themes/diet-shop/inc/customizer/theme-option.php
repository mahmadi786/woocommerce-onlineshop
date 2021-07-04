<?php 

/**
 * Theme Options Panel.
 *
 * @package diet-shop
 */

$default = diet_shop_get_default_theme_options();
global $wp_customize;



// Add Theme Options Panel.
$wp_customize->add_panel( 'theme_option_panel',
	array(
		'title'      => esc_html__( 'Theme Options', 'diet-shop' ),
		'priority'   => 10,
		'capability' => 'edit_theme_options',
	)
);

// Styling Options.*/

$wp_customize->add_section( 'styling_section_settings',
	array(
		'title'      => esc_html__( 'Styling Options', 'diet-shop' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);


// Primary Color.
$wp_customize->add_setting( '__primary_color',
	array(
	'default'           => $default['__primary_color'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( '__primary_color',
	array(
	'label'    	   => esc_html__( 'Primary Color Scheme:', 'diet-shop' ),
	'section'  	   => 'styling_section_settings',
	'description'  => esc_html__( 'The theme comes with unlimited color schemes for your theme\'s styling. upgrade pro for color options & features', 'diet-shop' ),
	'type'     => 'color',
	'priority' => 120,
	)
);

$wp_customize->add_setting( '__secondary_color',
	array(
	'default'           => $default['__secondary_color'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( '__secondary_color',
	array(
	'label'    	   => esc_html__( 'Secondary Color Scheme:', 'diet-shop' ),
	'section'  	   => 'styling_section_settings',
	'description'  => esc_html__( 'The theme comes with unlimited color schemes for your theme\'s styling. upgrade pro for color options & features', 'diet-shop' ),
	'type'     => 'color',
	'priority' => 120,
	)
);
	
/*Posts management section start */
$wp_customize->add_section( 'theme_option_section_settings',
	array(
		'title'      => esc_html__( 'Blog Management', 'diet-shop' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

		/*Posts Layout*/
		$wp_customize->add_setting( 'blog_layout',
			array(
				'default'           => $default['blog_layout'],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'diet_shop_sanitize_select',
			)
		);
		$wp_customize->add_control( 'blog_layout',
			array(
				'label'    => esc_html__( 'Blog Layout Options', 'diet-shop' ),
				'description' => esc_html__( 'Choose between different layout options to be used as default', 'diet-shop' ),
				'section'  => 'theme_option_section_settings',
				'choices'   => array(
					'sidebar-content'  => esc_html__( 'Primary Sidebar - Content', 'diet-shop' ),
					'content-sidebar' => esc_html__( 'Content - Primary Sidebar', 'diet-shop' ),
					'no-sidebar'    => esc_html__( 'No Sidebar', 'diet-shop' ),
					),
				'type'     => 'select',
				
			)
		);
		
		
		
		/*Blog Loop Content*/
		$wp_customize->add_setting( 'blog_loop_content_type',
			array(
				'default'           => $default['blog_loop_content_type'],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'diet_shop_sanitize_select',
			)
		);
		$wp_customize->add_control( 'blog_loop_content_type',
			array(
				'label'    => esc_html__( 'Archive Content Type', 'diet-shop' ),
				'description' => esc_html__( 'Choose Archive, Blog Page Content type as default', 'diet-shop' ),
				'section'  => 'theme_option_section_settings',
				'choices'               => array(
					'excerpt' => __( 'Excerpt', 'diet-shop' ),
					'content' => __( 'Content', 'diet-shop' ),
					),
				'type'     => 'select',
				
			)
		);
		
		/*Social Profile*/
		$wp_customize->add_setting( 'read_more_text',
			array(
				'default'           => $default['read_more_text'],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control( 'read_more_text',
			array(
				'label'    => esc_html__( 'Read more text', 'diet-shop' ),
				'description' => esc_html__( 'Leave empty to hide', 'diet-shop' ),
				'section'  => 'theme_option_section_settings',
				'type'     => 'text',
				
			)
		);
		
		/*Social Profile*/
		$wp_customize->add_setting( 'index_hide_thumb',
			array(
				'default'           => $default['index_hide_thumb'],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'diet_shop_sanitize_checkbox',
			)
		);
		$wp_customize->add_control( 'index_hide_thumb',
			array(
				'label'    => esc_html__( 'Hide post thumbnail / Media ?', 'diet-shop' ),
				'section'  => 'theme_option_section_settings',
				'type'     => 'checkbox',
				
			)
		);
		
/*Posts management section start */
$wp_customize->add_section( 'page_option_section_settings',
	array(
		'title'      => esc_html__( 'Page Management', 'diet-shop' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

	
		/*Home Page Layout*/
		$wp_customize->add_setting( 'page_layout',
			array(
				'default'           => $default['blog_layout'],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'diet_shop_sanitize_select',
			)
		);
		$wp_customize->add_control( 'page_layout',
			array(
				'label'    => esc_html__( 'Page Layout Options', 'diet-shop' ),
				'section'  => 'page_option_section_settings',
				'description' => esc_html__( 'Choose between different layout options to be used as default', 'diet-shop' ),
				'choices'   => array(
					'sidebar-content'  => esc_html__( 'Primary Sidebar - Content', 'diet-shop' ),
					'content-sidebar' => esc_html__( 'Content - Primary Sidebar', 'diet-shop' ),
					'no-sidebar'    => esc_html__( 'No Sidebar', 'diet-shop' ),
					),
				'type'     => 'select',
				'priority' => 170,
			)
		);


		// Footer Section.
		$wp_customize->add_section( 'footer_section',
			array(
			'title'      => esc_html__( 'Copyright', 'diet-shop' ),
			'priority'   => 130,
			'capability' => 'edit_theme_options',
			'panel'      => 'theme_option_panel',
			)
		);
		
		// Setting copyright_text.
		$wp_customize->add_setting( 'copyright_text',
			array(
			'default'           => $default['copyright_text'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control( 'copyright_text',
			array(
			'label'    => esc_html__( 'Footer Copyright Text', 'diet-shop' ),
			'section'  => 'footer_section',
			'type'     => 'textarea',
			'priority' => 120,
			)
		);
		
		
		



		