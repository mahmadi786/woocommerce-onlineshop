<?php
/**
 * Gallery widget section
 */

class foodhunt_portfolio_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'gallery-section', 'description' => esc_html__( 'Display some pages as Portfolio or Gallery.', 'foodhunt') );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false,$name= esc_html__( 'TG: Portfolio', 'foodhunt' ), $widget_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ] = '';
		$defaults[ 'text' ] = '';
		$defaults[ 'number' ] = 8;

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance[ 'title' ] );
		$text = esc_textarea( $instance[ 'text' ] );
		$number = absint( $instance[ 'number' ] ); ?>

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

		<p><?php esc_html_e( 'Note: Create the pages and select Gallery Template to display Gallery pages. The Recommended size for featured image is 340px by 340px.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
		if ( current_user_can('unfiltered_html') )
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		else
			$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes($new_instance[ 'text' ]) ) ); // wp_filter_post_kses() expects slashed
		$instance[ 'number' ] = absint( $new_instance[ 'number' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post, $foodhunt_duplicate_posts;

		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		$text = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '';
		$number = empty( $instance[ 'number' ] ) ? 8 : $instance[ 'number' ];

		$page_array = array();
		$pages = get_pages();

		// get the pages associated with Gallery Template.
		foreach ( $pages as $page ) {
			$page_id = $page->ID;
			$template_name = get_post_meta( $page_id, '_wp_page_template', true );
			if( $template_name == 'page-templates/template-portfolio.php' && !in_array( $page_id , $foodhunt_duplicate_posts ) ) {
				array_push( $page_array, $page_id );
			}
		}

		$get_featured_posts = new WP_Query( array(
			'posts_per_page'        => $number,
			'post_type'             =>  array( 'page' ),
			'post__in'              => $page_array,
			'orderby'               => array( 'menu_order' => 'ASC', 'date' => 'DESC' )
		) );

		echo $before_widget; ?>

		<div class="section-wrapper clearfix">
			<div class="tg-container">

				<div class="section-title-wrapper">
					<?php
					if( !empty( $title ) ) { echo $before_title . esc_html( $title ) . $after_title; }
					if( !empty( $text ) ) { ?> <h4 class="sub-title"> <?php echo esc_textarea( $text ); ?> </h4> <?php } ?>
				</div>

				<?php if( !empty( $page_array ) ) : ?>

					<ul class="gallery-wrapper">
						<?php while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
							$foodhunt_duplicate_posts[] = $post->ID; ?>

							<li class="gallery-list">

								<?php if( has_post_thumbnail() ) {
									$title_attribute     = the_title_attribute( 'echo=0' );
									$thumb_id            = get_post_thumbnail_id( get_the_ID() );
									$img_altr            = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
									$img_alt             = ! empty( $img_altr ) ? $img_altr : $title_attribute;
									$post_thumbnail_attr = array(
										'alt'   => esc_attr( $img_alt ),
									);
									the_post_thumbnail('foodhunt-featured-image', $post_thumbnail_attr );

								}
								else {
									$image_popup_url = esc_url( get_template_directory_uri() ) . '/images/portfolio-placehoder.jpg';
									echo '<img src="' . esc_url( $image_popup_url ) . '">';
								} ?>

								<a href="<?php the_permalink(); ?>" class="gallery-zoom"> <span> <?php echo '<i class="fa fa-link"> </i>'; ?> </span> </a>
							</li>
						<?php endwhile; ?>
					</ul>

					<?php
					// Reset Post Data
					wp_reset_postdata();
				endif; ?>
			</div>
		</div><!-- .section-wrapper -->

		<?php echo $after_widget;
	}
}
