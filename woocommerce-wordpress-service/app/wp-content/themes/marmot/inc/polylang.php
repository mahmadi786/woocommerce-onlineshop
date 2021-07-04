<?php

namespace Marmot;

defined('ABSPATH') || exit;

/**
 * Polylang
 * 
 * Makes Marmot fully compatible with polylang
 * 
 * @since 1.0.0
 */
class Polylang {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Polylang 
     */
    private static $_instance = null;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Polylang
     */
    public static function instance() {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Class constructor
     *
     * @since 1.0.0
     */
    private function __construct() {
        // Enable Templates Translations
        add_filter('pll_get_post_types', [$this, 'add_cpts_to_polylang'], 10, 2);

        // Change template_id based on selected language
        add_filter('hqt/elementor/display/template/id', [$this, 'change_template_based_on_language']);
    }

    /**
     * Makes post types translatable
     * 
     * @since 1.0.0
     * 
     * @param array $post_types
     * @param $is_settings
     * @return array
     */
    function add_cpts_to_polylang($post_types, $is_settings) {

        $relevant_types = apply_filters(
                'hqt/polylang/post_types',
                [
                    'elementor_library', // Elementor
                ]
        );

        /** Add all post types to Polylang */
        foreach ($relevant_types as $relevant_type) {
            $post_types[$relevant_type] = $relevant_type;
        }

        /** Return modified post types list for Polylang */
        return $post_types;
    }

    /**
     * Search for post_id for current language
     * 
     * @since 1.0.0
     * 
     * @param int $post_id
     * @return int
     */
    function change_template_based_on_language($post_id) {

        if (!function_exists('pll_get_post')) {
            return $post_id;
        }

        $translation_post_id = pll_get_post($post_id);

        if (null === $translation_post_id) {

            /** The current language is not defined yet */
            return $post_id;
        } elseif (false === $translation_post_id) {

            /** No translation yet */
            return $post_id;
        } elseif ($translation_post_id > 0) {

            /** Return translated post ID */
            return $translation_post_id;
        }

        return $post_id;
    }

}
