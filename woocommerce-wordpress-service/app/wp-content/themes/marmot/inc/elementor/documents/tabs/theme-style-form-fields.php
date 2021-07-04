<?php

namespace Marmot\Elementor\Documents\Tabs;

use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Theme_Style_Form_Fields extends Tab_Base {

    public function get_id() {
        return 'theme-style-form-fields';
    }

    public function get_title() {
        return __('Form Fields', 'marmot');
    }

    protected function register_tab_controls() {
        $label_selectors = [
            '{{WRAPPER}} label',
            // HQ Selectors
            '{{WRAPPER}} .hq-checkbox-label > span',
            '{{WRAPPER}} .hq-radio-label > span',
        ];

        $input_selectors = [
            '{{WRAPPER}} input:not([type="button"]):not([type="submit"])',
            '{{WRAPPER}} textarea',
            '{{WRAPPER}} .elementor-field-textual',
            // HQ Selectors
            '{{WRAPPER}} select',
            '{{WRAPPER}} .select2-selection',
        ];

        $input_focus_selectors = [
            '{{WRAPPER}} input:focus:not([type="button"]):not([type="submit"])',
            '{{WRAPPER}} textarea:focus',
            '{{WRAPPER}} .elementor-field-textual:focus',
            // HQ Selectors
            '{{WRAPPER}} select:focus',
            '{{WRAPPER}} .select2-container.select2-container--focus .select2-selection'
        ];

        $label_selector = implode(',', $label_selectors);
        $input_selector = implode(',', $input_selectors);
        $input_focus_selector = implode(',', $input_focus_selectors);

        $this->start_controls_section(
                'section_form_fields',
                [
                    'label' => __('Form Fields', 'marmot'),
                    'tab' => $this->get_id(),
                ]
        );

        $this->add_default_globals_notice();

        $this->add_control(
                'form_label_heading',
                [
                    'type' => Controls_Manager::HEADING,
                    'label' => __('Label', 'marmot'),
                ]
        );

        $this->add_control(
                'form_label_color',
                [
                    'label' => __('Color', 'marmot'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => [],
                    'selectors' => [
                        $label_selector => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'label' => __('Typography', 'marmot'),
                    'name' => 'form_label_typography',
                    'selector' => $label_selector,
                ]
        );

        $this->add_control(
                'form_field_heading',
                [
                    'type' => Controls_Manager::HEADING,
                    'label' => __('Field', 'marmot'),
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'label' => __('Typography', 'marmot'),
                    'name' => 'form_field_typography',
                    'selector' => $input_selector,
                ]
        );

        $this->start_controls_tabs('tabs_form_field_style');

        $this->start_controls_tab(
                'tab_form_field_normal',
                [
                    'label' => __('Normal', 'marmot'),
                ]
        );

        $this->add_form_field_state_tab_controls('form_field', $input_selector);

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_form_field_focus',
                [
                    'label' => __('Focus', 'marmot'),
                ]
        );

        $this->add_form_field_state_tab_controls('form_field_focus', $input_focus_selector);

        $this->add_control(
                'form_field_focus_transition_duration',
                [
                    'label' => __('Transition Duration', 'marmot') . ' (ms)',
                    'type' => Controls_Manager::SLIDER,
                    'selectors' => [
                        $input_selector => 'transition: {{SIZE}}ms',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 3000,
                        ],
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
                'form_field_padding',
                [
                    'label' => __('Padding', 'marmot'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        $input_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
        );

        $this->add_control('form_radio_checkbox_field_heading', [
            'type' => Controls_Manager::HEADING,
            'label' => __('Checkboxes and Radios', 'marmot'),
            'separator' => 'before',
                ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'form_radio_checkbox_field_typography',
            'selector' => '{{WRAPPER}} .hq-checkbox label span, {{WRAPPER}} .hq-radio label span',
        ]);

        $this->add_control('form_radio_checkbox_field_text_color', [
            'label' => __('Text Color', 'marmot'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-checkbox label span, {{WRAPPER}} .hq-radio label span' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('form_radio_checkbox_field_size', [
            'label' => __('Size', 'marmot'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 15,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-checkbox label span:before,'
                . '{{WRAPPER}} .hq-radio label span:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                '{{WRAPER}} .hq-checkbox label span:after' => 'width: calc({{SIZE}}{{UNIT}} / 2.5); height: calc({{SIZE}}{{UNIT}} / 1.666); top: calc(-{{SIZE}}{{UNIT}} / 5); left: calc({{SIZE}}{{UNIT}} / 2 - {{SIZE}}{{UNIT}} / 5)',
                '{{WRAPPER}} .hq-radio label span:after' => 'width: calc({{SIZE}}{{UNIT}} / 2.5); height: calc({{SIZE}}{{UNIT}} / 2.5); left: calc({{SIZE}}{{UNIT}} / 2 - {{SIZE}}{{UNIT}} / 5)',
            ],
        ]);

        $this->add_responsive_control('form_radio_checkbox_field_spacing', [
            'label' => __('Input Spacing', 'marmot'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-checkbox label, {{WRAPPER}} .hq-radio label' => 'padding-left: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('form_checkbox_field_border_radius', [
            'label' => __('Checkbox Border Radius', 'marmot'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .hq-checkbox label span:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('form_radio_field_border_radius', [
            'label' => __('Radio Border Radius', 'marmot'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .hq-radio label span:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('tabs_form_radio_checkbox_field_style');

        $this->start_controls_tab('tab_form_radio_checkbox_field_unchecked', [
            'label' => __('Unchecked', 'marmot'),
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'form_radio_checkbox_unchecked_field_border',
            'label' => __('Border', 'marmot'),
            'selector' => '{{WRAPPER}} .hq-checkbox label span:before, {{WRAPPER}} .hq-radio label span:before',
        ]);

        $this->add_control('form_radio_checkbox_unchecked_field_background_color', [
            'label' => __('Background Color', 'marmot'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-checkbox label span:before, {{WRAPPER}} .hq-radio label span:before' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_form_radio_checkbox_field_checked', [
            'label' => __('Checked', 'marmot'),
        ]);

        $this->add_control('form_checkbox_checked_field_text_color', [
            'label' => __('Check Color', 'marmot'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-checkbox label input:checked ~ span:after' => 'border-color: {{VALUE}}',
            ],
        ]);
        
        $this->add_control('form_radio_checked_field_text_color', [
            'label' => __('Radio Color', 'marmot'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-radio label input:checked ~ span:after' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_control('form_checkbox_checked_field_background_color', [
            'label' => __('Checkbox Background Color', 'marmot'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-checkbox label input:checked ~ span:before' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('form_radio_checked_field_background_color', [
            'label' => __('Radio Background Color', 'marmot'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-radio label input:checked ~ span:before' => 'background-color: {{VALUE}};',
            ],
                ]
        );
        
        $this->add_control('form_checkbox_radio_checked_field_border_color', [
            'label' => __('Border Color', 'marmot'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-checkbox label input:checked ~ span:before,'
                . '{{WRAPPER}} .hq-radio label input:checked ~ span:before' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();


        $this->end_controls_section();
    }

    private function add_form_field_state_tab_controls($prefix, $selector) {
        $this->add_control(
                $prefix . '_text_color',
                [
                    'label' => __('Text Color', 'marmot'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => [],
                    'selectors' => [
                        $selector => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                $prefix . '_background_color',
                [
                    'label' => __('Background Color', 'marmot'),
                    'type' => Controls_Manager::COLOR,
                    'dynamic' => [],
                    'selectors' => [
                        $selector => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => $prefix . '_box_shadow',
                    'selector' => $selector,
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => $prefix . '_border',
                    'selector' => $selector,
                    'fields_options' => [
                        'color' => [
                            'dynamic' => [],
                        ],
                    ],
                ]
        );

        $this->add_control(
                $prefix . '_border_radius',
                [
                    'label' => __('Border Radius', 'marmot'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );
    }

}
