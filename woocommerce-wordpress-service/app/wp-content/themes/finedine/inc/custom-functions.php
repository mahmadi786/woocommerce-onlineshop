<?php
/**
 * body class for sidebar
 *
 * @param  $classes
 *
 * @return array
 */
function finedine_body_sidebar_class ( $classes ) {
	// get the sidebar position form customizer.
	$position      = finedine_sidebar_position();
	$extra_class   = null;
	$sidebar_class = null;

	if ( is_single() ) {
		if ( 'right' === $position ) {
			$extra_class = 'right-sidebar-layout';
		} elseif ( 'left' === $position ) {
			$extra_class = 'left-sidebar-layout';
		} else {
			$extra_class = 'right-sidebar-layout';
		}
	} elseif ( is_page_template( 'template-restaurant.php' ) ) {
		$extra_class = 'restaurant-template';
	} else {
		$extra_class = 'hfeed';
	}

	return array_merge( $classes, array( $extra_class ) );
}
add_filter( 'body_class', 'finedine_body_sidebar_class' );

/**
 * Count recommended plugins
 *
 * @return string
 */
function finedine_sm_count_recommended_plugins() {
	// count the recommended plugins.
	$rec_plugins       = finedine_get_recommended_plugin_info();
	$recommend_plugins = get_theme_support( 'recommend-plugins' );
	$plugin_count      = 0;

	foreach ( $rec_plugins as $recommended_plugin_name => $plugin_status_slug ) {
		if ( ! empty( $recommended_plugin_name ) ) {
			$active_file_name = $plugin_status_slug[1] . '/wp-' . $plugin_status_slug[1] . '.php';
		}

		if ( ! is_plugin_active( $active_file_name ) ) {
			$plugin_count++;
		}
	}
	$plugin_count = 0;

	return $plugin_count;
}


/**
 * Count recommended action (plugins,settings)
 *
 * @return string
 */
function finedine_sm_recommended_count() {
	$show_on_front = get_option( 'show_on_front' );
	$page_on_front = get_option( 'page_on_front' );
	$front_pages   = get_pages(
		array(
			'meta_key'   => 'wp_page_template',
			'meta_value' => 'template-restaurant.php'
		)
	);
	// check the status of front page.
	$count_recommended = 0;
	$frontpage_id      = '';
	if ( ! empty( $front_pages ) ) {
		$frontpage_id = $front_pages[0]->ID;
	}
	if ( 'page' !== $show_on_front || $frontpage_id !== $page_on_front ) {
		$count_recommended = 2;
	}
	if ( 'page' === $show_on_front || $frontpage_id !== $page_on_front ) {
		$count_recommended = 1;
	}
	if ( 'page' === $show_on_front || $frontpage_id === $page_on_front ) {
		$count_recommended = 0;
	}
	return $count_recommended;

}

/**
 *  Plugin status
 *
 * @return int
 */
function finedine_sm_count_recommended_plugins_static() {
	$show_on_front = get_option( 'show_on_front' );
	$page_on_front = get_option( 'page_on_front' );
	$front_pages   = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'template-restaurant.php'
	));
	// Check the status of front page.
	if ( 'page' !== $show_on_front ) {
		$count_one = 1;
	} else {
		$count_one = 0;
	}
	return $count_one;
}

/**
 * Badge Update
 *
 * @return int
 */
function finedine_badge_update_action() {
	// Check the eye action in db.
	$db_badge_count_total = finedine_sm_recommended_count();
	$badge_plugins        = get_option('badge_plugins');
	$badge_static         = get_option('badge_static');
	// Static page.
	$db_badge_count_static = finedine_sm_count_recommended_plugins_static();
	if ( 0 === $db_badge_count_total ) {
		$badge_static = 0;
	}
	$count_badge_update = (int) $db_badge_count_total - (int) $badge_static;
	return $count_badge_update;
}
// Add update badge function.
add_action( 'wp_ajax_nopriv_finedine_update_recommended_badge', 'finedine_update_recommended_badge' );
add_action( 'wp_ajax_finedine_update_recommended_badge', 'finedine_update_recommended_badge' );

/**
 * Update badge visibility by clicking eye icon
 *
 */
function finedine_update_recommended_badge() {

    $sm_recommended_count = finedine_sm_recommended_count();
    $data_id = $_POST['data_id'];

	if ( 'badge_plugins_hide' === $data_id ) {
		$option_name = 'badge_plugins';
		$new_value   = 0;
	}
	if ( 'badge_plugins_show' === $data_id ) {
		$option_name = 'badge_plugins';
		$new_value   = 1;
	}
	if ( 'badge_static_hide' === $data_id ) {
		$option_name = 'badge_static';
		$new_value   = 0;
	}
	if ( 'badge_static_show' === $data_id ) {
		$option_name = 'badge_static';
		$new_value   = 1;
	}

	if ( get_option( $option_name ) !== false ) {
		update_option( $option_name, $new_value );
	} else {
		add_option( $option_name, $new_value );
	}
	die();
}


/**
 * Getting value of customizer
 *
 * @param  $option_name
 *
 * @return bool
 */
function finedine_get_option( $option_name ) {

	global $finedine_settings;

	$finedine_settings = wp_parse_args( get_option( 'finedine_theme_settings', array() ), finedine_get_option_defaults() );

	return isset( $finedine_settings[ $option_name ] ) ? $finedine_settings[ $option_name ] : false;
}



