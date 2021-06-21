<?php
/**
 * FoodHunt Admin Class.
 *
 * @author  ThemeGrill
 * @package foodhunt
 * @since   1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FoodHunt_Admin' ) ) :

	/**
	 * FoodHunt_Admin Class.
	 */
	class FoodHunt_Admin {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Localize array for import button AJAX request.
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'foodhunt-admin-style', get_template_directory_uri() . '/inc/admin/css/admin.css', array(), FOODHUNT_THEME_VERSION );

			wp_enqueue_script( 'foodhunt-plugin-install-helper', get_template_directory_uri() . '/inc/admin/js/plugin-handle.js', array( 'jquery' ), FOODHUNT_THEME_VERSION, true );

			$welcome_data = array(
				'uri'      => esc_url( admin_url( '/themes.php?page=demo-importer&browse=all&foodhunt-hide-notice=welcome' ) ),
				'btn_text' => esc_html__( 'Processing...', 'foodhunt' ),
				'nonce'    => wp_create_nonce( 'foodhunt_demo_import_nonce' ),
			);

			wp_localize_script( 'foodhunt-plugin-install-helper', 'foodhuntRedirectDemoPage', $welcome_data );
		}
	}

endif;

return new FoodHunt_Admin();
