<?php
/**
 * Displaying Footer.
 *
 * @package Food Restaurant
 */
?>
<footer role="contentinfo">
	<div class="footersec">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3">
		            <?php dynamic_sidebar('footer-1');?>
		        </div>
		        <div class="col-lg-3 col-md-3">
		            <?php dynamic_sidebar('footer-2');?>
		        </div>
		        <div class="col-lg-3 col-md-3">
		            <?php dynamic_sidebar('footer-3');?>
		        </div> 
		        <div class="col-lg-3 col-md-3">
		            <?php dynamic_sidebar('footer-4');?>
		        </div>        
			</div>
		</div>
	</div>
	<div class="copyright-wrapper">
	    <div class="copyright">
	       <span><?php food_restaurant_credit(); ?> <?php echo esc_html(get_theme_mod('food_restaurant_footer_copy',__('By LogicalThemes','food-restaurant'))); ?></span>
	    </div>
	    <div class="clear"></div>
	</div>
</footer>
<?php wp_footer(); ?>

</body>
</html>