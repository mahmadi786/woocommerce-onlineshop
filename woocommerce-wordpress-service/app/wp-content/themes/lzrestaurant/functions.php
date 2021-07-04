<?php
/**
 * lzrestaurant functions and definitions
 *
 * 
 * @subpackage lzrestaurant
 * @since 1.0
 */

if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

function lzrestaurant_setup() {
	
	load_theme_textdomain( 'lzrestaurant', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-background', $defaults = array(
    'default-color'          => '',
    'default-image'          => '',
    'default-repeat'         => '',
    'default-position-x'     => '',
    'default-attachment'     => '',
    'wp-head-callback'       => '_custom_background_cb',
    'admin-head-callback'    => '',
    'admin-preview-callback' => ''
	));

	add_image_size( 'lzrestaurant-featured-image', 2000, 1200, true );

	add_image_size( 'lzrestaurant-thumbnail-avatar', 100, 100, true );

	$GLOBALS['content_width'] = 525;
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'lzrestaurant' ),
	) );

	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	* Enable support for Post Formats.
	*
	* See: https://codex.wordpress.org/Post_Formats
	*/
	add_theme_support( 'post-formats', array('image','video','gallery','audio',) );
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', lzrestaurant_fonts_url() ) );

	// Theme Activation Notice
	global $pagenow;

		if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
		add_action( 'admin_notices', 'lzrestaurant_activation_notice' );
	}

}
add_action( 'after_setup_theme', 'lzrestaurant_setup' );

// Notice after Theme Activation
function lzrestaurant_activation_notice() {
	echo '<div class="notice notice-success is-dismissible start-notice">';
		echo '<h3>'. esc_html__( 'Welcome to Luzuk!!', 'lzrestaurant' ) .'</h3>';
		echo '<p>'. esc_html__( 'Thank you for choosing LZ Restaurant theme. It will be our pleasure to have you on our Welcome page to serve you better.', 'lzrestaurant' ) .'</p>';
		echo '<p><a href="'. esc_url( admin_url( 'themes.php?page=lzrestaurant_guide' ) ) .'" class="button button-primary">'. esc_html__( 'GET STARTED', 'lzrestaurant' ) .'</a></p>';
	echo '</div>';
}

function lzrestaurant_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'lzrestaurant' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'lzrestaurant' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 2', 'lzrestaurant' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'lzrestaurant' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 3', 'lzrestaurant' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'lzrestaurant' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'lzrestaurant' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer.', 'lzrestaurant' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'lzrestaurant' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'lzrestaurant' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'lzrestaurant' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'lzrestaurant' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'lzrestaurant' ),
		'id'            => 'footer-4',
		'description'   => __( 'Add widgets here to appear in your footer.', 'lzrestaurant' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'lzrestaurant_widgets_init' );

function lzrestaurant_fonts_url() {
	$fonts_url = '';

	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'lzrestaurant' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
		$font_families[] = 'Sacramento';
		

		$query_args = array(
			'family' => rawurlencode( implode( '|', $font_families ) ),
			'subset' => rawurlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

function lzrestaurant_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'lzrestaurant' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'lzrestaurant_excerpt_more' );

//Enqueue scripts and styles.
function lzrestaurant_scripts() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'lzrestaurant-fonts', lzrestaurant_fonts_url(), array(), null );

	
	//Bootstarp 
	wp_enqueue_style( 'bootstrap', esc_url(get_template_directory_uri()).'/assets/css/bootstrap.css' );

	// Theme stylesheet.
	wp_enqueue_style( 'lzrestaurant-basic-style', get_stylesheet_uri() );

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'lzrestaurant-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'lzrestaurant-style' ), '1.0' );
		wp_style_add_data( 'lzrestaurant-ie9', 'conditional', 'IE 9' );
	}
	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'lzrestaurant-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'lzrestaurant-style' ), '1.0' );
	wp_style_add_data( 'lzrestaurant-ie8', 'conditional', 'lt IE 9' );
	//font-awesome
	wp_enqueue_style( 'font-awesome', esc_url(get_template_directory_uri()).'/assets/css/fontawesome-all.css' );
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'lzrestaurant-navigation', esc_url(get_template_directory_uri()) . '/assets/js/lzrestaurant-navigation.js', array('jquery') );
	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'bootstrap', esc_url(get_template_directory_uri()) . '/assets/js/bootstrap.js', array('jquery') );
	wp_enqueue_script( 'jquery-superfish', esc_url(get_template_directory_uri()) . '/assets/js/jquery.superfish.js', array('jquery') ,'',true);
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lzrestaurant_scripts' );

function lzrestaurant_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'lzrestaurant_front_page_template' );

function lzrestaurant_sanitize_choices( $input, $setting ) {
    global $wp_customize; 
    $control = $wp_customize->get_control( $setting->id ); 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

//footer Link
define('LZRESTAURANT_LIVE_DEMO',__('https://luzukdemo.com/demo/lz-restaurant/','lzrestaurant'));
define('LZRESTAURANT_PRO_DOCS',__('https://luzukdemo.com/demo/lz-restaurant/documentation/','lzrestaurant'));
define('LZRESTAURANT_BUY_NOW',__('https://www.luzuk.com/product/premium-restaurant-wordpress-theme/','lzrestaurant'));
define('LZRESTAURANT_SUPPORT',__('https://wordpress.org/support/theme/lzrestaurant/','lzrestaurant'));
define('LZRESTAURANT_CREDIT',__('https://www.luzuk.com/themes/free-restaurant-wordpress-theme/','lzrestaurant'));

if ( ! function_exists( 'lzrestaurant_credit' ) ) {
	function lzrestaurant_credit(){
		echo "<a href=".esc_url(LZRESTAURANT_CREDIT)." target='_blank'>". esc_html__('Restaurant WordPress Theme','lzrestaurant') ."</a>";
	}
}

function lzrestaurant_sanitize_dropdown_pages( $page_id, $setting ) {
  // Ensure $input is an absolute integer.
  $page_id = absint( $page_id );
  // If $page_id is an ID of a published page, return it; otherwise, return the default.
  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/* Excerpt Limit Begin */
function lzrestaurant_string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}

function lzrestaurant_sanitize_checkbox( $input ) {
	// Boolean check 
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'lzrestaurant_loop_columns');
if (!function_exists('lzrestaurant_loop_columns')) {
	function lzrestaurant_loop_columns() {
		return 3; // 3 products per row
	}
}

require get_parent_theme_file_path( '/inc/custom-header.php' );

require get_parent_theme_file_path( '/inc/template-tags.php' );

require get_parent_theme_file_path( '/inc/template-functions.php' );

require get_parent_theme_file_path( '/inc/customizer.php' );

require get_parent_theme_file_path( '/inc/getting-started/getting-started.php' );