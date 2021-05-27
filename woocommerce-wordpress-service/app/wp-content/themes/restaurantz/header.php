<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Restaurantz
 */

?><?php
	/**
	 * Hook - restaurantz_action_doctype.
	 *
	 * @hooked restaurantz_doctype -  10
	 */
	do_action( 'restaurantz_action_doctype' );
?>
<head>
	<?php
	/**
	 * Hook - restaurantz_action_head.
	 *
	 * @hooked restaurantz_head -  10
	 */
	do_action( 'restaurantz_action_head' );
	?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php do_action( 'wp_body_open' ); ?>

	<?php
	/**
	 * Hook - restaurantz_action_before.
	 *
	 * @hooked restaurantz_page_start - 10
	 * @hooked restaurantz_skip_to_content - 15
	 */
	do_action( 'restaurantz_action_before' );
	?>

    <?php
	  /**
	   * Hook - restaurantz_action_before_header.
	   *
	   * @hooked restaurantz_header_start - 10
	   */
	  do_action( 'restaurantz_action_before_header' );
	?>
		<?php
		/**
		 * Hook - restaurantz_action_header.
		 *
		 * @hooked restaurantz_site_branding - 10
		 */
		do_action( 'restaurantz_action_header' );
		?>
    <?php
	  /**
	   * Hook - restaurantz_action_after_header.
	   *
	   * @hooked restaurantz_header_end - 10
	   * @hooked restaurantz_add_primary_navigation - 20
	   */
	  do_action( 'restaurantz_action_after_header' );
	?>

	<?php
	/**
	 * Hook - restaurantz_action_before_content.
	 *
	 * @hooked restaurantz_add_breadcrumb - 7
	 * @hooked restaurantz_content_start - 10
	 */
	do_action( 'restaurantz_action_before_content' );
	?>
    <?php
	  /**
	   * Hook - restaurantz_action_content.
	   */
	  do_action( 'restaurantz_action_content' );
	?>
