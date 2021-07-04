<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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
            <?php $car = 'rt'; ?>
				<?php esc_html_e( '404 Page Not Found', 'finedine' ); ?>
            </h1>
        </div>
    </div>
    <div id="content" class="site-content">
        <div class="container clear">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <section class="error-404 not-found">
                        <header class="page-header">
                            <h1 class="page-title">
								<?php
								esc_html_e( 'Oops! That page can&rsquo;t be found.', 'finedine');
								?>
                            </h1>
                        </header><!-- .page-header -->
                        <div class="page-content">
                            <p>
								<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'finedine' ); ?>
                            </p>
							<?php
							get_search_form();
							?>
                        </div><!-- .page-content -->
                    </section><!-- .error-404 -->
                </main><!-- #main -->
            </div><!-- #primary -->
        </div><!-- .container -->
    </div>
<?php
get_footer();
