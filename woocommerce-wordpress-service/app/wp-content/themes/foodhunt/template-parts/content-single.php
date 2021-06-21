<?php
/**
 * Template part for displaying single posts.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-blog' ); ?>>

	<?php if( has_post_thumbnail() ) {
		$image_class = 'entry-image-wrapper';
	} else {
		$image_class = 'entry-image-wrapper no-image-wrapper';
	} ?>

	<div class="<?php echo esc_attr( $image_class ) ?>">

		<?php if( has_post_thumbnail() ) { ?>
			<div class="entry-thumbnail">
				<?php $image     = '';
				$title_attribute = the_title_attribute( 'echo=0' );
				$thumb_id        = get_post_thumbnail_id( get_the_ID() );
				$img_altr        = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
				$img_alt         = ! empty( $img_altr ) ? $img_altr : $title_attribute;
				$image           .= '<a href="' . get_permalink() . '" title="' . $title_attribute . '">';
				$image           .= get_the_post_thumbnail( $post->ID, 'foodhunt-blog', array(
						'title' => $title_attribute,
						'alt'   => $img_alt,
					) ) . '</a>';

				echo $image;
				?>
			</div> <!-- entry-thumbnail-end -->
		<?php } ?>

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</div>

	<div class="entry-text-wrapper clearfix">

		<?php if( get_theme_mod( 'foodhunt_hide_meta', 0 ) != '1' ) { ?>
			<div class="entry-meta">
				<?php foodhunt_entry_meta(); ?>
			</div><!-- .entry-meta -->
		<?php } ?>

		<div class="entry-content-wrapper">
			<div class="entry-content">

				<?php the_content(); ?>

				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'foodhunt' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->
		</div>
	</div>
</article><!-- #post-## -->
