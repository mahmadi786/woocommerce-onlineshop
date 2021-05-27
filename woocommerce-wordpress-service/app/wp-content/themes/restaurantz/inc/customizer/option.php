<?php
/**
 * Theme Options.
 *
 * @package Restaurantz
 */

$default = restaurantz_get_default_theme_options();

// Add Panel.
$wp_customize->add_panel( 'theme_option_panel',
	array(
	'title'      => __( 'Theme Options', 'restaurantz' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);

// Setting show_title.
$wp_customize->add_setting( 'theme_options[show_title]',
	array(
	'default'           => $default['show_title'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'restaurantz_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[show_title]',
	array(
	'label'    => __( 'Show Site Title', 'restaurantz' ),
	'section'  => 'title_tagline',
	'type'     => 'checkbox',
	'priority' => 25,
	)
);
// Setting show_tagline.
$wp_customize->add_setting( 'theme_options[show_tagline]',
	array(
	'default'           => $default['show_tagline'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'restaurantz_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[show_tagline]',
	array(
	'label'    => __( 'Show Tagline', 'restaurantz' ),
	'section'  => 'title_tagline',
	'type'     => 'checkbox',
	'priority' => 25,
	)
);

// Layout Section.
$wp_customize->add_section( 'section_layout',
	array(
	'title'      => __( 'Layout Options', 'restaurantz' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting global_layout.
$wp_customize->add_setting( 'theme_options[global_layout]',
	array(
	'default'           => $default['global_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'restaurantz_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[global_layout]',
	array(
	'label'    => __( 'Global Layout', 'restaurantz' ),
	'section'  => 'section_layout',
	'type'     => 'select',
	'choices'  => restaurantz_get_global_layout_options(),
	'priority' => 100,
	)
);
// Setting archive_layout.
$wp_customize->add_setting( 'theme_options[archive_layout]',
	array(
	'default'           => $default['archive_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'restaurantz_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[archive_layout]',
	array(
	'label'    => __( 'Archive Layout', 'restaurantz' ),
	'section'  => 'section_layout',
	'type'     => 'select',
	'choices'  => restaurantz_get_archive_layout_options(),
	'priority' => 100,
	)
);
// Setting archive_image.
$wp_customize->add_setting( 'theme_options[archive_image]',
	array(
	'default'           => $default['archive_image'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'restaurantz_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[archive_image]',
	array(
	'label'    => __( 'Image in Archive', 'restaurantz' ),
	'section'  => 'section_layout',
	'type'     => 'select',
	'choices'  => restaurantz_get_image_sizes_options( true, array( 'disable', 'thumbnail', 'large' ), false ),
	'priority' => 100,
	)
);
// Setting archive_image_alignment.
$wp_customize->add_setting( 'theme_options[archive_image_alignment]',
	array(
	'default'           => $default['archive_image_alignment'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'restaurantz_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[archive_image_alignment]',
	array(
	'label'           => __( 'Image Alignment in Archive', 'restaurantz' ),
	'section'         => 'section_layout',
	'type'            => 'select',
	'choices'         => restaurantz_get_image_alignment_options(),
	'priority'        => 100,
	'active_callback' => 'restaurantz_is_image_in_archive_active',
	)
);
// Setting single_image.
$wp_customize->add_setting( 'theme_options[single_image]',
	array(
	'default'           => $default['single_image'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'restaurantz_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[single_image]',
	array(
	'label'    => __( 'Image in Single Post/Page', 'restaurantz' ),
	'section'  => 'section_layout',
	'type'     => 'select',
	'choices'  => restaurantz_get_image_sizes_options( true, array( 'disable', 'large' ), false ),
	'priority' => 100,
	)
);

// Pagination Section.
$wp_customize->add_section( 'section_pagination',
	array(
	'title'      => __( 'Pagination Options', 'restaurantz' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting pagination_type.
$wp_customize->add_setting( 'theme_options[pagination_type]',
	array(
	'default'           => $default['pagination_type'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'restaurantz_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[pagination_type]',
	array(
	'label'       => __( 'Pagination Type', 'restaurantz' ),
	'section'     => 'section_pagination',
	'type'        => 'select',
	'choices'     => restaurantz_get_pagination_type_options(),
	'priority'    => 100,
	)
);

// Footer Section.
$wp_customize->add_section( 'section_footer',
	array(
	'title'      => __( 'Footer Options', 'restaurantz' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting footer_background_image.
$wp_customize->add_setting( 'theme_options[footer_background_image]',
	array(
	'default'           => $default['footer_background_image'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'restaurantz_sanitize_image',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control( $wp_customize, 'theme_options[footer_background_image]',
		array(
		'label'           => __( 'Footer Widgets Background Image.', 'restaurantz' ),
		'description'	  => sprintf( __( 'Recommended Size %1$dpx X %2$dpx', 'restaurantz' ), 1400, 335 ),
		'section'         => 'section_footer',
		'settings'        => 'theme_options[footer_background_image]',
		'priority'        => 100,

		)
	)
);
// Setting copyright_text.
$wp_customize->add_setting( 'theme_options[copyright_text]',
	array(
	'default'           => $default['copyright_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'restaurantz_sanitize_footer_content',
	)
);
$wp_customize->add_control( 'theme_options[copyright_text]',
	array(
	'label'    => __( 'Copyright Text', 'restaurantz' ),
	'section'  => 'section_footer',
	'type'     => 'text',
	'priority' => 100,
	)
);

// Breadcrumb Section.
$wp_customize->add_section( 'section_breadcrumb',
	array(
	'title'      => __( 'Breadcrumb Options', 'restaurantz' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting breadcrumb_type.
$wp_customize->add_setting( 'theme_options[breadcrumb_type]',
	array(
	'default'           => $default['breadcrumb_type'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'restaurantz_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[breadcrumb_type]',
	array(
	'label'       => __( 'Breadcrumb Type', 'restaurantz' ),
	'description' => sprintf( __( 'Advanced: Requires %1$sBreadcrumb NavXT%2$s plugin', 'restaurantz' ), '<a href="https://wordpress.org/plugins/breadcrumb-navxt/" target="_blank">','</a>' ),
	'section'     => 'section_breadcrumb',
	'type'        => 'select',
	'choices'     => restaurantz_get_breadcrumb_type_options(),
	'priority'    => 100,
	)
);
