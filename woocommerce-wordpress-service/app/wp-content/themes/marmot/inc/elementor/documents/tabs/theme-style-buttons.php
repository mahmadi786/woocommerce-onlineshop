<?php

namespace Marmot\Elementor\Documents\Tabs;

use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Theme_Style_Buttons extends Tab_Base {

    public function get_id() {
        return 'theme-style-buttons';
    }

    public function get_title() {
        return __('Buttons', 'marmot');
    }

    protected function register_tab_controls() {
        $button_selectors = [
            '{{WRAPPER}} button',
            '{{WRAPPER}} input[type="button"]',
            '{{WRAPPER}} input[type="submit"]',
            '{{WRAPPER}} .elementor-button',
            // HQ Selectors
            '{{WRAPPER}} .elementor-button.buttom.alt',
            '{{WRAPPER}} button.elementor-button.button.alt',
            '{{WRAPPER}} input.elementor-button.button.alt',
            '{{WRAPPER}} .woocommerce-Button',
            '{{WRAPPER}}.woocommerce a.added_to_cart',
            '{{WRAPPER}} button.button',
            '{{WRAPPER}} button.button:disabled[disabled]',
            '{{WRAPPER}} button.button.disabled',
            '{{WRAPPER}} button.button.alt',
            '{{WRAPPER}} a.button',
            '{{WRAPPER}} a.button.alt',
            '{{WRAPPER}} #respond input#submit',
        ];

        $button_hover_selectors = [
            '{{WRAPPER}} button:hover',
            '{{WRAPPER}} button:focus',
            '{{WRAPPER}} input[type="button"]:hover',
            '{{WRAPPER}} input[type="button"]:focus',
            '{{WRAPPER}} input[type="submit"]:hover',
            '{{WRAPPER}} input[type="submit"]:focus',
            '{{WRAPPER}} .elementor-button:hover',
            '{{WRAPPER}} .elementor-button:focus',
            // HQ Selectors
            '{{WRAPPER}} button.elementor-button.button.alt:hover',
            '{{WRAPPER}} button.elementor-button.button.alt:focus',
            '{{WRAPPER}} input.elementor-button.button.alt:hover',
            '{{WRAPPER}} input.elementor-button.button.alt:focus',
            '{{WRAPPER}} .woocommerce-Button:hover',
            '{{WRAPPER}} .woocommerce-Button:focus',
            '{{WRAPPER}} button.button:disabled[disabled]:hover',
            '{{WRAPPER}} button.button.disabled:hover',
            '{{WRAPPER}} button.button:hover',
            '{{WRAPPER}} button.button:focus',
            '{{WRAPPER}} button.button.alt:hover',
            '{{WRAPPER}} button.button.alt:focus',
            '{{WRAPPER}} a.button:hover',
            '{{WRAPPER}} a.button:focus',
            '{{WRAPPER}} a.button.alt:hover',
            '{{WRAPPER}} a.button.alt:focus',
            '{{WRAPPER}} #respond input#submit:hover',
            '{{WRAPPER}} #respond input#submit:focus',
        ];

        $button_selector = implode(',', $button_selectors);
        $button_hover_selector = implode(',', $button_hover_selectors);

        $this->start_controls_section(
                'section_buttons',
                [
                    'label' => __('Buttons', 'marmot'),
                    'tab' => $this->get_id(),
                ]
        );

        $this->add_default_globals_notice();

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'label' => __('Typography', 'marmot'),
                    'name' => 'button_typography',
                    'selector' => $button_selector,
                ]
        );

        $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'button_text_shadow',
                    'selector' => $button_selector,
                ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
                'tab_button_normal',
                [
                    'label' => __('Normal', 'marmot'),
                ]
        );

        $this->add_control(
                'button_text_color',
                [
                    'label' => __('Text Color', 'marmot'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => [],
                    'selectors' => [
                        $button_selector => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'button_background_color',
                [
                    'label' => __('Background Color', 'marmot'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => [],
                    'selectors' => [
                        $button_selector => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'button_box_shadow',
                    'selector' => $button_selector,
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'button_border',
                    'selector' => $button_selector,
                    'fields_options' => [
                        'color' => [
                            'dynamic' => [],
                        ],
                    ],
                ]
        );

        $this->add_control(
                'button_border_radius',
                [
                    'label' => __('Border Radius', 'marmot'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        $button_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_button_hover',
                [
                    'label' => __('Hover', 'marmot'),
                ]
        );

        $this->add_control(
                'button_hover_text_color',
                [
                    'label' => __('Text Color', 'marmot'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => [],
                    'selectors' => [
                        $button_hover_selector => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'button_hover_background_color',
                [
                    'label' => __('Background Color', 'marmot'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => [],
                    'selectors' => [
                        $button_hover_selector => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'button_hover_box_shadow',
                    'selector' => $button_hover_selector,
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'button_hover_border',
                    'selector' => $button_hover_selector,
                    'fields_options' => [
                        'color' => [
                            'dynamic' => [],
                        ],
                    ],
                ]
        );

        $this->add_control(
                'button_hover_border_radius',
                [
                    'label' => __('Border Radius', 'marmot'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        $button_hover_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
                'button_padding',
                [
                    'label' => __('Padding', 'marmot'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        $button_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
        );

        $this->end_controls_section();
    }

}
