<?php

class Restaurantz_Latest_News_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'restaurantz_latest_news',
			__( 'Restaurantz: Latest News', 'restaurantz' ),
			array(
				'description' => __( 'Displays latest posts in grid', 'restaurantz' ),
			),
			array(),
			array(
				'title' => array(
					'type' => 'text',
					'label' => __( 'Title', 'restaurantz' ),
				),
				'sub_title' => array(
					'type' => 'text',
					'label' => __( 'Sub Title', 'restaurantz' ),
				),
				'posts' => array(
					'type'  => 'posts',
					'label' => __( 'Posts', 'restaurantz' ),
				),
				'settings' => array(
					'type'   => 'section',
					'label'  => __( 'Settings', 'restaurantz' ),
					'hide' => true,
					'fields' => array(
		    			'post_column' => array(
					        'type'  => 'select',
					        'label' => __( 'Number of Columns', 'restaurantz' ),
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
							'default' => 'medium',
							'options' => restaurantz_get_image_sizes_options( true, array( 'disable', 'thumbnail', 'medium' ), false ),
						),
						'excerpt_length' => array(
							'type'        => 'number',
							'label'       => __( 'Excerpt Length', 'restaurantz' ),
							'description' => __( 'in words', 'restaurantz' ),
							'default'     => 10,
		   				 ),
						'more_text' => array(
							'type'    => 'text',
							'label'   => __( 'Read More Text', 'restaurantz' ),
							'default' => __( 'Read more', 'restaurantz' ),
						),
						'disable_date' => array(
							'type'  => 'checkbox',
							'label' => __( 'Disable Date in Post', 'restaurantz' ),
		    			),
		    			'disable_comment' => array(
							'type'  => 'checkbox',
							'label' => __( 'Disable Comment in Post', 'restaurantz' ),
		    			),
		    			'disable_excerpt' => array(
							'type'  => 'checkbox',
							'label' => __( 'Disable Post Excerpt', 'restaurantz' ),
		    			),
		    			'disable_date' => array(
							'type'  => 'checkbox',
							'label' => __( 'Disable Date in Post', 'restaurantz' ),
		    			),
		    			'disable_more_text' => array(
							'type'  => 'checkbox',
							'label' => __( 'Disable Read More Text', 'restaurantz' ),
		    			),
	    			),
				),
			),
			plugin_dir_path( __FILE__ )
		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'restaurantz_latest_news', __FILE__, 'Restaurantz_Latest_News_Widget' );
