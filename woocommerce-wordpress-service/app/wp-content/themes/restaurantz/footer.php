<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Restaurantz
 */

	/**
	 * Hook - restaurantz_action_after_content.
	 *
	 * @hooked restaurantz_content_end - 10
	 */
	do_action( 'restaurantz_action_after_content' );
	?>

	<?php
	/**
	 * Hook - restaurantz_action_before_footer.
	 *
	 * @hooked restaurantz_footer_start - 10
	 */
	do_action( 'restaurantz_action_before_footer' );
	?>
    <?php
	  /**
	   * Hook - restaurantz_action_footer.
	   *
	   * @hooked restaurantz_footer_copyright - 10
	   */
	  do_action( 'restaurantz_action_footer' );
	?>
	<?php
	/**
	 * Hook - restaurantz_action_after_footer.
	 *
	 * @hooked restaurantz_footer_end - 10
	 */
	do_action( 'restaurantz_action_after_footer' );
	?>

<?php
	/**
	 * Hook - restaurantz_action_after.
	 *
	 * @hooked restaurantz_page_end - 10
	 * @hooked restaurantz_footer_goto_top - 20
	 */
	do_action( 'restaurantz_action_after' );
?>

<?php wp_footer(); ?>
</body>
</html>
