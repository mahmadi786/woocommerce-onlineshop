<?php

namespace Marmot;

defined('ABSPATH') || exit;

/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 * 
 * @since 1.0.0
 */
class Customizer {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Customizer 
     */
    private static $_instance;

    /**
     * CSS File name
     * 
     * @since 1.0.0
     */
    const THEME_CSS_FILE_NAME = 'hqt-global-css';

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Customizer
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
        self::$_instance = &$this;

        if (Marmot::is_debug()) {
            self::generate_global_css();
        }

        // Setup the Theme Customizer settings and controls...
        add_action('customize_register', ['\Marmot\Customizer', 'register'], 999);

        // Styles
        add_action('customize_controls_print_styles', [$this, 'customize_controls_print_styles']);

        add_action('customize_save_after', [$this, 'customize_save_after']);

        // Theme CSS Generate & Enqueue
        add_action('wp_enqueue_scripts', [$this, 'wp_enqueue_styles']);
        add_action('customize_controls_enqueue_scripts', [$this, 'customize_controls_enqueue_scripts']);
        // On clear cache
        add_action('elementor/core/files/clear_cache', ['Marmot\Customizer', 'generate_global_css']);
    }

    /**
     * Enqueue Styles
     * 
     * @since 1.0.0
     */
    public function wp_enqueue_styles() {
        if (\Marmot\Marmot::is_full_customization_mode()) {
            $global_css_data_rand = get_option('_hqt_global_css_data', '');
            if ($global_css_data_rand) {
                wp_enqueue_style(THEME_SLUG, Marmot::get_base_uploads_url() . self::THEME_CSS_FILE_NAME . '.css', false, $global_css_data_rand);
            } else {

                $global_css_data_rand = self::generate_global_css();

                if (false !== $global_css_data_rand) {
                    wp_enqueue_style(THEME_SLUG, Marmot::get_base_uploads_url() . self::THEME_CSS_FILE_NAME . '.css', false, $global_css_data_rand);
                }
            }
        } else {
            wp_enqueue_style(THEME_SLUG, MARMOT_THEME_URL . '/assets/css/no-elementor.css', false, THEME_VERSION);
            
            $style_url = apply_filters('hqt/no_elementor/custom_style_url', MARMOT_THEME_URL . '/assets/css/no-elementor-customizations.css');
            if ($style_url) {
                wp_enqueue_style(THEME_SLUG . '-customizations', $style_url, false, THEME_VERSION);
            }
        }
    }

    /**
     * Enqueues scripts for customizer settings.
     *
     * @return void
     */
    public function customize_controls_enqueue_scripts() {
        wp_enqueue_script(THEME_SLUG . '-customize', MARMOT_THEME_URL . '/assets/js/customize.js', array('jquery', 'customize-preview'), THEME_VERSION, true);
    }

    /**
     * Generate global css
     * 
     * @param bool $save Save in file
     * @return array
     */
    public static function generate_global_css($save = true) {

        if (!class_exists('\HQExtra\HQExtra') || false === $fs = \HQExtra\Filesystem::instance()) {
            return false;
        }

        $data = [];

        // Add reset css in global preset
        $data['css'] = Customizer::compileSCSS($fs);
        $data['rand'] = mt_rand(1000, 9999);

        if ($save) {
            $fs->put_contents(Marmot::get_base_uploads_dir() . self::THEME_CSS_FILE_NAME . '.css', $data['css']);
            update_option('_hqt_global_css_data', $data['rand']);
        }

        return $data['rand'];
    }

    /**
     * Set defaults
     * 
     * @since 1.0.0
     */
    public function customize_save_after() {
        $this->setDefauls();
        self::generate_global_css();
        //$this->clean_old_options();
    }

    /**
     * Clear old customizer options from old devs
     * 
     * @since 1.0.0
     */
    protected function clean_old_options() {
        $mods = get_theme_mods();

        $setting_controls = Customizer\Settings::instance()->add_setting_controls;
        foreach ($setting_controls as $controlKey => $control) {
            if (isset($mods[$controlKey])) {
                unset($mods[$controlKey]);
            }
        }

        foreach ($mods as $mod_key => $mod) {
            if (in_array($mod_key, [
                        'nav_menu_locations',
                        'custom_css_post_id',
                        'custom_logo',
                    ])) {
                continue;
            }
            remove_theme_mod($mod_key);
        }
    }

    /**
     * Compile Theme Main CSS
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public static function compileSCSS(\HQExtra\Filesystem $filesystem) {
        // Prepare dir
        $upload_dir = Marmot::get_base_uploads_dir();
        $SCSS_cache_dir = $upload_dir . 'scss_cache';
        if (!is_dir($SCSS_cache_dir)) {
            wp_mkdir_p($SCSS_cache_dir);
        }

        // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
        require MARMOT_THEME_DIR . 'lib/scssphp/scss.inc.php';
        $scss = new \ScssPhp\ScssPhp\Compiler([
            'cacheDir' => $SCSS_cache_dir,
            'forceRefresh' => true,
        ]);
        $scss->setImportPaths(MARMOT_THEME_DIR . 'assets/scss/');

        $variables = [
            'content_width' => (empty(get_option('elementor_container_width', 1140)) ? 1140 : get_option('elementor_container_width', 1140)) . 'px',
            // Responsive widths
            'mobile_width' => '480px', // ??
            'tablet_width' => (empty(get_option('elementor_viewport_md', 768)) ? 768 : get_option('elementor_viewport_md', 768)) . 'px',
            'desktop_width' => (empty(get_option('elementor_viewport_lg', 1025)) ? 1025 : get_option('elementor_viewport_lg', 1025)) . 'px',
        ];

        $scss->setVariables($variables);

        $css = $scss->compile($filesystem->get_contents(MARMOT_THEME_DIR . 'assets/scss/style.scss'));

        return $css;
    }

    /**
     * Sets theme default mods
     * 
     * @since 1.0.0
     */
    public function setDefauls() {
        $mods = get_theme_mods();

        $setting_controls = Customizer\Settings::instance()->add_setting_controls;
        foreach ($setting_controls as $controlKey => $control) {
            if (isset($mods[$controlKey]) || (isset($control['type']) && in_array($control['type'], ['hr', 'sub-title', 'link', 'button', 'description', 'warning']))) { // Check if there is value already
                continue;
            }
            set_theme_mod($controlKey, isset($control['default']) ? $control['default'] : '');
        }
    }

    /**
     * This hooks into 'customize_register' (available as of WP 3.4) and allows
     * you to add new sections and controls to the Theme Customize screen.
     *
     * Note: To enable instant preview, we have to actually write a bit of custom
     * javascript. See live_preview() for more.
     *
     * @see add_action('customize_register',$func)
     * @param \WP_Customize_Manager $wp_customize
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/
     * @since 1.0.0
     */
    public static function register(\WP_Customize_Manager $wp_customize) {
        $priority = 1;
        foreach (Customizer\Settings::instance()->add_panels as $panelKey => $panel) {
            $panelOptions = [
                'title' => $panel['title'],
                'description' => isset($panel['description']) ? $panel['description'] : '',
                'priority' => isset($panel['priority']) ? $panel['priority'] : $priority++,
            ];

            $wp_customize->add_panel($panelKey, $panelOptions);
        }
        foreach (Customizer\Settings::instance()->remove_panels as $panel) {
            $wp_customize->remove_panel($panel);
        }

        $priority = 0;
        foreach (Customizer\Settings::instance()->add_sections as $sectionKey => $section) {
            $sectionOptions = [
                'title' => $section['title'], // Visible title of section
                'capability' => 'edit_theme_options', //Capability needed to tweak
                'panel' => isset($section['panel']) ? $section['panel'] : '',
                'priority' => isset($section['priority']) ? $section['priority'] : $priority++,
                'sidebar_id' => 'custom-sidebar-mainsidebar',
            ];

            if (isset($section['description'])) {
                $sectionOptions['description'] = $section['description']; //Descriptive tooltip
            }

            if (!isset($section['section'])) {
                $wp_customize->add_section($sectionKey, $sectionOptions);
            }
        }
        foreach (Customizer\Settings::instance()->remove_sections as $section) {
            $wp_customize->remove_section($section);
        }

        $priority = 0;
        foreach (Customizer\Settings::instance()->add_setting_controls as $controlKey => $control) {
            $wp_customize->add_setting(
                    "$controlKey",
                    [
                        'control_type' => $control['type'],
                        'default' => isset($control['default']) ? $control['default'] : '',
                        'type' => isset($control['customize_setting_type']) ? $control['customize_setting_type'] : 'theme_mod',
                        'capability' => isset($control['capability']) ? $control['capability'] : 'edit_theme_options',
                        'transport' => isset($control['transport']) ? $control['transport'] : 'refresh',
                        'selectors' => isset($control['selectors']) ? $control['selectors'] : '',
                        'style_callback' => isset($control['style_callback']) ? $control['style_callback'] : null,
                        'post_js' => isset($control['transport']) ? $control['transport'] : '',
                        'sanitize_callback' => isset($control['sanitize_callback']) ? $control['sanitize_callback'] : 'sanitize_text_field'
                    ]
            );

            $control_args = [
                'label' => isset($control['label']) ? $control['label'] : '',
                'section' => $control['section'],
                'settings' => $controlKey,
                'priority' => isset($control['priority']) ? $control['priority'] : $priority++,
                'choices' => isset($control['choices']) ? $control['choices'] : [],
                'description' => isset($control['description']) ? $control['description'] : '',
                'subcontrols' => isset($control['subcontrols']) ? $control['subcontrols'] : [],
                'url' => isset($control['url']) ? $control['url'] : [],
                'type' => isset($control['type']) ? $control['type'] : null,
                'transport' => isset($control['transport']) ? $control['transport'] : 'refresh',
            ];

            if (!isset($control['control'])) {
                $wp_customize->add_control($controlKey, $control_args);
            } else {
                $wp_customize->add_control(new $control['control']($wp_customize, $controlKey, $control_args));
            }
        }

        foreach (Customizer\Settings::instance()->transport_settings as $transportSetting) {
            // We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
            $wp_customize->get_setting($transportSetting)->transport = 'postMessage';
        }

        do_action('hqt/customizer/setting/done', $wp_customize);
    }

    /**
     * Load styles for customizer styles
     * 
     * @since 1.0.0
     */
    public static function customize_controls_print_styles() {
        // Main customizer
        wp_register_style(THEME_SLUG . '-customizer', MARMOT_THEME_URL . '/assets/css/admin/customizer.css', [], THEME_VERSION, 'all');
        wp_enqueue_style(THEME_SLUG . '-customizer');

        $mobile_width = intval(get_theme_mod('elementor_viewport_md', 768));
        $mobile_margin_left = -($mobile_width / 2) . 'px'; //Half of -$mobile_width

        $tablet_width = intval(get_theme_mod('elementor_viewport_lg', 1025));
        $tablet_margin_left = -($tablet_width / 2) . 'px'; //Half of -$tablet_width
        // phpcs:disable
        echo sprintf('<style>
            .wp-customizer .preview-mobile .wp-full-overlay-main {
                margin-left: %1$s;
                width: %2$s;
                height: %3$spx;
            }

            .wp-customizer .preview-tablet .wp-full-overlay-main {
                margin-left: %4$s;
                width: %5$spx;
                height: %6$spx;
            }
        </style>',
                $mobile_margin_left, $mobile_width, $mobile_width,
                $tablet_margin_left, $tablet_width, $tablet_width);
        // phpcs:enable
    }

    /**
     * adds sanitization callback funtion : number
     */
    public static function sanitize_number($value) {
        $value = esc_attr($value); // clean input
        $value = (int) $value; // Force the value into integer type.
        return (0 < $value) ? $value : null;
    }

    /**
     * Select sanitization callback
     * 
     * https://divpusher.com/blog/wordpress-customizer-sanitization-examples/
     *
     * @since 1.0.0
     */
    public static function sanitize_select($input, $setting) {
        // Ensure input is a slug.
        $input = sanitize_key($input);

        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control($setting->id)->choices;

        // If the input is a valid key, return it; otherwise, return the default.
        return ( array_key_exists($input, $choices) ? $input : $setting->default );
    }

    /**
     * Checkbox sanitization callback
     * 
     * https://divpusher.com/blog/wordpress-customizer-sanitization-examples/
     *
     * @since 1.0.0
     */
    function sanitize_checkbox($input) {

        //returns true if checkbox is checked
        return ( isset($input) ? true : false );
    }

    /**
     * Check for required plugins for full customization mode and generate install and activate buttons
     * 
     * @since 1.1.0
     * 
     * @return string
     */
    public static function required_plugins_for_full_customozation_mode() {

        $required_plugins_for_full_customozation_mode = '';
        // Check  for HQTheme Extra
        if (!defined('\HQExtra\VERSION')) {
            if (!is_plugin_installed('hqtheme-extra/hqtheme-extra.php')) {
                $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=hqtheme-extra'), 'install-plugin_hqtheme-extra');
                /* translators: %s: plugin name "HQTheme Extra" */
                $required_plugins_for_full_customozation_mode .= '<p><a target="_blank" class="button new" href="' . esc_attr($install_url) . '">' . sprintf(_x('Install "%s" plugin', 'settings', 'marmot'), 'HQTheme Extra') . '</a></p>';
            } else {
                $activate_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . 'hqtheme-extra/hqtheme-extra.php' . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . 'hqtheme-extra/hqtheme-extra.php');
                /* translators: %s: plugin name "HQTheme Extra" */
                $required_plugins_for_full_customozation_mode .= '<p><a target="_blank" class="button new" href="' . esc_attr($activate_url) . '">' . sprintf(_x('Activate "%s" plugin', 'settings', 'marmot'), 'HQTheme Extra') . '</a></p>';
            }
        }

        // Check for Elementor
        if (!defined('\ELEMENTOR_VERSION')) {
            if (!is_plugin_installed('elementor/elementor.php')) {
                $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
                /* translators: %s: plugin name "Elementor" */
                $required_plugins_for_full_customozation_mode .= '<p><a target="_blank" class="button new" href="' . esc_attr($install_url) . '">' . sprintf(_x('Install "%s" plugin', 'settings', 'marmot'), 'Elementor') . '</a></p>';
            } else {
                $activate_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . 'elementor/elementor.php' . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . 'elementor/elementor.php');
                /* translators: %s: plugin name "Elementor" */
                $required_plugins_for_full_customozation_mode .= '<p><a target="_blank" class="button new" href="' . esc_attr($activate_url) . '">' . sprintf(_x('Activate "%s" plugin', 'settings', 'marmot'), 'Elementor') . '</a></p>';
            }
        }

        // Add notice
        if (!empty($required_plugins_for_full_customozation_mode)) {
            $required_plugins_for_full_customozation_mode .= ' <p>' . _x('Customizer refresh is required after plugins activation!', 'settings', 'marmot') . '</p>';
        }

        return $required_plugins_for_full_customozation_mode;
    }

}
