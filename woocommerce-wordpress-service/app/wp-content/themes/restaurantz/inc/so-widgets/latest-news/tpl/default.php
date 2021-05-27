<?php if ( ! empty( $instance['title'] ) ) : ?>
	<?php echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'] ?>
<?php endif; ?>
<?php if ( ! empty( $instance['sub_title'] ) ) : ?>
	<h4 class="widget-sub-title"><?php echo esc_html( $instance['sub_title'] ); ?></h4>
<?php endif; ?>
<?php
$post_selector_pseudo_query = $instance['posts'];
$processed_query            = siteorigin_widget_post_selector_process_query( $post_selector_pseudo_query );
$all_posts = get_posts( $processed_query  );

if ( ! empty( $all_posts ) ) : ?>

  	<?php global $post; ?>

  	<div class="latest-news-widget latest-news-col-<?php echo esc_attr( $instance['settings']['post_column'] ); ?>">

  		<div class="inner-wrapper">

  			<?php foreach ( $all_posts as $key => $post ) : ?>
  				<?php setup_postdata( $post ); ?>

  				<div class="latest-news-item">

  					<?php if ( 'disable' !== $instance['settings']['featured_image'] && has_post_thumbnail() ) : ?>
  						<div class="latest-news-thumb">
  							<a href="<?php the_permalink(); ?>">
  								<?php
  								$featured_image = esc_attr( $instance['settings']['featured_image'] );
  								$img_attributes = array( 'class' => 'aligncenter' );
  								the_post_thumbnail( esc_attr( $featured_image ), $img_attributes );
  								?>
  							</a>
  						</div><!-- .latest-news-thumb -->
  					<?php endif ?>
  					<div class="latest-news-text-wrap">
  						<h3 class="latest-news-title">
  							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
  						</h3><!-- .latest-news-title -->

  						<?php if ( false === $instance['settings']['disable_date'] || ( false === $instance['settings']['disable_comment'] && comments_open( get_the_ID() ) ) ): ?>
  							<div class="latest-news-meta">

  								<?php if ( false === $instance['settings']['disable_date'] ): ?>
  									<span class="latest-news-date"><?php the_time( get_option('date_format') ); ?></span><!-- .latest-news-date -->
  								<?php endif ?>

  								<?php if ( false === $instance['settings']['disable_comment'] ): ?>
  									<?php
  									if ( comments_open( get_the_ID() ) ) {
  										echo '<span class="latest-news-comments">';
  										comments_popup_link( '<span class="leave-reply">' . __( 'No Comment', 'restaurantz' ) . '</span>', __( '1 Comment', 'restaurantz' ), __( '% Comments', 'restaurantz' ) );
  										echo '</span>';
  									}
  									?>
  								<?php endif; ?>

  							</div><!-- .latest-news-meta -->
  						<?php endif; ?>

  						<?php if ( false === $instance['settings']['disable_excerpt'] ): ?>
  							<?php $excerpt_length = $instance['settings']['excerpt_length']; ?>
  							<div class="latest-news-summary">
	  							<?php
	  							$excerpt = restaurantz_the_excerpt( esc_attr( $excerpt_length ), $post );
	  							echo wp_kses_post( wpautop( $excerpt ) );
	  							?>
  							</div><!-- .latest-news-summary -->
  						<?php endif ?>
  						<?php if ( false === $instance['settings']['disable_more_text'] ): ?>
  							<div class="latest-news-read-more"><a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html( $instance['settings']['more_text'] ); ?></a></div><!-- .latest-news-read-more -->
  						<?php endif ?>
  					</div><!-- .latest-news-text-wrap -->

  				</div><!-- .latest-news-item -->

  			<?php endforeach; ?>

  		</div><!-- .row -->

  	</div><!-- .latest-news-widget -->

  	<?php wp_reset_postdata(); // Reset. ?>

<?php endif;

