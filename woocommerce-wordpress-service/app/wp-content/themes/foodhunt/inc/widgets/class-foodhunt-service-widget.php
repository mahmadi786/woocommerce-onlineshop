<?php
/**
 * Service Widget section.
 */

class foodhunt_service_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'service-section', 'description' => esc_html__( 'Display some pages as services.', 'foodhunt' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = esc_html__( 'TG: Service', 'foodhunt' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults['title'] = '';
		$defaults['text'] = '';
		$defaults['number'] = '3';
		$defaults[ 'background_image' ] = '';
		$defaults[ 'background_color' ] = '#4a4a4a';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance['title'] );
		$text = esc_textarea( $instance['text'] );
		$number = absint( $instance[ 'number' ] );
		$background_image = esc_url_raw( $instance[ 'background_image' ] );
		$background_color = esc_attr( $instance[ 'background_color' ] ); ?>

		<p>
			<strong><?php esc_html_e( 'Widget SETTINGS :', 'foodhunt' ); ?></strong><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','foodhunt' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of pages to display:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p><?php esc_html_e( 'Note: Create the pages and select Services Template to display Services pages. The Recommended size for featured image is 290px by 290px.', 'foodhunt' ); ?></p>

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
			<input class="my-color-picker" type="text" data-default-color="#4a4a4a" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" value="<?php echo  $background_color; ?>" />
		</p>

		<p><?php esc_html_e( 'Note: Background image (if used) will override the background color.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['background_color'] =  esc_attr( $new_instance['background_color'] );
		$instance['background_image'] =  esc_url_raw( $new_instance['background_image'] );
		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );

		if ( current_user_can( 'unfiltered_html' ) )
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		else
			$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); //   wp_filter_post_kses() expects slashed

		$instance[ 'number' ] = absint( $new_instance[ 'number' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post, $foodhunt_duplicate_posts;
		$background_color = isset( $instance[ 'background_color' ] ) ? $instance[ 'background_color' ] : '';
		$background_image = isset( $instance[ 'background_image' ] ) ? $instance[ 'background_image' ] : '';
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$number = empty( $instance[ 'number' ] ) ? 3 : $instance[ 'number' ];

		$page_array = array();
		$pages = get_pages();
		// get the pages associated with Services Template.
		foreach ( $pages as $page ) {
			$page_id = $page->ID;
			$template_name = get_post_meta( $page_id, '_wp_page_template', true );
			if( $template_name == 'page-templates/template-services.php' && !in_array( $page_id , $foodhunt_duplicate_posts ) ) {
				array_push( $page_array, $page_id );
			}
		}

		$get_featured_pages = new WP_Query( array(
			'posts_per_page'        => $number,
			'post_type'             =>  array( 'page' ),
			'post__in'              => $page_array,
			'orderby'               => array( 'menu_order' => 'ASC', 'date' => 'DESC' )
		) );

		echo $before_widget;
		$bg_image_class = 'no-bg-image';
		$bg_image_style = '';
		if ( !empty( $background_image ) ) {
			$bg_image_style = 'style=background-image:url(' . esc_url( $background_image ) . ');background-repeat:no-repeat;background-size:cover;background-attachment:fixed;';
			$bg_image_class = 'section-wrapper-with-bg-image';
		}elseif ( $background_color != '#4a4a4a' ) {
			$bg_image_style = 'style=background-color:' . esc_attr( $background_color ) . ';';
		}?>
		<div class="section-wrapper clearfix <?php echo esc_attr( $bg_image_class ) ?>" <?php echo $bg_image_style; ?>>
			<?php if ( !empty( $background_image ) ) { echo '<div class="section-overlay"> </div>'; } ?>

			<div class="tg-container">
				<?php if( !empty( $title ) || !empty( $text ) ) { ?>
					<div class="section-title-wrapper">

						<?php if( !empty( $title ) )  {
							echo $before_title . esc_html( $title ) . $after_title;
						}

						if( !empty( $text ) ) {
							echo '<h4 class="sub-title">' . esc_textarea( $text ) . '</h4>';
						} ?>
					</div>
				<?php }

				if( !empty( $page_array ) ) {
					$count = 0; ?>
					<div class="service-wrapper clearfix">
						<div class="tg-column-wrapper clearfix">

							<?php while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();
								$foodhunt_duplicate_posts[] = $post->ID;

								if ( $count % 3 == 0 && $count > 1 ) { echo '<div class="clearfix"></div>'; } ?>

								<div class="tg-column-3 service-block">
									<h3 class="service-title">
										<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>"> <?php echo esc_html( get_the_title() ); ?></a>
									</h3>

									<?php if( has_post_thumbnail() ) { ?>
										<?php $title_attribute = the_title_attribute( 'echo=0' );
										$thumb_id              = get_post_thumbnail_id( get_the_ID() );
										$img_altr              = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
										$img_alt               = ! empty( $img_altr ) ? $img_altr : $title_attribute;
										$post_thumbnail_attr   = array(
											'alt'   => esc_attr( $img_alt ),
											'title' => esc_attr( $title_attribute ),
										); ?>
										<figure class="service-img">
											<?php the_post_thumbnail( 'foodhunt-featured-image', $post_thumbnail_attr ); ?>
										</figure>
									<?php } ?>

									<div class="service-desc">
										<?php the_excerpt(); ?>
									</div>

									<a class="service-btn" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <?php  esc_html_e( 'Read More', 'foodhunt' ) ?></a>
								</div>
								<?php $count++;
							endwhile;

							// Reset Post Data
							wp_reset_postdata(); ?>
						</div><!-- .tg-column-wrapper -->
					</div>
				<?php } ?>
			</div>
		</div>
		<?php echo $after_widget;
	}
}
