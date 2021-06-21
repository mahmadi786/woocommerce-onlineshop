<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */


// Function to register the widget areas(sidebar) and widgets.
function foodhunt_widgets_init() {

	// Registering main right sidebar
	register_sidebar( array(
		'name'            => esc_html__( 'Right Sidebar', 'foodhunt' ),
		'id'              => 'foodhunt_right_sidebar',
		'description'     => esc_html__( 'Shows widgets at Right side.', 'foodhunt' ),
		'before_widget'   => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'    => '</aside>',
		'before_title'    => '<h4 class="widget-title"><span>',
		'after_title'     => '</span></h4>'
		) );
	// Registering main left sidebar
	register_sidebar( array(
		'name'            => esc_html__( 'Left Sidebar', 'foodhunt' ),
		'id'              => 'foodhunt_left_sidebar',
		'description'     => esc_html__( 'Shows widgets at Left side.', 'foodhunt' ),
		'before_widget'   => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'    => '</aside>',
		'before_title'    => '<h4 class="widget-title"><span>',
		'after_title'     => '</span></h4>'
		) );
	// Registering Restaurant Template sidebar
	register_sidebar( array(
		'name'            => esc_html__( 'Restaurant Template Sidebar', 'foodhunt' ),
		'id'              => 'foodhunt_business_sidebar',
		'description'     => esc_html__( 'Shows widgets On the Restaurant Template.', 'foodhunt' ),
		'before_widget'   => '<section id="%1$s" class="widget %2$s clearfix">',
		'after_widget'    => '</section>',
		'before_title'    => '<h3 class="section-title">',
		'after_title'     => '</h3>'
		) );
	// Registering Footer sidebar
	for( $i = 1; $i <= 4; $i++ ) {
		register_sidebar( array(
			'name'            => esc_html__( 'Footer Sidebar ', 'foodhunt' ) . $i,
			'id'              => 'foodhunt_footer_sidebar'.$i,
			'description'     => esc_html__( 'Show widgets at Footer section.', 'foodhunt' ),
			'before_widget'   => '<aside id="%1$s" class="widget footer-block %2$s clearfix">',
			'after_widget'    => '</aside>',
			'before_title'    => '<h4 class="widget-title"><span>',
			'after_title'     => '</span></h4>'
			) );
	}
	register_widget( 'foodhunt_about_us_widget' );
	register_widget( 'foodhunt_service_widget' );
	register_widget( 'foodhunt_call_to_action_widget' );
	register_widget( 'foodhunt_our_team_widget' );
	register_widget( 'foodhunt_featured_posts_widget' );
	register_widget( 'foodhunt_portfolio_widget' );
	register_widget( 'foodhunt_contact_widget' );
}
add_action( 'widgets_init', 'foodhunt_widgets_init');

/**
 * Include Foodhunt widgets class.
 */
// Class: TG: Call to Action Widget.
require_once get_template_directory() . '/inc/widgets/class-foodhunt-about-us-widget.php';

// Class: TG: Call to Action Widget.
require_once get_template_directory() . '/inc/widgets/class-foodhunt-call-to-action-widget.php';

// Class: TG: Services Widget.
require_once get_template_directory() . '/inc/widgets/class-foodhunt-service-widget.php';

// Class: TG: Our Team Widget.
require_once get_template_directory() . '/inc/widgets/class-foodhunt-our-team-widget.php';

// Class: TG: Portfolio Widget.
require_once get_template_directory() . '/inc/widgets/class-foodhunt-portfolio-widget.php';

// Class: TG: Featured Posts Widget.
require_once get_template_directory() . '/inc/widgets/class-foodhunt-featured-posts-widget.php';

// Class: TG: Contact Us Widget.
require_once get_template_directory() . '/inc/widgets/class-foodhunt-contact-widget.php';
