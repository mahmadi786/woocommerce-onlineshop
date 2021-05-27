<?php

class Restaurantz_Social_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'restaurantz-social',
			__( 'Restaurantz: Social', 'restaurantz' ),
			array(
				'description' => __( 'Social Icons Widget', 'restaurantz' ),
			),
			array(),
			array(
				'title' => array(
					'type'  => 'text',
					'label' => __( 'Title', 'restaurantz' ),
				),
				'subtitle' => array(
					'type'  => 'text',
					'label' => __( 'Sub Title', 'restaurantz' ),
				),
			)
		);

	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'restaurantz-social', __FILE__, 'Restaurantz_Social_Widget' );
