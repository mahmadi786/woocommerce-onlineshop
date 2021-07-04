<?php
/**
 * The template for displaying the footer
 * 
 * @subpackage lzrestaurant
 * @since 1.0
 * @version 1.4
 */

?> 
		</div>
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="container">
				<?php
				get_template_part( 'template-parts/footer/footer', 'widgets' );
				?>
			</div>
			<div class="clearfix"></div>
			<div class="copyright">
				<div class="container">
					<?php get_template_part( 'template-parts/footer/site', 'info' );
					?>
				</div>
			</div>
		</footer>
	</div>
</div>
<?php wp_footer(); ?>

</body>
</html>
