<?php
/**
* Partial functions
*
* @package Theme Palace
* @subpackage Food Restro
* @since Food Restro 1.0.0
*/

if ( ! function_exists( 'food_restro_service_title_partial' ) ) :
    // service title
    function food_restro_service_title_partial() {
        $options = food_restro_get_theme_options();
        return esc_html( $options['service_title'] );
    }
endif;

if ( ! function_exists( 'food_restro_about_btn_title_partial' ) ) :
    // about btn title
    function food_restro_about_btn_title_partial() {
        $options = food_restro_get_theme_options();
        return esc_html( $options['about_btn_title'] );
    }
endif;

if ( ! function_exists( 'food_restro_testimonial_title_partial' ) ) :
    // testimonial title
    function food_restro_testimonial_title_partial() {
        $options = food_restro_get_theme_options();
        return esc_html( $options['testimonial_title'] );
    }
endif;

if ( ! function_exists( 'food_restro_cta_btn_title_partial' ) ) :
    // cta btn title
    function food_restro_cta_btn_title_partial() {
        $options = food_restro_get_theme_options();
        return esc_html( $options['cta_btn_title'] );
    }
endif;

if ( ! function_exists( 'food_restro_blog_title_partial' ) ) :
    // blog title
    function food_restro_blog_title_partial() {
        $options = food_restro_get_theme_options();
        return esc_html( $options['blog_title'] );
    }
endif;
