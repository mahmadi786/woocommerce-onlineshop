<?php
/**
 * About us section.
 */

class foodhunt_about_us_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'about-section', 'description' => esc_html__( 'Suitable for About Us page.', 'foodhunt' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = esc_html__( 'TG: Featured Single Page', 'foodhunt' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults['title'] = '';
		$defaults['text'] = '';
		$defaults['page_id'] = '';
		$defaults['button_text'] = '';
		$defaults['button_url'] = '';
		$defaults['button_icon'] = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance['title'] );
		$text = esc_textarea( $instance['text'] );
		$page_id = absint( $instance['page_id'] );
		$button_text = esc_attr( $instance['button_text'] );
		$button_url = esc_url( $instance['button_url'] );
		$button_icon = esc_attr( $instance['button_icon'] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','foodhunt' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p><?php esc_html_e( 'Select a page to display Title, Excerpt and Featured image.' , 'foodhunt' ) ?></p>
		<label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php esc_html_e( 'Page', 'foodhunt' ); ?>:</label>
		<?php wp_dropdown_pages( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'page_id' ), 'selected' => $page_id ) ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php esc_html_e( 'Button Text:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo $button_text; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'button_url' ); ?>"><?php esc_html_e( 'Button Redirect Link:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_url' ); ?>" name="<?php echo $this->get_field_name( 'button_url' ); ?>" type="text" value="<?php echo $button_url; ?>" />
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
		<p><?php esc_html_e( 'Info: The Recommended size for featured image is 530px by 440px.', 'foodhunt' ); ?></p>
		<p><?php esc_html_e( 'Note: Leave Button Redirect Link empty to redirect it to the respective page.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );

		if ( current_user_can('unfiltered_html') ) {
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		}
		else {
			$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); // wp_filter_post_kses() expects slashed
		}

		$instance[ 'page_id' ] = absint( $new_instance[ 'page_id' ] );
		$instance[ 'button_text' ] = sanitize_text_field( $new_instance[ 'button_text' ] );
		$instance[ 'button_url' ] = esc_url_raw( $new_instance[ 'button_url' ] );
		$instance[ 'button_icon' ] = sanitize_text_field( $new_instance[ 'button_icon' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$text = apply_filters( 'widget_text', empty( $instance[ 'text' ] ) ? '' : $instance['text'], $instance );
		$page_id = isset( $instance[ 'page_id' ] ) ? $instance[ 'page_id' ] : '';
		$button_text = isset( $instance[ 'button_text' ] ) ? $instance[ 'button_text' ] : '';
		$button_url = empty( $instance[ 'button_url' ] ) ? '' : $instance[ 'button_url' ];
		$button_icon = isset( $instance[ 'button_icon' ] ) ? $instance[ 'button_icon' ] : '';

		echo $before_widget; ?>

		<div class="section-wrapper clearfix">
			<div class="tg-container">

				<div class="section-title-wrapper">
					<?php if( !empty( $title ) ) echo $before_title . esc_html( $title ) . $after_title;

					if( !empty( $text ) ) { ?>
						<h4 class="sub-title"><?php echo esc_textarea( $text ); ?></h4>
					<?php } ?>
				</div>

				<?php if( $page_id ) : ?>
					<div class="about-wrapper clearfix">
						<?php
						$the_query = new WP_Query( 'page_id='.$page_id );
						while( $the_query->have_posts() ):$the_query->the_post();

							if( has_post_thumbnail() ) { ?>
								<?php $title_attribute = the_title_attribute( 'echo=0' );
								$thumb_id            = get_post_thumbnail_id( get_the_ID() );
								$img_altr            = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
								$img_alt             = ! empty( $img_altr ) ? $img_altr : $title_attribute;
								$post_thumbnail_attr = array(
									'alt'   => esc_attr( $img_alt ),
									'title' => esc_attr( $title_attribute ),
								); ?>
								<figure class="about-img">
									<?php the_post_thumbnail( 'full', $post_thumbnail_attr ); ?>
								</figure>
							<?php } ?>

							<div class="about-content-wrapper">
								<?php
								$output = '<h3 class="about-title">' . esc_html( get_the_title() ) . '</h3>';

								$output .= '<div class="about-desc">' . '<p>' . esc_html( get_the_excerpt() ) . '</p></div>';

								if( $button_url == '' ) {
									$button_url = get_permalink();
								}

								if( !empty( $button_text ) ) {
									$output .= '<a class="about-btn" href="'. esc_url( $button_url ) . '">' . esc_html( $button_text ) . ' <i class="fa ' . esc_attr( $button_icon ) . '"></i></a>';
								}

								echo $output;
								?>
							</div>
						<?php endwhile;

						// Reset Post Data
						wp_reset_postdata(); ?>
					</div><!-- .about-wrapper -->
				<?php endif; ?>
			</div><!-- .tg-container -->
		</div>

		<?php echo $after_widget;
	}
}
