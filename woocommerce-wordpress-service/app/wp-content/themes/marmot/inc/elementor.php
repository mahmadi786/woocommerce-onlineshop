<?php

namespace Marmot;

defined('ABSPATH') || exit;

const SAVED_TEMPLATES_CACHE_KEY = \Marmot\THEME_SLUG . '_saved_templates';
const CHOOSE_TEMPLATES_CACHE_KEY = \Marmot\THEME_SLUG . '_choosetemplate';
const BUILDER_CONTENT_FOR_DISPLAY_CACHE_KEY = \Marmot\THEME_SLUG . '_content_for_display';

use Elementor\Core\Responsive\Responsive as Elementor_Resposive;

/**
 * Elementor
 * 
 * Integrates Marmot with Elementor Page Builder
 * 
 * @since 1.0.0
 */
class Elementor {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Elementor 
     */
    private static $_instance = null;

    /**
     * Cache data
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public static $data;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Elementor
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
        if (!class_exists('\Elementor\Plugin')) {
            return;
        }
        add_action('elementor/init', [$this, 'elementor_init']);

        Elementor\Templates_Types_Manager::instance();

        add_filter('template_include', [$this, 'template_include'], 15/* After Plugins/Elementor */);

        // List all taxononies - dynamic tags
        add_filter('elementor_pro/dynamic_tags/post_terms/taxonomy_args', [$this, 'filter_post_terms_taxonomy_arg']);

        // Force schemes on
        add_action('elementor/schemes/enabled_schemes', [$this, 'enabled_schemes']);

        add_action('elementor/editor/after_enqueue_styles', [$this, 'editor_styles']);

        // Prepare styles
        add_action('wp_enqueue_scripts', [Parts\Layout::instance(), 'enqueue_styles'], 9900);
    }

    public function elementor_init() {
// On change resolutins
        foreach (Elementor_Resposive::get_editable_breakpoints() as $breakpoint_key => $breakpoint) {
            foreach (['add', 'update'] as $action) {
                add_action("{$action}_option_elementor_viewport_{$breakpoint_key}", ['Marmot\Customizer', 'generate_global_css']);
            }
        }
    }

    public function enabled_schemes($enabled_schemes) {
        $enabled_schemes[] = 'color';
        $enabled_schemes[] = 'typography';
        return $enabled_schemes;
    }

    public function editor_styles() {
        wp_enqueue_style(THEME_SLUG . '-elementor-editor', MARMOT_THEME_URL . '/assets/css/admin/elementor-editor.css', '', THEME_VERSION);
    }

    /**
     * Change template for special Elementor elementor_types
     * 
     * @since 1.0.0
     * 
     * @param string $template
     * @return string
     */
    public function template_include($template) {
        if (
                class_exists('\Elementor\Plugin') &&
                \Elementor\Plugin::$instance->preview->is_preview_mode()
        ) {
            $elementor_type = get_post_meta(get_the_ID(), '_elementor_template_type');
            if (!empty($elementor_type[0]) && in_array($elementor_type[0], ['header', 'footer', 'sidebar', 'section'])) {
                $a = new \Elementor\Modules\PageTemplates\Module;
                $template = $a->get_template_path(\Elementor\Modules\PageTemplates\Module::TEMPLATE_CANVAS);
            }
        }

        return $template;
    }

    /**
     * Remove object_type filter for taxonomies
     * 
     * @since 1.0.0
     * 
     * @param array $taxonomy_args
     * @return array
     */
    public function filter_post_terms_taxonomy_arg($taxonomy_args) {
        if (
                class_exists('\Elementor\Plugin') &&
                \Elementor\Plugin::$instance->editor->is_edit_mode()
        ) {
// Show all taxonomies
            unset($taxonomy_args['object_type']);
        }

        return $taxonomy_args;
    }

}

/**
 * Returns Elementor templates by type
 * 
 * @since 1.0.0
 * 
 * @param string $type
 * @param bool $add_default_option
 * @param bool $add_allow_empty_option
 * @return array
 */
