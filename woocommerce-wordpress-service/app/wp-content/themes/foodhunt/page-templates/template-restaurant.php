<?php
/**
 * Template Name: Restaurant Template
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */
?>

<?php get_header(); ?>

	<?php do_action( 'foodhunt_before_content' ); ?>

	<?php if( is_active_sidebar( 'foodhunt_business_sidebar' ) ) {
		if( !dynamic_sidebar( 'foodhunt_business_sidebar' ) ):
		endif;
	} ?>

	<?php do_action( 'foodhunt_after_content' ); ?>

<?php get_footer(); ?>
