<?php

defined('ABSPATH') || exit;

use function Marmot\get_elementor_templates;

$add_setting_controls = array_merge($add_setting_controls,
        apply_filters('hqt/customizer/settings/post/single',
                array_merge(
                        [
                            // General Layout
                            'hq_post_single_standart_layout' => [
                                'default' => '',
                                'label' => _x('Standart Post Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_post_single',
                                'choices' => get_elementor_templates('single', 0, 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                            ],
                            // TODO Add info - https://wordpress.org/support/article/post-formats/
                            // 
                            // Image
                            'hq_post_single_image_layout' => [
                                'default' => 'default',
                                'label' => _x('Image Post Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_post_single',
                                'choices' => get_elementor_templates('single', 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => _x('A single image. The first <img /> tag in the post could be considered the image. Alternatively, if the post consists only of a URL, that will be the image URL and the title of the post (post_title) will be the title attribute for the image. ', 'settings', 'marmot')
                                . \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                            ],
                            // Gallery
                            'hq_post_single_gallery_layout' => [
                                'default' => 'default',
                                'label' => _x('Gallery Post Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_post_single',
                                'choices' => get_elementor_templates('single', 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => _x('A gallery of images. Post will likely contain a gallery shortcode and will have image attachments. ', 'settings', 'marmot')
                                . \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                            ],
                            // Audio
                            'hq_post_single_audio_layout' => [
                                'default' => 'default',
                                'label' => _x('Audio Post Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_post_single',
                                'choices' => get_elementor_templates('single', 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => _x('An audio file or playlist. Could be used for Podcasting. ', 'settings', 'marmot')
                                . \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                            ],
                            // Video
                            'hq_post_single_video_layout' => [
                                'default' => 'default',
                                'label' => _x('Video Post Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_post_single',
                                'choices' => get_elementor_templates('single', 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => _x('A single video or video playlist. ', 'settings', 'marmot')
                                . \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                            ],
                            // Link
                            'hq_post_single_link_layout' => [
                                'default' => 'default',
                                'label' => _x('Link Post Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_post_single',
                                'choices' => get_elementor_templates('single', 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => esc_html_x('A link to another site. Themes may wish to use the first <a href=""> tag in the post content as the external link for that post. An alternative approach could be if the post consists only of a URL, then that will be the URL and the title (post_title) will be the name attached to the anchor for it. ', 'settings', 'marmot')
                                . \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                            ],
                            // Quote
                            'hq_post_single_quote_layout' => [
                                'default' => 'default',
                                'label' => _x('Quote Post Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_post_single',
                                'choices' => get_elementor_templates('single', 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => _x('A quotation. Probably will contain a blockquote holding the quote content. Alternatively, the quote may be just the content, with the source/author being the title. ', 'settings', 'marmot')
                                . \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                            ],
                            // Status
                            'hq_post_single_status_layout' => [
                                'default' => 'default',
                                'label' => _x('Status Post Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_post_single',
                                'choices' => get_elementor_templates('single', 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => _x('A short status update, similar to a Twitter status update. ', 'settings', 'marmot')
                                . \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                            ],
                            // Chat
                            'hq_post_single_chat_layout' => [
                                'default' => 'default',
                                'label' => _x('Chat Post Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_post_single',
                                'choices' => get_elementor_templates('single', 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => _x('A chat transcript. ', 'settings', 'marmot')
                                . \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                            ],
                            // Aside
                            'hq_post_single_aside_layout' => [
                                'default' => 'default',
                                'label' => _x('Aside Post Layout', 'settings', 'marmot'),
                                'type' => 'select',
                                'section' => 'hq_post_single',
                                'choices' => get_elementor_templates('single', 1),
                                'sanitize_callback' => '\Marmot\Customizer::sanitize_select',
                                'description' => _x('Typically styled without a title. Similar to a Facebook note update. ', 'settings', 'marmot')
                                . \Marmot\Customizer\Settings::full_mode_requires_description('single'),
                            ],
                        ],
                        Marmot\Customizer\Settings::generate_layout_templates_controls('hq_post_single', _x('Standart Post', 'settings', 'marmot'))
                ),
                'post'
        )
);
