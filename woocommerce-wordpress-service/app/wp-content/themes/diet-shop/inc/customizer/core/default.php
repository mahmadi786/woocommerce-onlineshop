<?php
/**
 * Default theme options.
 *
 * @package diet-shop
 */

if ( ! function_exists( 'diet_shop_get_default_theme_options' ) ) :

	/**
	 * Get default theme options
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function diet_shop_get_default_theme_options() {

		$defaults = array();
		
		/*Global Layout*/
		$defaults['search_icon']     			    = 1;
		
		/*Posts Layout*/
		$defaults['blog_layout']     				= 'content-sidebar';
		$defaults['blog_loop_content_type']     	= 'excerpt';
		/*Posts Layout*/
		$defaults['page_layout']     				= 'content-sidebar';
		
		/*layout*/
		$defaults['copyright_text']					= esc_html__( 'Copyright All right reserved', 'diet-shop' );
		$defaults['read_more_text']					= esc_html__( 'Read more', 'diet-shop' );
		$defaults['index_hide_thumb']     			= false;
		$defaults['__primary_color']     			= '#777777';
		$defaults['__secondary_color']     			= '#db2a24';
		
		
	

		// Pass through filter.
		$defaults = apply_filters( 'diet_shop_filter_default_theme_options', $defaults );

		return $defaults;

	}

endif;
