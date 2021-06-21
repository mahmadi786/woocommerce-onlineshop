<?php
/**
 * Template part for displaying results in search pages.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-grid' ); ?>>
	<div class="entry-image-wrapper">
		<div class="entry-thumbnail">

			<?php if( has_post_thumbnail() ) {
				$image = '';
				$title_attribute = the_title_attribute( 'echo=0' );
				$image .= '<a href="' . get_permalink() . '" title="'. $title_attribute .'">';
				$image .= get_the_post_thumbnail( $post->ID, 'foodhunt-blog', array( 'title' => $title_attribute, 'alt' => $title_attribute ) ).'</a>';

				echo $image;
			} ?>
		</div> <!-- entry-thumbnail-end -->

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</div>

	<div class="entry-text-wrapper clearfix">

		<?php if( 'post' === get_post_type() && get_theme_mod( 'foodhunt_hide_meta', 0 ) != '1' ) : ?>
			<div class="entry-meta">
				<?php foodhunt_entry_meta(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>

		<div class="entry-content-wrapper">
			<div class="entry-content">

				<?php the_excerpt(); ?>

				<div class="entry-btn">
					<a class="btn" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php esc_html_e( 'Read More', 'foodhunt' ); ?>
					</a>
				</div>
			</div><!-- .entry-content -->
		</div>
	</div>
</article><!-- #post-## -->
