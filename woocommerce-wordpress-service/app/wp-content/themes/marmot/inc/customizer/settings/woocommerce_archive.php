<?php

defined('ABSPATH') || exit;

use function Marmot\get_elementor_templates;

$add_setting_controls = array_merge($add_setting_controls,
        apply_filters('hqt/customizer/settings/product/archive',
                array_merge(
                        [
                            'hq_product_archive_layout' => [
                                'default' => '',
                                'label' => _x('Shop Archive Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_product_archive',
                                'choices' => get_elementor_templates('archive', 0, 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => \Marmot\Customizer\Settings::full_mode_requires_description('archive'),
                            ],
                        ],
                        Marmot\Customizer\Settings::generate_layout_templates_controls('hq_product_archive', _x('Shop Archive', 'settings', 'marmot'))
                ),
                'product'
        )
);
