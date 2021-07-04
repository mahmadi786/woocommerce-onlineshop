<?php

/**
 * Marmot_Restaurant main functions file
 *
 * @since 1.0.0
 */

namespace Marmot_Restaurant;

defined('ABSPATH') || exit;

/**
 * Theme Directory Path
 *
 * @since 1.0.0
 * @var string
 */
define('MARMOT_RESTAURANT_THEME_DIR', trailingslashit(get_template_directory()));

/**
 * Theme URL
 *
 * @since 1.0.0
 * @var string
 */
define('MARMOT_RESTAURANT_THEME_URL', get_template_directory_uri());

/**
 * Theme Version
 *
 * @since 1.0.0
 * @var string
 */
const THEME_VERSION = '1.0.2';

/**
 * Theme Unique Slug
 *
 * @since 1.0.0
 * @var string
 */
const THEME_SLUG = 'marmot-restaurants';

/**
 * Marmot_Restaurant main class
 *
 * @since 1.0.0
 */
class Marmot_Restaurant {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Marmot_Restaurant 
     */
    private static $_instance = null;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Marmot
     */
    public static function instance() {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Marmot_Restaurant setup.
     *
     * Sets up theme defaults and registers the various WordPress features that
     * Marmot supports.
     *
     * @since Marmot_Restaurant 1.0.0
     */
    private function __construct() {
        // Enqueue child theme scrits and styles
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        // Change Google Fonts URL
        add_filter('hqt/no_elementor/load_google_fonts_url', [$this, 'load_google_fonts_url']);
        // Change custom header defaults
        add_filter('marmot/custom_header/args', [$this, 'custom_header_args']);
        // Change style url
        add_filter('hqt/no_elementor/custom_style_url', [$this, 'custom_style_url']);
        // Filter demos import
        add_filter('hqt/demo_import/listing/search_value', [$this, 'demo_import_listing_search_value']);
        // Filter starter content
        add_filter('marmot/starter_content', [$this, 'starter_content']);
    }

    /**
     * Change custom header defaults
     * 
     * @since 1.0.0
     * 
     * @param array $args
     * @return array
     */
    public function custom_header_args($args) {
        $args['default-image'] = get_theme_file_uri('/assets/images/header-image.jpg');
        return $args;
    }

    /**
     * Load chlid theme css
     * 
     * @since 1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style('child-style', get_stylesheet_uri(),
                ['marmot'],
                wp_get_theme()->get('Version') // this only works if you have Version in the style header
        );
    }

    /**
     * Change style url
     * 
     * @since 1.0.0
     */
    public function custom_style_url($custom_style_url) {
        return get_theme_file_uri('/assets/css/no-elementor-customizations.css');
    }

    /**
     * Change Google Fonts URL
     * 
     * @since 1.0.0
     */
    public function load_google_fonts_url($font_url) {
        return 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,700;1,300;1,700&family=Vollkorn&display=swap';
    }

    /**
     * Search for restaurants in demo import
     * 
     * @since 1.0.0
     * 
     * @param string $value
     * @return string
     */
    public function demo_import_listing_search_value($value) {
        return 'restaurant';
    }

    /**
     * Set starter content
     * 
     * @since 1.0.2
     * 
     * @param array $starter_content
     * @return array
     */
    public function starter_content($starter_content) {
        $starter_content['posts'] = [
            'front' => [
                'post_type' => 'page',
                'post_title' => esc_html_x('Create Amazing Website for Your Restaurant', 'Theme starter content', 'marmot-restaurants'),
                'post_content' => '
					<!-- wp:spacer {"height":50} -->
					<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
					<!-- /wp:spacer -->

					<!-- wp:columns {"verticalAlignment":"top","align":"wide"} -->
					<div class="wp-block-columns alignwide are-vertically-aligned-top"><!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:heading {"level":4} -->
					<h3>' . esc_html_x('Food and Drink Menus', 'Theme starter content', 'marmot-restaurants') . '</h3>
					<!-- /wp:heading -->

					<!-- wp:paragraph -->
					<p>' . esc_html_x('Present your meals in the best way with special menu pages.', 'Theme starter content', 'marmot-restaurants') . '</p>
					<!-- /wp:paragraph --></div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:heading {"level":4} -->
					<h3>' . esc_html_x('Online Orders', 'Theme starter content', 'marmot-restaurants') . '</h3>
					<!-- /wp:heading -->

					<!-- wp:paragraph -->
					<p>' . esc_html_x('Get your business to the next level by adding online orders to your site.', 'Theme starter content', 'marmot-restaurants') . '</p>
					<!-- /wp:paragraph --></div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:heading {"level":4} -->
					<h3>' . esc_html_x('Image Galleries and Sliders', 'Theme starter content', 'marmot-restaurants') . '</h3>
					<!-- /wp:heading -->

					<!-- wp:paragraph -->
					<p>' . esc_html_x('Impress your customers by displaying images and videos.', 'Theme starter content', 'marmot-restaurants') . '</p>
					<!-- /wp:paragraph --></div>
					<!-- /wp:column --></div>
					<!-- /wp:columns -->
                                        
<!-- wp:spacer {"height":50} -->
					<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
					<!-- /wp:spacer -->

					<!-- wp:columns {"verticalAlignment":"top","align":"wide"} -->
					<div class="wp-block-columns alignwide are-vertically-aligned-top"><!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:heading {"level":4} -->
					<h3>' . esc_html_x('Testimonials', 'Theme starter content', 'marmot-restaurants') . '</h3>
					<!-- /wp:heading -->

					<!-- wp:paragraph -->
					<p>' . esc_html_x('Share your customer feedback and earn the trust of your visitors.', 'Theme starter content', 'marmot-restaurants') . '</p>
					<!-- /wp:paragraph --></div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:heading {"level":4} -->
					<h3>' . esc_html_x('Contact Page', 'Theme starter content', 'marmot-restaurants') . '</h3>
					<!-- /wp:heading -->

					<!-- wp:paragraph -->
					<p>' . esc_html_x('Add address, location map, opening hours and other contact details.', 'Theme starter content', 'marmot-restaurants') . '</p>
					<!-- /wp:paragraph --></div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:heading {"level":4} -->
					<h3>' . esc_html_x('Mobile Optimized', 'Theme starter content', 'marmot-restaurants') . '</h3>
					<!-- /wp:heading -->

					<!-- wp:paragraph -->
					<p>' . esc_html_x('See how easily a visitor can use your page on a mobile device.', 'Theme starter content', 'marmot-restaurants') . '</p>
					<!-- /wp:paragraph --></div>
					<!-- /wp:column --></div>
					<!-- /wp:columns -->

					<!-- wp:spacer -->
					<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
					<!-- /wp:spacer -->',
            ],
            'menu' => [
                'post_type' => 'page',
                'post_title' => esc_html_x('Our Menu', 'Theme starter content', 'marmot-restaurants'),
                'post_content' => sprintf(
                        "<!-- wp:paragraph -->\n<p>%s</p>\n<!-- /wp:paragraph -->",
                        _x('This is a page with restautant menu.', 'Theme starter content', 'marmot-restaurants')
                ),
            ],
            'about' => [],
            'contact' => [],
            'blog' => [],
        ];

        $starter_content['nav_menus'] = [
            'primary' => [
                'name' => __('Main Menu', 'marmot-restaurants'),
                'items' => [
                    'link_home',
                    'page_menu',
                    'page_menu' => [
                        'type' => 'post_type',
                        'object' => 'page',
                        'object_id' => '{{menu}}',
                    ],
                    'page_blog',
                    'page_about',
                    'page_contact',
                ],
            ],
        ];
        return $starter_content;
    }

}

Marmot_Restaurant::instance();
