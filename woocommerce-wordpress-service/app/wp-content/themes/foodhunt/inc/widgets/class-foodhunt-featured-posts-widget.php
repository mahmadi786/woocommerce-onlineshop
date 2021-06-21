<?php
/**
 * Featured Posts widget
 */

class foodhunt_featured_posts_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'blog-section', 'description' => esc_html__( 'Display latest posts or posts of specific category.', 'foodhunt') );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false,$name= esc_html__( 'TG: Featured Posts', 'foodhunt' ),$widget_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ] = '';
		$defaults[ 'text' ] = '';
		$defaults[ 'number' ] = 3;
		$defaults[ 'type' ] = 'latest';
		$defaults[ 'category' ] = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance[ 'title' ] );
		$text = esc_textarea( $instance[ 'text' ] );
		$number = absint( $instance[ 'number' ] );
		$type = esc_attr( $instance[ 'type' ] );
		$category = absint( $instance[ 'category' ] ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php esc_html_e( 'Description','foodhunt' ); ?>
		<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to display:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<input type="radio" <?php checked( $type, 'latest' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php esc_html_e( 'Show latest Posts', 'foodhunt' );?><br />
			<input type="radio" <?php checked( $type,'category' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php esc_html_e( 'Show posts from a category', 'foodhunt' );?><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Select category', 'foodhunt' ); ?>:</label>
			<?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category' ), 'selected' => $category ) ); ?>
		</p>

		<p><?php esc_html_e( 'Info: To display posts from specific category, select the Category in above radio option than select the category from the drop-down list.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
		if ( current_user_can( 'unfiltered_html' ) )
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		else
			$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes($new_instance[ 'text' ]) ) ); // wp_filter_post_kses() expects slashed
		$instance[ 'number' ] = absint( $new_instance[ 'number' ] );
		$instance[ 'type' ] = esc_attr( $new_instance[ 'type' ] );
		$instance[ 'category' ] = absint( $new_instance[ 'category' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$text = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '';
		$number = empty( $instance[ 'number' ] ) ? 3 : $instance[ 'number' ];
		$type = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';

		if( $type == 'latest' ) {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page'        => $number,
				'post_type'             => 'post',
				'ignore_sticky_posts'   => true
			) );
		}
		else {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page'        => $number,
				'post_type'             => 'post',
				'category__in'          => $category
			) );
		}

		echo $before_widget; ?>

		<div class= "section-wrapper clearfix">
		<div class="tg-container">

			<div class="section-title-wrapper">
				<?php if ( !empty( $title ) ) { echo $before_title . esc_html( $title ) . $after_title; } ?>
				<?php if ( !empty( $text ) ) { ?>
					<h4 class="sub-title">
						<?php echo esc_textarea( $text ); ?>
					</h4>
				<?php } ?>
			</div>

			<div class="blog-wrapper clearfix">
				<?php $count = 1;
				while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
				$foodhunt_blog_class = 'blog-block';
				if ( $count % 2 == 0 ) {
					$foodhunt_blog_class .= ' blog-rtl';
				}

				if( has_post_thumbnail() ) { ?>
				<?php $title_attribute = the_title_attribute( 'echo=0' );
				$thumb_id              = get_post_thumbnail_id( get_the_ID() );
				$img_altr              = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
				$img_alt               = ! empty( $img_altr ) ? $img_altr : $title_attribute;
				$post_thumbnail_attr   = array(
					'alt'   => esc_attr( $img_alt ),
					'title' => esc_attr( $title_attribute ),
				); ?>

				<div class="<?php echo esc_attr( $foodhunt_blog_class ); ?> clearfix">

					<div class="blog-img">
						<?php the_post_thumbnail('foodhunt-featured-image', $post_thumbnail_attr); ?>
					</div>
					<?php }
					else {
					$foodhunt_blog_class .= ' no-featured-image'; ?>

					<div class="<?php echo esc_attr( $foodhunt_blog_class ); ?> clearfix"> <?php } ?>

						<div class="blog-content-wrapper">

							<div class="blog-title-btn-wrap clearfix">
								<h3 class="entry-title blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<a href="<?php the_permalink(); ?>" class="blog-btn" title="<?php the_title_attribute();?>"> <i class="fa fa-angle-right"> </i></a>
							</div>

							<div class="entry-meta">
									<span class="byline author">
										<i class="fa fa-user"> </i>
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_html( get_the_author() ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
									</span>

								<span class="posted-on">
										<?php
										$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

										$time_string = sprintf( $time_string,
											esc_attr( get_the_date( 'c' ) ),
											esc_html( get_the_date() )
										);
										printf( '<i class="fa fa-calendar"> </i><a href="%1$s" title="%2$s" rel="bookmark"> %3$s</a>',
											esc_url( get_permalink() ),
											esc_attr( get_the_time() ),
											$time_string
										); ?>
									</span>

								<?php if ( comments_open() ) { ?>
									<span class="comment">
											<i class="fa fa-comment"></i><?php comments_popup_link( esc_html__( 'Leave a comment', 'foodhunt' ), esc_html__( 'Comment (1)', 'foodhunt' ), esc_html__( 'Comments (%)', 'foodhunt' ) );?>
										</span>
								<?php } ?>
							</div>

							<div class="entry-content blog-desc">
								<?php the_excerpt(); ?>
							</div>
						</div><!-- blog content wrapper -->
					</div><!-- .blog-block -->

					<?php $count++;
					endwhile; ?>
				</div><!-- .blog-wrapper -->
			</div><!-- .tg-container -->
		</div>

		<?php
		// Reset Post Data
		wp_reset_postdata();
		echo $after_widget;
	}
}
