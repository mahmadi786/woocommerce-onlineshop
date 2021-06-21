<?php
/**
 * Call to action widget.
 */

class foodhunt_call_to_action_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'cta-section', 'description' => esc_html__( 'Use this widget to show the call to action section.', 'foodhunt' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = esc_html__( 'TG: Call To Action', 'foodhunt' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'text_main' ] = '';
		$defaults[ 'button_text' ] = '';
		$defaults[ 'button_url' ] = '';
		$defaults[ 'background_image' ] = '';
		$defaults[ 'background_color' ] = '#d40305';
		$defaults[ 'button_icon' ] = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$text_main = esc_textarea( $instance[ 'text_main' ] );
		$button_text = esc_attr( $instance[ 'button_text' ] );
		$button_url = esc_url( $instance[ 'button_url' ] );
		$background_image = esc_url_raw( $instance[ 'background_image' ] );
		$background_color = esc_attr( $instance[ 'background_color' ] );
		$button_icon = esc_attr( $instance['button_icon'] );
		?>

		<p>
			<strong><?php esc_html_e( 'Widget SETTINGS :', 'foodhunt' ); ?></strong><br />
		</p>

		<?php esc_html_e( 'Call to Action Main Text:', 'foodhunt' ); ?>
		<textarea class="widefat" rows="3" cols="20" id="<?php echo $this->get_field_id( 'text_main' ); ?>" name="<?php echo $this->get_field_name( 'text_main' ); ?>"><?php echo $text_main; ?></textarea>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php esc_html_e( 'Button Text:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo $button_text; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'button_url' ); ?>"><?php esc_html_e( 'Button Redirect Link:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_url' ); ?>" name="<?php echo $this->get_field_name( 'button_url' ); ?>" type="text" value="<?php echo $button_url; ?>" />
		</p>

		<p>
			<strong><?php esc_html_e( 'DESIGN SETTINGS :', 'foodhunt' ); ?></strong><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_image' ); ?>"> <?php esc_html_e( 'Background Image:', 'foodhunt' ); ?> </label> <br />
		<div class="media-uploader" id="<?php echo $this->get_field_id( 'background_image' ); ?>">
			<div class="custom_media_preview">
				<?php if ( $background_image != '' ) : ?>
					<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'background_image' ] ); ?>" style="max-width:100%;" />
				<?php endif; ?>
			</div>
			<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'background_image' ); ?>" name="<?php echo $this->get_field_name( 'background_image' ); ?>" value="<?php echo esc_url( $instance[ 'background_image' ] ); ?>" style="margin-top:5px;" />
			<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'background_image' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'foodhunt' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'foodhunt' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'foodhunt' ); ?></button>
		</div>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php esc_html_e( 'Background Color:', 'foodhunt' ); ?></label><br />
			<input class="my-color-picker" type="text" data-default-color="#d40305" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" value="<?php echo  $background_color; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_icon' ); ?>"><?php esc_html_e( 'Button Icon Class:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_icon' ); ?>" name="<?php echo $this->get_field_name( 'button_icon' ); ?>" placeholder="fa-cutlery" type="text" value="<?php echo $button_icon; ?>" />
		</p>

		<p>
			<?php
			$url = 'http://fontawesome.io/icons/';
			$link = sprintf( wp_kses( __( 'For Icon Class <a href="%s" target="_blank">Refer here</a>', 'foodhunt' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $url ) );
			echo $link;
			?>
		</p>

		<p><?php esc_html_e( 'Note: Background image (if used) will override the background color.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		if ( current_user_can( 'unfiltered_html' ) )
			$instance['text_main'] =  $new_instance['text_main'];
		else
			$instance['text_main'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text_main']) ) ); // wp_filter_post_kses() expects slashed

		$instance[ 'button_text' ] = sanitize_text_field( $new_instance[ 'button_text' ] );
		$instance[ 'button_url' ] = esc_url_raw( $new_instance[ 'button_url' ] );
		$instance[ 'background_image' ] =  esc_url_raw( $new_instance[ 'background_image' ] );
		$instance[ 'background_color' ] =  esc_attr( $new_instance[ 'background_color' ] );
		$instance[ 'button_icon' ] = sanitize_text_field( $new_instance[ 'button_icon' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$text_main = empty( $instance[ 'text_main' ] ) ? '' : $instance[ 'text_main' ];
		$button_text = isset( $instance[ 'button_text' ] ) ? $instance[ 'button_text' ] : '';
		$button_url = empty( $instance[ 'button_url' ] ) ? '#' : $instance[ 'button_url' ];
		$background_image = isset( $instance[ 'background_image' ] ) ? $instance[ 'background_image' ] : '';
		$background_color = isset( $instance[ 'background_color' ] ) ? $instance[ 'background_color' ] : '';
		$button_icon = isset( $instance[ 'button_icon' ] ) ? $instance[ 'button_icon' ] : '';

		echo $before_widget;
		$bg_image_style = '';
		$bg_image_class = 'no-bg-image';
		if ( !empty( $background_image ) ) {
			$bg_image_style = 'style=background-image:url(' . esc_url( $background_image ) . ');background-repeat:no-repeat;background-size:cover;background-attachment:fixed;';
			$bg_image_class = 'section-wrapper-with-bg-image';
		}elseif ( $background_color != '#d40305' ) {
			$bg_image_style = 'style=background-color:' . esc_attr( $background_color ) . ';';
		}?>
		<div class="section-wrapper <?php echo esc_attr( $bg_image_class ); ?> clearfix" <?php echo $bg_image_style; ?>>
			<div class="section-overlay"> </div>
			<div class="tg-container">

				<div class="cta-wrapper">
					<?php if( !empty( $text_main ) ) { ?>
						<div class="cta-desc">
							<?php echo esc_html( $text_main ); ?>
						</div>
						<?php if( !empty( $button_text ) ) { ?>
							<a class="cta-btn" href="<?php echo esc_url( $button_url ); ?>" title="<?php echo esc_attr( $button_text ); ?>"><?php echo esc_html( $button_text ) . '<i class="fa ' . esc_attr( $button_icon ) . '"> </i>' ?> </a>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php echo $after_widget;
	}
}
