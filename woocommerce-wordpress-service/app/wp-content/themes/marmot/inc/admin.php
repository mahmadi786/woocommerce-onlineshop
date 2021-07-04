<?php

namespace Marmot;

defined('ABSPATH') || exit;

class Admin {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Admin 
     */
    private static $_instance = null;
    protected static $included_premium_plugins;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Admin
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
        add_action('admin_menu', [$this, 'setup_menu']);

        // phpcs:ignore
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);

        // Init demos and imports
        if (class_exists('\HQExtra\HQExtra')) {
            \HQExtra\Demos\Ui::instance();
        }

        if (current_user_can('edit_theme_options')) {
            $this->welcome_notification();
            $this->installation_setup_notifications();
        }
        $this->set_included_premium_plugins();
    }

    private function set_included_premium_plugins() {
        self::$included_premium_plugins = [
            'marmot-enhancer-pro' => [
                'name' => 'Marmot Enhancer PRO',
                'logo_url' => MARMOT_THEME_URL . '/assets/images/admin/logo-marmot-enhancer-pro.png',
                'description' => _x('Import awesome templates with a click, create stunning popups, attach custom headers and footers on each page, use advanced widgets for Elementor with Dynamic Tags, create unique WooCommerce checkout flow and more, and more...', 'admin', 'marmot'),
                'init' => 'marmot-enhancer-pro/marmot-enhancer-pro.php',
                'constant' => '\HQPro\VERSION',
            ],
            'bdthemes-element-pack' => [
                'name' => 'ElementPack PRO',
                'logo_url' => MARMOT_THEME_URL . '/assets/images/admin/logo-element-pack.png',
                'description' => _x('Incredibly advanced, and super-flexible widgets, and A to Z essential addons to the Elementor Page Builder for WordPress.', 'admin', 'marmot'),
                'init' => 'bdthemes-element-pack/bdthemes-element-pack.php',
                'constant' => '\BDTEP_VER',
            ],
            'revslider' => [
                'name' => 'Slider Revolution',
                'logo_url' => MARMOT_THEME_URL . '/assets/images/admin/logo-slider-revolution.png',
                'description' => _x('Slider Revolution is more than just a WordPress slider. It helps beginner-and mid-level designers WOW their clients with pro-level visuals.', 'admin', 'marmot'),
                'init' => 'revslider/revslider.php',
                'constant' => '\RS_REVISION',
            ],
            'layerslider' => [
                'name' => 'LayerSlider',
                'logo_url' => MARMOT_THEME_URL . '/assets/images/admin/logo-layer-slider.png',
                'description' => _x('Premium multi-purpose animation platform. Sliders, image galleries, slideshows with mind-blowing effects.', 'admin', 'marmot'),
                'init' => 'LayerSlider/layerslider.php',
                'constant' => '\LS_MINIMUM_PHP_VERSION',
            ],
        ];
    }

    public function get_included_premium_plugins() {
        return self::$included_premium_plugins;
    }

    /**
     * Control admin installation and setup notices
     * 
     * @since 1.0.0
     */
    private function welcome_notification() {

        // phpcs:ignore
        if (isset($_GET['marmot-complete-welcome']) && $_GET['marmot-complete-welcome']) {
            set_theme_mod('marmot_welcome_hide', 1);
        }

        $setup_hide = get_theme_mod('marmot_welcome_hide', 0);

        // Show only if not hidden
        if ($setup_hide) {
            return;
        }

        // Do not show notice on setup page
        if (isset($_GET['page']) && in_array($_GET['page'], [THEME_SLUG, THEME_SLUG . '-theme-setup'])) {
            return;
        }

        if (defined('\HQExtra\VERSION')) {
            $dashboard_link = admin_url('admin.php?page=marmot');
        } else {
            $dashboard_link = admin_url('themes.php?page=marmot');
        }

        ob_start();
// phpcs:disable
        ?>
        <h3 class="p-0 mt-2 mb-0"><?php _ex('Welcome to Marmot Theme.', 'admin', 'marmot'); ?></h3>
        <p>
            <?php _ex('Marmot theme needs some plugins and setup to use all features.', 'admin', 'marmot'); ?><br>
            <?php _ex('Do not worry. It is very easy!', 'admin', 'marmot'); ?><br>
            <?php _ex('Just go to our dashboard page and flow the steps.', 'admin', 'marmot'); ?><br>
            <?php _ex('Your site will be ready in a couple of minutes.', 'admin', 'marmot'); ?>
        </p>
        <p>
            <a href="<?php echo esc_url($dashboard_link); ?>" class="button button-primary mr-1"><?php _ex('Marmot Dashboard', 'admin', 'marmot'); ?></a>
            <a href="<?php echo add_query_arg(['marmot-complete-welcome' => 1]); ?>"><?php _ex('Thanks! I do not need help for setup.', 'admin', 'marmot'); ?></a>
        </p>
        <?php
// phpcs:enable
        $message = ob_get_clean();
        Admin_Notifications::instance()->add_notice('marmot_theme_setup', 'info', $message, 1);
    }

    /**
     * Control admin installation and setup notices
     * 
     * @since 1.0.0
     */
    private function installation_setup_notifications() {

        if (!defined('\HQExtra\VERSION')) {
            return;
        }

        // phpcs:ignore
        if (isset($_GET['marmot-complete-setup']) && $_GET['marmot-complete-setup']) {
            set_theme_mod('marmot_setup', 0);
        }

        if (!get_theme_mod('marmot_setup', 0)) {
            return;
        }

        // Do not show notice on setup page
        if (isset($_GET['page']) && in_array($_GET['page'], [THEME_SLUG, THEME_SLUG . '-theme-setup', THEME_SLUG . '-ready-sites'])) {
            return;
        }

        ob_start();
        // phpcs:disable
        ?>
        <h3 class="p-0 mt-2 mb-0"><?php _ex('Marmot Theme requires some plugins and setup to use all features.', 'admin', 'marmot'); ?></h3>
        <p>
            <?php _ex('Do not worry. It is very easy!', 'admin', 'marmot'); ?><br>
            <?php _ex('Just go to our setup wizard page and follow the steps.', 'admin', 'marmot'); ?><br>
            <?php _ex('Your site will be ready in a couple of minutes.', 'admin', 'marmot'); ?>
        </p>
        <p>
            <a href="<?php echo esc_url(admin_url('admin.php?page=marmot-theme-setup')); ?>" class="button button-primary mr-1"><?php _ex('Setup Wizard', 'admin', 'marmot'); ?></a>
            <a href="<?php echo add_query_arg(['marmot-complete-setup' => 1]); ?>"><?php _ex('Thanks! I do not need help for setup.', 'admin', 'marmot'); ?></a>
        </p>
        <?php
        // phpcs:enable
        $message = ob_get_clean();
        Admin_Notifications::instance()->add_notice('marmot_theme_setup', 'info', $message, 1);
    }

    /**
     * Setup admin menu
     * 
     * @since 1.0.0
     */
    public function setup_menu() {

        // Display menus only for users with proper capabilities
        if (!current_user_can('edit_theme_options')) {
            return;
        }

        if (defined('\HQExtra\VERSION')) {
            return;
        }

        // Main page
        add_theme_page('Marmot', 'Marmot', 'edit_theme_options', THEME_SLUG, [$this, 'dashboard'], 1);
    }

    /**
     * Enqueue admin scripts
     */
    public function admin_enqueue_scripts() {
        if (!isset($_GET['page']) || !in_array($_GET['page'], [THEME_SLUG, THEME_SLUG . '-theme-setup', THEME_SLUG . '-theme-templates', THEME_SLUG . '-ready-sites', THEME_SLUG . '-theme-options'])) {
            return;
        }

        wp_enqueue_style('hqt-admin', MARMOT_THEME_URL . '/assets/css/admin/admin.css', '', THEME_VERSION);
        wp_enqueue_script(THEME_SLUG . '-admin-scripts', MARMOT_THEME_URL . "/assets/js/admin/scripts.js", ['jquery'], THEME_VERSION, true);
        $data = [
            'translate' => [
                'activate' => _x('Activate', 'admin', 'marmot'),
                'activated' => _x('Activated', 'admin', 'marmot'),
                'install' => _x('Install', 'admin', 'marmot'),
            ]
        ];
        wp_localize_script(THEME_SLUG . '-admin-scripts', 'MarmotData', $data);
    }

    /**
     * Dashboard page
     * 
     * @since 1.0.0
     */
    public function dashboard() {
        set_theme_mod('marmot_welcome_hide', 1);
// phpcs:disable
        ?>
        <div class="hqt-admin-page">
            <div class="wrap">
                <h1 class="hqt-invisible"></h1>
                <div class="hqt-logo-wrap">
                    <a href="<?php echo THEME_SITE_URL; ?>/?utm_source=wp-admin&utm_medium=logo&utm_campaign=default&utm_content=dashboard-top" target="_blank">
                        <img src="<?php echo MARMOT_THEME_URL; ?>/assets/images/admin/logo-marmot.png">
                    </a>
                </div>
                <small class="mt-0">Version <?php echo THEME_VERSION; ?></small>
                <ul class="marmot-tabs-nav" data-sticky>
                    <li><a href="#dashboard"><?php _ex('Dashboard', 'admin', 'marmot'); ?></a></li>
                    <?php if (defined('\HQExtra\VERSION')) : ?>
                        <li><a href="<?php echo esc_url(admin_url('admin.php?page=' . THEME_SLUG . '-theme-options')); ?>"><?php _ex('Theme Options', 'admin', 'marmot'); ?></a></li>
                        <li><a href="<?php echo esc_url(admin_url('admin.php?page=' . THEME_SLUG . '-theme-setup')); ?>"><?php _ex('Setup Wizard', 'admin', 'marmot'); ?></a></li>
                        <li><a href="<?php echo esc_url(admin_url('admin.php?page=' . THEME_SLUG . '-theme-templates')); ?>"><?php _ex('Theme Templates', 'admin', 'marmot'); ?></a></li>
                        <li><a href="<?php echo esc_url(admin_url('admin.php?page=' . THEME_SLUG . '-ready-sites')); ?>"><?php _ex('Ready Sites', 'admin', 'marmot'); ?></a></li>
                    <?php endif; ?>
                    <li><a href="#hq-widgets-for-elementor"><?php _ex('Free Widgets', 'admin', 'marmot'); ?></a></li>
                    <li><a href="#marmot-enhancer-pro"><?php _ex('PRO Version', 'admin', 'marmot'); ?></a></li>
                    <li class="tab-clear"><a href="<?php echo THEME_SITE_URL; ?>/support/" target="_blank"><?php _ex('Need Help?', 'admin', 'marmot'); ?></a></li>
                </ul>
                <div class="hqt-container mt-0" id="dashboard">
                    <div class="hqt-row mt-3">
                        <div class="hqt-col-1-2__md">
                            <h2 class="mt-6 mb-0 text-medium"><?php _ex('Thank you for choosing Marmot Theme', 'admin', 'marmot'); ?></h2>
                            <?php
                            if (!defined('\HQExtra\VERSION')) {
                                ?>
                                <div class="hqt-row border-rad-10 hqt-box-shadow my-3 mx-0 py-3 px-2" style="border-left: solid 4px #2096F3;">
                                    <div class="hqt-col-1-1">
                                        <h3 class="p-0 mt-0 mb-3"><?php _ex('Marmot Theme requires HQTheme Extra plugin to use all features.', 'admin', 'marmot'); ?></h3>
                                        <p class="mt-1 mb-3">
                                            <?php _ex('It is very easy!', 'admin', 'marmot'); ?><br>
                                            <?php _ex('Just use the button bellow to install and activate the plugin.', 'admin', 'marmot'); ?><br>
                                        </p>
                                        <?php
                                        $class = 'btn btn-primary';
                                        $install_url = '';
                                        if (!is_plugin_installed('hqtheme-extra/hqtheme-extra.php')) {
                                            $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=hqtheme-extra'), 'install-plugin_hqtheme-extra');
                                        }
                                        $activate_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . 'hqtheme-extra/hqtheme-extra.php' . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . 'hqtheme-extra/hqtheme-extra.php');
                                        ?>
                                        <a href="#" 
                                           data-hqt-btn="install-activate-plugin"
                                           data-action-label="prepend"
                                           data-plugin-name="<?php echo esc_attr('HQTheme Extra') ?>" 
                                           data-install-url="<?php echo esc_attr($install_url); ?>" 
                                           data-activate-url="<?php echo esc_attr($activate_url); ?>"
                                           data-callback="refresh-page" 
                                           class="<?php echo $class; ?>"><?php echo esc_html('HQTheme Extra') ?></a>
                                    </div>
                                </div>
                                <?php
                            } elseif (get_theme_mod('marmot_setup', 0)) {
                                ?>
                                <div class="hqt-row border-rad-10 hqt-box-shadow my-3 mx-0 py-3 px-2" style="border-left: solid 4px #2096F3;">
                                    <div class="hqt-col-1-1">
                                        <h3 class="p-0 mt-0 mb-3"><?php _ex('Marmot Theme requires some plugins and setup to use all features.', 'admin', 'marmot'); ?></h3>
                                        <p class="mt-1 mb-3">
                                            <?php _ex('It is very easy!', 'admin', 'marmot'); ?><br>
                                            <?php _ex('Just go to our setup wizard page and follow the steps.', 'admin', 'marmot'); ?><br>
                                            <?php _ex('Your site will be ready in a couple of minutes.', 'admin', 'marmot'); ?>
                                        </p>
                                        <a href="<?php echo esc_url(admin_url('admin.php?page=marmot-theme-setup')); ?>" class="btn btn-primary mr-1"><?php _ex('Setup Wizard', 'admin', 'marmot'); ?></a>
                                        <a href="<?php echo esc_url(admin_url('admin.php?page=marmot&marmot-complete-setup=1')); ?>"><?php _ex('Thanks! I do not need help for setup.', 'admin', 'marmot'); ?></a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <ul class="hqt-list list-dot my-3">
                                <li><?php _ex('The most flexible theme for Elementor page builder fans', 'admin', 'marmot'); ?></li>
                                <li><?php _ex('Professionally ready to use demos right behind a click', 'admin', 'marmot'); ?></li>
                                <li><?php _ex('Fast and light - Marmot theme is made for speed', 'admin', 'marmot'); ?></li>
                            </ul>
                            <div class="mt-5">
                                <?php if (defined('\HQExtra\VERSION')) : ?>
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=marmot-ready-sites')); ?>" class="btn btn-border ml-2 mr-1"><?php _ex('View Demos', 'admin', 'marmot'); ?></a>
                                <?php endif; ?>
                                <a target="_blank" href="<?php echo THEME_SITE_URL; ?>/?utm_source=wp-admin&utm_medium=link&utm_campaign=default&utm_content=learn-more" ><?php _ex('Learn More', 'admin', 'marmot'); ?></a>
                            </div>
                        </div>
                        <div class="hqt-col-1-2__md">
                            <div class="hqt-row">
                                <div class="hqt-col-1-2 mb-4">
                                    <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                                        <div class="p-2" style="background: #f40c3c;">
                                            <i class="dashicons dashicons-admin-appearance hqt-dashboard-icon"></i>
                                        </div>
                                        <div class="d-flex flex-basis-100 align-items-center">
                                            <h3 class="px-3"><?php _ex('Modern Design', 'admin', 'marmot'); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="hqt-col-1-2 mb-4">
                                    <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                                        <div class="p-2" style="background: #f7382b;">
                                            <i class="dashicons dashicons-fullscreen-alt hqt-dashboard-icon"></i>
                                        </div>
                                        <div class="d-flex flex-basis-100 align-items-center">
                                            <h3 class="px-3"><?php _ex('Fully Responsive', 'admin', 'marmot'); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="hqt-col-1-2 mb-4">
                                    <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                                        <div class="p-2" style="background: #fb7015;">
                                            <i class="dashicons dashicons-admin-generic hqt-dashboard-icon"></i>
                                        </div>
                                        <div class="d-flex flex-basis-100 align-items-center">
                                            <h3 class="px-3"><?php _ex('No Coding Required', 'admin', 'marmot'); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="hqt-col-1-2 mb-4">
                                    <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                                        <div class="p-2" style="background: #ffa002;">
                                            <i class="dashicons dashicons-admin-settings hqt-dashboard-icon"></i>
                                        </div>
                                        <div class="d-flex flex-basis-100 align-items-center">
                                            <h3 class="px-3"><?php _ex('Customize Everything', 'admin', 'marmot'); ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h2 class="mt-0 mb-2 text-medium"><?php _ex('Use Elementor templates for', 'admin', 'marmot'); ?></h2>
                            <h3 class="mt-2 mb-0"><?php _ex('Header and Footer', 'admin', 'marmot'); ?></h3>
                            <a href="<?php echo THEME_SITE_URL; ?>/documentation/category/headers-and-footers/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_content=learn-more" target="_blank">
                                <?php _ex('Learn how', 'admin', 'marmot'); ?>
                            </a>
                            <h3 class="mt-2 mb-0"><?php _ex('Single and Archive post page', 'admin', 'marmot'); ?></h3>
                            <a href="<?php echo THEME_SITE_URL; ?>/documentation/category/blog/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_content=learn-more" target="_blank">
                                <?php _ex('Learn how', 'admin', 'marmot'); ?>
                            </a>
                            <h3 class="mt-2 mb-0"><?php _ex('WooCommerce product and Woo Archive page', 'admin', 'marmot'); ?></h3>
                            <a href="<?php echo THEME_SITE_URL; ?>/woocommerce-integration/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_content=learn-more" target="_blank">
                                <?php _ex('Learn more', 'admin', 'marmot'); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="hqt-container" id="hq-widgets-for-elementor">
                    <div class="hqt-row mt-3 align-items-center">
                        <div class="hqt-col-1-2__md">
                            <img src="<?php echo MARMOT_THEME_URL; ?>/assets/images/admin/logo-hq-widgets.png">
                            <h2 class="mt-5 mb-0 text-medium"><?php _ex('More Widgets - Endless Customization', 'admin', 'marmot'); ?></h2>
                            <p><?php _ex('With our free widgets plugin you can build your website with no limits. Tens of widgets available.', 'admin', 'marmot'); ?></p>
                            <div class="mt-5">
                                <?php
                                $learn_more_class = '';
                                if (!defined('\HQWidgetsForElementor\VERSION')) {
                                    $install_url = '';
                                    $hq_widgets_for_elementor_name = 'HQ Widgets For Elementor';
                                    $hq_widgets_for_elementor_slug = 'hq-widgets-for-elementor';
                                    $hq_widgets_for_elementor_init = 'hq-widgets-for-elementor/hq-widgets-for-elementor.php';
                                    if (!is_plugin_installed($hq_widgets_for_elementor_init)) {
                                        $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $hq_widgets_for_elementor_slug), 'install-plugin_' . $hq_widgets_for_elementor_slug);
                                    }
                                    $activate_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $hq_widgets_for_elementor_init . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $hq_widgets_for_elementor_init);
                                    ?>
                                    <a href="#" 
                                       data-hqt-btn="install-activate-plugin"
                                       data-action-label="prepend"
                                       data-plugin-name="<?php echo esc_attr($hq_widgets_for_elementor_name) ?>" 
                                       data-install-url="<?php echo esc_attr($install_url); ?>" 
                                       data-activate-url="<?php echo esc_attr($activate_url); ?>" 
                                       data-callback="refresh-page" 
                                       class="btn btn-primary mt-3 mr-2">
                                           <?php echo esc_html($hq_widgets_for_elementor_name) ?>
                                    </a>
                                    <?php
                                } else {
                                    $learn_more_class = 'btn btn-border';
                                }
                                ?>
                                <a href="<?php echo THEME_SITE_URL; ?>/hq-widgets-for-elementor/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_term=marmot&utm_content=dashboard-free-widgets" class="<?php echo $learn_more_class ?>" target="_blank">
                                    <?php _ex('Learn More', 'admin', 'marmot'); ?>
                                </a>
                            </div>
                        </div>
                        <div class="hqt-col-1-2__md">
                        </div>
                    </div>
                </div>
                <div class="hqt-container" style="border: solid 1px #ff0048;" id="marmot-enhancer-pro">
                    <div class="hqt-row mt-3">
                        <div class="hqt-col-1-2__md">
                            <div class="hqt-logo-wrap">
                                <a href="<?php echo THEME_SITE_URL; ?>/?utm_source=wp-admin&utm_medium=logo&utm_campaign=default&utm_content=dashboard-top" target="_blank">
                                    <img src="<?php echo MARMOT_THEME_URL; ?>/assets/images/admin/logo-marmot-pro.png">
                                </a>
                            </div>
                            <h2 class="mt-5 mb-0 text-medium"><?php _ex('Add PRO Features to Marmot theme', 'admin', 'marmot'); ?></h2>
                            <p><?php _ex('Access all PRO Demos. Improve theme templates system. Attach custom headers and footers by page, post, taxonomy, product, premium support and much more.', 'admin', 'marmot'); ?></p>
                            <div class="mt-5">
                                <?php echo $this->get_pro_button(['class' => 'btn-primary mr-2']); ?>
                                <?php if (defined('\HQExtra\VERSION')) : ?>
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=marmot-ready-sites')); ?>" class="btn btn-danger-border mr-2">
                                        <?php _ex('View Demos', 'admin', 'marmot'); ?>
                                    </a>
                                    <a target="_blank" href="<?php echo THEME_SITE_URL; ?>/marmot-theme-pro/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_term=marmot&utm_content=pro-theme">
                                        <?php _ex('Learn More', 'admin', 'marmot'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="hqt-row mt-3 mb-6 mx-0" style="background: #F8F8F8;">
                        <div class="hqt-col-1-2__sm">
                            <ul class="hqt-list list-dot my-6 py-6">
                                <li class="mb-3">
                                    <h3 class="mt-0 mb-0"><?php _ex('Advanced Navigation Menu widget', 'admin', 'marmot'); ?></h3>
                                    <p class="m-0"><?php _ex('Horizontal and vertical layouts, extra styling, effects and more...', 'admin', 'marmot'); ?></p>
                                </li>
                                <li class="mb-3">
                                    <h3 class="m-0"><?php _ex('Advanced Contact Form 7 widget', 'admin', 'marmot'); ?></h3>
                                    <p class="m-0"><?php _ex('Flexibility to customize your forms the way you like - control every element\'s layout and spacing easily.', 'admin', 'marmot'); ?></p>
                                </li>
                                <li class="mb-3">
                                    <h3 class="m-0"><?php _ex('WooCommerce Cart widget', 'admin', 'marmot'); ?></h3>
                                    <p class="m-0"><?php _ex('Nice dropdown or offcanvas menu with all the products in the shopping cart allows the user to review and finish orders faster.', 'admin', 'marmot'); ?></p>
                                </li>
                            </ul>
                        </div>
                        <div class="hqt-col-1-2__sm">
                            <ul class="hqt-list list-dot my-6 py-6">
                                <li class="mb-3">
                                    <h3 class="m-0"><?php _ex('OpenTable Reservations', 'admin', 'marmot'); ?></h3>
                                    <p class="m-0"><?php _ex('Adds and customize OpenTable.com widget with no coding.', 'admin', 'marmot'); ?></p>
                                </li>
                                <li class="mb-3">
                                    <h3 class="m-0"><?php _ex('More widgets coming...', 'admin', 'marmot'); ?></h3>
                                    <p class="m-0"><?php _ex('We are developing new widgets continuously. We believe that our products are live and we have to take care of and help them grow.', 'admin', 'marmot'); ?></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hqt-row">
                        <div class="hqt-col-1-3__sm">
                            <div class="p-3 mb-3 border-rad-5 text-white" style="background: #f40c3c;">
                                <h3 class="mt-0 mb-1 text-white"><?php _ex('Dynamic Tags', 'admin', 'marmot'); ?></h3>
                                <p class="m-0" style="line-height: 1.2"><small><?php _ex('Display data from the current page or post, changing dynamically according to the post type it’s on, for example Post Title, Post Content, Page Title, etc.', 'admin', 'marmot'); ?></small></p>
                            </div>
                        </div>
                        <div class="hqt-col-1-3__sm">
                            <div class="p-3 mb-3 border-rad-5 text-white" style="background: #f7382b;">
                                <h3 class="mt-0 mb-1 text-white"><?php _ex('Dynamic Conditions', 'admin', 'marmot'); ?></h3>
                                <p class="m-0" style="line-height: 1.2"><small><?php _ex('Control content visibility on your website. The Dynamic Conditions options gives you flexibility to show or hide content based on your custom rules.​', 'admin', 'marmot'); ?></small></p>
                            </div>
                        </div>
                        <div class="hqt-col-1-3__sm">
                            <div class="p-3 mb-3 border-rad-5 text-white" style="background: #fb7015;">
                                <h3 class="mt-0 mb-1 text-white"><?php _ex('Dismiss Element', 'admin', 'marmot'); ?></h3>
                                <p class="m-0" style="line-height: 1.2"><small><?php _ex('Create elements, which user can dismiss and hide from the content, useful for ad content, notifications, product upsells, etc.', 'admin', 'marmot'); ?></small></p>
                            </div>
                        </div>
                    </div>
                    <div class="hqt-row my-3">
                        <div class="hqt-col-1-2__sm hqt-col-1-4__lg">
                            <h3 class="mt-2 mb-0"><?php _ex('Advanced popup building system', 'admin', 'marmot'); ?></h3>
                            <p class="m-0"><?php _ex('Use Elementor widgets to create awesome popups. Any type of popup without coding.', 'admin', 'marmot'); ?></p>
                            <a href="https://marmot.hqwebs.net/popups-for-elementor/?utm_source=wp-admin&utm_medium=link&utm_campaign=default&utm_term=marmot&utm_content=dashboard-pro-section" target="_blank">
                                <?php _ex('Learn more', 'admin', 'marmot'); ?>
                            </a>
                        </div>
                        <div class="hqt-col-1-2__sm hqt-col-1-4__lg">
                            <h3 class="mt-2 mb-0"><?php _ex('Access to reach popup library', 'admin', 'marmot'); ?></h3>
                            <p class="m-0"><?php _ex('Premade popups right behide a click.', 'admin', 'marmot'); ?></p>
                            <?php if ($this->license_pro_plugin_ready()) : ?>
                                <?php
                                $options = \HQLib\hq_get_option('theme_modules');
                                if (\HQLib\Helper::is_module_active('popup', $options)) :
                                    ?>
                                    <a href="<?php echo esc_url(admin_url('edit.php?post_type=hqpopup&page=hqpopup-library')); ?>">
                                        <?php _ex('Browse library', 'admin', 'marmot'); ?>
                                    </a>
                                    <?php
                                else :
                                    ?>
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=marmot-theme-options&tab=theme_modules')); ?>">
                                        <?php _ex('Activate Module', 'admin', 'marmot'); ?>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="hqt-col-1-2__sm hqt-col-1-4__lg">
                            <h3 class="mt-2 mb-0"><?php _ex('WooCommerce integration', 'admin', 'marmot'); ?></h3>
                            <p class="m-0"><?php _ex('Smooth user experience throughout the whole selling process.', 'admin', 'marmot'); ?></p>
                            <a href="<?php echo THEME_SITE_URL; ?>/woocommerce-integration/?utm_source=wp-admin&utm_medium=link&utm_campaign=default&utm_term=marmot&utm_content=dashboard-pro-section" target="_blank">
                                <?php _ex('Learn more', 'admin', 'marmot'); ?>
                            </a>
                        </div>
                        <div class="hqt-col-1-2__sm hqt-col-1-4__lg">
                            <h3 class="mt-2 mb-0"><?php _ex('New features coming...', 'admin', 'marmot'); ?></h3>
                            <p class="m-0"><?php _ex('We are improving it all the time by adding new features and demos.', 'admin', 'marmot'); ?></p>
                            <a href="<?php echo THEME_SITE_URL; ?>/features/?utm_source=wp-admin&utm_medium=link&utm_campaign=default&utm_term=marmot&utm_content=dashboard-pro-section" target="_blank">
                                <?php _ex('Learn More', 'admin', 'marmot'); ?>
                            </a>
                        </div>
                        <div class="hqt-col-1-1  mt-3">
                            <?php echo $this->get_pro_button(['class' => 'mt-3 mr-2']); ?>
                            <?php if (defined('\HQExtra\VERSION')) : ?>
                                <a target="_blank" href="<?php echo THEME_SITE_URL; ?>/marmot-theme-pro/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_term=marmot&utm_content=pro-theme" class="btn btn-border">
                                    <?php _ex('Learn More', 'admin', 'marmot'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <h2 class="my-6 text-medium"><?php _ex('Included Premium Plugins', 'admin', 'marmot'); ?></h2>
                    <div class="hqt-row">
                        <?php foreach (self::$included_premium_plugins as $included_premium_plugin_slug => $included_premium_plugin) : ?>
                            <div class="hqt-col-1-2__sm hqt-col-1-3__md hqt-col-1-4__xl px-3">
                                <img src="<?php echo esc_url($included_premium_plugin['logo_url']); ?>" class="img-fluid">
                                <p><?php echo esc_html($included_premium_plugin['description']); ?></p>
                                <?php
                                if (class_exists('\HQExtra\HQExtra') && \HQLib\License::is_activated()) {
                                    if (defined($included_premium_plugin['constant'])) {
                                        // Plugin is active
                                        ?>
                                        <span class="d-iblock text-success px-1"><?php _ex('Activated', 'admin', 'marmot'); ?></span>
                                        <?php
                                    } else {
                                        $install_url = '';
                                        if (!\HQLib\is_plugin_installed($included_premium_plugin['init'])) {
                                            $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $included_premium_plugin_slug), 'install-plugin_' . $included_premium_plugin_slug);
                                        }
                                        $activate_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $included_premium_plugin['init'] . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $included_premium_plugin['init']);
                                        ?>
                                        <a href="#" 
                                           data-hqt-btn="install-activate-plugin"
                                           data-action-label="replace"
                                           data-plugin-name="<?php echo esc_attr($included_premium_plugin['name']) ?>" 
                                           data-install-url="<?php echo esc_attr($install_url); ?>" 
                                           data-activate-url="<?php echo esc_attr($activate_url); ?>" 
                                           data-callback="replace-button-label-activated" 
                                           class="btn btn-primary mt-3">
                                               <?php echo esc_html($included_premium_plugin['name']) ?>
                                        </a>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php $this->page_footer_section(); ?>
            </div>
        </div>
        <?php
// phpcs:enable
    }

    private function no_theme_extra_section() {
        $install_url = '';
        if (!is_plugin_installed(THEME_EXTRA_PLUGIN_FILE)) {
            $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . THEME_EXTRA_PLUGIN_SLUG), 'install-plugin_' . THEME_EXTRA_PLUGIN_SLUG);
        }
        $activate_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . THEME_EXTRA_PLUGIN_FILE . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . THEME_EXTRA_PLUGIN_FILE);
