<?php
/**
 * Contact us section.
 */

class foodhunt_contact_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'contact-section', 'description' => esc_html__( 'Show your Contact page.', 'foodhunt' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = esc_html__( 'TG: Contact Us', 'foodhunt' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ] = '';
		$defaults[ 'text' ] = '';
		$defaults[ 'page_id' ] = '';
		$defaults[ 'shortcode' ] = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance[ 'title' ] );
		$text = esc_textarea( $instance['text'] );
		$page_id = absint( $instance[ 'page_id' ] );
		$shortcode = esc_attr( $instance[ 'shortcode' ] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','foodhunt' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>


		<p><?php esc_html_e( 'Install the Contact Form 7 Plugin and paste the shortcode here:', 'foodhunt' ) ?></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'shortcode' ); ?>"><?php esc_html_e( 'Shortcode:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'shortcode' ); ?>" name="<?php echo $this->get_field_name( 'shortcode' ); ?>" type="text" value="<?php echo $shortcode; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php esc_html_e( 'Select a Contact page:', 'foodhunt' ); ?>:</label>
			<?php wp_dropdown_pages( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'page_id' ), 'selected' => $instance[ 'page_id' ] ) ); ?>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );

		if ( current_user_can('unfiltered_html') )
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		else
			$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); // wp_filter_post_kses() expects slashed

		$instance[ 'page_id' ] = absint( $new_instance[ 'page_id' ] );
		$instance[ 'shortcode' ] = sanitize_text_field( $new_instance[ 'shortcode' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$text = apply_filters( 'widget_text', empty( $instance[ 'text' ] ) ? '' : $instance['text'], $instance );
		$page_id = isset( $instance[ 'page_id' ] ) ? $instance[ 'page_id' ] : '';
		$shortcode = isset( $instance[ 'shortcode' ] ) ? $instance[ 'shortcode' ] : '';

		echo $before_widget; ?>
		<div class="section-wrapper clearfix">
			<div class="tg-container">

				<div class="section-title-wrapper">
					<?php if( !empty( $title ) ) echo $before_title . esc_html( $title ) . $after_title;

					if( !empty( $text ) ) { ?>
						<h4 class="sub-title"><?php echo esc_textarea( $text ); ?></h4>
					<?php } ?>
				</div>

				<div class="contact-wrapper">
					<div class="tg-column-wrapper clearfix">
						<?php if ( !empty ( $shortcode ) ) { ?>
							<div class="tg-column-2 contact-form">

								<?php echo do_shortcode( $shortcode ); ?>
							</div>
						<?php } ?>

						<?php if( $page_id ) : ?>
							<div class="tg-column-2 contact-details-wrapper">

								<?php $the_query = new WP_Query( 'page_id='.$page_id );
								while( $the_query->have_posts() ):$the_query->the_post(); ?>
									<h3 class="contact-title"> <?php the_title(); ?> </h3>

									<div class="contact-content-wrapper"> <?php the_content(); ?> </div>
								<?php endwhile; ?>
							</div>
						<?php endif;
						// Reset Post Data
						wp_reset_postdata(); ?>
					</div>
				</div><!-- .contact-wrapper -->
			</div><!-- .tg-container -->
		</div>
		<?php echo $after_widget;
	}
}
