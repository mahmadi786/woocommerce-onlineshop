<?php

class Restaurantz_Cta_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'restaurantz-cta',
			__( 'Restaurantz: CTA', 'restaurantz' ),
			array(
				'description' => __( 'Simple Call to action widget', 'restaurantz' ),
			),
			array(),
			array(
				'title' => array(
					'type' => 'text',
					'label' => __( 'Title', 'restaurantz' ),
				),
				'sub_title' => array(
					'type' => 'text',
					'label' => __( 'Subtitle', 'restaurantz' ),
				),
				'button' => array(
					'type' => 'widget',
					'class' => 'SiteOrigin_Widget_Button_Widget',
					'label' => __( 'Button', 'restaurantz' ),
				),
			),
			plugin_dir_path( __FILE__ )
		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}

	function modify_child_widget_form( $child_widget_form, $child_widget ) {
		// Remove alignment option in Button.
		unset( $child_widget_form['design']['fields']['align'] );
		return $child_widget_form;
	}

	/**
	 * Initialize the CTA widget
	 */
	function initialize() {
		// This widget requires the button widget.
		if ( ! class_exists( 'SiteOrigin_Widget_Button_Widget' ) ) {
			SiteOrigin_Widgets_Bundle::single()->include_widget( 'button' );
		}
	}
}

siteorigin_widget_register( 'restaurantz-cta', __FILE__, 'Restaurantz_Cta_Widget' );
