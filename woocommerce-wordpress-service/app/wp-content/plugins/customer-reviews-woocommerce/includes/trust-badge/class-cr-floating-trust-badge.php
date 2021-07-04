<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CR_Floating_Trust_Badge' ) ) :

	class CR_Floating_Trust_Badge {

		protected $lang;
		public static $floating_light = array(
			'small' => array(
				'border'  => '#dfdfdf',
				'top'     => '#FFFFFF',
				'middle'  => '#F8942D',
				'bottom'  => '#FFFFFF'
			),
			'big'   => array(
				'border'  => '#dfdfdf',
				'top'     => '#F8942D',
				'middle'  => '#FFFFFF',
				'bottom'  => '#F2F2F2'
			)
		);
		public static $floating_dark = array(
			'small' => array(
				'border'  => '#373737',
				'top'     => '#373737',
				'middle'  => '#242424',
				'bottom'  => '#373737'
			),
			'big'   => array(
				'border'  => '#373737',
				'top'     => '#373737',
				'middle'  => '#242424',
				'bottom'  => '#373737'
			)
		);

	  public function __construct() {
			$this->lang = CR_Trust_Badge::get_badge_language();
			add_action( 'wp_footer', array( $this, 'display' ) );
	  }

		public function display() {
			if( isset( $_COOKIE['cr_hide_trustbadge'] ) ) {
				return;
			}
			if( apply_filters( 'cr_floatingtrustbadge_hide', false ) ) {
				return;
			}
			$l_suffix = '';
			$site_lang = '';
      if( 'en' !== $this->lang ) {
        $l_suffix = '-' . $this->lang;
				$site_lang = $this->lang . '/';
      }

			$light_small_src = 'https://www.cusrev.com/badges/' . Ivole_Email::get_blogurl() . '-cl' . $l_suffix . '.png';
      $light_big_src = 'https://www.cusrev.com/badges/' . Ivole_Email::get_blogurl() . '-cwl' . $l_suffix . '.png';
      $dark_small_src = 'https://www.cusrev.com/badges/' . Ivole_Email::get_blogurl() . '-cd' . $l_suffix . '.png';
      $dark_big_src = 'https://www.cusrev.com/badges/' . Ivole_Email::get_blogurl() . '-cwd' . $l_suffix . '.png';
      $small_src = '';
      $big_src = '';

			$float_style = get_option( 'ivole_trust_badge_floating_type', 'light' );
      if( 'light' === $float_style ) {
				$small_src = $light_small_src;
        $big_src = $light_big_src;
        $float_colors = CR_Floating_Trust_Badge::$floating_light['small'];
				$float_colors2 = array(
					'small' => CR_Floating_Trust_Badge::$floating_light['small'],
					'big' => CR_Floating_Trust_Badge::$floating_light['big']
				);
			} else  {
				$small_src = $dark_small_src;
        $big_src = $dark_big_src;
        $float_colors = CR_Floating_Trust_Badge::$floating_dark['small'];
				$float_colors2 = array(
					'small' => CR_Floating_Trust_Badge::$floating_dark['small'],
					'big' => CR_Floating_Trust_Badge::$floating_dark['big']
				);
			}
			$float_location = get_option( 'ivole_trust_badge_floating_location', 'bottomright' );
      if( 'bottomleft' === $float_location ) {
        $location_css = "left:0px;";
      } else {
        $location_css = "right:0px;";
      }

			$output = '<div id="cr_floatingtrustbadge_front" style="border-color: ' . $float_colors['border'] . '; ' . $location_css . '"; data-crcolors=\'' . json_encode( $float_colors2 ) . '\'>';
			$output .= '<div class="cr-floatingbadge-background">';
			$output .= '<div class="cr-floatingbadge-background-top" style="background-color: ' . $float_colors['top'] . ';"></div>';
			$output .= '<div class="cr-floatingbadge-background-middle" style="background-color: ' . $float_colors['middle'] . ';"></div>';
			$output .= '<div class="cr-floatingbadge-background-bottom" style="background-color: ' . $float_colors['bottom'] . ';"></div>';
			$output .= '</div>';
			$output .= '<div class="cr-floatingbadge-top">';
			$output .= '<svg width="70" height="65" viewBox="0 0 70 65" fill="none" xmlns="http://www.w3.org/2000/svg">';
			$output .= '<path d="M34.9752 53.9001L13.3948 65L17.5124 41.4914L0 24.8173L24.2098 21.3758L34.9752 0L45.7902 21.3758L70 24.8173L52.4876 41.4914L56.6052 65L34.9752 53.9001Z" fill="#F4DB6B"></path>';
			$output .= '<path d="M25.8965 38.2439C25.8965 43.1395 29.9645 47.1142 34.9752 47.1142C39.9858 47.1142 44.0538 43.1395 44.0538 38.2439H25.8965Z" fill="#E98B3E"></path>';
			$output .= '<path d="M29.7163 30.7793C29.7163 32.2335 28.5257 33.3968 27.0374 33.3968C25.549 33.3968 24.3584 32.2335 24.3584 30.7793C24.3584 29.3252 25.549 28.1619 27.0374 28.1619C28.5257 28.1619 29.7163 29.3252 29.7163 30.7793Z" fill="#E98B3E"></path>';
			$output .= '<path d="M45.6411 30.7793C45.6411 32.2335 44.4505 33.3968 42.9622 33.3968C41.4739 33.3968 40.2832 32.2335 40.2832 30.7793C40.2832 29.3252 41.4739 28.1619 42.9622 28.1619C44.4505 28.1619 45.6411 29.3252 45.6411 30.7793Z" fill="#E98B3E"></path>';
			$output .= '<path d="M34.9752 0L24.2098 21.3758L0 24.8173L27.9305 25.5444L34.9752 0Z" fill="#F6D15A"></path>';
			$output .= '<path d="M13.3945 65.0001L34.975 53.9002L56.605 65.0001L34.975 48.229L13.3945 65.0001Z" fill="#F6D15A"></path>';
			$output .= '</svg>';
			$output .= '<div class="cr-floatingbadge-close" style="display:none;">';
			$output .= '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">';
			$output .= '<path d="M14.8,12l3.6-3.6c0.8-0.8,0.8-2,0-2.8c-0.8-0.8-2-0.8-2.8,0L12,9.2L8.4,5.6c-0.8-0.8-2-0.8-2.8,0   c-0.8,0.8-0.8,2,0,2.8L9.2,12l-3.6,3.6c-0.8,0.8-0.8,2,0,2.8C6,18.8,6.5,19,7,19s1-0.2,1.4-0.6l3.6-3.6l3.6,3.6   C16,18.8,16.5,19,17,19s1-0.2,1.4-0.6c0.8-0.8,0.8-2,0-2.8L14.8,12z" />';
			$output .= '</svg>';
			$output .= '</div>';
			$output .= '</div>';
			$output .= '<img class="cr_floatingtrustbadge_small" src="' . $small_src . '" alt="' . __( 'Trust Badge', 'customer-reviews-woocommerce' ) . '" loading="lazy">';
			$output .= '<a class="cr_floatingtrustbadge_big" href="https://www.cusrev.com/' . $site_lang . 'reviews/' . get_option( 'ivole_reviews_verified_page', Ivole_Email::get_blogdomain() ) . '" rel="nofollow noopener noreferrer" target="_blank" style="display:none;"><img src="' . $big_src . '" loading="lazy"></a>';
			$output .= '</div>';
			echo $output;
		}
	}

endif;

?>
