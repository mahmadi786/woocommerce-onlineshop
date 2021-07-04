<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once('class-cr-email-func.php');
require_once('class-ivole-admin.php');
require_once('class-ivole-sender.php');
require_once('class-ivole-reviews.php');
require_once('class-ivole-endpoint.php');
require_once('class-ivole-endpoint-replies.php');
require_once('class-cr-referrals.php');
require_once( __DIR__ . '/includes/reminders/class-cr-manual.php' );
require_once('class-ivole-structured-data.php');
require_once('class-ivole-replies.php');
require_once( __DIR__ . '/includes/blocks/class-cr-all-reviews.php' );
require_once( __DIR__ . '/includes/blocks/class-cr-reviews-grid.php' );
require_once( __DIR__ . '/includes/blocks/class-cr-reviews-slider.php' );
require_once('class-ivole-admin-menu-reviews.php');
require_once('class-ivole-admin-menu-reminders.php');
require_once('class-cr-admin-menu-settings.php');
require_once('class-ivole-admin-menu-diagnostics.php');
require_once( __DIR__ . '/includes/reviews/class-cr-ajax-reviews.php');
require_once( __DIR__ . '/includes/reviews/class-cr-reviews-list-table.php' );
require_once('class-ivole-reminders-list-table.php');
require_once('class-ivole-settings-review-extensions.php');
require_once('class-ivole-settings-license.php');
require_once('class-ivole-settings-referrals.php');
require_once( __DIR__ . '/includes/settings/class-cr-settings-review-reminder.php' );
require_once( __DIR__ . '/includes/settings/class-cr-settings-review-discount.php' );
require_once( __DIR__ . '/includes/settings/class-cr-settings-trust-badges.php' );
require_once( __DIR__ . '/includes/settings/class-cr-settings-shortcodes.php' );
require_once( __DIR__ . '/includes/google/class-cr-google-shopping-feed.php' );
require_once( __DIR__ . '/includes/google/class-cr-google-shopping-prod-feed.php' );
require_once( __DIR__ . '/includes/google/class-cr-admin-menu-product-feed.php' );
require_once( __DIR__ . '/includes/google/class-cr-product-feed-status.php' );
require_once( __DIR__ . '/includes/google/class-cr-product-feed-categories.php' );
require_once( __DIR__ . '/includes/google/class-cr-product-feed-identifiers.php' );
require_once( __DIR__ . '/includes/google/class-cr-product-feed-attributes.php' );
require_once( __DIR__ . '/includes/google/class-cr-product-feed-reviews.php' );
require_once( __DIR__ . '/includes/google/class-cr-product-fields.php' );
require_once('class-cr-checkout.php');
require_once( __DIR__ . '/includes/import-export/class-cr-admin-import.php' );
require_once( __DIR__ . '/includes/import-export/class-cr-admin-menu-import.php' );
require_once( __DIR__ . '/includes/import-export/class-cr-export-reviews.php' );
require_once( __DIR__ . '/includes/import-export/class-cr-reviews-exporter.php' );
require_once( __DIR__ . '/includes/tags/class-cr-admin-menu-tags.php' );
require_once( __DIR__ . '/includes/tags/class-cr-tags.php' );
require_once( __DIR__ . '/includes/trust-badge/class-cr-trust-badge.php' );
require_once( __DIR__ . '/includes/trust-badge/class-cr-floating-trust-badge.php' );
require_once( __DIR__ . '/includes/qna/class-cr-qna.php' );
require_once( __DIR__ . '/includes/qna/class-cr-qna-list-table.php' );
require_once( __DIR__ . '/includes/qna/class-cr-admin-menu-qna.php' );
require_once( __DIR__ . '/includes/qna/class-cr-settings-qna.php' );
require_once( __DIR__ . '/includes/qna/class-cr-qna-shortcode.php' );

class Ivole {
	public function __construct() {
		if( function_exists( 'wc' ) ) {
			$ivole_admin = new Ivole_Admin();
			$ivole_sender = new Ivole_Sender();
			$ivole_reviews = new Ivole_Reviews();
			$ivole_endpoint = new Ivole_Endpoint();
			$ivole_endpoint_replies = new Ivole_Endpoint_Replies();
			$cr_referrals = new CR_Referrals();
			$ivole_structured_data = new Ivole_StructuredData();
			$cr_checkout = new CR_Checkout();
			$cr_product_fields = new CR_Product_Fields();
			$cr_ajax_reviews = new CR_Ajax_Reviews();
			$cr_tags = new CR_Tags();
			$cr_qna = new CR_Qna();
			$cr_trust_badge = new CR_Trust_Badge();

			if( 'yes' === get_option( 'ivole_reviews_shortcode', 'no' ) ) {
				$cr_all_reviews = new CR_All_Reviews();
				$cr_reviews_grid = new CR_Reviews_Grid();
				$cr_reviews_slider = new CR_Reviews_Slider();
				$cr_qna_shortcode = new CR_Qna_Shortcode( $cr_qna );
			}

			if ( is_admin() ) {
				$reviews_admin_menu = new Ivole_Reviews_Admin_Menu();
				$reminders_admin_menu = new Ivole_Reminders_Admin_Menu();
				$tags_admin_menu = new CR_Tags_Admin_Menu();
				$qna_admin_menu = new CR_Qna_Admin_Menu();
				$product_feed_admin_menu = new CR_Product_Feed_Admin_Menu();
				$settings_admin_menu = new CR_Settings_Admin_Menu();
				$diagnostics_admin_menu = new Ivole_Diagnostics_Admin_Menu();
				$cr_manual = new CR_Manual();
				$cr_admin_import = new CR_Admin_Import();
				$import_admin_menu = new CR_Import_Admin_Menu();
				$reviews_exporter = new CR_Reviews_Exporter();

				new CR_Review_Reminder_Settings( $settings_admin_menu );
				new Ivole_Review_Extensions_Settings( $settings_admin_menu );
				new CR_Review_Discount_Settings( $settings_admin_menu );
				new Ivole_Premium_Settings( $settings_admin_menu );
				new Ivole_Trust_Badges( $settings_admin_menu );
				new Ivole_Referrals_Settings( $settings_admin_menu );
				new CR_Qna_Settings( $settings_admin_menu );
				new CR_Shortcodes_Settings( $settings_admin_menu );
				new CR_Status_Product_Feed( $product_feed_admin_menu );
				new CR_Categories_Product_Feed( $product_feed_admin_menu );
				new CR_Identifiers_Product_Feed( $product_feed_admin_menu );
				new CR_Attributes_Product_Feed( $product_feed_admin_menu );
				new CR_Reviews_Product_Feed( $product_feed_admin_menu );
				new CR_Export_Reviews( $import_admin_menu );
			}
		}
	}

	/**
	* Check installation cURL php extension
	* @return bool
	*/
	public static function is_curl_installed()
	{
		return in_array  ('curl', get_loaded_extensions() );
	}
}
