<?php
/**
 * dynamic css genration depends on customizer
 *
 * @return string
 */
if ( ! function_exists( 'finedine_dynamic_customizer_style' ) ) {
	/**
	 * Customizer style
	 */
	function finedine_dynamic_customizer_style() {

		global $finedine_settings, $finedine_array_of_default_settings;

		// Get default values.
		$defaults = finedine_get_option_defaults();

		$finedine_settings
			= wp_parse_args( get_option( 'finedine_theme_settings', array() ),
			finedine_get_option_defaults() );
		?>
        <style id="finedine_dynamic_customizer_style" type="text/css">
            <?php
				// Copyright.
				$finedine_copyright_text        = ( isset( $finedine_settings['finedine_copyright_text'] ) ) ? $finedine_settings['finedine_copyright_text'] : '';
				$finedine_remove_copyright_text = ( isset( $finedine_settings['finedine_remove_copyright_text'] ) ) ? $finedine_settings['finedine_remove_copyright_text'] : '';

				if ( '1' !== $finedine_remove_copyright_text ) {
					echo '.copyright-text{ display:block;}';
				} else {
					echo '.copyright-text{ display:none;}';
				}

				// Credit.
				$finedine_credit_text        = ( isset( $finedine_settings['finedine_credit_text'] ) ) ? $finedine_settings['finedine_credit_text'] : '';
				$finedine_remove_credit_text = ( isset( $finedine_settings['finedine_remove_credit_text'] ) ) ? $finedine_settings['finedine_remove_credit_text'] : '';
				if ( 1 !== $finedine_remove_credit_text ) {
					echo '.credit-text{ display:block; }';
				} else {
					echo '.credit-text{ display:none; }';
				}

				// Slider hide show.
				$show_slider = ( isset( $finedine_settings['hide_feature_slider_1'] ) ) ? $finedine_settings['hide_feature_slider_1'] : '';
				if ( '1' === $show_slider ) {
					echo '.hero-slider.owl-carousel{ display:none;}';
				} else {
					echo '.hero-slider.owl-carousel{ display:block;}';
				}

				// Hide/Show slider class.
				if ( 'No' === $show_slider ) {
					$hide_slider = 'block';
				} else {
					$hide_slider = 'None';
				}
				?>
        </style>

		<?php
	}
}

add_action( 'wp_head', 'finedine_dynamic_customizer_style' );



