<?php
/**
 * FoodHunt functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */

if ( ! function_exists( 'foodhunt_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function foodhunt_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on foodhunt, use a find and replace
		 * to change 'foodhunt' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'foodhunt', get_template_directory() . '/languages' );

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

		// Adds the support for the Custom Logo introduced in WordPress 4.5
		add_theme_support(
			'custom-logo',
			array(
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary_one' => esc_html__( 'Primary Left Menu', 'foodhunt' ),
				'primary_two' => esc_html__( 'Primary Right Menu', 'foodhunt' ),
				'social'      => esc_html__( 'Social Menu', 'foodhunt' ),
				'footer'      => esc_html__( 'Footer Menu', 'foodhunt' ),
			)
		);

		// Register image sizes for use in widgets
		add_image_size( 'foodhunt-blog', 870, 480, true );
		add_image_size( 'foodhunt-featured-image', 340, 340, true );

		// Adding excerpt option box for pages as well
		add_post_type_support( 'page', 'excerpt' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'foodhunt_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Added WooCommerce support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
endif; // foodhunt_setup
add_action( 'after_setup_theme', 'foodhunt_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 870; /* pixels */
}

if ( ! function_exists( 'foodhunt_content_width' ) ) :
	/**
	 * Change the content width based on the Theme Settings and Page/Post Settings
	 */
	function foodhunt_content_width() {
		global $content_width;

		$classes = foodhunt_layout_class();

		if ( $classes == 'no-sidebar-full-width' ) {
			$content_width = 1200;
		}
	}
endif;
add_action( 'template_redirect', 'foodhunt_content_width' );

/**
 * Enqueue scripts and styles.
 */
function foodhunt_scripts() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'foodhunt-style', get_stylesheet_uri() );

	wp_enqueue_style( 'foodhunt-google-font', '//fonts.googleapis.com/css?family=Lato:400,300,700|Great+Vibes' );

	wp_enqueue_style( 'font-awesome', esc_url( get_template_directory_uri() ) . '/font-awesome/css/font-awesome' . $suffix . '.css', array(), '4.7.0' );

	if ( is_front_page() ) {

		wp_enqueue_script( 'jquery-bxslider', esc_url( get_template_directory_uri() ) . '/js/jquery.bxslider' . $suffix . '.js', array( 'jquery' ), '4.2.12', true );

		wp_enqueue_script( 'jquery-parallax', esc_url( get_template_directory_uri() ) . '/js/jquery.parallax-1.1.3' . $suffix . '.js', array( 'jquery' ), '1.1.3', true );
	}

	wp_enqueue_script( 'jquery-ticker', esc_url( get_template_directory_uri() ) . '/js/jquery.ticker' . $suffix . '.js', array( 'jquery' ), '1.2.1', true );

	// Skip link focus fix JS enqueue.
	wp_enqueue_script( 'foodhunt-skip-link-focus-fix', esc_url( get_template_directory_uri() ) . '/js/skip-link-focus-fix.js', array(), false, true );

	wp_enqueue_script( 'foodhunt-custom', esc_url( get_template_directory_uri() ) . '/js/foodhunt-custom' . $suffix . '.js', array( 'jquery' ), false, true );

	wp_enqueue_script( 'html5', esc_url( get_template_directory_uri() ) . 'js/html5shiv' . $suffix . '.js', array(), '3.7.3', false );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
} // foodhunt_scripts
add_action( 'wp_enqueue_scripts', 'foodhunt_scripts' );

/**
 * Enqeue scripts in admin section for widgets.
 */
function foodhunt_admin_scripts( $hook ) {
	global $post_type;

	if ( $hook == 'widgets.php' || $hook == 'customize.php' ) {
		// Image Uploader
		wp_enqueue_media();
		wp_enqueue_script( 'foodhunt-script', esc_url( get_template_directory_uri() ) . '/js/image-uploader.js', false, '1.0', true );

		// Color Picker
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'foodhunt-color-picker', esc_url( get_template_directory_uri() ) . '/js/color-picker.js', array( 'wp-color-picker' ), false );
	}

	if ( $post_type == 'page' ) {
		wp_enqueue_script( 'foodhunt-meta-toggle', esc_url( get_template_directory_uri() ) . '/js/metabox-toggle.js', false, '1.0', true );
	}
}
add_action( 'admin_enqueue_scripts', 'foodhunt_admin_scripts' );

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Widgets.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Header Image Functions.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Template Tag file.
 */
require get_template_directory() . '/inc/foodhunt.php';


global $foodhunt_duplicate_posts;
$foodhunt_duplicate_posts = array();

/**
 * Assign the FoodHunt version to a variable.
 */
$foodhunt_theme = wp_get_theme( 'foodhunt' );

define( 'FOODHUNT_THEME_VERSION', $foodhunt_theme->get( 'Version' ) );

/* Calling in the admin area for the Welcome Page */
if ( is_admin() ) {
	require get_template_directory() . '/inc/admin/class-foodhunt-admin.php';
	require get_template_directory() . '/inc/admin/class-foodhunt-dashboard.php';
	require get_template_directory() . '/inc/admin/class-foodhunt-notice.php';
	require get_template_directory() . '/inc/admin/class-foodhunt-welcome-notice.php';
	require get_template_directory() . '/inc/admin/class-foodhunt-upgrade-notice.php';
	require get_template_directory() . '/inc/admin/class-foodhunt-theme-review-notice.php';
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require_once get_template_directory() . '/inc/jetpack.php';
}
