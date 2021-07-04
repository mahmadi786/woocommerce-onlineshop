<?php
/**
 * finedine functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package finedine
 */

if ( ! function_exists( 'finedine_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function finedine_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on finedine, use a find and replace
		 * to change 'finedine' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'finedine', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'finedine' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		$defaults = array(
			'default-color'          => 'fff',
			'default-image'          => '',
			'default-repeat'         => 'repeat',
			'default-position-x'     => 'left',
			'default-position-y'     => 'top',
			'default-size'           => 'auto',
			'default-attachment'     => 'scroll',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		);
		add_theme_support( 'custom-background', $defaults );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @global int $content_width
		 */
		$GLOBALS['content_width'] = apply_filters( 'finedine_content_width', 640 );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		 * Recommend plugins
		 */
		add_theme_support( 'recommend-plugins', array(
			'contact-form-7' => array(
				'name'            => esc_html__( 'Contact Form 7', 'finedine' ),
				'active_filename' => 'contact-form-7/wp-contact-form-7.php',
			),
		) );


	}
endif;

add_action( 'after_setup_theme', 'finedine_setup' );

/**
 * Enqueue scripts and styles.
 */
function finedine_load_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'finedine-fonts', finedine_fonts_url(), array(), null );

	wp_enqueue_style( 'finedine-font-awesome', esc_url( get_template_directory_uri() ) . '/customizer/css/fontawesome.css', false, 'all' );

	wp_enqueue_style( 'finedine-style', get_stylesheet_uri() );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/assets/js/html5.js', array(), '3.7.3', true );

	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.js', array( 'jquery' ), '2.2.1', true );

	wp_enqueue_script( 'smooth-scroll', get_template_directory_uri() . '/assets/js/jquery.smooth-scroll.js', array( 'jquery' ), '2.2.0', true );

	wp_enqueue_script( 'wow', get_template_directory_uri() . '/assets/js/wow.js', array( 'jquery' ), '1.1.3', true );

	wp_enqueue_script('scrollbar', get_template_directory_uri().'/assets/js/jquery.scrollbar.js', array('jquery'), '1.1.3', true);

	wp_enqueue_script( 'finedine-scripts', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'finedine_load_scripts' );

/**
 * Enqueue admin scripts and styles.
 */
function finedine_load_admin_script_style( $hook ) {
	if ( 'appearance_page_sm_finedine' === $hook ) {
		wp_enqueue_style( 'finedine-custom-admin', get_template_directory_uri() . '/assets/admin/css/custom-admin.css', array(), null );
		wp_enqueue_script( 'finedine-custom-admin', get_template_directory_uri() . '/assets/admin/js/custom-admin.js', array( 'jquery' ), '2.2.1', true );
	}

	if ( 'widgets.php' === $hook ) {
		wp_enqueue_media();
		wp_enqueue_script( 'finedine-customizer-image-upload-script', get_template_directory_uri() . '/assets/admin/js/image_upload_widget.js', false, '1.0', true );
		wp_register_script( 'finedine-widget-script', get_template_directory_uri() . '/customizer/js/finedine-widget-script.js', array('jquery', 'customize-controls'), false, true );
		wp_enqueue_style( 'finedine-widget-style', get_template_directory_uri() . '/assets/admin/css/widgets.css' );
	}
}

add_action( 'admin_enqueue_scripts', 'finedine_load_admin_script_style' );

/**
 * Register localize script
 *
 */
function finedine_load_script() {
	wp_register_script( 'finedine-slider-option', get_template_directory_uri() . '/assets/js/slider_option.js', array( 'jquery' ), '1.0.2', true );

	global $finedine_settings, $finedine_array_of_default_settings;
	$finedine_settings = wp_parse_args( get_option( 'finedine_theme_settings', array() ), finedine_get_option_defaults() );

	$animation = ( isset( $finedine_settings['transition_effects'] ) ) ? $finedine_settings['transition_effects'] : '';

	$animation_effect = '';

	if ( '1' === $animation ) {
		$animation_effect = 'fadeOut'; // Change animation effects here.
	}
	$translation_array = array(
		'hero_slider_animation' => $animation_effect,
	);

	wp_localize_script( 'finedine-slider-option', 'finedine_hero_slider', $translation_array );

	wp_enqueue_script( 'finedine-slider-option' );
}

add_action( 'wp_enqueue_scripts', 'finedine_load_script' );

/**
 * Customizer_style in footer
 *
 */
function finedine_customizer_style() {
	wp_enqueue_style( 'finedine-customizer-style', get_template_directory_uri() . '/assets/admin/css/customizer-style.css' );
}

add_action( 'wp_footer', 'finedine_customizer_style' );

/**
 * Register custom fonts.
 */
function finedine_fonts_url() {
	$fonts_url = '';

	$font_families = array();

	$font_families[] = 'Great Vibes|Dancing Script';

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
	);

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );


	return esc_url( $fonts_url );
}


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

// TGM Plugin activation.
require_once trailingslashit( get_template_directory() ) . '/tgm/class-tgm-plugin-activation.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Theme dashboard additions.
 */
require get_template_directory() . '/inc/theme-dashboard.php';
/**
 * Register custom sidebar
 */
require get_template_directory() . '/inc/finedine-sidebar.php';
/**
 * Custom theme functions
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Include custom Widgets
 */
require get_template_directory() . '/widgets/class-finedine-block-widget.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	/**
	 * WooCommerce specific scripts & stylesheets.
	 *
	 * @return void
	 */
	function finedine_woocommerce_scripts() {
		$font_path   = WC()->plugin_url() . '/assets/fonts/';
		$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

		wp_add_inline_style( 'finedine-fonts', $inline_font );
	}

	add_action( 'wp_enqueue_scripts', 'finedine_woocommerce_scripts' );

	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Demo class
 */
require_once trailingslashit( get_template_directory() ) . '/demo/class-finedine-demo-import.php';

/**
 * Demo configuration.
 */
require_once trailingslashit( get_template_directory() ) . '/demo/demo.php';
