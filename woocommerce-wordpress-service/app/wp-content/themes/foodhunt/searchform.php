<?php
/**
 * The template for displaying search forms in foodhunt.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */
?>

<form role="search" method="get" class="search-form clearfix" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'foodhunt' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	<button type="submit" class="search-submit" name="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'foodhunt' ); ?>"><i class="fa fa-search"></i></button>
</form>
