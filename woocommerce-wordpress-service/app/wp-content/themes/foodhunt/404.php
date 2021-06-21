<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */

get_header(); ?>

	<?php do_action( 'foodhunt_before_content' ); ?>

	<main id="main" class="clearfix">
		<div id="content" class="clearfix" >
			<div class="tg-container">
				<div id="primary">

					<section class="error-404 not-found">
						<div class="page-content tg-column-wrapper clearfix">

							<div class="404-message clearfix">
								<div class="error-wrap tg-column-2">
									<span class="num-404"><?php esc_html_e( '404' , 'foodhunt' ); ?></span>
								</div>
								<div class="page-message tg-column-2">
									<h1 class="page-title">
										<span class="Oops"><?php _e( 'Oops!!' , 'foodhunt' ); ?></span>
										<span class="error-message"><?php esc_html_e( 'Page Not Found' , 'foodhunt' ); ?></span>
									</h1>
								</div>
							</div>

							<?php get_search_form(); ?>
						</div>
					</section><!-- .error-404 -->
				</div><!-- #primary -->

				<?php foodhunt_sidebar_select(); ?>

			</div><!-- .tg-container -->
		</div><!-- #content -->
	</main><!-- #main -->

	<?php do_action( 'foodhunt_after_content' ); ?>

<?php get_footer(); ?>
