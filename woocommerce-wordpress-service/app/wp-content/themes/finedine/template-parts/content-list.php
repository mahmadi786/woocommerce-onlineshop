<?php 
/**
 * Template part for displaying page content in list.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package finedine
 */
?>
<div class="col-md-6 col-lg-4">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php finedine_post_thumbnail(); ?>
		<span class="cat-links">
	        <?php echo wp_kses_post( finedine_post_category() ); ?>
		</span>
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			 ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php
			the_excerpt( sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'finedine' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'finedine' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->

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
