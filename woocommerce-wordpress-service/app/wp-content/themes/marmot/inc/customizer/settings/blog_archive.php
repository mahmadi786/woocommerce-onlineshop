<?php

defined('ABSPATH') || exit;

use function Marmot\get_elementor_templates;

$add_setting_controls = array_merge($add_setting_controls,
        apply_filters('hqt/customizer/settings/post/archive',
                array_merge(
                        [
                            'hq_post_archive_layout' => [
                                'default' => '',
                                'label' => _x('Blog Archive Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_post_archive',
                                'choices' => get_elementor_templates('archive', 0, 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => \Marmot\Customizer\Settings::full_mode_requires_description('archive'),
                            ],
                        ],
                        Marmot\Customizer\Settings::generate_layout_templates_controls('hq_post_archive', _x('Blog Archive', 'settings', 'marmot'))
                ),
                'post'
        )
);

