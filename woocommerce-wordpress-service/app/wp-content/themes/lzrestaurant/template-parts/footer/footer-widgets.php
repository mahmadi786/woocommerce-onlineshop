<?php
/**
 * Displays footer widgets if assigned
 *
 * @subpackage lzrestaurant
 * @since 1.0
 * @version 1.4
 */ 

?>
<aside class="widget-area" role="complementary">
	<div class="row">
		<?php
		if ( is_active_sidebar( 'footer-1' ) ) { ?>
			<div class="widget-column footer-widget-1 col-lg-3 col-md-3">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
		<?php }
		if ( is_active_sidebar( 'footer-2' ) ) { ?>
			<div class="widget-column footer-widget-2 col-lg-3 col-md-3">
				<?php dynamic_sidebar( 'footer-2' ); ?>
			</div>
		<?php } ?>
		<?php
		if ( is_active_sidebar( 'footer-3' ) ) { ?>
			<div class="widget-column footer-widget-3 col-lg-3 col-md-3">
				<?php dynamic_sidebar( 'footer-3' ); ?>
			</div>
		<?php }
		if ( is_active_sidebar( 'footer-4' ) ) { ?>
			<div class="widget-column footer-widget-4 col-lg-3 col-md-3">
				<?php dynamic_sidebar( 'footer-4' ); ?>
			</div>
		<?php } ?>
	</div>	
</aside>