function get_elementor_templates($type, $add_default_option = false, $add_allow_empty_option = false) {
    $cache_key = SAVED_TEMPLATES_CACHE_KEY . '_' . $type . '_' . $add_default_option;

    if (isset(Elementor::$data[$cache_key])) {
        return Elementor::$data[$cache_key];
    }

// Load templates
// TODO Load all template types at first call
    $args = [
        'post_type' => 'elementor_library',
        // phpcs:ignore WPThemeReview.CoreFunctionality.PostsPerPage.posts_per_page_posts_per_page
        'posts_per_page' => -1,
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => '_elementor_template_type',
                'value' => $type,
                'compare' => '==',
                'type' => 'post',
            ],
        ],
    ];

    $templatesRaw = new \WP_Query(
            $args
    );

    $templates = [];

    if ($add_allow_empty_option) {
        $templates[''] = '';
    }

    if ($add_default_option) {
        $templates['default'] = __('Default', 'marmot');
    }

    $templates['noeltmp'] = __('No Template', 'marmot');


    if ($templatesRaw->have_posts()) {
        while ($templatesRaw->have_posts()) {
            $templatesRaw->the_post();
            $templates[get_the_ID()] = get_the_title();
        }
        wp_reset_postdata();
    }
    Elementor::$data[$cache_key] = $templates;

    return $templates;
}

/**
 * Displays elementor template by id
 * 
 * @since 1.0.0
 * 
 * @param int $template_id
 * @param bool $echo
 */
function display_elementor_template($template_id, $echo = true) {
    if (empty($template_id)) {
        return;
    }

    /**
     * Filter suitable for translation templates
     */
    $template_id = apply_filters('hqt/elementor/display/template/id', $template_id);

    $cache_key = BUILDER_CONTENT_FOR_DISPLAY_CACHE_KEY . '_' . $template_id;

    if (empty(Elementor::$data[$cache_key])) {
        ob_start();

        if (class_exists('\Elementor\Plugin') && is_callable('Elementor\Plugin::instance')) {
            $elementor_instance = \Elementor\Plugin::instance();
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo $elementor_instance->frontend->get_builder_content_for_display($template_id);
        }

        Elementor::$data[$cache_key] = ob_get_clean();
    }

    if ($echo) {
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo Elementor::$data[$cache_key];
        unset(Elementor::$data[$cache_key]);
    }
}

/**
 * Displays the_content
 * 
 * @since 1.0.0
 * 
 * @param bool $echo
 */
function display_the_content($echo = true) {
    $id = get_the_ID();
    $cache_key = BUILDER_CONTENT_FOR_DISPLAY_CACHE_KEY . '_the_content_' . $id;

    if (!isset(Elementor::$data[$cache_key])) {
        ob_start();

        the_content();

        Elementor::$data[$cache_key] = ob_get_clean();
    }

    if ($echo) {
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo Elementor::$data[$cache_key];
        unset(Elementor::$data[$cache_key]);
    }
}

/**
 * Calculate and display template
 * 
 * @since 1.0.0
 * 
 * @param string $position
 * @param sting $main_template
 * @param bool $echo
 */
function choose_and_display_elementor_template($position, $main_template, $echo = true) {
    $template_id = choose_elementor_template($position, $main_template);

    if (empty($template_id)) {
        if ($echo) {
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo set_elementor_template_message($position);
        }
    } elseif ($template_id != 'noeltmp') {
        display_elementor_template($template_id, $echo);
    }
}

/**
 * Choose parameter based on current page
 * Function is used for choosing template and template position through choose_elementor_sidebar_position
 * 
 * @since 1.0.0
 * 
 * @global \WP_Query $wp_query
 * @param string $position
 * @param string $main_template
 * @return int/string
 */
