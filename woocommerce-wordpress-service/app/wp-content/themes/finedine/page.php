<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package finedine
 */

get_header();
?>

<div class="interior-hero">
	<?php
	if ( get_the_post_thumbnail_url() ) {
		?>
        <img src='<?php echo esc_url( get_the_post_thumbnail_url() ); ?>' alt='<?php esc_attr_e( 'header img', 'finedine' ); ?>'>
        <div class="title-wrap">
            <h1 class="page-title">
				<?php the_title(); ?>
            </h1>
        </div>
		<?php
	} else {
		if ( get_custom_header_markup() ) {
			the_custom_header_markup();
		}
		?>
        <div class="title-wrap">
            <h1 class="page-title">
				<?php the_title(); ?>
            </h1>
        </div>
		<?php
	}
	?>
</div>
	<div id="content" class="site-content">
		<div class="container clear">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">
					<div class="row">
						<div class="<?php if (class_exists( 'WooCommerce' )){ if(is_shop()) { echo 'col-lg-12'; } else { echo 'offset-lg-2 col-lg-8'; } } else{ echo 'offset-lg-2 col-lg-8'; } ?>">
								<?php
								while ( have_posts() ) :
									the_post();

									get_template_part( 'template-parts/content', 'page' );

									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;

								endwhile; // End of the loop.
								?>
						</div>

					</div>
				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- .container -->
</div>
<?php
get_footer();
