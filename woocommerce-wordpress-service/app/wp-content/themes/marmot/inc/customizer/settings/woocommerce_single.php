<?php

defined('ABSPATH') || exit;

use function Marmot\get_elementor_templates;

$add_setting_controls = array_merge($add_setting_controls,
        apply_filters('hqt/customizer/settings/product/single',
                array_merge(
                        [
                            'hq_product_single_layout' => [
                                'default' => '',
                                'label' => _x('Product Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_product_single',
                                'choices' => get_elementor_templates('single', 0, 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                            ],
                        ],
                        Marmot\Customizer\Settings::generate_layout_templates_controls('hq_product_single', _x('Product', 'settings', 'marmot'))
                ),
                'product'
        )
);
