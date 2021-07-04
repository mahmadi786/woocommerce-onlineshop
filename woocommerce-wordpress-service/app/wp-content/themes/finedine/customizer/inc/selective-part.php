<?php
/**
 * Add the selective part for customizer in frontend.
 */
if ( class_exists( 'WP_Customize_Control' ) ) :
	$wp_customize->selective_refresh->add_partial( 'blogname',
		array(
			// You can also select a css class.
			'selector' => '.site-title',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'blogdescription',
		array(
			'selector' => '.site-description',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'finedine_theme_settings[finedine_socials_facebook]',
		array(
			'selector' => '.social-connect',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'nav_menu',
		array(
			'selector' => '#primary-menu',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'website_layout',
		array(
			'selector' => '#content-wrapper',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'finedine_theme_settings[finedine_footerText_heading_label]',
		array(
			'selector' => '.footer-widget',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'finedine_theme_settings[finedine_copyright_text]',
		array(
			'selector' => '.copyright ',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'widgetText_heading_label',
		array(
			'selector' => '.sidebar',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'finedine_theme_settings[select_post_feature_slider]',
		array(
			'selector' => '.hero-slider .owl-stage-outer .hero-content',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'finedine_theme_settings[section_testimonial_title]',
		array(
			'selector' => '.widget-review .block-title',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'finedine_theme_settings[finedine_form_title]',
		array(
			'selector' => '#reservation-block .block-heading',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'finedine_theme_settings[finedine_header_left_text]',
		array(
			'selector' => '.left-text-block',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'finedine_theme_settings[finedine_header_middle_text]',
		array(
			'selector' => '.middle-text-block',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'finedine_theme_settings[finedine_header_right_text]',
		array(
			'selector' => '.right-text-block',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'finedine_theme_settings[finedine_header_reservation_text]',
		array(
			'selector' => '.smooth-scroll',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'finedine_theme_settings[finedine_contact_details_address]',
		array(
			'selector' => '#reservation-block .footer-contact',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'sm_cfa_block_widget',
		array(
			'selector' => '.widget-notice',
		)
	);

endif;
