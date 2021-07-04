<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Diet_Shop
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main">
<?php echo esc_html__( 'Skip to content', 'diet-shop' ); ?>
</a>
<div class="main-page-wrapper">
<?php

/**
* Hook - diet_shop_header 		
*
* @hooked diet_shop_header_logo_n_nav - 10
* @hooked diet_shop_get_hero_section  - 20

*/
 do_action( 'diet_shop_header' );
?>



