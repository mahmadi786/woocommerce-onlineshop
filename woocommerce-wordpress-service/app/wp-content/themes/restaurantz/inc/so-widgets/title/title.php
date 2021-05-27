<?php

class Restaurantz_Title_Subtitle_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'restaurantz-title-subtitle',
			__( 'Restaurantz: Title', 'restaurantz' ),
			array(
				'description' => __( 'A simple title and subtitle widget.', 'restaurantz' ),
			),
			array(),
			array(
				'primary_title' => array(
					'type'  => 'text',
					'label' => __( 'Primary Title', 'restaurantz' ),
				),
				'secondary_title' => array(
					'type'  => 'text',
					'label' => __( 'Secondary Title', 'restaurantz' ),
				),
				'title_content' => array(
					'type'  => 'textarea',
					'label' => __( 'Sub Title', 'restaurantz' ),
				),
				'align' => array(
					'type'    => 'select',
					'label'   => __( 'Alignment', 'restaurantz' ),
					'default' =>'center',
					'options' => array(
						'left'   => __( 'Left', 'restaurantz' ),
						'right'  => __( 'Right', 'restaurantz' ),
						'center' => __( 'Center', 'restaurantz' ),
					),
				),
			)
		);

	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'restaurantz-title-subtitle', __FILE__, 'Restaurantz_Title_Subtitle_Widget' );
