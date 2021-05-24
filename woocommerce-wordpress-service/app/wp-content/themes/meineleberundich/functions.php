<?php
/**
 * Theme functions
 *
 * @package MeineLeberUndIch
 */
define('THEME_TEXT_DOMAIN', 'meineleberundich');

/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
add_theme_support('title-tag');

// Load regular editor styles into the new block-based editor.
add_theme_support('editor-styles');

// Load default block styles.
add_theme_support('wp-block-styles');

// Add support for responsive embeds.
add_theme_support('responsive-embeds');

/**
 * Enqueues scripts and styles.
 */
function meineleberundich_scripts()
{
    // Add custom fonts, used in the main stylesheet.
    //wp_enqueue_style( 'meineleberundich-fonts', get_fonts_url(), [], null );

    // Theme stylesheet.
    wp_register_style('meineleberundich-style',
        get_template_directory_uri() . '/dist/app.css',
        [],
        filemtime(get_template_directory() . '/dist/app.css')
    );

//    wp_register_style( 'meineleberundich-style',
//        get_stylesheet_uri(),
//        [],
//        filemtime( get_template_directory() . '/dist/app.css' )
//    );

    // Theme script.
    wp_register_script('meineleberundich-script',
        get_template_directory_uri() . '/dist/app.js',
        [],
        filemtime(get_template_directory() . '/dist/app.js'),
        true);

    wp_enqueue_style('meineleberundich-style');
    wp_enqueue_script('meineleberundich-script');
}

add_action('wp_enqueue_scripts', 'meineleberundich_scripts');

// Add theme support for Custom Logo.
add_theme_support(
    'custom-logo',
    [
        'width'       => 380,
        'height'      => 120,
        'flex-width'  => true,
        'header-text' => ['site-title'],
    ]
);

//  nav menus
function register_my_menus()
{
    register_nav_menus(
        [
            'header-menu' => __('Header Menu'),
            'footer-menu' => __('Footer Menu'),
        ]
    );
}

add_action('init', 'register_my_menus');