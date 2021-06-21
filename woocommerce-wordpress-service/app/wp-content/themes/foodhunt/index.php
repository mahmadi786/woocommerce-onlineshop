<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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

					<?php if( have_posts() ) : ?>

						<?php /* Start the Loop */ ?>
						<?php while( have_posts() ) : the_post(); ?>

							<?php
							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
							?>

						<?php endwhile; ?>

						<?php get_template_part( 'navigation', 'none' ); ?>

					<?php else : ?>

						<?php get_template_part( 'template-parts/content', 'none' ); ?>

					<?php endif; ?>
				</div><!-- #primary -->

				<?php foodhunt_sidebar_select(); ?>
			</div><!-- .tg-container -->
		</div><!-- #content -->
	</main><!-- #main -->

	<?php do_action( 'foodhunt_after_content' ); ?>

<?php get_footer(); ?>
