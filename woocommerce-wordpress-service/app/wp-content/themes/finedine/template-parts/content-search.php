<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package finedine
 */

?>

<div class="col-md-4">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php finedine_post_thumbnail(); ?>
		<span class="cat-links">
			<?php  echo wp_kses_post( finedine_post_category() ); ?>
		</span>
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header><!-- .entry-header -->
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

		<footer class="entry-footer">
			<?php if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php
					finedine_posted_on();
					finedine_posted_by();
					?>
				</div><!-- .entry-meta -->
			<?php endif; ?>

		</footer><!-- .entry-footer -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div>
