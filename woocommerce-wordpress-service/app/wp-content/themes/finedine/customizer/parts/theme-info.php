<?php
/**
 * Theme Info
 *
 * @since   finedine 1.0
 * @package finedine
 */

if ( ! function_exists( 'finedine_add_info_customizer' ) ) {
	/**
	 * Theme Info
	 *
	 * @param $wp_customize
	 */
	function finedine_add_info_customizer ( $wp_customize ) {

		// Theme important links started.
		class Finedine_Important_Links extends WP_Customize_Control {

			public $type = 'finedine-important-links';

			public function render_content() {
				// Add Theme instruction, Support Forum, Demo Link, Rating Link.
				$important_links = array(
					'theme-info'    => array(
						'link' => esc_url( 'https://www.sampression.com/themes/finedine/' ),
						'text' => esc_html__( 'Theme Info', 'finedine' ),
					),
					'support'       => array(
						'link' => esc_url( 'https://www.sampression.com/support/' ),
						'text' => esc_html__( 'Support', 'finedine' ),
					),
					'documentation' => array(
						'link' => esc_url( 'https://www.sampression.com/documentation-finedine/' ),
						'text' => esc_html__( 'Documentation', 'finedine' ),
					),
					'demo'          => array(
						'link' => esc_url( 'https://www.demo.sampression.com/finedine/' ),
						'text' => esc_html__( 'Live Theme Demo', 'finedine' ),
					),
					'demo'          => array(
						'link' => esc_url( 'https://www.sampression.com/forums/' ),
						'text' => esc_html__( 'Community Forum', 'finedine' ),
					),
				);

				foreach ( $important_links as $important_link ) {
					echo '<p class="btn-wrap"><a target="_blank" href="' . esc_attr( $important_link['link'] ) . '" >' . esc_html( $important_link['text'] ) . ' </a></p>';
				}
			}
		}

		$wp_customize->add_section( 'finedine_important_links', array(
			'priority' => 1,
			'title'    => __( 'Finedine Important Links', 'finedine' ),
		) );

		$wp_customize->add_setting( 'finedine_theme_settings[finedine_important_links]',
			array(
				'capability'        => 'manage_options',
				'type'              => 'option',
				'sanitize_callback' => 'finedine_links_sanitize',
			)
		);

		$wp_customize->add_control( new
			finedine_Important_Links( $wp_customize,
				'finedine_theme_settings[finedine_important_links]', array(
					'label'    => __( 'Important Links', 'finedine' ),
					'section'  => 'finedine_important_links',
					'settings' => 'finedine_theme_settings[finedine_important_links]',
				)
			)
		);

	}
}

add_action( 'customize_register', 'finedine_add_info_customizer' );

