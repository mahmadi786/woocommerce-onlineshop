<?php

namespace Marmot\Customizer;

defined('ABSPATH') || exit;

use function Marmot\get_elementor_templates;

/**
 * Contains settings for customizing the theme customization screen.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 * 
 * @since 1.0.0
 */
class Settings {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Settings 
     */
    private static $_instance;

    /**
     * Panels for adding
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public $add_panels;

    /**
     * Panels for removing
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public $remove_panels;

    /**
     * Sections for adding
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public $add_sections;

    /**
     * Sections for removing
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public $remove_sections;

    /**
     * Settings type tansport
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public $transport_settings;

    /**
     * Controls for adding
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public $add_setting_controls;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Settings
     */
    public static function instance() {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Marmot options definitions
     *
     * @since 1.0.0
     */
    private function __construct() {

        $HQCustomize = \Marmot\Customizer::instance();

        // Add filters for no full customization mode settings
        if (!\Marmot\Marmot::is_full_customization_mode()) {
            add_filter('hqt/customizer/setting_controls/add', ['\Marmot\Customizer\Settings', 'no_elementor_customizer_options']);
            add_action('hqt/customizer/setting/done', ['\Marmot\Customizer\Settings', 'no_elementor_customizer_settings_done']);
        }

        // Panels array
        $add_panels = [
            'hq_general_settings' => [
                'title' => _x('Marmot Theme', 'settings', 'marmot'),
                'description' => _x('Site general options.', 'settings', 'marmot'),
                'priority' => 0,
            ],
            'hq_blog_settings' => [
                'title' => _x('Blog / News', 'settings', 'marmot'),
                'priority' => 140,
            ],
        ];
        $remove_panels = [];

        // Sections array
        $add_sections = [
            /* General */
            'hq_theme_mod' => [
                'title' => _x('Full Customozation Mode', 'settings', 'marmot'),
                'panel' => 'hq_general_settings',
            ],
            'hq_layouts' => [
                'title' => _x('Layouts', 'settings', 'marmot'),
                'panel' => 'hq_general_settings',
            ],
            'hq_other' => [
                'title' => _x('Other', 'settings', 'marmot'),
                'panel' => 'hq_general_settings',
            ],
            /* END General */

            /* Blog */
            'hq_blog_home' => [
                'title' => _x('Blog Page', 'settings', 'marmot'),
                'panel' => 'hq_blog_settings',
            ],
            'hq_post_archive' => [
                'title' => _x('Blog Category & Tag', 'settings', 'marmot'),
                'panel' => 'hq_blog_settings',
            ],
            'hq_post_single' => [
                'title' => _x('Single Post Page', 'settings', 'marmot'),
                'panel' => 'hq_blog_settings',
            ],
            /* END Blog */
            /* Woocommerce */
            'hq_woocommerce_general' => [
                'title' => _x('Shop Page', 'settings', 'marmot'),
                'panel' => 'woocommerce',
            ],
            'hq_product_archive' => [
                'title' => _x('Listing', 'settings', 'marmot'),
                'panel' => 'woocommerce',
            ],
            'hq_product_single' => [
                'title' => _x('Product Page', 'settings', 'marmot'),
                'panel' => 'woocommerce',
            ],
                /* END Woocommerce */
        ];

        if (\Marmot\Marmot::is_full_customization_mode()) {
            $remove_sections = [
                'background_image',
                'colors',
            ];
        } else {
            $remove_sections = [];
        }

        // specifies the transport for some options
        $transport_settings = [
            'blogname',
            'blogdescription',
        ];

        $add_setting_controls = [];

        do_action('hqt/customizer/settings/add_setting_controls/start');

        $settings_dir = dirname(__FILE__) . '/settings/';

        // phpcs:disable
        require $settings_dir . 'theme_mod.php';
        require $settings_dir . 'layouts.php';
        require $settings_dir . 'other.php';
        require $settings_dir . 'blog_general.php';
        require $settings_dir . 'blog_archive.php';
        require $settings_dir . 'blog_single.php';

        // WooCommerce
        if (class_exists('\WooCommerce')) {
            // WooCommerce Options
            require $settings_dir . 'woocommerce_general.php';
            require $settings_dir . 'woocommerce_archive.php';
            require $settings_dir . 'woocommerce_single.php';
        }
        // phpcs:enable

        /**
         *  Custom Post fields - PODS
         */
        $custom_pods = \Marmot\Pods::get_custom_post_types('post_type', false);
        foreach ($custom_pods as $custom_pod_key => $custom_pod) {
            // Panel
            $add_panels['hq_' . $custom_pod_key . '_settings'] = [
                'title' => $custom_pod,
                'priority' => 145,
            ];

            // Sections
            $add_sections['hq_' . $custom_pod_key . '_archive'] = [
                'title' => $custom_pod . ' ' . _x('Listing', 'settings', 'marmot'),
                'panel' => 'hq_' . $custom_pod_key . '_settings',
            ];
            $add_sections['hq_' . $custom_pod_key . '_single'] = [
                'title' => $custom_pod . ' ' . _x('Single', 'settings', 'marmot'),
                'panel' => 'hq_' . $custom_pod_key . '_settings',
            ];

            // Settings
            // Archive
            $add_setting_controls = array_merge($add_setting_controls,
                    apply_filters('hqt/customizer/settings/' . $custom_pod_key . '/archive',
                            array_merge(
                                    [
                                        'hq_' . $custom_pod_key . '_archive_layout' => [
                                            'default' => '',
                                            'label' => $custom_pod . ' ' . _x('Archive Layout', 'settings', 'marmot'),
                                            'type' => 'select',
                                            'section' => 'hq_' . $custom_pod_key . '_archive',
                                            'choices' => get_elementor_templates('archive', 0, 1),
                                            'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                        ]
                                    ],
                                    self::generate_layout_templates_controls('hq_' . $custom_pod_key . '_archive', ucfirst($custom_pod_key) . ' ' . _x('Archive', 'cpt settings', 'marmot'))
                            ),
                            $custom_pod_key
                    )
            );

            // Single
            $add_setting_controls = array_merge($add_setting_controls,
                    apply_filters('hqt/customizer/settings/' . $custom_pod_key . '/single',
                            array_merge(
                                    [
                                        'hq_' . $custom_pod_key . '_single_layout' => [
                                            'default' => '',
                                            'label' => $custom_pod . ' ' . _x('Single Layout', 'settings', 'marmot'),
                                            'type' => 'select',
                                            'section' => 'hq_' . $custom_pod_key . '_single',
                                            'choices' => get_elementor_templates('single', 0, 1),
                                            'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                        ]
                                    ],
                                    self::generate_layout_templates_controls('hq_' . $custom_pod_key . '_single', ucfirst($custom_pod_key) . ' ' . _x('Single', 'cpt settings', 'marmot'))
                            ),
                            $custom_pod_key
                    )
            );
        }

        do_action('hqt/customizer/settings/add_setting_controls/end');

        // Panels
        $this->add_panels = apply_filters('hqt/customizer/panels/add', $add_panels);
        $this->remove_panels = apply_filters('hqt/customizer/panels/remove', $remove_panels);

        // Sections
        $this->add_sections = apply_filters('hqt/customizer/sections/add', $add_sections);
        $this->remove_sections = apply_filters('hqt/customizer/sections/remove', $remove_sections);

        // Transport Settings
        $this->transport_settings = apply_filters('hqt/customizer/transport_settings', $transport_settings);
        $this->add_setting_controls = apply_filters('hqt/customizer/setting_controls/add', $add_setting_controls);

        return $this;
    }

    /**
     * Generates configs for section
     * 
     * @since 1.0.0
     * 
     * @param string $section
     * @return array
     */
    public static function generate_layout_templates_controls($section, $page_name) {
        return [
            // Header
            $section . '_header_template' => [
                'default' => 'default',
                'label' => _x('Header Template', 'settings', 'marmot'),
                'control' => 'Marmot\Customizer\Controls',
                'type' => 'pro',
                'section' => $section,
                /* translators: %s: page name in layout controls for header */
                'description' => sprintf(_x('Setup custom header template for %s page.', 'settings', 'marmot'), $page_name),
            ],
            // Footer
            $section . '_footer_template' => [
                'default' => 'default',
                'label' => _x('Footer Template', 'settings', 'marmot'),
                'control' => 'Marmot\Customizer\Controls',
                'type' => 'pro',
                'section' => $section,
                /* translators: %s: page name in layout controls for footer */
                'description' => sprintf(_x('Setup custom footer template for %s page.', 'settings', 'marmot'), $page_name),
            ],
        ];
    }

    /**
     * Check full customization mode and return description for templates field
     * 
     * @since 1.0.0
     * 
     * @param string $type
     * @return string
     */
    public static function full_mode_requires_description($type = '') {
        if (\Marmot\Marmot::is_full_customization_mode()) {
            return self::elementor_tempalates_howto($type);
        }
        /* translators: %1$s is replaced with "one <a> tag" %2$s is replaced with "close </a> tag" */
        return sprintf(_x('Applies only if %1$s Full Customizable Theme Mode%2$s is enabled.',
                        'settings',
                        'marmot'),
                '<a href="' . esc_url(admin_url('/customize.php?autofocus[control]=_hqt_theme_customizable_mode')) . '" data-focus-control="_hqt_theme_customizable_mode">',
                '</a>'
        );
    }

    /**
     * Generate Elementor template description text
     * 
     * @since 1.0.2
     * 
     * @param string $type
     * @return string
     */
    public static function elementor_tempalates_howto($type = '') {
        /* translators: %1$s is replaced with "one <a> tag" %2$s is replaced with "close </a> tag" */
        return sprintf(_x('Before choosing template, you have to create it %1$shere%2$s.(New templates will appear after refresh.)',
                        'settings',
                        'marmot'),
                '<a target="_blank" href="' . esc_url(admin_url('/edit.php?post_type=elementor_library&tabs_group=library&elementor_library_type=' . $type)) . '">',
                '</a>'
        );
    }

    /**
     * Add controls is theme is not in full customization mode
     * 
     * @since 1.0.7
     * 
     * @param array $add_setting_controls
     * @return array
     */
    public static function no_elementor_customizer_options($add_setting_controls) {
        return array_merge($add_setting_controls,
                apply_filters('hqt/customizer/no_elementor_options',
                        [
                            'hq_header_banner' => [
                                'default' => 'frontpage',
                                'label' => _x('Banner', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'header_image',
                                'choices' => [
                                    'frontpage' => _x('Homepage / Frontpage', 'settings', 'marmot'),
                                    'entire-site' => _x('Entire site', 'settings', 'marmot'),
                                    'disable' => _x('Disable', 'settings', 'marmot'),
                                ],
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                            ],
                            'hq_header_banner_heading_text' => [
                                'default' => _x('Welcome', 'settings', 'marmot'),
                                'label' => _x('Banner Heading Text', 'settings', 'marmot'),
                                'type' => 'text',
                                'section' => 'header_image',
                                'sanitize_callback' => 'wp_kses_post',
                            ],
                            'hq_header_banner_text' => [
                                'default' => _x('Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.', 'settings', 'marmot'),
                                'label' => _x('Banner Text', 'settings', 'marmot'),
                                'type' => 'text',
                                'section' => 'header_image',
                                'sanitize_callback' => 'wp_kses_post',
                            ],
                            'hq_header_banner_button_text' => [
                                'default' => _x('Learn more', 'settings', 'marmot'),
                                'label' => _x('Banner Button Text', 'settings', 'marmot'),
                                'type' => 'text',
                                'section' => 'header_image',
                                'sanitize_callback' => 'wp_kses_post',
                            ],
                            'hq_header_banner_button_url' => [
                                'default' => '',
                                'label' => _x('Banner Button URL', 'settings', 'marmot'),
                                'type' => 'text',
                                'section' => 'header_image',
                                'sanitize_callback' => 'esc_url_raw',
                            ],
                            /*
                            'header_background' => [
                                'default' => '#fff',
                                'label' => _x('Header Background Color ', 'settings', 'marmot'),
                                'type' => 'color',
                                'section' => 'colors',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ],
                            */
                        ]
                )
        );
    }

    /**
     * Add some changes on customizer settings
     * 
     * @since 1.0.7
     * 
     * @param \WP_Customize_Manager $wp_customize
     */
    public static function no_elementor_customizer_settings_done($wp_customize) {
        $wp_customize->get_section('header_image')->description = sprintf(
                /* translators: %1$s: a tag open with link to customizer control for full customization; %2$s: a tag close */
                esc_html_x('Header image section is available only if %1$sFull Customization mode%2$s is not activated.', 'settings', 'marmot'),
                '<a href="' . esc_url(admin_url('/customize.php?autofocus[control]=_hqt_theme_customizable_mode')) . '" data-focus-control="_hqt_theme_customizable_mode">',
                '</a>');
    }

}
