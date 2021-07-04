<?php
/**
 * Implement theme core function.
 */
require get_template_directory() . '/inc/theme-core.php';

/**
 * Implement the Site Header feature.
 */
require get_template_directory() . '/inc/class/class-theme-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/class/class-template-tags.php';

/**
 * Custom template  post type thumbnail for this theme.
 */
require get_template_directory() . '/inc/class/class-posts-thumbnail.php';

/**
 * Implement Posts Related Function.
 */
require get_template_directory() . '/inc/class/class-post-related.php';

/**
 * Implement Footer function.
 */
require get_template_directory() . '/inc/class/class-theme-footer.php';


/**
 * Implement the Theme Layout Function.
 */
require get_template_directory() . '/inc/class/class-container-layout.php';



/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}


require get_template_directory() . '/inc/tgm/recommended-plugins.php';

require get_template_directory() . '/inc/customizer/customizer.php';


//require get_template_directory() . '/inc/pro/admin-page.php';


require get_template_directory() . '/inc/admin/admin-page.php';

