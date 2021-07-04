<?php

defined('ABSPATH') || exit;

use function Marmot\get_elementor_templates;

$add_setting_controls = array_merge($add_setting_controls,
        apply_filters('hqt/customizer/settings/woocommerce/general',
                array_merge(
                        [
                            'hq_woocommerce_general_catalog_mode' => [
                                'default' => 0,
                                'label' => _x('Catalog Mode', 'settings', 'marmot'),
                                'type' => 'select',
                                'choices' => [
                                    0 => 'Off',
                                    1 => 'On',
                                ],
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'section' => 'hq_woocommerce_general',
                            ],
                            'hq_woocommerce_general_list_layout' => [
                                'default' => '',
                                'label' => _x('Shop Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_woocommerce_general',
                                'choices' => get_elementor_templates('archive', 0, 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => \Marmot\Customizer\Settings::full_mode_requires_description('archive'),
                            ],
                            'hq_woocommerce_general_lists_product_layout' => [
                                'default' => 'noeltmp',
                                'label' => _x('Single Product in Default Lists', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_woocommerce_general',
                                'choices' => get_elementor_templates('archive-post'),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => _x('This template will be used for displaying products in cart crosseell, product - related and upsell. ', 'settings', 'marmot')
                                . \Marmot\Customizer\Settings::full_mode_requires_description('archive-post'),
                            ],
                        ],
                        Marmot\Customizer\Settings::generate_layout_templates_controls('hq_woocommerce_general', _x('Shop Home', 'settings', 'marmot'))
                )
        )
);
