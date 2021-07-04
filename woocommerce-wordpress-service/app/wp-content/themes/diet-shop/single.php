<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Diet_Shop
 */

get_header();
$layout = diet_shop_get_option('blog_layout');

/**
* Hook - diet_shop_container_before 		- 10
*
* @hooked diet_shop_container_before
*/
 do_action( 'diet_shop_container_before', esc_attr( $layout ) );
?>

	
		

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'single');

			
			
			/**
			* Hook - diet_shop_single_post_navigation 		- 10
			*
			* @hooked diet_shop_single_post_navigation
			*/
			do_action( 'diet_shop_single_post_navigation' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	
<?php

/**
* Hook - diet_shop_container_after 		- 10
*
* @hooked diet_shop_container_after
*/
 do_action( 'diet_shop_container_after', esc_attr( $layout ) );

get_footer();
