<?php

use function Marmot\get_elementor_templates;

defined('ABSPATH') || exit;

$add_setting_controls = array_merge($add_setting_controls,
        apply_filters('hqt/customizer/settings/blog/home',
                array_merge(
                        [
                            'hq_blog_home_layout' => [
                                'default' => '',
                                'label' => _x('Blog Home Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_blog_home',
                                'choices' => get_elementor_templates('archive', 0, 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => \Marmot\Customizer\Settings::full_mode_requires_description('archive'),
                            ],
                            'hq_blog_home_excerpt_length' => [
                                'default' => 55,
                                'label' => _x('Blog Excerpt Length', 'settings', 'marmot'),
                                'type' => 'number',
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_number',
                                'section' => 'hq_blog_home',
                            ],
                        ],
                        Marmot\Customizer\Settings::generate_layout_templates_controls('hq_blog_home', _x('Blog Home', 'settings', 'marmot'))
                )
        )
);
