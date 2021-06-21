<?php
/**
 * Template part for displaying footer widget areas.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */
?>

<?php
/**
 * The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if( !is_active_sidebar( 'foodhunt_footer_sidebar1' ) &&
   !is_active_sidebar( 'foodhunt_footer_sidebar2' ) &&
   !is_active_sidebar( 'foodhunt_footer_sidebar3' ) &&
   !is_active_sidebar( 'foodhunt_footer_sidebar4' ) ) {
   return;
}
?>
<div id="top-footer">
	<div class="tg-container">
		<div class="top-footer-wrapper clearfix">
			<div class="tg-column-wrapper">

				<?php for( $i = 1; $i <= 4; $i++ ) {

					if( is_active_sidebar( 'foodhunt_footer_sidebar'.$i ) ): ?>
						<div class="tg-column-4">
							<?php
							// Calling the footer sidebar one if it exists.
							if( !dynamic_sidebar( 'foodhunt_footer_sidebar'.$i ) ):
							endif; ?>
						</div>
					<?php endif;
				} ?>
			</div>
		</div> <!-- top-footer-wrapper end -->
	</div>
</div> <!-- top footer end -->
