<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Restaurantz
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
    <?php
	  /**
	   * Hook - restaurantz_single_image.
	   *
	   * @hooked restaurantz_add_image_in_single_display -  10
	   */
	  do_action( 'restaurantz_single_image' );
	?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'restaurantz' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php restaurantz_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php
		/**
		 * Hook - restaurantz_author_bio.
		 *
		 * @hooked restaurantz_add_author_bio_in_single -  10
		 */
		do_action( 'restaurantz_author_bio' );
	?>

</article><!-- #post-## -->

