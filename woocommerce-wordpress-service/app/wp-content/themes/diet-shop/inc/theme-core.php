<?php
/**
 * Diet Shop functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Diet_Shop
 */
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'diet_shop_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function diet_shop_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Diet Shop, use a find and replace
		 * to change 'diet-shop' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'diet-shop', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'diet-shop' ),
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

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'diet_shop_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

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
		/*
		* Enable support for Post Formats.
		* See https://developer.wordpress.org/themes/functionality/post-formats/
		*/
		add_theme_support( 'post-formats', array(
			'image',
			'video',
			'gallery',
			'audio',
			'quote'
		) );
	}
endif;
add_action( 'after_setup_theme', 'diet_shop_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function diet_shop_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'diet_shop_content_width', 640 );
}
add_action( 'after_setup_theme', 'diet_shop_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function diet_shop_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'diet-shop' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'diet-shop' ),
		'before_widget' => '<section id="%1$s" class="sidebar-box widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'diet-shop' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Add footer widgets here.', 'diet-shop' ),
		'before_widget' => '<div id="%1$s"class="col-lg-3 col-sm-6 theme-footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="footer-title">',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Home Page Slider', 'diet-shop' ),
		'id'            => 'home_page_slider',
		'description'   => esc_html__( 'Add footer widgets here.', 'diet-shop' ),
		'before_widget' => '<div id="%1$s"class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="screen-reader-text">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'diet_shop_widgets_init' );

/**
 * Registers an editor stylesheet for the theme.
 */
function diet_shop_editor_styles() {
    add_editor_style( '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Oswald:300,400,500,600,700' );
}
add_action( 'admin_init', 'diet_shop_editor_styles' );

/**
 * Enqueue scripts and styles.
 */
function diet_shop_scripts() {
	
	$dietshop = wp_get_theme();
	
	wp_enqueue_style( 'diet-shop-google-font', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Oswald:300,400,500,600,700');
	/*----bootstrap css ----- */
	wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/resource/bootstrap/css/bootstrap.css' ), array(), '4.0.0' );
	/*----bootstrap css ----- */
	wp_enqueue_style( 'font-awesome', get_theme_file_uri( '/resource/font-awesome/css/all.css' ), array(), '5.10.2' );
	
	wp_enqueue_style( 'owl-carousel', get_theme_file_uri( '/resource/owl-carousel/assets/owl-carousel.css' ), array(), '2.3.4' );
	wp_enqueue_style( 'owl-theme-default', get_theme_file_uri( '/resource/owl-carousel/assets/owl-theme-default.css' ), array(), '2.3.4' );
	
	wp_enqueue_style( 'diet-shop-layout', get_theme_file_uri( '/layouts/diet-shop-layout.css' ), array(), $dietshop->get('Version') );
	wp_enqueue_style( 'diet-shop-responsive', get_theme_file_uri( '/layouts/responsive.css' ), array(),  $dietshop->get('Version'));
	
	wp_enqueue_style( 'diet-shop-style', get_stylesheet_uri() );
	
	$custom_css = ':root {--text-color:'.esc_attr( get_theme_mod('primary_color','#777777') ).'; --p-color: '.esc_attr( get_theme_mod('__secondary_color','#db2a24') ).'; }';
		
	wp_add_inline_style( 'diet-shop-style', $custom_css );

	wp_enqueue_script( 'bootstrap', get_theme_file_uri( '/resource/bootstrap/js/bootstrap.js' ) , array(), '4.0.0', true );
	wp_enqueue_script( 'sticky', get_theme_file_uri( '/resource/sticky/jquery-sticky.js' ) , array(),'1.0.4', true );
	
	wp_enqueue_script( 'owl-carousel', get_theme_file_uri( '/resource/owl-carousel/owl-carousel.js' ) , array(),'2.3.4', true );
	
	wp_enqueue_script( 'diet-shop-js',get_theme_file_uri( '/js/diet-shop.js' ) , array('jquery'), $dietshop->get('Version'), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'diet_shop_scripts' );



