<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package finedine
 */

get_header(); ?>
    <div class="featured-thumbnail">
		<?php
		if ( get_the_post_thumbnail_url() ) {
			?>
            <img src='<?php echo esc_url( get_the_post_thumbnail_url() ); ?>'
                 alt='<?php esc_attr_e( 'header img', 'finedine' ); ?>'>
            <div class="title-wrap">
                <h1 class="page-title"><?php the_title(); ?></h1>
            </div>
			<?php
		} else {
			if ( get_custom_header_markup() ) {
				the_custom_header_markup();
			}
			?>
            <div class="title-wrap">
                <h1 class="page-title"><?php the_title(); ?></h1>
            </div>
			<?php
		}
		?>
    </div>
    <div id="content" class="site-content">
        <div class="container clear">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', get_post_type() );
						if ( is_attachment() ) {
							?>

                            <nav class="navigation image-navigation">
                                <h2 class="screen-reader-text"><?php esc_html_e( 'Image navigation', 'finedine' ); ?></h2>
                                <div class="nav-links">
									<?php previous_image_link( false, '<div class="nav-previous"></div>' ); ?>
									<?php next_image_link( false, '<div class="nav-next"></div>' ); ?>
                                </div>
                            </nav>

							<?php
						} else {
							the_post_navigation();
						}

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>

                </main><!-- #main -->
            </div><!-- #primary -->
            <aside id="secondary" class="sidebar widget-area">
                <!--start of widget single page-->
	            <?php if ( is_active_sidebar( 'finedine-innerpage-sidebar' ) ) { ?>
					    <?php dynamic_sidebar( 'finedine-innerpage-sidebar' ); ?>
		            <?php
	            } else {
		            if ( is_customize_preview() ) {
			            ?>
                        <div class="widget-notice"><?php esc_html_e( 'To add a widget, please go to the Widgets > Blog Sidebar.', 'finedine' ); ?>
                            <br>
				            <?php esc_html_e( 'Recommended widgets', 'finedine' ); ?>
                            <strong><?php esc_html_e( 'WordPress Default Widget', 'finedine' ); ?>
                            </strong>
                        </div>
			            <?php
		            }
	            }
	            ?>
                <!--end of widget single page-->
            </aside>
        </div><!-- .container -->
    </div>
<?php get_footer();
