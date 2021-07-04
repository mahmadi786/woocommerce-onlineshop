<?php

namespace Marmot\Parts;

defined('ABSPATH') || exit;

use function Marmot\display_the_content;
use function Marmot\display_elementor_template;
use function Marmot\choose_and_display_elementor_template;

/**
 * Theme Layout
 * 
 * @since 1.0.0
 */
class Layout {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Layout 
     */
    private static $_instance;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Layout
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

        // Header
        add_action('hqt/primary_container/before', [$this, 'header_display'], 20);

        // Footer
        add_action('hqt/primary_container/after', [$this, 'footer_display'], 9900);

        // Content
        add_action('hqt/main_content', [$this, 'content_display']);
    }

    /**
     * Enqueue Styles
     * 
     * @since 1.0.0
     */
    public static function enqueue_styles() {
        if (!\Elementor\Plugin::instance()->preview->is_preview_mode()) {
            // Main elementor styles
            $elementor = \Elementor\Plugin::instance();
            $elementor->frontend->enqueue_styles();
            if (\Marmot\Marmot::is_full_customization_mode()) {
                // Header
                choose_and_display_elementor_template('header', 'hq_header_elementor_template', false);
                // Footer
                choose_and_display_elementor_template('footer', 'hq_footer_elementor_template', false);
                // Content
                self::get_content(false);
            }
        }
    }

    /**
     * Displays the header.
     * 
     * @since 1.0.0
     */
    public function header_display() {
        if (\Marmot\Marmot::is_full_customization_mode()) {
            ?>
            <header class="main-header">
                <?php
                choose_and_display_elementor_template('header', 'hq_header_elementor_template');
                ?>
            </header>
            <?php
        } else {
            get_template_part('noelementor-templates/header');
        }
    }

    /**
     * Displays the footer.
     * 
     * @since 1.0.0
     */
    public function footer_display() {
        if (\Marmot\Marmot::is_full_customization_mode()) {
            ?>
            <footer>
                <?php
                // Footer
                choose_and_display_elementor_template('footer', 'hq_footer_elementor_template');
                ?>
            </footer>
            <?php
        } else {
            get_template_part('noelementor-templates/footer');
        }
    }

    /**
     * Displays the content.
     * 
     * @since 1.0.0
     */
    public function content_display() {
        if (\Marmot\Marmot::is_full_customization_mode()) {
            self::get_content();
        } else {
            get_template_part('noelementor-templates/index', 'archive');
        }
    }

    /**
     * 
     * @since 1.0.0
     * 
     * @param boolean $echo
     */
    public static function get_content($echo = true) {
        // TODO Woocommerce & other plugins
        if (is_404()) {
            display_elementor_template(get_theme_mod('hq_404_elementor_template'), $echo);
        } elseif (is_search()) {
            display_elementor_template(get_theme_mod('hq_search_results_elementor_template'), $echo);
        } elseif (is_home()) {
            // TODO template for first page
            $tpl = get_theme_mod('hq_blog_home_layout');
            if (!empty($tpl) && $tpl != 'noeltmp') {
                display_elementor_template($tpl, $echo);
            } else {
                if ($echo) {
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo \Marmot\set_elementor_template_message('blog-home');
                }
            }
        } elseif (is_attachment()) {
            $tpl = get_theme_mod('hq_attachment_elementor_template');
            if (!empty($tpl) && $tpl != 'noeltmp') {
                display_elementor_template($tpl, $echo);
            } else {
                self::the_content($echo);
            }
        } elseif (is_single()) {
            if ('post' === get_post_type()) {
                self::single_post_template($echo);
            } else {
                self::single_template($echo);
            }
        } elseif (is_page()) {
            self::page_template($echo);
        } elseif (is_archive()) {
            self::archive_template($echo);
        } else {
            self::the_content($echo);
        }
    }

    /**
     * 
     * @since 1.0.0
     * 
     * @param boolean $echo
     */
    protected static function the_content($echo = true) {
        display_the_content($echo);
    }

    /**
     * 
     * @since 1.0.0
     * 
     * @param boolean $echo
     */
    protected static function single_template($echo) {
        while (have_posts()) {
            the_post();

            if (
                    \Elementor\Plugin::instance()->preview->is_preview_mode() ||
                    \Elementor\Plugin::instance()->db->is_built_with_elementor(get_the_ID())
            ) {
                self::the_content($echo);
            } else {
                // Load post content
                $tpl = \HQLib\get_post_meta(null, 'single_template');

                if (!empty($tpl) && $tpl != 'default') {
                    if ($tpl != 'noeltmp') {
                        display_elementor_template($tpl, $echo);
                    }
                } else {
                    $tpl = get_theme_mod('hq_' . get_post_type() . '_single_layout');
                    if (empty($tpl)) {
                        if ($echo) {
                            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            echo \Marmot\set_elementor_template_message('single', get_post_type());
                        }
                    } elseif ($tpl != 'noeltmp') {
                        display_elementor_template($tpl, $echo);
                    }
                }
            }
        }
    }

    /**
     * 
     * @since 1.0.0
     * 
     * @param boolean $echo
     */
    protected static function single_post_template($echo) {

        while (have_posts()) :
            the_post();

            if (
                    \Elementor\Plugin::instance()->preview->is_preview_mode() ||
                    \Elementor\Plugin::instance()->db->is_built_with_elementor(get_the_ID())
            ) {
                self::the_content($echo);
            } else {
                // Load blog content
                $tpl = \HQLib\get_post_meta(null, 'single_template');

                if (!empty($tpl) && $tpl != 'default') {
                    if ($tpl != 'noeltmp') {
                        display_elementor_template($tpl, $echo);
                    } else { // Load content if no template
                        self::the_content($echo);
                    }
                } else {
                    $tpl = get_theme_mod('hq_post_single_' . get_post_format() . '_layout');
                    if (!empty($tpl) && $tpl != 'default') {
                        display_elementor_template($tpl, $echo);
                    } else {
                        $tpl = get_theme_mod('hq_post_single_standart_layout');
                        if (!empty($tpl) && 'noeltmp' !== $tpl) {
                            display_elementor_template($tpl, $echo);
                        } else {
                            self::the_content($echo);
                        }
                    }
                }
            }
        endwhile;
    }

    /**
     * 
     * @since 1.0.0
     * 
     * @param boolean $echo
     */
    protected static function page_template($echo) {
        while (have_posts()) {
            the_post();

            if (
                    \Elementor\Plugin::instance()->preview->is_preview_mode() ||
                    \Elementor\Plugin::instance()->db->is_built_with_elementor(get_the_ID())
            ) {
                self::the_content($echo);
            } else {
                // Load page content
                $tpl = \HQLib\get_post_meta(null, 'single_template');

                if (!empty($tpl) && $tpl != 'default') {
                    if ($tpl != 'noeltmp') {
                        display_elementor_template($tpl, $echo);
                    } else { // Load content if no template
                        self::the_content($echo);
                    }
                } else {
                    $tpl = get_theme_mod('hq_page_elementor_template');
                    if (!empty($tpl) && $tpl != 'noeltmp') {
                        display_elementor_template($tpl, $echo);
                    } else {
                        self::the_content($echo);
                    }
                }
            }
        }
    }

    /**
     * 
     * @since 1.0.0
     * 
     * @param boolean $echo
     */
    protected static function archive_template($echo) {
        global $wp_query;
        $queried_object = $wp_query->get_queried_object();

        if (isset($queried_object->term_id)) { // Is Taxonomy
            $tpl = \HQLib\get_term_meta($queried_object->term_id, 'archive_template');

            if (!empty($tpl) && $tpl != 'default') { // By Taxonomy
                display_elementor_template($tpl, $echo);
            } else { // Arvhive by post type
                $tpl = get_theme_mod('hq_' . get_post_type() . '_archive_layout');
                if (empty($tpl)) {
                    if ($echo) {
                        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        echo \Marmot\set_elementor_template_message('archive', get_post_type());
                    }
                } elseif ($tpl != 'noeltmp') {
                    display_elementor_template($tpl, $echo);
                }
            }
        } else { // Arvhive by post type
            $tpl = get_theme_mod('hq_' . get_post_type() . '_archive_layout');
            if (empty($tpl)) {
                if ($echo) {
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo \Marmot\set_elementor_template_message('archive', get_post_type());
                }
            } elseif (!empty($tpl) && $tpl != 'noeltmp') {
                display_elementor_template($tpl, $echo);
            }
        }
    }

}
