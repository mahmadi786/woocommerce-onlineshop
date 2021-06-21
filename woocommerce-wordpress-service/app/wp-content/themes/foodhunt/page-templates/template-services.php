<?php
/**
 * Template Name: Service Template
 *
 * Displays the Service Template of the theme.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */

get_header(); ?>

	<?php do_action( 'foodhunt_before_content' ); ?>

	<?php $foodhunt_layout = foodhunt_layout_class(); ?>

	<main id="main" class="clearfix">
		<div id="content" class="clearfix <?php echo esc_attr( $foodhunt_layout ); ?>" >
			<div class="tg-container">
				<div id="primary">

					<?php while( have_posts() ) : the_post();

						// Include the page content template.
						if( is_singular( 'page' ) ) {
							get_template_part( 'template-parts/content', 'page' );

						} else {
							get_template_part( 'template-parts/content', 'single' );

							get_template_part( 'navigation', 'none' );
						}

						// If comments are open or we have at least one comment, load up the comment template.
						if( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

						do_action( 'foodhunt_after_comments_template' );

					endwhile; // End of the loop. ?>
				</div><!-- #primary -->

				<?php foodhunt_sidebar_select(); ?>
			</div><!-- .tg-container -->
		</div><!-- #content -->
	</main><!-- #main -->

	<?php do_action( 'foodhunt_after_content' ); ?>
<?php get_footer(); ?>
