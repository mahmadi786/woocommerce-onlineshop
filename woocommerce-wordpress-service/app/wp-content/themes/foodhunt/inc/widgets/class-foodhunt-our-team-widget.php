<?php
/**
 * Our Team section.
 */

class foodhunt_our_team_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'chef-section', 'description' => esc_html__( 'Show your Team Members.', 'foodhunt' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = esc_html__( 'TG: Our Team', 'foodhunt' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {

		$defaults[ 'title' ] = '';
		$defaults[ 'text' ] = '';
		$defaults[ 'number' ] = '3';
		$defaults[  'background_image' ] = '';
		$defaults[  'background_color' ] = '#5c5c5c';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance[ 'title' ] );
		$text = esc_textarea( $instance[ 'text' ] );
		$number = absint( $instance[ 'number' ] );
		$background_image = esc_url_raw( $instance[ 'background_image' ] );
		$background_color = esc_attr( $instance[ 'background_color' ] );
		?>

		<p>
			<strong><?php esc_html_e( 'Widget SETTINGS :', 'foodhunt' ); ?></strong><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php esc_html_e( 'Description:','foodhunt' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of pages to display:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p><?php esc_html_e( 'Note: Create the pages and select Our Team Template to display Our Team pages. The Recommended size for featured image is 380px by 380px.', 'foodhunt' ); ?></p>

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
			<input class="my-color-picker" type="text" data-default-color="#5c5c5c" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" value="<?php echo $background_color; ?>" />
		</p>

		<p><?php esc_html_e( 'Note: Background image (if used) will override the background color.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );

		if ( current_user_can( 'unfiltered_html' ) )
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		else
			$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); // wp_filter_post_kses() expects slashed

		$instance[ 'number' ] = absint( $new_instance[ 'number' ] );
		$instance['background_image'] =  esc_url_raw( $new_instance['background_image'] );
		$instance['background_color'] =  esc_attr( $new_instance['background_color'] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post, $foodhunt_duplicate_posts;
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$text = apply_filters( 'widget_text', empty( $instance[ 'text' ] ) ? '' : $instance[ 'text' ], $instance );
		$number = empty( $instance[ 'number' ] ) ? 3 : $instance[ 'number' ];
		$background_image = isset( $instance[ 'background_image' ] ) ? $instance[ 'background_image' ] : '';
		$background_color = isset( $instance[ 'background_color' ] ) ? $instance[ 'background_color' ] : '';

		$page_array = array();
		$pages = get_pages();
		// get the pages associated with Our Team Template.
		foreach ( $pages as $page ) {
			$page_id = $page->ID;
			$template_name = get_post_meta( $page_id, '_wp_page_template', true );
			if( $template_name == 'page-templates/template-team.php' && !in_array( $page_id , $foodhunt_duplicate_posts ) ) {
				array_push( $page_array, $page_id );
			}
		}

		$get_featured_pages = new WP_Query( array(
			'posts_per_page'        => $number,
			'post_type'             =>  array( 'page' ),
			'post__in'              => $page_array,
			'orderby'               => array( 'menu_order' => 'ASC', 'date' => 'DESC' )
		) );

		$bg_image_class = 'no-bg-image';
		$bg_image_style = '';
		if ( !empty( $background_image ) ) {
			$bg_image_style = 'style=background-image:url(' . esc_url( $background_image ) . ');background-repeat:no-repeat;background-size:cover;background-attachment:fixed;';
			$bg_image_class = 'section-wrapper-with-bg-image';
		}
		elseif ( $background_color != '#5c5c5c' ) {
			$bg_image_style = 'style=background-color:' . esc_attr( $background_color ) . ';';
		}

		echo $before_widget; ?>
		<div class="section-wrapper <?php echo esc_attr( $bg_image_class ) ?> clearfix" <?php echo $bg_image_style; ?>>

			<div class="tg-container">
				<div class="section-title-wrapper">
					<?php if( !empty( $title ) ) echo $before_title . esc_html( $title ) . $after_title;

					if( !empty( $text ) ) { ?>
						<h4 class="sub-title"><?php echo esc_textarea( $text ); ?></h4>
					<?php } ?>
				</div>

				<?php if( !empty ( $page_array ) ) :
					$count = 0; ?>
					<div class="chef-wrapper clearfix">
						<div class="tg-column-wrapper clearfix">
							<?php while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();
								$foodhunt_duplicate_posts[] = $post->ID;

								if ( $count % 3 == 0 && $count > 1 ) { ?> <div class="clearfix"></div> <?php }
								$title_attribute = the_title_attribute( 'echo=0' ); ?>

								<div class="tg-column-3 chef-block">

									<?php if( has_post_thumbnail() ) { ?>
										<?php $thumb_id      = get_post_thumbnail_id( get_the_ID() );
										$img_altr            = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
										$img_alt             = ! empty( $img_altr ) ? $img_altr : $title_attribute;
										$post_thumbnail_attr = array(
											'alt'   => esc_attr( $img_alt ),
										); ?>
										<figure class="chef-img">
											<?php the_post_thumbnail( 'full', $post_thumbnail_attr ); ?>
										</figure>
									<?php } ?>

									<div class="chef-content-wrapper">
										<?php
										$output = '';
										$output .= '<h3 class="chef-title"> <a href="' . esc_url( get_permalink() ) . '" alt ="' . $title_attribute . '">' . esc_html( get_the_title() ) . '</a></h3>';
										$foodhunt_designation = get_post_meta( $post->ID, 'foodhunt_designation', true );
										if( !empty( $foodhunt_designation ) ) {
											$output .= '<div class="chef-designation">' . esc_html( $foodhunt_designation ) . '</div>';
										}

										$output .= '<div class="chef-desc">' . '<p>' . esc_html( get_the_excerpt() ) . '</p></div>';

										$output .= '<a class="chef-btn" href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '" alt ="' . $title_attribute . '">' . esc_html__( 'Read More' , 'foodhunt' ) . '</a>';

										echo $output; ?>
									</div>
								</div>
								<?php $count++;
							endwhile;

							// Reset Post Data
							wp_reset_postdata(); ?>
						</div><!-- .team-content-wrapper -->
					</div><!-- .chef-wrapper -->

				<?php endif; ?>
			</div><!-- .tg-container -->
		</div>

		<?php echo $after_widget;
	}
}
