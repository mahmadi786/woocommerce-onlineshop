<?php
/**
 * FoodHunt Theme Customizer.
 *
 * @package    ThemeGrill
 * @subpackage FoodHunt
 * @since      0.1
 */

/**
 * Loads custom control for layout settings
 */
function foodhunt_custom_controls() {

	require_once get_template_directory() . '/inc/admin/customize-controls.php';
}

/* Theme Customizer setup. */
add_action( 'customize_register', 'foodhunt_custom_controls' );

function foodhunt_customize_register( $wp_customize ) {
	// Transport postMessage variable set
	$customizer_selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '#site-title a',
			'render_callback' => 'foodhunt_customize_partial_blogname',
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '#site-description',
			'render_callback' => 'foodhunt_customize_partial_blogdescription',
		) );
	}

	/**
	 * Class to include upsell link campaign for theme.
	 *
	 * Class FOODHUNT_Upsell_Section
	 */
	class FOODHUNT_Upsell_Section extends WP_Customize_Section {
		public $type = 'foodhunt-upsell-section';
		public $url  = '';
		public $id   = '';

		/**
		 * Gather the parameters passed to client JavaScript via JSON.
		 *
		 * @return array The array to be exported to the client as JSON.
		 */
		public function json() {
			$json        = parent::json();
			$json['url'] = esc_url( $this->url );
			$json['id']  = $this->id;

			return $json;
		}

		/**
		 * An Underscore (JS) template for rendering this section.
		 */
		protected function render_template() {
			?>
			<li id="accordion-section-{{ data.id }}" class="foodhunt-upsell-accordion-section control-section-{{ data.type }} cannot-expand accordion-section">
				<h3 class="accordion-section-title"><a href="{{{ data.url }}}" target="_blank">{{ data.title }}</a></h3>
			</li>
			<?php
		}
	}

// Register `FOODHUNT_Upsell_Section` type section.
	$wp_customize->register_section_type( 'FOODHUNT_Upsell_Section' );

