<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

/**
 * food_restro_content_end_action hook
 *
 * @hooked food_restro_content_end -  10
 *
 */
do_action( 'food_restro_content_end_action' );

/**
 * food_restro_content_end_action hook
 *
 * @hooked food_restro_footer_start -  10
 * @hooked Food_Restro_Footer_Widgets->add_footer_widgets -  20
 * @hooked food_restro_footer_site_info -  40
 * @hooked food_restro_footer_end -  100
 *
 */
do_action( 'food_restro_footer' );

/**
 * food_restro_page_end_action hook
 *
 * @hooked food_restro_page_end -  10
 *
 */
do_action( 'food_restro_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>
