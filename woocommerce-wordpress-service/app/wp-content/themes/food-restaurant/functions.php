<?php
/**
 * Food Restaurant functions and definitions
 *
 * @package Food Restaurant
 */

if ( ! function_exists( 'food_restaurant_setup' ) ) :

/* Theme Setup */

function food_restaurant_setup() {

	$GLOBALS['content_width'] = apply_filters( 'food_restaurant_content_width', 640 );

	load_theme_textdomain( 'food-restaurant', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );
	add_image_size('food-restaurant-homepage-thumb',240,145,true);
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'food-restaurant' ),
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'f1f1f1'
	) );

	/*
	* Enable support for Post Formats.
	*
	* See: https://codex.wordpress.org/Post_Formats
	*/
	add_theme_support( 'post-formats', array('image','video','gallery','audio',) );

	add_editor_style( array( 'css/editor-style.css', food_restaurant_font_url() ) );

	// Theme Activation Notice
	global $pagenow;
	
	if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
		add_action( 'admin_notices', 'food_restaurant_activation_notice' );
	}

}
endif; // food_restaurant_setup
add_action( 'after_setup_theme', 'food_restaurant_setup' );

// Notice after Theme Activation
function food_restaurant_activation_notice() {
	echo '<div class="foodwelcome notice notice-success is-dismissible">';
		echo '<h3>'. esc_html__( 'Warm Greetings to you!!', 'food-restaurant' ) .'</h3>';
		echo '<p>'. esc_html__( ' Our sincere thanks for choosing our food restaurant theme. We assure you a high performing theme for your food business. Please proceed towards welcome section to start an amazing journey with us. ', 'food-restaurant' ) .'</p>';
		echo '<p><a href="'. esc_url( admin_url( 'themes.php?page=food_restaurant_guide' ) ) .'" class="button button-primary">'. esc_html__( 'Welcome...', 'food-restaurant' ) .'</a></p>';
	echo '</div>';
}

