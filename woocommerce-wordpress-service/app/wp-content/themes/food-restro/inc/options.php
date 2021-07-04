<?php
/**
 * Theme Palace options
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

/**
 * List of pages for page choices.
 * @return Array Array of page ids and name.
 */
function food_restro_page_choices() {
    $pages = get_pages();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'food-restro' );
    foreach ( $pages as $page ) {
        $choices[ $page->ID ] = $page->post_title;
    }
    return  $choices;
}

if ( ! function_exists( 'food_restro_site_layout' ) ) :
    /**
     * Site Layout
     * @return array site layout options
     */
    function food_restro_site_layout() {
        $food_restro_site_layout = array(
            'wide'  => get_template_directory_uri() . '/assets/images/full.png',
            'boxed-layout' => get_template_directory_uri() . '/assets/images/boxed.png',
        );

        $output = apply_filters( 'food_restro_site_layout', $food_restro_site_layout );
        return $output;
    }
endif;

if ( ! function_exists( 'food_restro_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function food_restro_selected_sidebar() {
        $food_restro_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'food-restro' ),
            'optional-sidebar'      => esc_html__( 'Optional Sidebar 1', 'food-restro' ),
        );

        $output = apply_filters( 'food_restro_selected_sidebar', $food_restro_selected_sidebar );

        return $output;
    }
endif;


if ( ! function_exists( 'food_restro_global_sidebar_position' ) ) :
    /**
     * Global Sidebar position
     * @return array Global Sidebar positions
     */
    function food_restro_global_sidebar_position() {
        $food_restro_global_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'food_restro_global_sidebar_position', $food_restro_global_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'food_restro_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function food_restro_sidebar_position() {
        $food_restro_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'food_restro_sidebar_position', $food_restro_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'food_restro_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function food_restro_pagination_options() {
        $food_restro_pagination_options = array(
            'numeric'   => esc_html__( 'Numeric', 'food-restro' ),
            'default'   => esc_html__( 'Default(Older/Newer)', 'food-restro' ),
        );

        $output = apply_filters( 'food_restro_pagination_options', $food_restro_pagination_options );

        return $output;
    }
endif;

if ( ! function_exists( 'food_restro_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function food_restro_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Enable', 'food-restro' ),
            'off'       => esc_html__( 'Disable', 'food-restro' )
        );
        return apply_filters( 'food_restro_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'food_restro_hide_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function food_restro_hide_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'food-restro' ),
            'off'       => esc_html__( 'No', 'food-restro' )
        );
        return apply_filters( 'food_restro_hide_options', $arr );
    }
endif;

if ( ! function_exists( 'food_restro_sortable_sections' ) ) :
    /**
     * List of sections Control options
     * @return array List of Sections control options.
     */
    function food_restro_sortable_sections() {
        $sections = array(
            'slider'    => esc_html__( 'Main Slider', 'food-restro' ),
            'service'   => esc_html__( 'Services', 'food-restro' ),
            'about'     => esc_html__( 'About Us', 'food-restro' ),
            'gallery'   => esc_html__( 'Gallery', 'food-restro' ),
            'testimonial' => esc_html__( 'Testimonial', 'food-restro' ),
            'cta'       => esc_html__( 'Call to Action', 'food-restro' ),
            'blog'      => esc_html__( 'Blog', 'food-restro' ),
        );
        return apply_filters( 'food_restro_sortable_sections', $sections );
    }
endif;
