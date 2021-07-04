<?php
/**
 * lzrestaurant: Customizer
 *
 * @subpackage lzrestaurant
 * @since 1.0
 */

function lzrestaurant_customize_register( $wp_customize ) {

	$wp_customize->add_setting('lzrestaurant_show_site_title',array(
       'default' => true,
       'sanitize_callback'	=> 'lzrestaurant_sanitize_checkbox'
    ));
    $wp_customize->add_control('lzrestaurant_show_site_title',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Site Title','lzrestaurant'),
       'section' => 'title_tagline'
    ));

    $wp_customize->add_setting('lzrestaurant_show_tagline',array(
       'default' => true,
       'sanitize_callback'	=> 'lzrestaurant_sanitize_checkbox'
    ));
    $wp_customize->add_control('lzrestaurant_show_tagline',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Site Tagline','lzrestaurant'),
       'section' => 'title_tagline'
    ));

	$wp_customize->add_panel( 'lzrestaurant_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Theme Settings', 'lzrestaurant' ),
	    'description' => __( 'Description of what this panel does.', 'lzrestaurant' ),
	) );

	$wp_customize->add_section( 'lzrestaurant_theme_options_section', array(
    	'title'      => __( 'General Settings', 'lzrestaurant' ),
		'priority'   => 30,
		'panel' => 'lzrestaurant_panel_id'
	) );

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('lzrestaurant_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'lzrestaurant_sanitize_choices'	        
	));
	$wp_customize->add_control('lzrestaurant_theme_options', array(
        'type' => 'radio',
        'label' => __('Do you want this section','lzrestaurant'),
        'section' => 'lzrestaurant_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','lzrestaurant'),
            'Right Sidebar' => __('Right Sidebar','lzrestaurant'),
            'One Column' => __('One Column','lzrestaurant'),
            'Three Columns' => __('Three Columns','lzrestaurant'),
            'Four Columns' => __('Four Columns','lzrestaurant'),
            'Grid Layout' => __('Grid Layout','lzrestaurant')
        ),
	));

    //Social Icons(topbar)
	$wp_customize->add_section('lzrestaurant_topbar_header',array(
		'title'	=> __('Social Icon Section','lzrestaurant'),
		'description'	=> __('Add Social Link here','lzrestaurant'),
		'priority'	=> null,
		'panel' => 'lzrestaurant_panel_id',
	));

	$wp_customize->add_setting('lzrestaurant_facebook',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('lzrestaurant_facebook',array(
		'label'	=> __('Add Facebook link','lzrestaurant'),
		'section'	=> 'lzrestaurant_topbar_header',
		'setting'	=> 'lzrestaurant_facebook',
		'type'		=> 'url'
	));

	$wp_customize->add_setting('lzrestaurant_twitter',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('lzrestaurant_twitter',array(
		'label'	=> __('Add Twitter link','lzrestaurant'),
		'section'	=> 'lzrestaurant_topbar_header',
		'setting'	=> 'lzrestaurant_twitter',
		'type'		=> 'url'
	));

	$wp_customize->add_setting('lzrestaurant_instagram',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('lzrestaurant_instagram',array(
		'label'	=> __('Add Instagram link','lzrestaurant'),
		'section'	=> 'lzrestaurant_topbar_header',
		'setting'	=> 'lzrestaurant_instagram',
		'type'		=> 'url'
	));

	$wp_customize->add_setting('lzrestaurant_pinterest',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('lzrestaurant_pinterest',array(
		'label'	=> __('Add Pintrest link','lzrestaurant'),
		'section'	=> 'lzrestaurant_topbar_header',
		'setting'	=> 'lzrestaurant_pinterest',
		'type'		=> 'url'
	));

	$wp_customize->add_setting('lzrestaurant_tumblr',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('lzrestaurant_tumblr',array(
		'label'	=> __('Add Tumblr link','lzrestaurant'),
		'section'	=> 'lzrestaurant_topbar_header',
		'setting'	=> 'lzrestaurant_tumblr',
		'type'		=> 'url'
	));

	//home page slider
	$wp_customize->add_section( 'lzrestaurant_slider_section' , array(
    	'title'      => __( 'Slider Settings', 'lzrestaurant' ),
		'priority'   => null,
		'panel' => 'lzrestaurant_panel_id'
	) );

	$wp_customize->add_setting('lzrestaurant_slider_hide_show',array(
       'default' => 'true',
       'sanitize_callback'	=> 'lzrestaurant_sanitize_checkbox'
	));
	$wp_customize->add_control('lzrestaurant_slider_hide_show',array(
	   'type' => 'checkbox',
	   'label' => __('Show / Hide slider','lzrestaurant'),
	   'section' => 'lzrestaurant_slider_section',
	));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'lzrestaurant_slider' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'lzrestaurant_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'lzrestaurant_slider' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'lzrestaurant' ),
			'section'  => 'lzrestaurant_slider_section',
			'type'     => 'dropdown-pages'
		) );
	}
	

	//Feature Products
    $wp_customize->add_section( 'lzrestaurant_product', array(
    	'title'      => __( 'Feature Products', 'lzrestaurant' ),
		'priority'   => 30,
		'panel' => 'lzrestaurant_panel_id'
	) );

    $wp_customize->add_setting('lzrestaurant_title1',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('lzrestaurant_title1',array(
		'label'	=> __('Section Short Title','lzrestaurant'),
		'section'	=> 'lzrestaurant_product',
		'setting'	=> 'lzrestaurant_title1',
		'type'		=> 'text'
	));

    $wp_customize->add_setting('lzrestaurant_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('lzrestaurant_title',array(
		'label'	=> __('Section Title','lzrestaurant'),
		'section'	=> 'lzrestaurant_product',
		'setting'	=> 'lzrestaurant_title',
		'type'		=> 'text'
	));

	$wp_customize->add_setting( 'lzrestaurant_product_page', array(
		'default'           => '',
		'sanitize_callback' => 'lzrestaurant_sanitize_dropdown_pages'
	));
	$wp_customize->add_control( 'lzrestaurant_product_page', array(
		'label'    => __( 'Select Product Page', 'lzrestaurant' ),
		'section'  => 'lzrestaurant_product',
		'type'     => 'dropdown-pages'
	));

	//Footer Text
    $wp_customize->add_section( 'lzrestaurant_footer', array(
    	'title'      => __( 'Footer Text', 'lzrestaurant' ),
		'priority'   => null,
		'panel' => 'lzrestaurant_panel_id'
	) );

    $wp_customize->add_setting('lzrestaurant_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('lzrestaurant_footer_copy',array(
		'label'	=> __('Section Title','lzrestaurant'),
		'section'	=> 'lzrestaurant_footer',
		'setting'	=> 'lzrestaurant_footer_copy',
		'type'		=> 'text'
	));

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'lzrestaurant_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'lzrestaurant_customize_partial_blogdescription',
	) );

	//front page
	$num_sections = apply_filters( 'lzrestaurant_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $i, array(
			'default'           => false,
			'sanitize_callback' => 'lzrestaurant_sanitize_dropdown_pages',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'panel_' . $i, array(
			/* translators: %d is the front page section number */
			'label'          => sprintf( __( 'Front Page Section %d Content', 'lzrestaurant' ), $i ),
			'description'    => ( 1 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'lzrestaurant' ) ),
			'section'        => 'theme_options',
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'active_callback' => 'lzrestaurant_is_static_front_page',
		) );

		$wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
			'selector'            => '#panel' . $i,
			'render_callback'     => 'lzrestaurant_front_page_section',
			'container_inclusive' => true,
		) );
	}
}
add_action( 'customize_register', 'lzrestaurant_customize_register' );

function lzrestaurant_customize_partial_blogname() {
	bloginfo( 'name' );
}

function lzrestaurant_customize_partial_blogdescription() {
	bloginfo( 'description' );
}


function lzrestaurant_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}

function lzrestaurant_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
if ( ! class_exists ( 'LZ_Food_Recipee_Customize' ) ) {
final class LZrestaurant_Customize {

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
		$manager->register_section_type( 'LZrestaurant_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new LZrestaurant_Customize_Section_Pro(
				$manager,
				'lzrestaurant_example_1',
				array(
					'priority' => 9,
					'title'    => esc_html__( 'LZ Restaurant Pro', 'lzrestaurant' ),
					'pro_text' => esc_html__( 'Upgrade Pro', 'lzrestaurant' ),
					'pro_url'  => esc_url('https://www.luzuk.com/product/premium-restaurant-wordpress-theme/')
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

		wp_enqueue_script( 'lzrestaurant-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'lzrestaurant-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
LZrestaurant_Customize::get_instance();
}