/* Theme Widgets Setup */
function food_restaurant_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'food-restaurant' ),
		'description'   => __( 'Appears on blog page sidebar', 'food-restaurant' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Posts and Pages Sidebar', 'food-restaurant' ),
		'description'   => __( 'Appears on posts and pages', 'food-restaurant' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Third Column Sidebar', 'food-restaurant' ),
		'description'   => __( 'Appears on posts and pages', 'food-restaurant' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'food-restaurant' ),
		'description'   => __( 'Appears in footer', 'food-restaurant' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'food-restaurant' ),
		'description'   => __( 'Appears in footer', 'food-restaurant' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'food-restaurant' ),
		'description'   => __( 'Appears in footer', 'food-restaurant' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'food-restaurant' ),
		'description'   => __( 'Appears in footer', 'food-restaurant' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'food_restaurant_widgets_init' );

/* Theme Font URL */
function food_restaurant_font_url(){
	$font_url = '';
	$font_family = array();
	$font_family[] = 'PT Sans:300,400,600,700,800,900';
	$font_family[] = 'Roboto:400,700';
	$font_family[] = 'Roboto Condensed:400,700';
	$font_family[] = 'Open Sans';
	$font_family[] = 'Overpass';
	$font_family[] = 'Montserrat:300,400,600,700,800,900';
	$font_family[] = 'Playball:300,400,600,700,800,900';
	$font_family[] = 'Alegreya:300,400,600,700,800,900';
	$font_family[] = 'Julius Sans One';
	$font_family[] = 'Arsenal';
	$font_family[] = 'Slabo';
	$font_family[] = 'Lato';
	$font_family[] = 'Overpass Mono';
	$font_family[] = 'Source Sans Pro';
	$font_family[] = 'Raleway';
	$font_family[] = 'Merriweather';
	$font_family[] = 'Droid Sans';
	$font_family[] = 'Rubik';
	$font_family[] = 'Lora';
	$font_family[] = 'Ubuntu';
	$font_family[] = 'Cabin';
	$font_family[] = 'Arimo';
	$font_family[] = 'Playfair Display';
	$font_family[] = 'Quicksand';
	$font_family[] = 'Padauk';
	$font_family[] = 'Muli';
	$font_family[] = 'Inconsolata';
	$font_family[] = 'Bitter';
	$font_family[] = 'Pacifico';
	$font_family[] = 'Indie Flower';
	$font_family[] = 'VT323';
	$font_family[] = 'Dosis';
	$font_family[] = 'Frank Ruhl Libre';
	$font_family[] = 'Fjalla One';
	$font_family[] = 'Oxygen';
	$font_family[] = 'Arvo';
	$font_family[] = 'Noto Serif';
	$font_family[] = 'Lobster';
	$font_family[] = 'Crimson Text';
	$font_family[] = 'Yanone Kaffeesatz';
	$font_family[] = 'Anton';
	$font_family[] = 'Libre Baskerville';
	$font_family[] = 'Bree Serif';
	$font_family[] = 'Gloria Hallelujah';
	$font_family[] = 'Josefin Sans';
	$font_family[] = 'Abril Fatface';
	$font_family[] = 'Varela Round';
	$font_family[] = 'Vampiro One';
	$font_family[] = 'Shadows Into Light';
	$font_family[] = 'Cuprum';
	$font_family[] = 'Rokkitt';
	$font_family[] = 'Vollkorn';
	$font_family[] = 'Francois One';
	$font_family[] = 'Orbitron';
	$font_family[] = 'Patua One';
	$font_family[] = 'Acme';
	$font_family[] = 'Satisfy';
	$font_family[] = 'Josefin Slab';
	$font_family[] = 'Quattrocento Sans';
	$font_family[] = 'Architects Daughter';
	$font_family[] = 'Russo One';
	$font_family[] = 'Monda';
	$font_family[] = 'Righteous';
	$font_family[] = 'Lobster Two';
	$font_family[] = 'Hammersmith One';
	$font_family[] = 'Courgette';
	$font_family[] = 'Permanent Marker';
	$font_family[] = 'Cherry Swash';
	$font_family[] = 'Cormorant Garamond';
	$font_family[] = 'Poiret One';
	$font_family[] = 'BenchNine';
	$font_family[] = 'Economica';
	$font_family[] = 'Handlee';
	$font_family[] = 'Cardo';
	$font_family[] = 'Alfa Slab One';
	$font_family[] = 'Averia Serif Libre';
	$font_family[] = 'Cookie';
	$font_family[] = 'Chewy';
	$font_family[] = 'Great Vibes';
	$font_family[] = 'Coming Soon';
	$font_family[] = 'Philosopher';
	$font_family[] = 'Days One';
	$font_family[] = 'Kanit';
	$font_family[] = 'Shrikhand';
	$font_family[] = 'Tangerine';
	$font_family[] = 'IM Fell English SC';
	$font_family[] = 'Boogaloo';
	$font_family[] = 'Bangers';
	$font_family[] = 'Fredoka One';
	$font_family[] = 'Bad Script';
	$font_family[] = 'Volkhov';
	$font_family[] = 'Shadows Into Light Two';
	$font_family[] = 'Marck Script';
	$font_family[] = 'Sacramento';
	$font_family[] = 'Unica One';

	$query_args = array(
		'family'	=> rawurlencode(implode('|',$font_family)),
	);
	$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
	return $font_url;
}

/* Theme enqueue scripts */
function food_restaurant_scripts() {
	wp_enqueue_style( 'food-restaurant-font', food_restaurant_font_url(), array() );
	wp_enqueue_style( 'bootstrap-css', esc_url(get_template_directory_uri()) . '/css/bootstrap.css');
	wp_enqueue_style( 'food-restaurant-basic-style', get_stylesheet_uri() );
	wp_style_add_data( 'food-restaurant-style', 'rtl', 'replace' );
	wp_enqueue_style( 'font-awesome-css', esc_url(get_template_directory_uri()).'/css/fontawesome-all.css' );
	
	// Paragraph
	    $food_restaurant_paragraph_color = get_theme_mod('food_restaurant_paragraph_color', '');
	    $food_restaurant_paragraph_font_family = get_theme_mod('food_restaurant_paragraph_font_family', '');
	    $food_restaurant_paragraph_font_size = get_theme_mod('food_restaurant_paragraph_font_size', '');
	// "a" tag
		$food_restaurant_atag_color = get_theme_mod('food_restaurant_atag_color', '');
	    $food_restaurant_atag_font_family = get_theme_mod('food_restaurant_atag_font_family', '');
	// "li" tag
		$food_restaurant_li_color = get_theme_mod('food_restaurant_li_color', '');
	    $food_restaurant_li_font_family = get_theme_mod('food_restaurant_li_font_family', '');
	// H1
		$food_restaurant_h1_color = get_theme_mod('food_restaurant_h1_color', '');
	    $food_restaurant_h1_font_family = get_theme_mod('food_restaurant_h1_font_family', '');
	    $food_restaurant_h1_font_size = get_theme_mod('food_restaurant_h1_font_size', '');
	// H2
		$food_restaurant_h2_color = get_theme_mod('food_restaurant_h2_color', '');
	    $food_restaurant_h2_font_family = get_theme_mod('food_restaurant_h2_font_family', '');
	    $food_restaurant_h2_font_size = get_theme_mod('food_restaurant_h2_font_size', '');
	// H3
		$food_restaurant_h3_color = get_theme_mod('food_restaurant_h3_color', '');
	    $food_restaurant_h3_font_family = get_theme_mod('food_restaurant_h3_font_family', '');
	    $food_restaurant_h3_font_size = get_theme_mod('food_restaurant_h3_font_size', '');
	// H4
		$food_restaurant_h4_color = get_theme_mod('food_restaurant_h4_color', '');
	    $food_restaurant_h4_font_family = get_theme_mod('food_restaurant_h4_font_family', '');
	    $food_restaurant_h4_font_size = get_theme_mod('food_restaurant_h4_font_size', '');
	// H5
		$food_restaurant_h5_color = get_theme_mod('food_restaurant_h5_color', '');
	    $food_restaurant_h5_font_family = get_theme_mod('food_restaurant_h5_font_family', '');
	    $food_restaurant_h5_font_size = get_theme_mod('food_restaurant_h5_font_size', '');
	// H6
		$food_restaurant_h6_color = get_theme_mod('food_restaurant_h6_color', '');
	    $food_restaurant_h6_font_family = get_theme_mod('food_restaurant_h6_font_family', '');
	    $food_restaurant_h6_font_size = get_theme_mod('food_restaurant_h6_font_size', '');

		$food_restaurant_custom_css ='
			p,span{
			    color:'.esc_html($food_restaurant_paragraph_color).'!important;
			    font-family: '.esc_html($food_restaurant_paragraph_font_family).';
			    font-size: '.esc_html($food_restaurant_paragraph_font_size).';
			}
			a{
			    color:'.esc_html($food_restaurant_atag_color).'!important;
			    font-family: '.esc_html($food_restaurant_atag_font_family).';
			}
			li{
			    color:'.esc_html($food_restaurant_li_color).'!important;
			    font-family: '.esc_html($food_restaurant_li_font_family).';
			}
			h1{
			    color:'.esc_html($food_restaurant_h1_color).'!important;
			    font-family: '.esc_html($food_restaurant_h1_font_family).'!important;
			    font-size: '.esc_html($food_restaurant_h1_font_size).'!important;
			}
			h2{
			    color:'.esc_html($food_restaurant_h2_color).'!important;
			    font-family: '.esc_html($food_restaurant_h2_font_family).'!important;
			    font-size: '.esc_html($food_restaurant_h2_font_size).'!important;
			}
			h3{
			    color:'.esc_html($food_restaurant_h3_color).'!important;
			    font-family: '.esc_html($food_restaurant_h3_font_family).'!important;
			    font-size: '.esc_html($food_restaurant_h3_font_size).'!important;
			}
			h4{
			    color:'.esc_html($food_restaurant_h4_color).'!important;
			    font-family: '.esc_html($food_restaurant_h4_font_family).'!important;
			    font-size: '.esc_html($food_restaurant_h4_font_size).'!important;
			}
			h5{
			    color:'.esc_html($food_restaurant_h5_color).'!important;
			    font-family: '.esc_html($food_restaurant_h5_font_family).'!important;
			    font-size: '.esc_html($food_restaurant_h5_font_size).'!important;
			}
			h6{
			    color:'.esc_html($food_restaurant_h6_color).'!important;
			    font-family: '.esc_html($food_restaurant_h6_font_family).'!important;
			    font-size: '.esc_html($food_restaurant_h6_font_size).'!important;
			}
		';

	/*------ Slider Show/Hide ------*/
	$food_restaurant_slider = get_theme_mod('food_restaurant_slider_hide');
	if($food_restaurant_slider == false ){
		$food_restaurant_custom_css .='.page-template-home-custom .header{';
			$food_restaurant_custom_css .='position: static; background-color: #fb6e21;';
		$food_restaurant_custom_css .='}';
		$food_restaurant_custom_css .='.page-template-home-custom .header .logo, .page-template-home-custom #menu-sidebar .primary-navigation{';
			$food_restaurant_custom_css .=' background-color: transparent;';
		$food_restaurant_custom_css .='}';
		$food_restaurant_custom_css .='.page-template-home-custom .header .logo a, .page-template-home-custom .header .logo p, .page-template-home-custom .primary-navigation ul li a{';
			$food_restaurant_custom_css .=' color: #fff;';
		$food_restaurant_custom_css .='}';
	}

	$food_restaurant_slider_hide = get_theme_mod('food_restaurant_slider_hide');
	if($food_restaurant_slider_hide != true){
		$food_restaurant_custom_css .='#menu-sidebar .primary-navigation{';
			$food_restaurant_custom_css .='position: static;top: 0px; transform: none;';
		$food_restaurant_custom_css .='}';
	}

	wp_add_inline_style( 'food-restaurant-basic-style',$food_restaurant_custom_css );
	
	wp_enqueue_script( 'bootstrap-js', esc_url(get_template_directory_uri()) . '/js/bootstrap.js', array('jquery') ,'',true);
	wp_enqueue_script( 'food-restaurant-customscripts', esc_url(get_template_directory_uri()) . '/js/custom.js', array('jquery') );
	wp_enqueue_script( 'jquery-superfish', esc_url(get_template_directory_uri()) . '/js/jquery.superfish.js', array('jquery') ,'',true);
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'food_restaurant_scripts' );

define('FOOD_RESTAURANT_FREE_THEME_DOC',__('https://logicalthemes.com/docs/free-food-restaurant/','food-restaurant'));
define('FOOD_RESTAURANT_SUPPORT',__('https://wordpress.org/support/theme/food-restaurant','food-restaurant'));
define('FOOD_RESTAURANT_REVIEW',__('https://wordpress.org/support/theme/food-restaurant/reviews/#new-post','food-restaurant'));
define('FOOD_RESTAURANT_BUY_NOW',__('https://www.logicalthemes.com/premium/food-restaurant-wordpress-theme/','food-restaurant'));
define('FOOD_RESTAURANT_LIVE_DEMO',__('https://www.logicalthemes.com/food-restaurant-theme/','food-restaurant'));
define('FOOD_RESTAURANT_PRO_DOC',__('https://www.logicalthemes.com/docs/food-restaurant-pro/','food-restaurant'));
define('FOOD_RESTAURANT_CREDIT',__('https://www.logicalthemes.com/free/wp-food-restaurant-wordpress-theme/','food-restaurant'));

if ( ! function_exists( 'food_restaurant_credit' ) ) {
	function food_restaurant_credit(){
		echo "<a href=".esc_url(FOOD_RESTAURANT_CREDIT)." target='_blank'>".esc_html__('Restaurant WordPress Theme','food-restaurant')."</a>";
	}
}

/*radio button sanitization*/
 function food_restaurant_sanitize_choices( $input, $setting ) {
    global $wp_customize; 
    $control = $wp_customize->get_control( $setting->id ); 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function food_restaurant_sanitize_checkbox( $input ) {
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function food_restaurant_sanitize_float( $input ) {
	return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

function food_restaurant_sanitize_dropdown_pages( $page_id, $setting ) {
  // Ensure $input is an absolute integer.
  $page_id = absint( $page_id );
  // If $page_id is an ID of a published page, return it; otherwise, return the default.
  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'food_restaurant_loop_columns');
if (!function_exists('food_restaurant_loop_columns')) {
	function food_restaurant_loop_columns() {
		$columns = get_theme_mod( 'food_restaurant_products_per_column', 3 );
		return $columns; // 3 products per row
	}
}

//Change number of products that are displayed per page (shop page)
add_filter( 'loop_shop_per_page', 'food_restaurant_shop_per_page', 20 );
function food_restaurant_shop_per_page( $cols ) {
  	$cols = get_theme_mod( 'food_restaurant_products_per_page', 9 );
	return $cols;
}

/* Excerpt Limit Begin */
function food_restaurant_string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}

/* Custom template tags for this theme. */
require get_template_directory() . '/inc/template-tags.php';

/* Load Jetpack compatibility file. */
require get_template_directory() . '/inc/customizer.php';

/* Implement the Custom Header feature. */
require get_template_directory() . '/inc/custom-header.php';

/* Implement the About theme page */
require get_template_directory() . '/inc/getting-started/getting-started.php';