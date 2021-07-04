<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
			<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
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

								/*
								 * Include the Post-Type-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'list' );
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
			<?php //get_sidebar(); ?>
        </div><!-- .container -->
    </div><!-- #content -->
    <!--start of widget footer-->
<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) :
	?>
    <aside class="sidebar bottom-widget-area wow fadeIn">
        <div class="container">
            <div class="row">

                <!--show restaurant_footer-->

				<?php
				dynamic_sidebar( 'footer-sidebar-1' );
				?>

                <!--end of show restaurant_footer-->

            </div>
        </div>
    </aside>
<?php
endif;
?>
    <!--end of show restaurant_footer-->
<?php
get_footer();
