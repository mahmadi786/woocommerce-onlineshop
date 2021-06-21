<?php
/**
 * The template for displaying the footer.
 *
 * Displays all of the footer section and closing of the #page div.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */
?>

	</div><!--  body-content-wrapper end -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php get_template_part( 'template-parts/content-footer' ); ?>

		<div id="bottom-footer">
			<div class="tg-container">

				<?php do_action( 'foodhunt_footer_copyright' ); ?>

				<div class="footer-menu">
					<?php if( has_nav_menu( 'footer' ) ) {
						wp_nav_menu( array(
							'theme_location' => 'footer',
							'depth' => -1,
							'fallback_cb' => false
						));
					} ?>
				</div>
			</div>
		</div> <!-- bottom footer end -->
	</footer><!-- #colophon -->

	<a href="#" class="scrollup"><i class="fa fa-angle-up"> </i> </a>
</div><!-- #page -->

<div class="search-box">
	<div class="search-form-wrapper">
		<?php get_search_form(); ?>
		<div class="close"> <?php esc_html_e( 'close me', 'foodhunt' ) ?> </div>
	</div>
</div>
<?php wp_footer(); ?>

</body>
</html>
