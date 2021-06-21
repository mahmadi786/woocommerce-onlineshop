<?php
/**
 * Food Restaurant Theme Customizer
 *
 * @package Food Restaurant
 */

/**
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function food_restaurant_customize_register( $wp_customize ) {	

	//add home page setting pannel
	$wp_customize->add_panel( 'food_restaurant_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'LT Settings', 'food-restaurant' ),
	    'description' => __( 'Description of what this panel does.', 'food-restaurant' ),
	) );

	$wp_customize->add_section( 'food_restaurant_left_right' , array(
    	'title'      => __( 'General Settings', 'food-restaurant' ),
		'priority'   => 30,
		'panel' => 'food_restaurant_panel_id'
	) );

	$wp_customize->add_setting( 'food_restaurant_sticky_header',array(
		'default'	=> false,
      	'sanitize_callback'	=> 'food_restaurant_sanitize_checkbox'
    ) );
    $wp_customize->add_control('food_restaurant_sticky_header',array(
    	'type' => 'checkbox',
    	'description' => __( 'Click on the checkbox to enable sticky header.', 'food-restaurant' ),
        'label' => __( 'Sticky Header','food-restaurant' ),
        'section' => 'food_restaurant_left_right'
    ));

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('food_restaurant_theme_options',array(
	        'default' => __( 'Right Sidebar', 'food-restaurant' ),
	        'sanitize_callback' => 'food_restaurant_sanitize_choices'	        
	    )
    );
	$wp_customize->add_control('food_restaurant_theme_options', array(
        'type' => 'radio',
        'description' => __( 'Choose sidebar between different options', 'food-restaurant' ),
        'label' => __( 'Do you want this section', 'food-restaurant' ),
        'section' => 'food_restaurant_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','food-restaurant'),
            'Right Sidebar' => __('Right Sidebar','food-restaurant'),
            'One Column' => __('One Column','food-restaurant'),
            'Three Columns' => __('Three Columns','food-restaurant'),
            'Four Columns' => __('Four Columns','food-restaurant'),
            'Grid Layout' => __('Grid Layout','food-restaurant')
        ),
    ));

	$food_restaurant_font_array = array(
        '' =>'No Fonts',
        'Abril Fatface' => 'Abril Fatface',
        'Acme' =>'Acme', 
        'Anton' => 'Anton', 
        'Architects Daughter' =>'Architects Daughter',
        'Arimo' => 'Arimo', 
        'Arsenal' =>'Arsenal',
        'Arvo' =>'Arvo',
        'Alegreya' =>'Alegreya',
        'Alfa Slab One' =>'Alfa Slab One',
        'Averia Serif Libre' =>'Averia Serif Libre', 
        'Bangers' =>'Bangers', 
        'Boogaloo' =>'Boogaloo', 
        'Bad Script' =>'Bad Script',
        'Bitter' =>'Bitter', 
        'Bree Serif' =>'Bree Serif', 
        'BenchNine' =>'BenchNine',
        'Cabin' =>'Cabin',
        'Cardo' =>'Cardo', 
        'Courgette' =>'Courgette', 
        'Cherry Swash' =>'Cherry Swash',
        'Cormorant Garamond' =>'Cormorant Garamond', 
        'Crimson Text' =>'Crimson Text',
        'Cuprum' =>'Cuprum', 
        'Cookie' =>'Cookie',
        'Chewy' =>'Chewy',
        'Days One' =>'Days One',
        'Dosis' =>'Dosis',
        'Droid Sans' =>'Droid Sans', 
        'Economica' =>'Economica', 
        'Fredoka One' =>'Fredoka One',
        'Fjalla One' =>'Fjalla One',
        'Francois One' =>'Francois One', 
        'Frank Ruhl Libre' => 'Frank Ruhl Libre', 
        'Gloria Hallelujah' =>'Gloria Hallelujah',
        'Great Vibes' =>'Great Vibes', 
        'Handlee' =>'Handlee', 
        'Hammersmith One' =>'Hammersmith One',
        'Inconsolata' =>'Inconsolata',
        'Indie Flower' =>'Indie Flower', 
        'IM Fell English SC' =>'IM Fell English SC',
        'Julius Sans One' =>'Julius Sans One',
        'Josefin Slab' =>'Josefin Slab',
        'Josefin Sans' =>'Josefin Sans',
        'Kanit' =>'Kanit',
        'Lobster' =>'Lobster',
        'Lato' => 'Lato',
        'Lora' =>'Lora', 
        'Libre Baskerville' =>'Libre Baskerville',
        'Lobster Two' => 'Lobster Two',
        'Merriweather' =>'Merriweather',
        'Monda' =>'Monda',
        'Montserrat' =>'Montserrat',
        'Muli' =>'Muli',
        'Marck Script' =>'Marck Script',
        'Noto Serif' =>'Noto Serif',
        'Open Sans' =>'Open Sans',
        'Overpass' => 'Overpass', 
        'Overpass Mono' =>'Overpass Mono',
        'Oxygen' =>'Oxygen',
        'Orbitron' =>'Orbitron',
        'Patua One' =>'Patua One',
        'Pacifico' =>'Pacifico',
        'Padauk' =>'Padauk',
        'Playball' =>'Playball',
        'Playfair Display' =>'Playfair Display',
        'PT Sans' =>'PT Sans',
        'Philosopher' =>'Philosopher',
        'Permanent Marker' =>'Permanent Marker',
        'Poiret One' =>'Poiret One',
        'Quicksand' =>'Quicksand',
        'Quattrocento Sans' =>'Quattrocento Sans',
        'Raleway' =>'Raleway',
        'Rubik' =>'Rubik',
        'Rokkitt' =>'Rokkitt',
        'Russo One' => 'Russo One', 
        'Righteous' =>'Righteous', 
        'Slabo' =>'Slabo', 
        'Source Sans Pro' =>'Source Sans Pro',
        'Shadows Into Light Two' =>'Shadows Into Light Two',
        'Shadows Into Light' =>  'Shadows Into Light',
        'Sacramento' =>'Sacramento',
        'Shrikhand' =>'Shrikhand',
        'Tangerine' => 'Tangerine',
        'Ubuntu' =>'Ubuntu',
        'VT323' =>'VT323',
        'Varela Round' =>'Varela Round',
        'Vampiro One' =>'Vampiro One',
        'Vollkorn' => 'Vollkorn',
        'Volkhov' =>'Volkhov',
        'Kavoon' =>'Kavoon',
        'Yanone Kaffeesatz' =>'Yanone Kaffeesatz'
    );

	//Typography
	$wp_customize->add_section( 'food_restaurant_typography', array(
    	'title'      => __( 'Typography', 'food-restaurant' ),
		'priority'   => 30,
		'panel' => 'food_restaurant_panel_id'
	) );
	
	// This is Paragraph Color picker setting
	$wp_customize->add_setting( 'food_restaurant_paragraph_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'food_restaurant_paragraph_color', array(
		'label' => __('Paragraph Color', 'food-restaurant'),
		'section' => 'food_restaurant_typography',
		'settings' => 'food_restaurant_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('food_restaurant_paragraph_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'food_restaurant_sanitize_choices'
	));
	$wp_customize->add_control(
	    'food_restaurant_paragraph_font_family', array(
	    'section'  => 'food_restaurant_typography',
	    'label'    => __( 'Paragraph Fonts','food-restaurant'),
	    'type'     => 'select',
	    'choices'  => $food_restaurant_font_array,
	));

	$wp_customize->add_setting('food_restaurant_paragraph_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_restaurant_paragraph_font_size',array(
		'label'	=> __('Paragraph Font Size','food-restaurant'),
		'section'	=> 'food_restaurant_typography',
		'setting'	=> 'food_restaurant_paragraph_font_size',
		'type'	=> 'text'
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'food_restaurant_atag_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'food_restaurant_atag_color', array(
		'label' => __('"a" Tag Color', 'food-restaurant'),
		'section' => 'food_restaurant_typography',
		'settings' => 'food_restaurant_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('food_restaurant_atag_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'food_restaurant_sanitize_choices'
	));
	$wp_customize->add_control(
	    'food_restaurant_atag_font_family', array(
	    'section'  => 'food_restaurant_typography',
	    'label'    => __( '"a" Tag Fonts','food-restaurant'),
	    'type'     => 'select',
	    'choices'  => $food_restaurant_font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'food_restaurant_li_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'food_restaurant_li_color', array(
		'label' => __('"li" Tag Color', 'food-restaurant'),
		'section' => 'food_restaurant_typography',
		'settings' => 'food_restaurant_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('food_restaurant_li_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'food_restaurant_sanitize_choices'
	));
	$wp_customize->add_control(
	    'food_restaurant_li_font_family', array(
	    'section'  => 'food_restaurant_typography',
	    'label'    => __( '"li" Tag Fonts','food-restaurant'),
	    'type'     => 'select',
	    'choices'  => $food_restaurant_font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting( 'food_restaurant_h1_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'food_restaurant_h1_color', array(
		'label' => __('H1 Color', 'food-restaurant'),
		'section' => 'food_restaurant_typography',
		'settings' => 'food_restaurant_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('food_restaurant_h1_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'food_restaurant_sanitize_choices'
	));
	$wp_customize->add_control(
	    'food_restaurant_h1_font_family', array(
	    'section'  => 'food_restaurant_typography',
	    'label'    => __( 'H1 Fonts','food-restaurant'),
	    'type'     => 'select',
	    'choices'  => $food_restaurant_font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('food_restaurant_h1_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_restaurant_h1_font_size',array(
		'label'	=> __('H1 Font Size','food-restaurant'),
		'section'	=> 'food_restaurant_typography',
		'setting'	=> 'food_restaurant_h1_font_size',
		'type'	=> 'text'
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting( 'food_restaurant_h2_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'food_restaurant_h2_color', array(
		'label' => __('h2 Color', 'food-restaurant'),
		'section' => 'food_restaurant_typography',
		'settings' => 'food_restaurant_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('food_restaurant_h2_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'food_restaurant_sanitize_choices'
	));
	$wp_customize->add_control(
	    'food_restaurant_h2_font_family', array(
	    'section'  => 'food_restaurant_typography',
	    'label'    => __( 'h2 Fonts','food-restaurant'),
	    'type'     => 'select',
	    'choices'  => $food_restaurant_font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('food_restaurant_h2_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_restaurant_h2_font_size',array(
		'label'	=> __('h2 Font Size','food-restaurant'),
		'section'	=> 'food_restaurant_typography',
		'setting'	=> 'food_restaurant_h2_font_size',
		'type'	=> 'text'
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting( 'food_restaurant_h3_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'food_restaurant_h3_color', array(
		'label' => __('h3 Color', 'food-restaurant'),
		'section' => 'food_restaurant_typography',
		'settings' => 'food_restaurant_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('food_restaurant_h3_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'food_restaurant_sanitize_choices'
	));
	$wp_customize->add_control(
	    'food_restaurant_h3_font_family', array(
	    'section'  => 'food_restaurant_typography',
	    'label'    => __( 'h3 Fonts','food-restaurant'),
	    'type'     => 'select',
	    'choices'  => $food_restaurant_font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('food_restaurant_h3_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_restaurant_h3_font_size',array(
		'label'	=> __('h3 Font Size','food-restaurant'),
		'section'	=> 'food_restaurant_typography',
		'setting'	=> 'food_restaurant_h3_font_size',
		'type'	=> 'text'
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting( 'food_restaurant_h4_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'food_restaurant_h4_color', array(
		'label' => __('h4 Color', 'food-restaurant'),
		'section' => 'food_restaurant_typography',
		'settings' => 'food_restaurant_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('food_restaurant_h4_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'food_restaurant_sanitize_choices'
	));
	$wp_customize->add_control(
	    'food_restaurant_h4_font_family', array(
	    'section'  => 'food_restaurant_typography',
	    'label'    => __( 'h4 Fonts','food-restaurant'),
	    'type'     => 'select',
	    'choices'  => $food_restaurant_font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('food_restaurant_h4_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_restaurant_h4_font_size',array(
		'label'	=> __('h4 Font Size','food-restaurant'),
		'section'	=> 'food_restaurant_typography',
		'setting'	=> 'food_restaurant_h4_font_size',
		'type'	=> 'text'
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting( 'food_restaurant_h5_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'food_restaurant_h5_color', array(
		'label' => __('h5 Color', 'food-restaurant'),
		'section' => 'food_restaurant_typography',
		'settings' => 'food_restaurant_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('food_restaurant_h5_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'food_restaurant_sanitize_choices'
	));
	$wp_customize->add_control(
	    'food_restaurant_h5_font_family', array(
	    'section'  => 'food_restaurant_typography',
	    'label'    => __( 'h5 Fonts','food-restaurant'),
	    'type'     => 'select',
	    'choices'  => $food_restaurant_font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('food_restaurant_h5_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_restaurant_h5_font_size',array(
		'label'	=> __('h5 Font Size','food-restaurant'),
		'section'	=> 'food_restaurant_typography',
		'setting'	=> 'food_restaurant_h5_font_size',
		'type'	=> 'text'
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting( 'food_restaurant_h6_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'food_restaurant_h6_color', array(
		'label' => __('h6 Color', 'food-restaurant'),
		'section' => 'food_restaurant_typography',
		'settings' => 'food_restaurant_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('food_restaurant_h6_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'food_restaurant_sanitize_choices'
	));
	$wp_customize->add_control(
	    'food_restaurant_h6_font_family', array(
	    'section'  => 'food_restaurant_typography',
	    'label'    => __( 'h6 Fonts','food-restaurant'),
	    'type'     => 'select',
	    'choices'  => $food_restaurant_font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('food_restaurant_h6_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_restaurant_h6_font_size',array(
		'label'	=> __('h6 Font Size','food-restaurant'),
		'section'	=> 'food_restaurant_typography',
		'setting'	=> 'food_restaurant_h6_font_size',
		'type'	=> 'text'
	));

	//home page slider
	$wp_customize->add_section( 'food_restaurant_slider_section' , array(
    	'title'      => __( 'Slider Settings', 'food-restaurant' ),
		'priority'   => null,
		'panel' => 'food_restaurant_panel_id'
	) );

	$wp_customize->add_setting('food_restaurant_slider_hide',array(
       'default' => false,
       'sanitize_callback'  => 'food_restaurant_sanitize_checkbox'
    ));
    $wp_customize->add_control('food_restaurant_slider_hide',array(
       'type' => 'checkbox',
       'description' => __( 'Click on the checkbox to enable slider.', 'food-restaurant' ),
       'label' => __('Show / Hide slider','food-restaurant'),
       'section' => 'food_restaurant_slider_section',
    ));

	for ( $count = 1; $count <= 4; $count++ ) {
		// Add color scheme setting and control.
		$wp_customize->add_setting( 'food_restaurant_slider' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'food_restaurant_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'food_restaurant_slider' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'food-restaurant' ),
			'section'  => 'food_restaurant_slider_section',
			'type'     => 'dropdown-pages'
		) );
	}
	
	//Our Product
	$wp_customize->add_section('food_restaurant_product',array(
		'title'	=> __('Food Products','food-restaurant'),
		'description'=> __('This section will appear below the slider.','food-restaurant'),
		'panel' => 'food_restaurant_panel_id',
	));

	$wp_customize->add_setting('food_restaurant_product_sec_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_restaurant_product_sec_title',array(
		'label'	=> __('Title','food-restaurant'),
		'section'	=> 'food_restaurant_product',
		'setting'	=> 'food_restaurant_product_sec_title',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('food_restaurant_product_sec_subtitle',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_restaurant_product_sec_subtitle',array(
		'label'	=> __('Sub Title','food-restaurant'),
		'section'	=> 'food_restaurant_product',
		'setting'	=> 'food_restaurant_product_sec_subtitle',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('food_restaurant_product_sec_short_line',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_restaurant_product_sec_short_line',array(
		'label'	=> __('Short Line','food-restaurant'),
		'section'	=> 'food_restaurant_product',
		'setting'	=> 'food_restaurant_product_sec_short_line',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('food_restaurant_product_sec_box_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'food_restaurant_product_sec_box_image',array(
        'label' => __('Product Leftside Image','food-restaurant'),
        'description'=> __('Image size (480px x 720px)','food-restaurant'),
        'section' => 'food_restaurant_product',
        'settings' => 'food_restaurant_product_sec_box_image'
	)));
	
	$wp_customize->add_setting( 'food_restaurant_product_settings', array(
		'default'           => '',
		'sanitize_callback' => 'food_restaurant_sanitize_dropdown_pages'
	));
	$wp_customize->add_control( 'food_restaurant_product_settings', array(
		'label'    => __( 'Select Product Page', 'food-restaurant' ),
		'section'  => 'food_restaurant_product',
		'type'     => 'dropdown-pages'
	));

	//footer
	$wp_customize->add_section('food_restaurant_footer_section',array(
		'title'	=> __('Footer Text','food-restaurant'),
		'description'	=> __('Add some text for footer like copyright etc.','food-restaurant'),
		'panel' => 'food_restaurant_panel_id'
	));
	
	$wp_customize->add_setting('food_restaurant_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_restaurant_footer_copy',array(
		'label'	=> __('Copyright Text','food-restaurant'),
		'section'	=> 'food_restaurant_footer_section',
		'type'		=> 'text'
	));

	//Wocommerce Shop Page
	$wp_customize->add_section('food_restaurant_woocommerce_shop_page',array(
		'title'	=> __('Woocommerce Shop Page','food-restaurant'),
		'panel' => 'food_restaurant_panel_id'
	));

	$wp_customize->add_setting( 'food_restaurant_products_per_column' , array(
		'default'           => 3,
		'transport'         => 'refresh',
		'sanitize_callback' => 'food_restaurant_sanitize_choices',
	) );
	$wp_customize->add_control( 'food_restaurant_products_per_column', array(
		'label'    => __( 'Product Per Columns', 'food-restaurant' ),
		'description'	=> __('How many products should be shown per Column?','food-restaurant'),
		'section'  => 'food_restaurant_woocommerce_shop_page',
		'type'     => 'select',
		'choices'  => array(
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
		),
	)  );

	$wp_customize->add_setting('food_restaurant_products_per_page',array(
		'default'	=> 9,
		'sanitize_callback'	=> 'food_restaurant_sanitize_float',
	));	
	$wp_customize->add_control('food_restaurant_products_per_page',array(
		'label'	=> __('Product Per Page','food-restaurant'),
		'description'	=> __('How many products should be shown per page?','food-restaurant'),
		'section'	=> 'food_restaurant_woocommerce_shop_page',
		'type'		=> 'number'
	));

	$wp_customize->add_setting('food_restaurant_site_title_tagline',array(
       'default' => true,
       'sanitize_callback'	=> 'food_restaurant_sanitize_checkbox'
    ));
    $wp_customize->add_control('food_restaurant_site_title_tagline',array(
       'type' => 'checkbox',
       'label' => __('Display Site Title and Tagline in Header','food-restaurant'),
       'section' => 'title_tagline'
    ));
}
add_action( 'customize_register', 'food_restaurant_customize_register' );	

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Food_Restaurant_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Food_Restaurant_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Food_Restaurant_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority'   => 9,
					'title'    => esc_html__( 'Food Restaurant Pro', 'food-restaurant' ),
					'pro_text' => esc_html__( 'Go Pro', 'food-restaurant' ),
					'pro_url'  => esc_url( 'https://www.logicalthemes.com/premium/food-restaurant-wordpress-theme/' ),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'food-restaurant-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'food-restaurant-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Food_Restaurant_Customize::get_instance();