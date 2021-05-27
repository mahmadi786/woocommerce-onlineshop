<?php
/**
 * Theme functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package Restaurantz
 */

if ( ! function_exists( 'restaurantz_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function restaurantz_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Restaurantz, use a find and replace
		 * to change 'restaurantz' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'restaurantz', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'restaurantz-featured-banner', 1400, 320, true );
		add_image_size( 'restaurantz-food-thumb', 350, 250, true );

		// This theme uses wp_nav_menu() in four location.
		register_nav_menus( array(
			'primary'  => esc_html__( 'Primary Menu', 'restaurantz' ),
			'footer'   => esc_html__( 'Footer Menu', 'restaurantz' ),
			'social'   => esc_html__( 'Social Menu', 'restaurantz' ),
			'notfound' => esc_html__( '404 Menu', 'restaurantz' ),
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

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'restaurantz_custom_background_args', array(
			'default-color' => '#ffffff',
			'default-image' => '',
		) ) );

		// Set up the WordPress core custom header feature.
		add_theme_support( 'custom-header', apply_filters( 'restaurantz_custom_header_args', array(
				'default-image' => get_template_directory_uri() . '/images/header-banner.jpg',
				'width'         => 1400,
				'height'        => 320,
				'flex-height'   => true,
				'header-text'   => false,
		) ) );

		// Register default headers.
		register_default_headers( array(
			'dinner-table' => array(
				'url'           => '%s/images/header-banner.jpg',
				'thumbnail_url' => '%s/images/header-banner.jpg',
				'description'   => _x( 'Dinner Table', 'header image description', 'restaurantz' ),
			),

		) );


		// Editor style.
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		add_editor_style( 'css/editor-style' . $min . '.css' );

		// Enable support for footer widgets.
		add_theme_support( 'footer-widgets', 4 );

		// Load Supports.
		require_once get_template_directory() . '/inc/support.php';

		global $restaurantz_default_options;
		$restaurantz_default_options = restaurantz_get_default_theme_options();

	}
endif;

add_action( 'after_setup_theme', 'restaurantz_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function restaurantz_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'restaurantz_content_width', 862 );
}
add_action( 'after_setup_theme', 'restaurantz_content_width', 0 );

if ( ! function_exists( 'restaurantz_template_redirect' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet for different value other than the default one
	 *
	 * @global int $content_width
	 */
	function restaurantz_template_redirect() {
		$global_layout = restaurantz_get_option( 'global_layout' );

		if ( 'no-sidebar' === $global_layout ) {
			$GLOBALS['content_width'] = 1170;
		}

		// Three Columns
		elseif ( 'three-columns' == $global_layout ) {
			$GLOBALS['content_width'] = 555;
		}
	}
endif;
add_action( 'template_redirect', 'restaurantz_template_redirect' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function restaurantz_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'restaurantz' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your Primary Sidebar.', 'restaurantz' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Secondary Sidebar', 'restaurantz' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your Secondary Sidebar.', 'restaurantz' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'restaurantz_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function restaurantz_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/third-party/font-awesome/css/font-awesome' . $min . '.css', '', '4.7.0' );

	$fonts_url = restaurantz_fonts_url();
	if ( ! empty( $fonts_url ) ) {
		wp_enqueue_style( 'restaurantz-google-fonts', $fonts_url, array(), null );
	}

	wp_enqueue_style( 'sidr', get_template_directory_uri() .'/third-party/sidr/css/jquery.sidr.dark' . $min . '.css', '', '2.2.1' );

	wp_enqueue_style( 'restaurantz-style', get_stylesheet_uri(), null, date( 'Ymd-Gis', filemtime( get_template_directory() . '/style.css' ) ) );

	wp_enqueue_script( 'restaurantz-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix' . $min . '.js', array(), '1.2.0', true );

	wp_enqueue_script( 'sidr', get_template_directory_uri() . '/third-party/sidr/js/jquery.sidr' . $min . '.js', array( 'jquery' ), '2.2.1', true );

	wp_enqueue_script( 'restaurantz-custom', get_template_directory_uri() . '/js/custom' . $min . '.js', array( 'jquery' ), '1.2.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'restaurantz_scripts' );

/**
 * Enqueue admin scripts and styles.
 */
function restaurantz_admin_scripts( $hook ) {

	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_style( 'restaurantz-metabox', get_template_directory_uri() . '/css/metabox' . $min . '.css', '', '1.2.0' );
		wp_enqueue_script( 'restaurantz-custom-admin', get_template_directory_uri() . '/js/admin' . $min . '.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-tabs' ), '1.2.0', true );
	}

}
add_action( 'admin_enqueue_scripts', 'restaurantz_admin_scripts' );

/**
 * Load init.
 */
require_once get_template_directory() . '/inc/init.php';
