<?php

class Restaurantz_Address_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'restaurantz-address',
			__( 'Restaurantz: Address', 'restaurantz' ),
			array(
				'description' => __( 'Displays contact address details', 'restaurantz' ),
				),
			array(),
			array(
				'title' => array(
					'type' => 'text',
					'label' => __( 'Title', 'restaurantz' ),
				),
				'sub_title' => array(
					'type'  => 'text',
					'label' => __( 'Sub Title', 'restaurantz' ),
				),
				'address_repeater' => array(
					'type'      => 'repeater',
					'label'     => __( 'Enter Contact Details.', 'restaurantz' ),
					'item_name' => __( 'Details', 'restaurantz' ),
					'item_label' => array(
						'selector'     => "[id*='address_repeater-contact']",
						'update_event' => 'change',
						'value_method' => 'val',
					),
					'fields' => array(
						'icon' => array(
							'type'  => 'icon',
							'label' => __( 'Select Icon', 'restaurantz' ),
						),
						'contact' => array(
							'type'  => 'text',
							'label' => __( 'Enter Address Details like Phone Number / Address / Location', 'restaurantz' ),
						),
						'contact_detail' => array(
							'type'  => 'text',
							'label' => __( 'Enter Details for Above Fields', 'restaurantz' ),
						),
					),
				),
			)
		);

	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'restaurantz-address', __FILE__, 'Restaurantz_Address_Widget' );
