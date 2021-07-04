<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package finedine
 */

if ( ! is_active_sidebar( 'primary-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="sidebar widget-area">
	<?php dynamic_sidebar( 'primary-sidebar' ); ?>
</aside><!-- #secondary -->
