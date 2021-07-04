<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage Food Restro
	 * @since Food Restro 1.0.0
	 */

	/**
	 * food_restro_doctype hook
	 *
	 * @hooked food_restro_doctype -  10
	 *
	 */
	do_action( 'food_restro_doctype' );

?>
<head>
<?php
	/**
	 * food_restro_before_wp_head hook
	 *
	 * @hooked food_restro_head -  10
	 *
	 */
	do_action( 'food_restro_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<?php
	/**
	 * food_restro_page_start_action hook
	 *
	 * @hooked food_restro_page_start -  10
	 *
	 */
	do_action( 'food_restro_page_start_action' ); 

	/**
	 * food_restro_header_action hook
	 *
	 * @hooked food_restro_header_start -  10
	 * @hooked food_restro_site_branding -  20
	 * @hooked food_restro_site_navigation -  30
	 * @hooked food_restro_header_end -  50
	 *
	 */
	do_action( 'food_restro_header_action' );

	/**
	 * food_restro_content_start_action hook
	 *
	 * @hooked food_restro_content_start -  10
	 *
	 */
	do_action( 'food_restro_content_start_action' );

	/**
	 * food_restro_header_image_action hook
	 *
	 * @hooked food_restro_header_image -  10
	 *
	 */
	do_action( 'food_restro_header_image_action' );

    if ( food_restro_is_frontpage() ) {

    	$sections = food_restro_sortable_sections();
    	$i = 1;
		foreach ( $sections as $section => $value ) {
			add_action( 'food_restro_primary_content', 'food_restro_add_'. $section .'_section', $i . 0 );
		}
		do_action( 'food_restro_primary_content' );
	} 