// Add `FOODHUNT_Upsell_Section` to display pro link.
	$wp_customize->add_section(
		new FOODHUNT_Upsell_Section( $wp_customize, 'foodhunt_upsell_section',
			array(
				'title'      => esc_html__( 'View PRO version', 'foodhunt' ),
				'url'        => 'https://themegrill.com/themes/foodhunt/?utm_source=foodhunt-customizer&utm_medium=view-pro-link&utm_campaign=view-pro#free-vs-pro',
				'capability' => 'edit_theme_options',
				'priority'   => 1,
			)
		)
	);


	// Header Options
	$wp_customize->add_panel(
		'foodhunt_header_options',
		array(
			'capabitity'  => 'edit_theme_options',
			'description' => esc_html__( 'Contain all the Header related settings', 'foodhunt' ),
			'priority'    => 160,
			'title'       => esc_html__( 'Header Options', 'foodhunt' ),
		)
	);

	// Header News/ Ticker Option
	$wp_customize->add_section(
		'foodhunt_ticker_section',
		array(
			'priority'    => 10,
			'description' => esc_html__( 'Display Latest post Titles in the Header Top Bar.', 'foodhunt' ),
			'title'       => esc_html__( 'Header News', 'foodhunt' ),
			'panel'       => 'foodhunt_header_options',
		)
	);

	// Ticker Activation Setting
	$wp_customize->add_setting(
		'foodhunt_ticker_activation',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'transport'         => $customizer_selective_refresh,
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_ticker_activation',
		array(
			'label'   => esc_html__( 'Enable Header News', 'foodhunt' ),
			'section' => 'foodhunt_ticker_section',
			'type'    => 'checkbox',
		)
	);

	// Selective refresh for header news
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'foodhunt_ticker_activation', array(
			'selector'        => '.header-ticker',
			'render_callback' => '',
		) );
	}

	// Ticker Text
	$wp_customize->add_setting(
		'foodhunt_ticker_text',
		array(
			'default'           => esc_html__( 'Special:', 'foodhunt' ),
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$wp_customize->add_control(
		'foodhunt_ticker_text',
		array(
			'label'   => esc_html__( 'Text before Post Titles:', 'foodhunt' ),
			'section' => 'foodhunt_ticker_section',
		)
	);


	// Header Sticky Option
	$wp_customize->add_section(
		'foodhunt_header_sticky',
		array(
			'priority'    => 20,
			'description' => esc_html__( 'Header is Sticky by default', 'foodhunt' ),
			'title'       => esc_html__( 'Header Sticky Option', 'foodhunt' ),
			'panel'       => 'foodhunt_header_options',
		)
	);

	$wp_customize->add_setting(
		'foodhunt_non_sticky',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_non_sticky',
		array(
			'label'   => esc_html__( 'Check to make Header Non-sticky', 'foodhunt' ),
			'section' => 'foodhunt_header_sticky',
			'type'    => 'checkbox',
		)
	);

	// Logo Section
	$wp_customize->add_section(
		'foodhunt_header_logo',
		array(
			'priority' => 30,
			'title'    => esc_html__( 'Header Logo', 'foodhunt' ),
			'panel'    => 'foodhunt_header_options',
		)
	);

	// Logo Placement
	$wp_customize->add_setting(
		'foodhunt_logo_placement',
		array(
			'default'           => 'text-only',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_radio_sanitize',
		)
	);

	$wp_customize->add_control(
		'foodhunt_logo_placement',
		array(
			'label'   => esc_html__( 'Choose the required option', 'foodhunt' ),
			'section' => 'title_tagline',
			'type'    => 'radio',
			'choices' => array(
				'logo-only'   => esc_html__( 'Header Logo Only', 'foodhunt' ),
				'text-only'   => esc_html__( 'Header Text Only', 'foodhunt' ),
				'both'        => esc_html__( 'Show both Logo and Text', 'foodhunt' ),
				'header-none' => esc_html__( 'None', 'foodhunt' ),
			),
		)
	);

	// Header Page Title Bar Section
	$wp_customize->add_section(
		'foodhunt_header_title',
		array(
			'priority'    => 40,
			'title'       => esc_html__( 'Header Title Bar', 'foodhunt' ),
			'description' => esc_html__( 'Display image as background just below the main Menu on Home page, archive and single pages.', 'foodhunt' ),
			'panel'       => 'foodhunt_header_options',
		)
	);

	// Image Upload
	$wp_customize->add_setting(
		'foodhunt_header_title_bar',
		array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'foodhunt_header_title_bar',
			array(
				'label'   => esc_html__( 'Upload Image', 'foodhunt' ),
				'section' => 'foodhunt_header_title',
				'setting' => 'foodhunt_header_title_bar',
			)
		)
	);
	// End of Header Options

	/**************************************************************************************/

	// Slider Options
	$wp_customize->add_panel(
		'foodhunt_slider_options',
		array(
			'capabitity'  => 'edit_theme_options',
			'description' => esc_html__( 'Contain all the Slider related settings', 'foodhunt' ),
			'priority'    => 180,
			'title'       => esc_html__( 'Slider Options', 'foodhunt' ),
		)
	);

	// Slider Section
	$wp_customize->add_section(
		'foodhunt_header_slider',
		array(
			'priority'    => 10,
			'title'       => 'Slider Settings',
			'description' => esc_html__( 'Slider displays the Title, Content and Featured image of the page. The recommended size for slider image is 1920px by 1000px. Select the pages in the option provided below', 'foodhunt' ),
			'panel'       => 'foodhunt_slider_options',
		)
	);

	// Slider Activation Setting
	$wp_customize->add_setting(
		'foodhunt_slider_activation',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'transport'         => $customizer_selective_refresh,
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_slider_activation',
		array(
			'label'    => esc_html__( 'Enable Slider', 'foodhunt' ),
			'section'  => 'foodhunt_header_slider',
			'type'     => 'checkbox',
			'priority' => 10,
		)
	);

	// Selective refresh for slider activation
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'foodhunt_slider_activation', array(
			'selector'        => '#home-slider',
			'render_callback' => '',
		) );
	}

	// Slider Icon
	$wp_customize->add_setting(
		'foodhunt_slider_icon',
		array(
			'default'           => 'fa-cutlery',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$wp_customize->add_control(
		'foodhunt_slider_icon',
		array(
			'label'    => esc_html__( 'Enter Icon Class', 'foodhunt' ),
			'section'  => 'foodhunt_header_slider',
			'priority' => 20,
		)
	);

	// Slider Images Selection Setting
	for ( $i = 1; $i <= 4; $i ++ ) {
		$wp_customize->add_setting(
			'foodhunt_slide' . $i,
			array(
				'default'           => '',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'foodhunt_sanitize_integer',
			)
		);

		$wp_customize->add_control(
			'foodhunt_slide' . $i,
			array(
				'label'    => esc_html__( 'Slide ', 'foodhunt' ) . $i,
				'section'  => 'foodhunt_header_slider',
				'type'     => 'dropdown-pages',
				'priority' => $i + 30,
			)
		);
	}

	// Slider Controls
	$wp_customize->add_section(
		'foodhunt_controls_section',
		array(
			'priority'    => 20,
			'title'       => 'Slider Controls',
			'description' => esc_html__( 'Option to hide the slider controls', 'foodhunt' ),
			'panel'       => 'foodhunt_slider_options',
		)
	);

	// Slider Controls Setting
	$wp_customize->add_setting(
		'foodhunt_slider_controls',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_slider_controls',
		array(
			'label'   => esc_html__( 'Hide slider Left/Right Arrows', 'foodhunt' ),
			'section' => 'foodhunt_controls_section',
			'type'    => 'checkbox',
		)
	);

	// Slider Pager Setting
	$wp_customize->add_setting(
		'foodhunt_slider_pager',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_slider_pager',
		array(
			'label'   => esc_html__( 'Hide slider navigation Buttons', 'foodhunt' ),
			'section' => 'foodhunt_controls_section',
			'type'    => 'checkbox',
		)
	);
	// End of Slider Options

	/**************************************************************************************/

	// Design Options
	$wp_customize->add_panel(
		'foodhunt_design_options',
		array(
			'capabitity'  => 'edit_theme_options',
			'description' => esc_html__( 'Contain all the Design related settings', 'foodhunt' ),
			'priority'    => 200,
			'title'       => esc_html__( 'Design Options', 'foodhunt' ),
		)
	);

	// default layout setting
	$wp_customize->add_section(
		'foodhunt_default_layout_section',
		array(
			'priority' => 10,
			'title'    => esc_html__( 'Default layout', 'foodhunt' ),
			'panel'    => 'foodhunt_design_options',
		)
	);

	$wp_customize->add_setting(
		'foodhunt_default_layout',
		array(
			'default'           => 'right-sidebar',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_radio_sanitize',
		)
	);
	$wp_customize->add_control( new FOODHUNT_Image_Radio_Control(
		$wp_customize,
		'foodhunt_default_layout',
		array(
			'type'     => 'radio',
			'label'    => esc_html__( 'Select default layout. This layout will be reflected in whole site archives, categories, search	page etc. The layout for a single post and page can be controlled from below options', 'foodhunt' ),
			'section'  => 'foodhunt_default_layout_section',
			'settings' => 'foodhunt_default_layout',
			'choices'  => array(
				'right-sidebar'               => esc_url( get_template_directory_uri() ) . '/inc/admin/images/right-sidebar.png',
				'left-sidebar'                => esc_url( get_template_directory_uri() ) . '/inc/admin/images/left-sidebar.png',
				'no-sidebar-full-width'       => esc_url( get_template_directory_uri() ) . '/inc/admin/images/no-sidebar-full-width-layout.png',
				'no-sidebar-content-centered' => esc_url( get_template_directory_uri() ) . '/inc/admin/images/no-sidebar-content-centered-layout.png',
			),
		)
	) );

	// default layout for pages
	$wp_customize->add_section(
		'foodhunt_default_page_layout_section',
		array(
			'priority' => 20,
			'title'    => esc_html__( 'Default layout for pages only', 'foodhunt' ),
			'panel'    => 'foodhunt_design_options',
		)
	);

	$wp_customize->add_setting(
		'foodhunt_default_page_layout',
		array(
			'default'           => 'right-sidebar',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_radio_sanitize',
		)
	);
	$wp_customize->add_control( new FOODHUNT_Image_Radio_Control(
		$wp_customize,
		'foodhunt_default_page_layout',
		array(
			'type'     => 'radio',
			'label'    => esc_html__( 'Select default layout for pages. This layout will be reflected in all pages unless unique layout is 	set for specific page', 'foodhunt' ),
			'section'  => 'foodhunt_default_page_layout_section',
			'settings' => 'foodhunt_default_page_layout',
			'choices'  => array(
				'right-sidebar'               => esc_url( get_template_directory_uri() ) . '/inc/admin/images/right-sidebar.png',
				'left-sidebar'                => esc_url( get_template_directory_uri() ) . '/inc/admin/images/left-sidebar.png',
				'no-sidebar-full-width'       => esc_url( get_template_directory_uri() ) . '/inc/admin/images/no-sidebar-full-width-layout.png',
				'no-sidebar-content-centered' => esc_url( get_template_directory_uri() ) . '/inc/admin/images/no-sidebar-content-centered-layout.png',
			),
		)
	) );

	// default layout for single posts
	$wp_customize->add_section(
		'foodhunt_default_single_posts_layout_section',
		array(
			'priority' => 30,
			'title'    => esc_html__( 'Default layout for single posts only', 'foodhunt' ),
			'panel'    => 'foodhunt_design_options',
		)
	);

	$wp_customize->add_setting(
		'foodhunt_default_single_posts_layout',
		array(
			'default'           => 'right-sidebar',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_radio_sanitize',
		)
	);
	$wp_customize->add_control( new FOODHUNT_Image_Radio_Control(
		$wp_customize,
		'foodhunt_default_single_posts_layout',
		array(
			'type'     => 'radio',
			'label'    => esc_html__( 'Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post', 'foodhunt' ),
			'section'  => 'foodhunt_default_single_posts_layout_section',
			'settings' => 'foodhunt_default_single_posts_layout',
			'choices'  => array(
				'right-sidebar'               => esc_url( get_template_directory_uri() ) . '/inc/admin/images/right-sidebar.png',
				'left-sidebar'                => esc_url( get_template_directory_uri() ) . '/inc/admin/images/left-sidebar.png',
				'no-sidebar-full-width'       => esc_url( get_template_directory_uri() ) . '/inc/admin/images/no-sidebar-full-width-layout.png',
				'no-sidebar-content-centered' => esc_url( get_template_directory_uri() ) . '/inc/admin/images/no-sidebar-content-centered-layout.png',
			),
		)
	) );

	// primary color options
	$wp_customize->add_section( 'foodhunt_primary_color_setting', array(
		'priority' => 40,
		'title'    => esc_html__( 'Primary color option', 'foodhunt' ),
		'panel'    => 'foodhunt_design_options',
	) );

	$wp_customize->add_setting( 'foodhunt_primary_color', array(
		'default'              => '#dd0103',
		'capability'           => 'edit_theme_options',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'foodhunt_color_option_hex_sanitize',
		'sanitize_js_callback' => 'foodhunt_color_escaping_option_sanitize',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'foodhunt_primary_color', array(
		'label'    => esc_html__( 'This will reflect in links, buttons and many others. Choose a color to match your site', 'foodhunt' ),
		'section'  => 'foodhunt_primary_color_setting',
		'settings' => 'foodhunt_primary_color',
	) ) );


	if ( ! function_exists( 'wp_update_custom_css_post' ) ) {
		$wp_customize->add_section( 'foodhunt_custom_css_setting', array(
			'priority' => 50,
			'title'    => esc_html__( 'Custom CSS', 'foodhunt' ),
			'panel'    => 'foodhunt_design_options',
		) );

		$wp_customize->add_setting( 'foodhunt_custom_css', array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'wp_filter_nohtml_kses',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses',
		) );
		$wp_customize->add_control(
			new FOODHUNT_Custom_CSS_Control( $wp_customize, 'foodhunt_custom_css', array(
				'label'    => esc_html__( 'Write your custom css', 'foodhunt' ),
				'section'  => 'foodhunt_custom_css_setting',
				'settings' => 'foodhunt_custom_css',
			) )
		);
	}
	// End of Design Options

	/**************************************************************************************/

	// Additional Options
	$wp_customize->add_panel(
		'foodhunt_additional_options',
		array(
			'capabitity'  => 'edit_theme_options',
			'description' => esc_html__( 'Contain all Additional settings', 'foodhunt' ),
			'priority'    => 220,
			'title'       => esc_html__( 'Additional Options', 'foodhunt' ),
		)
	);

	// Author Bio Display options
	$wp_customize->add_section(
		'foodhunt_author_bio_display_section',
		array(
			'priority' => 10,
			'title'    => esc_html__( 'Author Bio Options', 'foodhunt' ),
			'panel'    => 'foodhunt_additional_options',
		)
	);

	$wp_customize->add_setting(
		'foodhunt_author_bio_display',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_author_bio_display',
		array(
			'label'   => esc_html__( 'Check to display the Author Bio in single post page.', 'foodhunt' ),
			'section' => 'foodhunt_author_bio_display_section',
			'type'    => 'checkbox',
			'setting' => 'foodhunt_author_bio_display',
		)
	);

	// Content Display options
	$wp_customize->add_section(
		'foodhunt_content_display',
		array(
			'priority'    => 10,
			'title'       => 'Posts page content display',
			'description' => esc_html__( 'Display full content or short description/excerpt on the Posts Page', 'foodhunt' ),
			'panel'       => 'foodhunt_additional_options',
		)
	);

	$wp_customize->add_setting(
		'foodhunt_content',
		array(
			'default'           => 'excerpt',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_radio_sanitize',
		)
	);

	$wp_customize->add_control(
		'foodhunt_content',
		array(
			'label'   => esc_html__( 'Choose to show Excerpt or Full Post', 'foodhunt' ),
			'section' => 'foodhunt_content_display',
			'type'    => 'radio',
			'choices' => array(
				'excerpt' => esc_html__( 'Display Excerpt', 'foodhunt' ),
				'full'    => esc_html__( 'Display Full Content', 'foodhunt' ),
			),
		)
	);

	// Related posts display
	$wp_customize->add_section(
		'foodhunt_related_posts_display_section',
		array(
			'priority' => 10,
			'title'    => esc_html__( 'Related Posts', 'foodhunt' ),
			'panel'    => 'foodhunt_additional_options',
		)
	);

	$wp_customize->add_setting(
		'foodhunt_related_posts_display_setting',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_related_posts_display_setting',
		array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Check to activate related posts .', 'foodhunt' ),
			'section' => 'foodhunt_related_posts_display_section',
			'setting' => 'foodhunt_related_posts_display_setting',
		)
	);

	$wp_customize->add_setting( 'foodhunt_related_posts_display', array(
		'default'           => 'categories',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'foodhunt_radio_sanitize',
	) );

	$wp_customize->add_control( 'foodhunt_related_posts_display', array(
		'type'     => 'radio',
		'label'    => esc_html__( 'Related Posts Must Be Shown As:', 'foodhunt' ),
		'section'  => 'foodhunt_related_posts_display_section',
		'settings' => 'foodhunt_related_posts_display',
		'choices'  => array(
			'categories' => esc_html__( 'Related Posts By Categories', 'foodhunt' ),
			'tags'       => esc_html__( 'Related Posts By Tags', 'foodhunt' ),
		),
	) );

	// Hide Meta from the archives and single post
	$wp_customize->add_section(
		'foodhunt_meta',
		array(
			'priority'    => 20,
			'title'       => 'Posts Meta/Information',
			'description' => esc_html__( 'Hide specific or all the meta/information from the Blog posts and Single post', 'foodhunt' ),
			'panel'       => 'foodhunt_additional_options',
		)
	);

	// Hide all the Meta
	$wp_customize->add_setting(
		'foodhunt_hide_meta',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_hide_meta',
		array(
			'label'   => esc_html__( 'Check to All the Meta.', 'foodhunt' ),
			'section' => 'foodhunt_meta',
			'type'    => 'checkbox',
		)
	);

	// Hide Date
	$wp_customize->add_setting(
		'foodhunt_hide_date',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_hide_date',
		array(
			'label'   => esc_html__( 'Check to hide Date.', 'foodhunt' ),
			'section' => 'foodhunt_meta',
			'type'    => 'checkbox',
		)
	);

	// Hide Author
	$wp_customize->add_setting(
		'foodhunt_hide_author',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_hide_author',
		array(
			'label'   => esc_html__( 'Check to hide Author.', 'foodhunt' ),
			'section' => 'foodhunt_meta',
			'type'    => 'checkbox',
		)
	);

	// Hide Comments
	$wp_customize->add_setting(
		'foodhunt_hide_comment',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_hide_comment',
		array(
			'label'   => esc_html__( 'Check to hide Comment.', 'foodhunt' ),
			'section' => 'foodhunt_meta',
			'type'    => 'checkbox',
		)
	);

	// Hide Category
	$wp_customize->add_setting(
		'foodhunt_hide_cat',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_hide_cat',
		array(
			'label'   => esc_html__( 'Check to hide Category.', 'foodhunt' ),
			'section' => 'foodhunt_meta',
			'type'    => 'checkbox',
		)
	);

	// Hide Tags
	$wp_customize->add_setting(
		'foodhunt_hide_tags',
		array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'foodhunt_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'foodhunt_hide_tags',
		array(
			'label'   => esc_html__( 'Check to hide Tags.', 'foodhunt' ),
			'section' => 'foodhunt_meta',
			'type'    => 'checkbox',
		)
	);
	// End of Additional Options

	/**************************************************************************************/
}

