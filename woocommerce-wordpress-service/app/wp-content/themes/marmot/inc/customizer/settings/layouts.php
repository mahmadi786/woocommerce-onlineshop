<?php
defined('ABSPATH') || exit;

use function Marmot\get_elementor_templates;

ob_start();
?>
<h2 class="mt-0"><?php esc_html(_x('Marmot Theme - Templates', 'customizer', 'marmot')); ?></h2>
<p><?php echo esc_html(_x('Marmot theme works with Elementor templates.', 'customizer', 'marmot')) ?></p>
<p><?php echo esc_html(_x('Below you can choose which templates to use.', 'customizer', 'marmot')) ?></p>
<p><?php echo esc_html(_x('Still confusing? Check out out "Theme Templates" page. It is specialy designed to help you with templates creation and setup.', 'customizer', 'marmot')) ?></p>
<?php
$required_plugins_for_theme_templates = '';
// Check  for HQTheme Extra
if (!defined('\HQExtra\VERSION')) {
    if (!Marmot\is_plugin_installed('hqtheme-extra/hqtheme-extra.php')) {
        $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=hqtheme-extra'), 'install-plugin_hqtheme-extra');
        /* translators: %s: plugin name "HQTheme Extra" */
        $required_plugins_for_theme_templates .= '<p><a target="_blank" class="button new" href="' . esc_attr($install_url) . '">' . esc_html(sprintf(_x('Install "%s" plugin', 'settings', 'marmot'), 'HQTheme Extra')) . '</a></p>';
    } else {
        $activate_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . 'hqtheme-extra/hqtheme-extra.php' . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . 'hqtheme-extra/hqtheme-extra.php');
        /* translators: %s: plugin name "HQTheme Extra" */
        $required_plugins_for_theme_templates .= '<p><a target="_blank" class="button new" href="' . esc_attr($activate_url) . '">' . esc_html(sprintf(_x('Activate "%s" plugin', 'settings', 'marmot'), 'HQTheme Extra')) . '</a></p>';
    }
}
if (!empty($required_plugins_for_theme_templates)) {
    /* translators: %s: plugin name "HQTheme Extra" */
    echo '<p>' . esc_html(sprintf(_x('Theme Templates requires "%s" plugin', 'settings', 'marmot'), 'HQTheme Extra')) . '</p>';
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo $required_plugins_for_theme_templates;
    echo ' <p>' . esc_html(_x('Customizer refresh is required after plugins activation!', 'settings', 'marmot')) . '</p>';
} else {
    echo '<p><a target="_blank" class="button new" href="' . esc_attr(admin_url('admin.php?page=marmot-theme-templates')) . '">' . sprintf(_x('Go to Theme Templates setup page', 'settings', 'marmot'), 'HQTheme Extra') . '</a></p>';
}
?>
<p>
    <?php echo esc_html(_x('More about Marmot templates system you can find in our documentation.', 'customizer', 'marmot')) ?><br>
    <a href="https://marmot.hqwebs.net/documentation/how-to-edit-header-template/" target="_blank" class="btn mt-1"><?php echo esc_html(_x('Documentation', 'customizer', 'marmot')) ?></a>
</p>
<?php
$how_to_use_desctiption = ob_get_clean();

$add_setting_controls = array_merge($add_setting_controls,
        apply_filters('hqt/customizer/settings/layouts',
                [
                    'hq_layout_info' => [
                        'section' => 'hq_layouts',
                        'control' => 'Marmot\Customizer\Controls',
                        'type' => 'raw_html',
                        'description' => $how_to_use_desctiption,
                    ],
                    'hq_header_elementor_template' => [
                        'default' => '',
                        'label' => _x('Header Template', 'settings', 'marmot'),
                        'type' => 'select',
                        'section' => 'hq_layouts',
                        'description' => \Marmot\Customizer\Settings::full_mode_requires_description('header'),
                        'choices' => get_elementor_templates('header', 0, 1),
                        'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                    ],
                    'hq_footer_elementor_template' => [
                        'default' => '',
                        'label' => _x('Footer Template', 'settings', 'marmot'),
                        'type' => 'select',
                        'section' => 'hq_layouts',
                        'description' => \Marmot\Customizer\Settings::full_mode_requires_description('footer'),
                        'choices' => get_elementor_templates('footer', 0, 1),
                        'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                    ],
                    'hq_page_elementor_template' => [
                        'default' => 'noeltmp',
                        'label' => _x('Page Template', 'settings', 'marmot'),
                        'type' => 'select',
                        'section' => 'hq_layouts',
                        'description' => \Marmot\Customizer\Settings::full_mode_requires_description('page'),
                        'choices' => get_elementor_templates('page'),
                        'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                    ],
                    'hq_attachment_elementor_template' => [
                        'default' => 'noeltmp',
                        'label' => _x('Attachment Template', 'settings', 'marmot'),
                        'type' => 'select',
                        'section' => 'hq_layouts',
                        'description' => \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                        'choices' => get_elementor_templates('single'),
                        'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                    ],
                    'hq_search_results_elementor_template' => [
                        'default' => 'noeltmp',
                        'label' => _x('Seach Results Template', 'settings', 'marmot'),
                        'type' => 'select',
                        'section' => 'hq_layouts',
                        'description' => \Marmot\Customizer\Settings::full_mode_requires_description('archive'),
                        'choices' => get_elementor_templates('archive'),
                        'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                    ],
                    'hq_404_elementor_template' => [
                        'default' => 'noeltmp',
                        'label' => _x('404 Template - Not Found', 'settings', 'marmot'),
                        'type' => 'select',
                        'section' => 'hq_layouts',
                        'description' => \Marmot\Customizer\Settings::full_mode_requires_description('page'),
                        'choices' => get_elementor_templates('page', 0, 1),
                        'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                    ],
        ])
);
