<?php
/**
 * Team widget.
 *
 * @package Restaurantz
 */

class Restaurantz_Team_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'restaurantz-team',
			__( 'Restaurantz: Team', 'restaurantz' ),
			array(
				'description' => __( 'Displays team member carousel', 'restaurantz' ),
			),
			array(),
			array(

				'title' => array(
					'type'  => 'text',
					'label' => __( 'Title', 'restaurantz' ),
				),
				'sub_title' => array(
					'type' => 'text',
					'label' => __( 'Sub Title', 'restaurantz' ),
				),
				'members' => array(
					'type'       => 'repeater',
					'label'      => __( 'Members', 'restaurantz' ),
					'item_name'  => __( 'Member', 'restaurantz' ),
					'item_label' => array(
						'selector'     => "[id*='members-full_name']",
						'update_event' => 'change',
						'value_method' => 'val',
					),
					'fields' => array(
						'full_name' => array(
							'type'  => 'text',
							'label' => __( 'Full Name', 'restaurantz' ),
						),
						'position' => array(
							'type'  => 'text',
							'label' => __( 'Position', 'restaurantz' ),
						),
						'profile_picture' => array(
							'type'     => 'media',
							'library'  => 'image',
							'label'    => __( 'Image', 'restaurantz' ),
							'fallback' => true,
						),
					),
				),
				'per_row' => array(
					'type'    => 'select',
					'label'   => __( 'Teams per row', 'restaurantz' ),
					'default' => 3,
					'options' => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
					),
				),
			)
		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'restaurantz-team', __FILE__, 'Restaurantz_Team_Widget' );