add_action( 'customize_register', 'foodhunt_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function foodhunt_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function foodhunt_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**************************************************************************************/

// Checkbox sanitization
function foodhunt_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return 0;
	}
}

// Sanitize Integer
function foodhunt_sanitize_integer( $input ) {
	if ( is_numeric( $input ) ) {
		return intval( $input );
	}
}

// Text sanitization
function foodhunt_text_sanitize( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

// Sanitize Radio Button
function foodhunt_radio_sanitize( $input, $setting ) {

	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

// color sanitization
function foodhunt_color_option_hex_sanitize( $color ) {
	if ( $unhashed = sanitize_hex_color_no_hash( $color ) ) {
		return '#' . $unhashed;
	}

	return $color;
}

function foodhunt_color_escaping_option_sanitize( $input ) {
	$input = esc_attr( $input );

	return $input;
}

/**************************************************************************************/

/**
 * Enqueue scripts for customizer
 */
function foodhunt_customizer_js() {
	wp_enqueue_script( 'foodhunt_customizer_script', esc_url( get_template_directory_uri() ) . '/js/customizer.js', array( "jquery" ), 'false', true );
}

add_action( 'customize_controls_enqueue_scripts', 'foodhunt_customizer_js' );
add_action( 'customize_preview_init', 'foodhunt_customizer_js' );
/*
 * Custom Scripts
 */
add_action( 'customize_controls_print_footer_scripts', 'foodhunt_customizer_custom_scripts' );

function foodhunt_customizer_custom_scripts() { ?>
	<style>
		/* Theme Instructions Panel CSS */
		li#accordion-section-foodhunt_upsell_section h3.accordion-section-title {
			background-color: #dd0103 !important;
			border-left-color: #a92717 !important;
		}

		#accordion-section-foodhunt_upsell_section h3 a:after {
			content: '\f345';
			color: #fff;
			position: absolute;
			top: 12px;
			right: 10px;
			z-index: 1;
			font: 400 20px/1 dashicons;
			speak: none;
			display: block;
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
			text-decoration: none !important;
		}

		li#accordion-section-foodhunt_upsell_section h3.accordion-section-title a {
			display: block;
			color: #fff !important;
			text-decoration: none;
		}

		li#accordion-section-foodhunt_upsell_section h3.accordion-section-title a:focus {
			box-shadow: none;
		}

		li#accordion-section-foodhunt_upsell_section h3.accordion-section-title:hover {
			background-color: #cc0002 !important;
		}

		/* Upsell button CSS */
		.themegrill-pro-info,
		.customize-control-foodhunt-important-links a {
			/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#8fc800+0,8fc800+100;Green+Flat+%232 */
			background: #008EC2;
			color: #fff;
			display: block;
			margin: 15px 0 0;
			padding: 5px 0;
			text-align: center;
			font-weight: 600;
		}

		.customize-control-foodhunt-important-links a {
			padding: 8px 0;
		}

		.themegrill-pro-info:hover,
		.customize-control-foodhunt-important-links a:hover {
			color: #ffffff;
			/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#006e2e+0,006e2e+100;Green+Flat+%233 */
			background: #2380BA;
		}
	</style>
	<script>
		( function ( $, api ) {
			api.sectionConstructor['foodhunt-upsell-section'] = api.Section.extend( {

				// No events for this type of section.
				attachEvents : function () {
				},

				// Always make the section active.
				isContextuallyActive : function () {
					return true;
				}
			} );
		} )( jQuery, wp.customize );

	</script>
	<?php
}
