<?php
/**
 * sidebar options sample.
 *
 * @since   finedine 1.0
 * @package finedine
 */
function finedine_customize_sidebar_layout( $wp_customize ) {

	class finedine_sidebar_Control extends WP_Customize_Control {

		public function render_content() {

			if ( empty( $this->choices ) ) {
				return;
			}

			$name = 'customize_sidebar';

			?>
            <style>
                #finedine-img-container .finedine-radio-img-img {
                    border: 3px solid #DEDEDE;
                    margin: 0 5px 5px 0;
                    cursor: pointer;
                    border-radius: 3px;
                    -moz-border-radius: 3px;
                    -webkit-border-radius: 3px;
                }

                #finedine-img-container .finedine-radio-img-selected {
                    border: 3px solid #AAA;
                    border-radius: 3px;
                    -moz-border-radius: 3px;
                    -webkit-border-radius: 3px;
                }

                input[type=checkbox]:before {
                    content: '';
                    margin: -3px 0 0 -4px;
                }
            </style>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <ul class="controls" id='finedine-img-container'>
				<?php
				// Getting value of customizer.
				global $finedine_settings, $finedine_array_of_default_settings;
				$finedine_settings = wp_parse_args( get_option( 'finedine_theme_settings', array() ), finedine_get_option_defaults() );
				$selected          = ( isset( $finedine_settings['finedine_sidebar_layout'] ) ) ? $finedine_settings['finedine_sidebar_layout'] : '';

				foreach ( $this->choices as $value => $label ) :
					$class = ( $selected === $value ) ? 'finedine-radio-img-selected finedine-radio-img-img' : 'finedine-radio-img-img';
					?>
                    <li style="display: inline;">
                        <label>
                            <input <?php $this->link(); ?>style='display:none'
                                   type="radio"
                                   value="<?php echo esc_attr( $value ); ?>"
                                   name="<?php echo esc_attr( $name ); ?>" <?php $this->link();
							checked( $this->value(), $value ); ?> />
                            <img src='<?php echo esc_url( $label ); ?>'
                                 class='<?php echo esc_attr($class); ?>'/>
                        </label>


                    </li>
				<?php

				endforeach;
				?>
            </ul>

            <script type="text/javascript">

                jQuery(document).ready(function ($) {
                    $('.controls#finedine-img-container li img').click(function () {
                        $('.controls#finedine-img-container li').each(function () {
                            $(this).find('img').removeClass('finedine-radio-img-selected');
                        });
                        $(this).addClass('finedine-radio-img-selected');
                    });
                });

            </script>

			<?php
		}
	}

	$defaults = finedine_get_option_defaults();
	// default layout setting.
	$wp_customize->add_section( 'finedine_default_layout_setting',
		array(
			'priority'    => 6,
			'description' => __( 'Finedine offers two different layout options from which to choose.', 'finedine' ),
			'title'       => __( 'Default Layout', 'finedine' ),
			'panel'       => 'finedine_theme_option_panel',
		)
	);

	$wp_customize->add_setting( 'finedine_theme_settings[finedine_sidebar_layout]',
		array(
			'type'              => 'option',
			'capability'        => 'manage_options',
			'default'           => $defaults['finedine_sidebar_layout'],
			'sanitize_callback' => 'finedine_sanitize_text',
		)
	);

	$wp_customize->add_control(
		new finedine_sidebar_Control(
			$wp_customize,
			'finedine_theme_settings[finedine_sidebar_layout]',
			array(
				'type'     => 'radio',
				'label'    => __( 'Sidebar Layout', 'finedine' ),
				'section'  => 'finedine_default_layout_setting',
				'settings' => 'finedine_theme_settings[finedine_sidebar_layout]',
				'choices'  =>
					array(
						'right' => esc_url( get_template_directory_uri() ) . '/customizer/images/right-sidebar.png',
						'left'  => esc_url( get_template_directory_uri() ) . '/customizer/images/left-sidebar.png',
					),
			)
		)
	);

}

add_action( 'customize_register', 'finedine_customize_sidebar_layout' );
