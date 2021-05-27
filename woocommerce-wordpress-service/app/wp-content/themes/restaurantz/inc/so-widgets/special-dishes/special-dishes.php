<?php

class Restaurantz_Special_Dishes_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'restaurantz-special-dishes',
			__( 'Restaurantz: Special Dishes', 'restaurantz' ),
			array(
				'description' => __( 'Display Special Dishes.', 'restaurantz' ),
			),
			array(),
			array(
				'title' => array(
					'type'  => 'text',
					'label' => __( 'Title', 'restaurantz' ),
				),
				'sub_title' => array(
					'type'  => 'text',
					'label' => __( 'Sub Title', 'restaurantz' ),
				),
				'dishes_post_id' => array(
					'type'        => 'posts',
					'label'       => __( 'Select Dishes', 'restaurantz' ),
					'description' => sprintf( __( 'Choose %1$sPost Type%2$s as %3$sMenu Items%4$s while building query to select dishes.', 'restaurantz' ), '<strong>', '</strong>', '<strong>', '</strong>' ),
				),
				'dishes_custom_ids' => array(
					'type'        => 'text',
					'label'       => __( 'Menu IDs', 'restaurantz' ),
					'description' => __( 'Enter Menu IDs separated by comma. These IDs will be used if no Dishes are selected in above field.', 'restaurantz' ),
				),
				'settings' => array(
					'type'   => 'section',
					'label'  => __( 'Settings', 'restaurantz' ),
					'fields' => array(
						'per_row' => array(
							'type' => 'select',
							'label' => __( 'Dishes Per Row', 'restaurantz' ),
							'default' => 4,
							'options' => array(
								'1' => 1,
								'2' => 2,
								'3' => 3,
								'4' => 4,
							),
						),
						'featured_image' => array(
							'type'    => 'select',
							'label'   => __( 'Image Size', 'restaurantz' ),
							'default' => 'restaurantz-food-thumb',
							'options' => restaurantz_get_image_sizes_options( true, array( 'disable', 'thumbnail', 'medium', 'restaurantz-food-thumb' ), false ),
						),
						'excerpt_settings' => array(
							'type'   => 'section',
							'label'  => __( 'Excerpt Settings', 'restaurantz' ),
							'hide'   => true,
							'fields' => array(
								'excerpt_length' => array(
									'type'        => 'number',
									'label'       => __( 'Excerpt Length', 'restaurantz' ),
									'description' => __( 'in words', 'restaurantz' ),
									'default'     => 20,
								),
								'disable_excerpt' => array(
									'type'  => 'checkbox',
									'label' => __( 'Disable Excerpt', 'restaurantz' ),
								),
							),
						),
					),
				),
			),
			plugin_dir_path( __FILE__ )
		);
	}

	function get_valid_menu_ids( $instance ) {

		$posts_selector = $instance['dishes_post_id'];
		$raw_select_ids = siteorigin_widget_post_selector_process_query( $posts_selector );
		$custom_ids = $instance['dishes_custom_ids'];

		$valid_select_ids = array();
		$select_ids       = array();
		$output           = array();

		if ( isset( $raw_select_ids['post_type'] ) && 'nova_menu_item' == $raw_select_ids['post_type'] ) {
			$all_posts = get_posts( $raw_select_ids );
			$valid_select_ids = wp_list_pluck( $all_posts, 'ID' );
		}

		if ( ! empty( $valid_select_ids ) ) {
			$output = $valid_select_ids;
		}

		if ( empty( $output ) ) {
			// No IDs from select box; try from custom text input.
			$custom_ids = sanitize_text_field( $custom_ids );
			$exploded = explode( ',', $custom_ids );
			$temp_ids = $exploded;
			$valid_custom_ids = array();

			if ( ! empty( $temp_ids ) ) {
				for ( $i = 0; $i < count( $temp_ids ); $i++ ) {
					if ( 'nova_menu_item' === get_post_type( $temp_ids[ $i ] ) ) {
						$valid_custom_ids[] = $temp_ids[ $i ];
					}
				}
			}
			if ( ! empty( $valid_custom_ids ) ) {
				$output = $valid_custom_ids;
			}
		} // End if output.

		return $output;

	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'restaurantz-special-dishes', __FILE__, 'Restaurantz_Special_Dishes_Widget' );
