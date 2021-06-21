<?php
/**
 * The template for displaying search results pages.
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

						<header class="page-header">
							<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'foodhunt' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
						</header><!-- .page-header -->

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );
							?>

						<?php endwhile; ?>

						<?php get_template_part( 'navigation', 'search' ); ?>

					<?php else : ?>

						<?php get_template_part( 'template-parts/content', 'none' ); ?>

					<?php endif; ?>
				</div><!-- #primary -->

				<?php foodhunt_sidebar_select(); ?>

			</div><!-- .tg-container -->
		</div><!-- #content -->
	</main><!-- #main -->

<?php get_footer(); ?>
