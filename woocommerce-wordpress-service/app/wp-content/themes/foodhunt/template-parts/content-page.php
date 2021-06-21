<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-text-wrapper clearfix">
		<div class="entry-content-wrapper">

			<div class="entry-content">
			<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'foodhunt' ),
					'after'  => '</div>',
				) );
			?>
			</div><!-- .entry-content -->
		</div>
	</div>
</article><!-- #post-## -->