function choose_elementor_template($position, $main_template) {

    $cache_key = CHOOSE_TEMPLATES_CACHE_KEY . '_' . $position . '_' . $main_template;

// Check for cached
    if (isset(Elementor::$data[$cache_key])) {
        return Elementor::$data[$cache_key];
    }

    $post_type = get_post_type();

    $templates = [
        'general' => $main_template,
        'blog-home' => 'hq_blog_home_' . $position . '_template',
        'post-archive' => 'hq_' . $post_type . '_archive_' . $position . '_template',
        'post-single' => 'hq_' . $post_type . '_single_' . $position . '_template',
        'shop-home' => 'hq_woocommerce_general_' . $position . '_template',
        'position_name' => $position . '_template',
    ];

// Get General
    $tpl = get_theme_mod($templates['general']);
    if (function_exists('is_shop') && (is_shop())) { // Shop
        $rawtpl = get_theme_mod($templates['shop-home']);
        if (!empty($rawtpl) && $rawtpl != 'default') { // Shop Home
            $tpl = $rawtpl;
        } else { // Load archive if other are empty
            $rawtpl = get_theme_mod($templates['post-archive']);
            if (!empty($rawtpl) && $rawtpl != 'default') { // Shop Archive
                $tpl = $rawtpl;
            }
        }
    } elseif (is_home()) {  // Blog
        $rawtpl = get_theme_mod($templates['blog-home']);
        if (!empty($rawtpl) && $rawtpl != 'default') { // Blog Home
            $tpl = $rawtpl;
        } else {
            $rawtpl = get_theme_mod($templates['post-archive']);
            if (!empty($rawtpl) && $rawtpl != 'default') { // Blog Archive
                $tpl = $rawtpl;
            }
        }
    } elseif (is_archive()) { // Archives - Load by taxonomy, if not set load archive
        global $wp_query;
        $term = $wp_query->get_queried_object();
        $archiveLoaded = 0;
        if (isset($term->term_id)) {
            $rawtpl = \HQLib\get_term_meta($term->term_id, 'archive_' . $templates['position_name']);
            if (!empty($rawtpl) && $rawtpl != 'default') {
                $tpl = $rawtpl;
                $archiveLoaded = 1;
            }
        }
// TODO - add author themlate
        if (!$archiveLoaded) { // Load archive template
            $rawtpl = get_theme_mod($templates['post-archive']);
            if (!empty($rawtpl) && $rawtpl != 'default') {
                $tpl = $rawtpl;
            }
        }
    } elseif (is_singular()) { // Single - Load template for all posts
        $rawtpl = \HQLib\get_post_meta(null, 'singular_' . $templates['position_name']);
        if (!empty($rawtpl) && $rawtpl != 'default') { // Per post
            $tpl = $rawtpl;
        } else { // By post type
            $rawtpl = get_theme_mod($templates['post-single']);
            if (!empty($rawtpl) && $rawtpl != 'default') {
                $tpl = $rawtpl;
            }
        }
    }

    $tpl = apply_filters('hqt/elementor/template/choose/' . $post_type . '/' . $position, $tpl);

    Elementor::$data[$cache_key] = $tpl;

    return $tpl;
}

/**
 * Return template creation/setup instructions
 * 
 * @since 1.0.0
 * 
 * @param string $position
 * @param string $post_type
 * @return string
 */
function set_elementor_template_message($position, $post_type = '') {
    $possition_name = '';
    $template_type = '';
    $how_to_link = '/documentation/';

    switch ($position) {
        case 'header':
            $possition_name = __('Header', 'marmot');
            $template_type = 'header';
            $how_to_link = '/documentation/how-to-create-and-attach-header/';
            break;
        case 'footer':
            $possition_name = __('Footer', 'marmot');
            $template_type = 'footer';
            $how_to_link = '/documentation/how-to-create-and-attach-footer/';
            break;
        case 'blog-home':
            $possition_name = __('Blog Home', 'marmot');
            $template_type = 'archive';
            $how_to_link = '/documentation/how-to-create-blog-archive/';
            break;
        case 'single':
            $possition_name = ucfirst($post_type) . ' ' . __('Single', 'marmot');
            $template_type = 'single';
            if ('post' === $post_type) {
                $how_to_link = '/documentation/how-to-create-single-post/';
            } else { // Custom post type
                $how_to_link = '/documentation/create-archive-and-single-page-templates-for-custom-post-type/';
            }
            break;
        case 'archive':
            $possition_name = ucfirst($post_type) . ' ' . __('Archive', 'marmot');
            $template_type = 'archive';
            if ('post' === $post_type) {
                $how_to_link = '/documentation/how-to-create-blog-archive/';
            } else { // Custom post type
                $how_to_link = '/documentation/create-archive-and-single-page-templates-for-custom-post-type/';
            }
            break;

        default:
            break;
    }
    if (empty($template_type)) {
        return;
    }
    ob_start();
    ?>
    <div style="
         max-width: 500px; 
         margin: 0 auto 2em auto;
         padding: 1em;
         box-shadow: 0 0 25px #f1f1f1;
         text-align: center;">
        <h4><?php
            /* translators: %s: template name for missing template message */
            echo esc_html(sprintf(_x('Missing %s Template', 'set template message', 'marmot'), '<i>"' . $possition_name . '"</i>'));
            ?></h4>
        <p>
            <a href="<?php echo esc_url(admin_url('admin.php?page=marmot-theme-templates')); ?>" 
               target="_blank"
               style="
               display: inline-block;
               color: #2196F3;
               text-align: center;
               margin: 10px;
               border-radius: 4px;
               text-decoration: none;
               border: solid 1px;
               padding: 7px 17px;"><?php echo esc_html_x('Setup your templates here!', 'set template message', 'marmot'); ?></a>
        </p>
    </div>
    <?php
    return ob_get_clean();
}
