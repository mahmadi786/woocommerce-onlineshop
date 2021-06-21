<?php $related_posts = foodhunt_related_posts_function(); ?>

<?php if ( $related_posts->have_posts() ): ?>

	<div class="related-posts-wrapper">

		<h4 class="related-posts-main-title">
			<i class="fa fa-thumbs-up"></i><span><?php esc_html_e( 'You May Also Like', 'foodhunt' ); ?></span>
		</h4>

		<div class="related-posts clearfix">

			<?php
			$count = 1;
			while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
				<div class="tg-column-3">
					<?php if ( has_post_thumbnail() ): ?>
						<?php $title_attribute = the_title_attribute( 'echo=0' );
						$thumb_id              = get_post_thumbnail_id( get_the_ID() );
						$img_altr              = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
						$img_alt               = ! empty( $img_altr ) ? $img_altr : $title_attribute;
						$post_thumbnail_attr   = array(
							'alt'   => esc_attr( $img_alt ),
							'title' => esc_attr( $title_attribute ),
						); ?>
						<div class="related-posts-thumbnail">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php the_post_thumbnail( 'foodhunt-event-image', $post_thumbnail_attr ); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="article-content">

						<h3 class="entry-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h3><!--/.post-title-->

						<div class="entry-meta">
							<?php
							$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
							if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
								$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
							}

							$post_date = sprintf(
								'<span class="entry-date">%1$s</span>
								<span class="entry-month-year">
									<span class="entry-month">%2$s</span>
									<span class="entry-year">%3$s</span>
								</span>',
								esc_html( get_the_time( 'j' ) ),
								esc_html( get_the_time( 'F' ) ),
								esc_html( get_the_time( 'Y' ) )
							);

							$time_string = sprintf( $time_string,
								esc_attr( get_the_date( 'c' ) ),
								$post_date,
								esc_attr( get_the_modified_date( 'c' ) ),
								esc_html( get_the_modified_date() )
							);

							$posted_on = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );

							echo '<span class="posted-on">' . $posted_on . '</span>';

							$byline = sprintf( '<i class="fa fa-user"></i><a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ) );
							echo '<span class="byline author vcard"> ' . $byline . '</span>'; ?>

						</div>

					</div>

			</div><!--/.related-->

			<?php if ( $count % 3 == 0 && $count > 1 ) { echo '<div class="clearfix"></div>'; } ?>
		<?php $count++;
		endwhile; ?>

		</div><!--/.post-related-->
	</div>
<?php endif; ?>

<?php wp_reset_postdata(); ?>