// phpcs:disable
        ?>
        <div class="hqt-container">
            <div class="hqt-row align-items-center my-4">
                <div class="hqt-col-1-2__md">
                    <h1 class="text-bold p-0 mt-0 mb-3"><?php _ex('Plugin Required', 'admin ready sites', 'marmot'); ?></h1>
                    <p class="mt-1 mb-2"><?php _ex('HQTheme Extra adds extra features and options to Marmot theme and allows you to import beautiful pre-made demos. With the one-click demo import feature you can import all our professional demo sites.', 'admin', 'marmot'); ?></p>
                    <a href="#" 
                       data-hqt-btn="install-activate-plugin"
                       data-action-label="replace"
                       data-plugin-name="<?php esc_attr_e(_x('HQTheme Extra', 'admin', 'marmot')) ?>" 
                       data-install-url="<?php echo esc_attr($install_url); ?>" 
                       data-activate-url="<?php echo esc_attr($activate_url); ?>" 
                       data-callback="refresh-page"
                       class="btn btn-primary mt-3"
                       ><?php _ex('HQTheme Extra', 'admin', 'marmot') ?></a>
                </div>
                <div class="hqt-col-1-2__md">
                </div>
            </div>
        </div>
        <?php
// phpcs:enable
    }

    /**
     * Renders Marmot admin page footer
     */
    public function page_footer_section() {
// phpcs:disable
        ?>
        <div class="hqt-page-footer-info">
            <p>Thank you for choosing Marmot Theme by <a target="_blank" href="https://marmot.hqwebs.net/?utm_source=wp-admin&utm_medium=link&utm_campaign=default&utm_content=marmot-page-footer">HQWebS</a>.</p> 
        </div>
        <?php
// phpcs:enable
    }

    public static function get_pro_button($args = [], $actionLabel = 'prepend') {

        global $mar_fs;
        if (class_exists('\HQExtra\HQExtra')) {
            if (!\HQLib\License::is_activated()) {
                $class = 'btn btn-danger' . (!empty($args['class']) ? ' ' . $args['class'] : '');
                return sprintf('<a href="%s" class="%s">%s</a>', $mar_fs->pricing_url(), $class, _x('Get PRO License', 'admin', 'marmot'));
            } else {
                if (!class_exists('\HQPro\HQ_Pro')) {
                    $class = 'btn btn-primary' . (!empty($args['class']) ? ' ' . $args['class'] : '');
                    $install_url = '';
                    if (!is_plugin_installed(self::$included_premium_plugins['marmot-enhancer-pro']['init'])) {
                        $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=marmot-enhancer-pro'), 'install-plugin_marmot-enhancer-pro');
                    }
                    $activate_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . self::$included_premium_plugins['marmot-enhancer-pro']['init'] . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . self::$included_premium_plugins['marmot-enhancer-pro']['init']);
                    ob_start();
                    ?>
                    <a href="#" 
                       data-hqt-btn="install-activate-plugin"
                       data-action-label="<?php echo esc_attr($actionLabel); ?>"
                       data-plugin-name="<?php echo esc_attr(self::$included_premium_plugins['marmot-enhancer-pro']['name']) ?>" 
                       data-install-url="<?php echo esc_attr($install_url); ?>" 
                       data-activate-url="<?php echo esc_attr($activate_url); ?>"
                       data-callback="refresh-page" 
                       class="<?php echo esc_attr($class); ?>">
                           <?php echo esc_html(self::$included_premium_plugins['marmot-enhancer-pro']['name']) ?>
                    </a>
                    <?php
                    return ob_get_clean();
                }
            }
        } else {
            ob_start();
            ?>
            <div class="hqt-row border-rad-10 hqt-box-shadow my-3 mx-0 py-3 px-2" style="border-left: solid 4px #2096F3;">
                <div class="hqt-col-1-1">
                    <h3 class="p-0 mt-0 mb-3"><?php echo esc_html_x('Marmot Theme requires HQTheme Extra plugin to use all features.', 'admin', 'marmot'); ?></h3>
                    <p class="mt-1 mb-3">
                        <?php echo esc_html_x('It is very easy!', 'admin', 'marmot'); ?><br>
                        <?php echo esc_html_x('Just use the button bellow to install and activate the plugin.', 'admin', 'marmot'); ?><br>
                    </p>
                    <?php
                    $class = 'btn btn-primary';
                    $install_url = '';
                    if (!is_plugin_installed('hqtheme-extra/hqtheme-extra.php')) {
                        $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=hqtheme-extra'), 'install-plugin_hqtheme-extra');
                    }
                    $activate_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . 'hqtheme-extra/hqtheme-extra.php' . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . 'hqtheme-extra/hqtheme-extra.php');
                    ?>
                    <a href="#" 
                       data-hqt-btn="install-activate-plugin"
                       data-action-label="prepend"
                       data-plugin-name="<?php echo esc_attr('HQTheme Extra') ?>" 
                       data-install-url="<?php echo esc_attr($install_url); ?>" 
                       data-activate-url="<?php echo esc_attr($activate_url); ?>"
                       data-callback="refresh-page" 
                       class="<?php echo esc_attr($class); ?>"><?php echo esc_html('HQTheme Extra') ?></a>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }
    }

    public static function license_pro_plugin_ready() {
        if (class_exists('\HQExtra\HQExtra') && \HQLib\License::is_activated()) {
            if (class_exists('\HQPro\HQ_Pro')) {
                return true;
            }
        }
        return false;
    }

}
