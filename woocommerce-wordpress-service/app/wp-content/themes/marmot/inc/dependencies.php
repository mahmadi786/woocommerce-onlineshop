<?php

namespace Marmot;

defined('ABSPATH') || exit;

class Dependencies {

    /**
     *
     * @var bool
     */
    protected $is_dependencies_met = true;

    /**
     * Required / Recommended Plugins
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public static $plugins = [
        'hqtheme-extra' => [
            'name' => 'HQTheme Extra',
            'file' => 'hqtheme-extra/hqtheme-extra.php',
            'min_version' => '1.0.15',
            'main_class' => '\HQExtra\HQExtra',
            'constant' => '',
            'action' => '',
            'required' => false,
            'dismiss' => true,
        ],
    ];

    /**
     * Current plugin name
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    protected $currnet_plugin_name;

    public function __construct($currnet_plugin_name, $requires_hqtheme = false) {
        $this->currnet_plugin_name = $currnet_plugin_name;
        $this->check_plugins();
        if (!self::is_theme_active()) {
            if ($requires_hqtheme) {
                $this->is_dependencies_met = false;
            }
        }
    }

    public function is_theme_installed() {
        foreach ((array) wp_get_themes() as $theme_dir => $theme) {
            if ('Marmot' === $theme->name || 'Marmot' === $theme->parent_theme) {
                return true;
            }
        }
        return false;
    }

    public static function is_theme_active() {
        $theme = wp_get_theme();

        if ('Marmot' === $theme->name || 'Marmot' === $theme->parent_theme) {
            return true;
        }
        return false;
    }

    public function is_dependencies_met() {
        return $this->is_dependencies_met;
    }

    public function check_plugins() {
        foreach (static::$plugins as $plugin_name => $plugin_data) {
            if (!class_exists($plugin_data['main_class'])) {
                $type = '';
                if ($plugin_data['required']) {
                    $this->is_dependencies_met = false;
                    // Check other plugins only in admin
                    if (!is_admin()) {
                        return;
                    }
                    $type = 'error';
                    /* translators: %s: plugin dependency */
                    $message_template_install = __('<b>%1$s</b> is not working because you need to install <b>%2$s</b> plugin.', 'marmot');
                    /* translators: %s: plugin dependency */
                    $message_template_activate = __('<b>%1$s</b> is not working because you need to activate <b>%2$s</b> plugin.', 'marmot');
                } elseif (is_admin()) {
                    $type = 'info';
                    /* translators: %s: plugin dependency */
                    $message_template_install = __('<b>%1$s</b> recommends to install <b>%2$s</b> plugin.', 'marmot');
                    /* translators: %s: plugin dependency */
                    $message_template_activate = __('<b>%1$s</b> recommends to activate <b>%2$s</b> plugin.', 'marmot');
                }

                if ($type) { // Prepare notifications for Recommendered only in admin
                    if (is_plugin_installed($plugin_data['file'])) {
                        if (!current_user_can('activate_plugins')) {
                            return;
                        }
                        $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin_data['file'] . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin_data['file']);
                        $message = '<p>' . sprintf($message_template_activate, $this->currnet_plugin_name, $plugin_data['name']) . '</p>';
                        $message .= '<p>' . sprintf('<a href="%1$s" class="button-primary">%2$s %3$s</a>', $activation_url, __('Activate', 'marmot'), $plugin_data['name']) . '</p>';
                    } else {
                        if (!current_user_can('install_plugins')) {
                            return;
                        }
                        if (isset($_GET['action']) && $_GET['action'] == 'install-plugin') {
                            return;
                        }
                        $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $plugin_name), 'install-plugin_' . $plugin_name);
                        $message = '<p>' . sprintf($message_template_install, $this->currnet_plugin_name, $plugin_data['name']) . '</p>';
                        $message .= '<p>' . sprintf('<a href="%1$s" class="button-primary">%2$s %3$s</a>', esc_url($install_url), __('Install', 'marmot'), $plugin_data['name']) . '</p>';
                    }
                    // Add notice
                    //Admin_Notifications::instance()->add_notice('plugin_' . $plugin_name, $type, $message, $plugin_data['dismiss']);
                }
            } else {
                // Check min version
                $installed_plugin_version = self::get_installed_plugin_version($plugin_data['file']);
                if (!empty($plugin_data['min_version']) && version_compare($installed_plugin_version, $plugin_data['min_version'], '<')) {
                    $this->is_dependencies_met = false;
                    // Check other plugins only in admin
                    if (!is_admin()) {
                        return;
                    }
                    /* translators: %1$s: current plugin name; %2$s: required plugin name; %3$s: required plugin version */
                    $message_template_update = _x('<b>%1$s</b> is not working because you need to install <b>%2$s minimum version %3$s</b> plugin.', 'plugin dependency', 'marmot');

                    $type = 'error';
                    $update_url = wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=' . $plugin_data['file']), 'upgrade-plugin_' . $plugin_data['file']);

                    $message = '<p>' . sprintf($message_template_update, $this->currnet_plugin_name, $plugin_data['name'], $plugin_data['min_version']) . '</p>';
                    $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s %s</a>', $update_url, _x('Update', 'plugin dependency', 'marmot'), $plugin_data['name']) . '</p>';
                    Admin_Notifications::instance()->add_notice('plugin_' . $plugin_name, $type, $message, $plugin_data['dismiss']);
                }
            }
        }
    }

    public static function get_installed_plugin_version($activation) {
        // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
        require_once (ABSPATH . 'wp-admin/includes/plugin.php');
        $allPlugins = get_plugins();

        if (empty($allPlugins[$activation])) {
            return false;
        }

        return $allPlugins[$activation]['Version'];
    }

}
