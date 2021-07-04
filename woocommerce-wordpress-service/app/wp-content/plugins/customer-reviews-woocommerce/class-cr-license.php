<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CR_License' ) ) :

	class CR_License {
		public function __construct() {
		}

		public function check_license() {
			$licenseKey = get_option( 'ivole_license_key', '' );
			if( strlen( $licenseKey ) === 0 ) {
				return __( 'No license key entered', 'customer-reviews-woocommerce' );
			}
			if( ! Ivole::is_curl_installed() ) {
				return __( 'Error: cURL library is missing on the server.', 'customer-reviews-woocommerce' );
			}
			$data = array(
				'token' => '164592f60fbf658711d47b2f55a1bbba',
				'licenseKey' => $licenseKey,
				'shopDomain' => Ivole_Email::get_blogurl()
			);
			$api_url = 'https://api.cusrev.com/v1/production/check-license';
			$data_string = json_encode($data);
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $api_url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen( $data_string ) )
			);
			$result = curl_exec( $ch );
			if( false === $result ) {
				return __( 'Unknown: ', 'customer-reviews-woocommerce' ) . curl_error( $ch );
			}
			$result = json_decode( $result );
			if( isset( $result->error ) ) {
				update_option( 'ivole_form_rating_bar', 'smiley' );
				update_option( 'ivole_form_geolocation', 'no' );
				return __( 'Not Active: ', 'customer-reviews-woocommerce' ) . $result->error;
			} else if( isset( $result->valid ) && 1 == $result->valid ) {
				return __( 'Active: Professional Version', 'customer-reviews-woocommerce' );
			} else if( isset( $result->expired ) && 1 == $result->expired ) {
				update_option( 'ivole_form_rating_bar', 'smiley' );
				update_option( 'ivole_form_geolocation', 'no' );
				return __( 'Expired: Professional Version', 'customer-reviews-woocommerce' );
			} else if( isset( $result->expired ) && isset( $result->valid )
			&& false === $result->expired && false === $result->valid ) {
				update_option( 'ivole_form_rating_bar', 'smiley' );
				update_option( 'ivole_form_geolocation', 'no' );
				return __( 'Active: Free Version', 'customer-reviews-woocommerce' );
			} else {
				update_option( 'ivole_form_rating_bar', 'smiley' );
				update_option( 'ivole_form_geolocation', 'no' );
				return __( 'Unknown Error', 'customer-reviews-woocommerce' );
			}
		}

		public function register_license( $new_license ) {
			if( strlen( $new_license ) === 0 ) {
				return;
			}
			if( ! Ivole::is_curl_installed() ) {
				WC_Admin_Settings::add_error( __( 'Error: cURL library is missing on the server.', 'customer-reviews-woocommerce' ) );
				return;
			}
			$data = array(
				'token' => '164592f60fbf658711d47b2f55a1bbba',
				'licenseKey' => $new_license,
				'shopDomain' => Ivole_Email::get_blogurl()
			);
			$api_url = 'https://api.cusrev.com/v1/production/register-license';
			$data_string = json_encode($data);
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $api_url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen( $data_string ) )
			);
			$result = curl_exec( $ch );
			if( false === $result ) {
				WC_Admin_Settings::add_error( sprintf( __( 'License registration error: %s.', 'customer-reviews-woocommerce' ), curl_error( $ch ) ) );
				return;
			}
			$result = json_decode( $result );
			if( isset( $result->status ) ) {
				WC_Admin_Settings::add_message( sprintf( __( 'License has been successfully registered for \'%s\'.', 'customer-reviews-woocommerce' ), Ivole_Email::get_blogurl() ) );
				return;
			} else if( isset( $result->error ) ) {
				WC_Admin_Settings::add_error( sprintf( __( 'License registration error: %s.', 'customer-reviews-woocommerce' ), $result->error ) );
				return;
			} else {
				WC_Admin_Settings::add_error( __( 'License registration error #99', 'customer-reviews-woocommerce' ) );
				return;
			}
		}

	}

endif;
