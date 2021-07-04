<?php
/**
 * Register widget for page
 */
function finedine_sidebar_init() {

	register_sidebar(array(
		'name'          => esc_html__( 'Blog Sidebar', 'finedine' ),
		'id'            => 'finedine-innerpage-sidebar',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => esc_html__( 'Resturant Body 1', 'finedine' ),
		'id'            => 'finedine-front-widget-1',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="front-widget">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => esc_html__( 'Resturant Body 2', 'finedine' ),
		'id'            => 'finedine-front-widget-2',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="front-widget">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => esc_html__( 'Footer', 'finedine' ),
		'id'            => 'footer-sidebar-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s col-sm-6 col-md-4">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
}

add_action( 'widgets_init', 'finedine_sidebar_init' );


