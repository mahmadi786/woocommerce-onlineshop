<?php

defined('ABSPATH') || exit;

$add_setting_controls = array_merge($add_setting_controls,
        apply_filters('hqt/customizer/settings/theme_mod',
                [
                    '_hqt_theme_customizable_mode' => [
                        'default' => 'on',
                        'label' => _x('Enable Full Customizable Mode?', 'settings', 'marmot'),
                        'type' => 'select',
                        'section' => 'hq_theme_mod',
                        'description' => _x('Enable full customizations mode. Edit hedear, footer and content area with Elementor page bulder. This mode requires "HQTheme Extra" and "Elementor" plugins. Both are free.', 'settings', 'marmot') .
                        '<p>' . _x('Result from this option will be available only after save & refresh!', 'settings', 'marmot') . '</p>' .
                        \Marmot\Customizer::required_plugins_for_full_customozation_mode(),
                        'choices' => [
                            '' => 'Off',
                            'on' => 'On',
                        ],
                        'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                    ],
        ])
);
