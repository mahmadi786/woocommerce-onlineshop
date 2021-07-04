<?php

defined('ABSPATH') || exit;

$add_setting_controls = array_merge($add_setting_controls,
        apply_filters('hqt/customizer/settings/theme_mod',
                [
                    'hq_appearance_mobile_browsers_color' => [
                        'default' => '',
                        'label' => _x('Mobile Browser Color', 'settings', 'marmot'),
                        'control' => 'WP_Customize_Color_Control',
                        'type' => 'color',
                        'section' => 'hq_other',
                        'description' => '',
                        'sanitize_callback' => 'sanitize_hex_color',
                    ],
        ])
);
