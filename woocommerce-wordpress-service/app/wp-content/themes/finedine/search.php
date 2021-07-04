<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package finedine
 */

get_header();
?>
	<div class="interior-hero">
		<?php
        if ( get_custom_header_markup() ) {
            the_custom_header_markup();
        }
		?>
		<div class="title-wrap">
			<h1 class="page-title">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'finedine' ), '<span>' . get_search_query() . '</span>' );
				?>
			</h1>
		</div>
	</div>
	<div id="content" class="site-content">
		<div class="container clear">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">
					<div class="row">

					<?php if ( have_posts() ) : ?>

						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );
							?>

						<?php
                        endwhile;

						the_posts_navigation();

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>

					</div>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- .container -->
	</div>
<?php
get_footer();

