<?php

/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package    ThemeGrill
 * @subpackage FoodHunt
 * @since      0.1
 */

add_filter('excerpt_length', 'foodhunt_excerpt_length');
/**
 * Sets the post excerpt length to 40 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function foodhunt_excerpt_length($length)
{
	return 40;
}

add_filter('excerpt_more', 'foodhunt_continue_reading');
/**
 * Returns a "Continue Reading" link for excerpts
 */
function foodhunt_continue_reading()
{
	return '';
}

/****************************************************************************************/

if (!function_exists('foodhunt_pass_slider_parameters')) :
	/**
	 * Function to pass the slider effect parameters from php file to js file.
	 */
	function foodhunt_pass_slider_parameters()
	{

		$slider_controls = get_theme_mod('foodhunt_slider_controls', '0');
		$slider_pager    = get_theme_mod('foodhunt_slider_pager', '0');

		wp_localize_script(
			'foodhunt-custom',
			'foodhunt_slider_value',
			array(
				'slider_controls' => $slider_controls,
				'slider_pager'    => $slider_pager,
			)
		);
	}
endif;

/****************************************************************************************/

if (!function_exists('foodhunt_header_title')) :
	/**
	 * Function to display Header Title bar.
	 */
	function foodhunt_header_title()
	{
		if (is_archive()) {
			if (function_exists('foodhunt_is_in_woocommerce_page') && foodhunt_is_in_woocommerce_page()) {
				echo '<h1 class="header-title">';
				woocommerce_page_title(true);
				echo '</h1>';
			} else {
				the_archive_title('<h1 class="header-title">', '</h1>');
				the_archive_description('<div class="taxonomy-description">', '</div>');
			}
		} elseif (is_page()) {
			the_title('<h1 class="header-title">', '</h1>');
		} elseif (is_home()) {
			$queried_id = get_option('page_for_posts');
			echo '<h1 class="header-title">' . get_the_title($queried_id) . '</h1>';
		}
	}
endif;

/****************************************************************************************/

if (!function_exists('foodhunt_header_news')) :
	/**
	 * Header News/Latest Posts ticker section
	 */
	function foodhunt_header_news()
	{
		if (false === ($get_featured_posts = get_transient('foodhunt_cached_breaking_news'))) {
			$get_featured_posts = new WP_Query(array(
				'posts_per_page'         => 5,
				'post_type'              => 'post',
				'ignore_sticky_posts'    => true,
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			));

			set_transient('foodhunt_cached_breaking_news', $get_featured_posts, DAY_IN_SECONDS);
		} ?>

		<div class="header-ticker">
			<span class="ticker-title">
				<?php echo esc_html__( get_theme_mod( 'foodhunt_ticker_text',  'Special:' ), 'foodhunt' ); ?>
			</span>
			<ul>
				<?php while ($get_featured_posts->have_posts()) : $get_featured_posts->the_post(); ?>
					<li>
						<a href="<?php the_permalink(); ?>" target="_blank" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					</li>
				<?php endwhile; ?>
			</ul>
		</div> <!-- header ticker -->

	<?php
		// Reset Post Data
		wp_reset_query();
	}
endif;

/****************************************************************************************/

if (!function_exists('foodhunt_social_menu')) :
	/**
	 * Social icons menu section
	 */
	function foodhunt_social_menu()
	{ ?>

		<?php wp_nav_menu(array(
			'theme_location'  => 'social',
			'container_class' => 'social-icons-wrapper',
			'depth'           => -1,
			'fallback_cb'     => false,
		)); ?>
	<?php }
endif;

/****************************************************************************************/

/**
 * Purge the transient
 */
add_action('save_post', 'foodhunt_purge_transient');
function foodhunt_purge_transient($post)
{
	delete_transient('foodhunt_cached_breaking_news');
}

/****************************************************************************************/

if (!function_exists('foodhunt_entry_meta')) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function foodhunt_entry_meta()
	{
		if (get_theme_mod('foodhunt_hide_date', 0) != '1') {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if (get_the_time('U') !== get_the_modified_time('U')) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$post_date = sprintf(
				'<span class="entry-date">%1$s</span>
			<span class="entry-month-year">
				<span class="entry-month">%2$s</span>
				<span class="entry-year">%3$s</span>
			</span>',
				esc_html(get_the_time('j')),
				esc_html(get_the_time('F')),
				esc_html(get_the_time('Y'))
			);

			$time_string = sprintf(
				$time_string,
				esc_attr(get_the_date('c')),
				$post_date,
				esc_attr(get_the_modified_date('c')),
				esc_html(get_the_modified_date())
			);

			$posted_on = sprintf('<a href="%1$s" rel="bookmark">%2$s</a>', esc_url(get_permalink()), $time_string);

			echo '<span class="posted-on">' . $posted_on . '</span>';
		}

		if (get_theme_mod('foodhunt_hide_author', 0) != '1') {
			$byline = sprintf('<i class="fa fa-user"></i><a href="%1$s">%2$s</a>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_html(get_the_author()));

			echo '<span class="byline author vcard"> ' . $byline . '</span>';
		}

		if (!is_single() && !post_password_required() && (comments_open() || get_comments_number()) && get_theme_mod('foodhunt_hide_comment', 0) != '1') {
			echo '<span class="comments-link"> <i class="fa fa-comment"></i>';
			comments_popup_link(esc_html__('Leave a comment', 'foodhunt'), esc_html__('Comment (1)', 'foodhunt'), esc_html__('Comments (%)', 'foodhunt'));
			echo '</span>';
		}

		if (get_theme_mod('foodhunt_hide_cat', 0) != '1') {
			$categories_list = get_the_category_list(esc_html__(', ', 'foodhunt'));
			if ($categories_list) {
				printf('<span class="cat-links"><i class="fa fa-folder"></i>%1$s</span>', $categories_list);
			}
		}

		if (get_theme_mod('foodhunt_hide_tags', 0) != '1') {
			$tags_list = get_the_tag_list('<span class="tag-links"><i class="fa fa-tags"></i>', ', ', '</span>');
			if ($tags_list) {
				echo $tags_list;
			}
		}
	}
endif;

/****************************************************************************************/

if (!function_exists('foodhunt_sidebar_select')) :
	/**
	 * Function to select the sidebar
	 */
	function foodhunt_sidebar_select()
	{
		$foodhunt_layout = foodhunt_layout_class();

		if ($foodhunt_layout == 'right-sidebar') {
			get_sidebar();
		} elseif ($foodhunt_layout == 'left-sidebar') {
			get_sidebar('left');
		}
	}
endif;

/****************************************************************************************/

if (!function_exists('foodhunt_layout_class')) :
	/**
	 * Return the layout as selected by user
	 */
	function foodhunt_layout_class()
	{
		global $post;
		$classes = '';

		if ($post) {
			$layout_meta = get_post_meta($post->ID, 'foodhunt_page_layout', true);
		}

		if (is_home()) {
			$queried_id  = get_option('page_for_posts');
			$layout_meta = get_post_meta($queried_id, 'foodhunt_page_layout', true);
		}
		if (empty($layout_meta) || is_archive() || is_search()) {
			$layout_meta = 'default_layout';
		}

		$foodhunt_default_layout      = get_theme_mod('foodhunt_default_layout', 'right-sidebar');
		$foodhunt_default_page_layout = get_theme_mod('foodhunt_default_page_layout', 'right-sidebar');
		$foodhunt_default_post_layout = get_theme_mod('foodhunt_default_single_posts_layout', 'right-sidebar');

		if ($layout_meta == 'default_layout') {
			if (is_page()) {
				$classes = $foodhunt_default_page_layout;
			} elseif (is_single()) {
				$classes = $foodhunt_default_post_layout;
			} else {
				$classes = $foodhunt_default_layout;
			}
		} else {
			$classes = $layout_meta;
		}

		return $classes;
	}
endif;

/****************************************************************************************/

add_filter('body_class', 'foodhunt_body_class');
/*
 * Filter the body_class
 *
 * Throwing different class in the body tag
 */
function foodhunt_body_class($foodhunt_header_class)
{
	if (get_theme_mod('foodhunt_non_sticky', 0) == 1) {
		$foodhunt_header_class[] = 'non-stick';
	} else {
		$foodhunt_header_class[] = 'stick';
	}

	return $foodhunt_header_class;
}

/**************************************************************************************/

/**
 * Change hex code to RGB
 * Source: https://css-tricks.com/snippets/php/convert-hex-to-rgb/#comment-1052011
 */
function foodhunt_hex2rgb($hexstr)
{
	$int = hexdec($hexstr);
	$rgb = array("red" => 0xFF & ($int >> 0x10), "green" => 0xFF & ($int >> 0x8), "blue" => 0xFF & $int);
	$r   = $rgb['red'];
	$g   = $rgb['green'];
	$b   = $rgb['blue'];

	return "rgba($r,$g,$b, 0.85)";
}

/**
 * Generate darker color
 * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function foodhunt_darkcolor($hex, $steps)
{
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max(-255, min(255, $steps));

	// Normalize into a six character long hex string
	$hex = str_replace('#', '', $hex);
	if (strlen($hex) == 3) {
		$hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
	}

	// Split into three parts: R, G and B
	$color_parts = str_split($hex, 2);
	$return      = '#';

	foreach ($color_parts as $color) {
		$color  = hexdec($color); // Convert to decimal
		$color  = max(0, min(255, $color + $steps)); // Adjust color
		$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	}

	return $return;
}

add_action('wp_head', 'foodhunt_custom_css', 100);
/**
 * Hooks the Custom Internal CSS to head section
 */
function foodhunt_custom_css()
{

	$primary_color = get_theme_mod('foodhunt_primary_color', '#dd0103');;
	$primary_opacity = foodhunt_hex2rgb($primary_color);
	$primary_dark    = foodhunt_darkcolor($primary_color, -50);

	$foodhunt_internal_css = '';
	if ($primary_color != '#dd0103') {
		$foodhunt_internal_css = '.blog-btn,.blog-grid .entry-btn .btn:hover,.blog-grid .entry-thumbnail a,.blog-grid .more-link .entry-btn:hover,.blog-img,.chef-content-wrapper,.comment-list .comment-body,.contact-map,.header-titlebar-wrapper,.page-header,.single-blog .entry-thumbnail a,.sub-toggle{border-color:' . $primary_color . '}#cancel-comment-reply-link,#cancel-comment-reply-link:before,#secondary .entry-title a,#secondary .widget a:hover,.blog-grid .byline:hover a,.blog-grid .byline:hover i,.blog-grid .cat-links:hover a,.blog-grid .cat-links:hover i,.blog-grid .comments-link:hover a,.blog-grid .comments-link:hover i,.blog-grid .entry-btn .btn:hover,.blog-grid .entry-month-year:hover i,.blog-grid .entry-month-year:hover span,.blog-grid .more-link .entry-btn:hover,.comment-author .fn .url:hover,.contact-title,.logged-in-as a,.single-blog .byline:hover a,.single-blog .byline:hover i,.single-blog .cat-links:hover a,.single-blog .cat-links:hover i,.single-blog .comments-link:hover a,.single-blog .comments-link:hover i,.single-blog .entry-month-year:hover i,.single-blog .entry-month-year:hover span,.ticker-title,a,.num-404{color:' . $primary_color . '}#secondary .widget-title span::after,#top-footer .widget-title span::after,.about-btn,.blog-grid .entry-title,.contact-icon,.single-blog .entry-title,.sub-toggle,.scrollup,.search-form-wrapper .close,.search-form-wrapper .search-submit,.widget_search .search-form button{background:' . $primary_color . '}#bottom-footer .copyright a:hover,#bottom-footer li a:hover,#site-navigation ul li:hover>a,#site-navigation ul li>a:after,#top-footer .footer-block li:hover a,#top-footer .footer-block li:hover:before,#top-footer .widget a:hover:before,#top-footer .widget_tag_cloud a:hover,.blog-title a:hover,.chef-btn:hover,.chef-social a:hover,.chef-title a:hover,.entry-meta span a:hover,.entry-meta span:hover i,.mobile-menu-wrapper ul li.current-menu-ancestor>a,.mobile-menu-wrapper ul li.current-menu-item>a,.mobile-menu-wrapper ul li:hover>a,.service-title a:hover,.social-icons-wrapper li a:hover::before,.widget_archive a:hover::before,.widget_archive li a:hover,.widget_categories a:hover:before,.widget_categories li a:hover,.widget_meta a:hover:before,.widget_meta li a:hover,.widget_nav_menu a:hover:before,.widget_nav_menu li a:hover,.widget_pages a:hover:before,.widget_pages li a:hover,.widget_recent_comments a:hover:before,.widget_recent_comments li a:hover,.widget_recent_entries a:hover:before,.widget_recent_entries li a:hover,.widget_rss a:hover:before,.widget_rss li a:hover,.widget_tag_cloud a:hover,.search-icon:hover,a:hover, a:focus, a:active{color:' . $primary_dark . '}#home-slider .bx-pager-item a.active,#home-slider .bx-pager-item a:hover,.blog-btn:hover,.bttn:hover,.gallery-wrapper li .gallery-zoom span:hover,.navigation .nav-links a:hover,.slider-btn:hover,button,input[type=button]:hover,input[type=reset]:hover,input[type=submit]:hover,#site-navigation ul li > a::after,.about-btn:hover,.cta-btn:hover,.scrollup:hover, .scrollup:focus,.search-box .search-form-wrapper,.widget_search .search-form button:hover{background:' . $primary_dark . '}.contact-form input:focus,.gallery-wrapper li .gallery-zoom span:hover,.slider-btn:hover,.widget_tag_cloud a:hover,#top-footer .widget_tag_cloud a:hover,.cta-btn:hover{border-color:' . $primary_dark . '}.num-404{text-shadow:13px 0 0 ' . $primary_dark . '}.search-box{background:' . $primary_opacity . '}';
	}

	if (!empty($foodhunt_internal_css)) {
	?>
		<style type="text/css">
			<?php echo $foodhunt_internal_css; ?>
		</style>
	<?php
	}

	$foodhunt_custom_css = get_theme_mod('foodhunt_custom_css');
	if ($foodhunt_custom_css && !function_exists('wp_update_custom_css_post')) {
		echo '<!-- ' . get_bloginfo('name') . ' Custom Styles -->';
	?>
		<style type="text/css">
			<?php echo esc_html($foodhunt_custom_css); ?>
		</style><?php
			}
		}

		/****************************************************************************************/

		add_action('foodhunt_footer_copyright', 'foodhunt_footer_copyright', 10);
		/**
		 * Function to show the footer info, copyright information
		 */
		if (!function_exists('foodhunt_footer_copyright')) :
			function foodhunt_footer_copyright()
			{
				$site_link = '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name', 'display')) . '" >' . get_bloginfo('name', 'display') . '</a>';

				$wp_link = '<a href="https://wordpress.org" target="_blank" title="' . esc_attr__('WordPress', 'foodhunt') . '" rel="nofollow">' . esc_html__('WordPress', 'foodhunt') . '</a>';

				$tg_link = '<a href="' . 'https://themegrill.com/themes/foodhunt' . '" target="_blank" title="' . esc_attr__('FoodHunt', 'foodhunt') . '" rel="nofollow">' . __('FoodHunt', 'foodhunt') . '</a>';

				$default_footer_value = sprintf(esc_html__('Copyright &copy; %1$s %2$s.', 'foodhunt'), date('Y'), $site_link) . ' ' . sprintf(esc_html__('Theme: %1$s by %2$s.', 'foodhunt'), $tg_link, 'ThemeGrill') . ' ' . sprintf(esc_html__('Powered by %s', 'foodhunt'), $wp_link);

				$foodhunt_footer_copyright = '<div class="copyright">' . $default_footer_value . '</div>';
				echo $foodhunt_footer_copyright;
			}
		endif;

		/****************************************************************************************/

		add_action('add_meta_boxes', 'foodhunt_add_custom_box');
		/**
		 * Add Meta Boxes.
		 */
		function foodhunt_add_custom_box()
		{
			// Adding layout meta box for Page
			add_meta_box('page-layout', esc_html__('Select Layout', 'foodhunt'), 'foodhunt_layout_call', 'page', 'side');
			// Adding layout meta box for Post
			add_meta_box('post-layout', esc_html__('Select Layout', 'foodhunt'), 'foodhunt_layout_call', 'post', 'side');
			//Adding designation meta box
			add_meta_box('team-designation', esc_html__('Our Team Designation', 'foodhunt'), 'foodhunt_designation_call', 'page', 'side');
		}

		/****************************************************************************************/

		global $foodhunt_page_layout, $foodhunt_metabox_field_designation;
		$foodhunt_page_layout = array(
			'default-layout'              => array(
				'id'    => 'foodhunt_page_layout',
				'value' => 'default_layout',
				'label' => esc_html__('Default Layout', 'foodhunt'),
			),
			'right-sidebar'               => array(
				'id'    => 'foodhunt_page_layout',
				'value' => 'right-sidebar',
				'label' => esc_html__('Right Sidebar', 'foodhunt'),
			),
			'left-sidebar'                => array(
				'id'    => 'foodhunt_page_layout',
				'value' => 'left-sidebar',
				'label' => esc_html__('Left Sidebar', 'foodhunt'),
			),
			'no-sidebar-full-width'       => array(
				'id'    => 'foodhunt_page_layout',
				'value' => 'no-sidebar-full-width',
				'label' => esc_html__('No Sidebar Full Width', 'foodhunt'),
			),
			'no-sidebar-content-centered' => array(
				'id'    => 'foodhunt_page_layout',
				'value' => 'no-sidebar-content-centered',
				'label' => esc_html__('No Sidebar Content Centered', 'foodhunt'),
			),
		);

		$foodhunt_metabox_field_designation = array(
			array(
				'id'    => 'foodhunt_designation',
				'label' => esc_html__('team designation', 'foodhunt'),
			),
		);


		/****************************************************************************************/

		function foodhunt_layout_call()
		{
			global $foodhunt_page_layout;
			foodhunt_meta_form($foodhunt_page_layout);
		}

		function foodhunt_designation_call()
		{
			global $foodhunt_metabox_field_designation;
			foodhunt_meta_form($foodhunt_metabox_field_designation);
		}

		/**
		 * Displays metabox to for select layout option
		 */
		function foodhunt_meta_form($foodhunt_metabox_field)
		{
			global $post;

			// Use nonce for verification
			wp_nonce_field(basename(__FILE__), 'custom_meta_box_nonce');

			foreach ($foodhunt_metabox_field as $field) {
				$layout_meta = get_post_meta($post->ID, $field['id'], true);
				switch ($field['id']) {

						// Layout
					case 'foodhunt_page_layout':
						if (empty($layout_meta)) {
							$layout_meta = 'default_layout';
						} ?>

				<input class="post-format" type="radio" name="<?php echo esc_attr($field['id']); ?>" value="<?php echo esc_attr($field['value']); ?>" <?php checked($field['value'], $layout_meta); ?> />
				<label class="post-format-icon"><?php echo esc_html($field['label']); ?></label><br />
<?php

						break;

						// Team Designation
					case 'foodhunt_designation':
						echo esc_html__('Designation field for Team Member', 'foodhunt') . '<br>';
						echo '<input type="text" name="' . $field['id'] . '" value="' . esc_attr($layout_meta) . '"/><br>';

						break;
				}
			}
		}

		/****************************************************************************************/

		add_action('save_post', 'foodhunt_save_custom_meta');
		/**
		 * save the custom metabox data
		 *
		 * @hooked to save_post hook
		 */
		function foodhunt_save_custom_meta($post_id)
		{
			global $foodhunt_page_layout, $post, $foodhunt_metabox_field_designation, $post;;

			// Verify the nonce before proceeding.
			if (!isset($_POST['custom_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {
				return;
			}

			// Stop WP from clearing custom fields on autosave
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return;
			}

			if ('page' == $_POST['post_type']) {
				if (!current_user_can('edit_page', $post_id)) {
					return $post_id;
				}
			} elseif (!current_user_can('edit_post', $post_id)) {
				return $post_id;
			}

			foreach ($foodhunt_page_layout as $field) {
				//Execute this saving function
				$old = get_post_meta($post_id, $field['id'], true);
				$new = sanitize_key($_POST[$field['id']]);
				if ($new && $new != $old) {
					update_post_meta($post_id, $field['id'], $new);
				} elseif ('' == $new && $old) {
					delete_post_meta($post_id, $field['id'], $old);
				}
			} // end foreach

			if ('page' == $_POST['post_type']) {
				// loop through fields and save the data
				foreach ($foodhunt_metabox_field_designation as $field) {
					$old = get_post_meta($post_id, $field['id'], true);
					$new = sanitize_key($_POST[$field['id']]);
					if ($new && $new != $old) {
						update_post_meta($post_id, $field['id'], $new);
					} elseif ('' == $new && $old) {
						delete_post_meta($post_id, $field['id'], $old);
					}
				} // end foreach
			}
		}

		/****************************************************************************************/

		add_filter('restaurantpress_widget_menu_settings', 'foodhunt_rp_widget_menu_settings');
		add_action('restaurantpress_widget_menu_before', 'foodhunt_rp_widget_menu_before', 10, 2);
		add_action('restaurantpress_widget_menu_after', 'foodhunt_rp_widget_menu_after');

		function foodhunt_rp_widget_menu_settings($settings)
		{

			$settings['background_color'] = array(
				'type'  => 'color',
				'std'   => '#F5F5F5',
				'label' => esc_html__('Background Color', 'foodhunt'),
			);

			return $settings;
		}

		function foodhunt_rp_widget_menu_before($args, $instance)
		{
			echo '<div class="section-wrapper rp-wrapper clearfix" style="background-color: ' . $instance['background_color'] . '"><div class="tg-container">';
		}

		function foodhunt_rp_widget_menu_after()
		{
			echo '</div></div>';
		}

		/****************************************************************************************/

		/**
		 * Making the theme Woocommrece compatible
		 */
		remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
		remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

		add_filter('woocommerce_show_page_title', '__return_false');

		add_action('woocommerce_before_main_content', 'foodhunt_wrapper_start', 10);
		add_action('woocommerce_after_main_content', 'foodhunt_wrapper_end', 10);
		add_action('woocommerce_sidebar', 'foodhunt_get_sidebar', 20);

		function foodhunt_wrapper_start()
		{
			$foodhunt_layout = foodhunt_layout_class();
			echo '<main id="main" class="clearfix"><div id="content" class="clearfix ' . $foodhunt_layout . '"><div class="tg-container"><div id="primary">';
		}

		function foodhunt_wrapper_end()
		{
			echo '</div>';
		}

		function foodhunt_get_sidebar()
		{
			foodhunt_sidebar_select();
			echo '</div></div></main>';
		}

		if (class_exists('woocommerce') && !function_exists('foodhunt_is_in_woocommerce_page')) :
			/*
	 * woocommerce - conditional to check if woocommerce related page showed
	 */
			function foodhunt_is_in_woocommerce_page()
			{
				return (is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page()) ? true : false;
			}
		endif;

		// Displays the site logo
		if (!function_exists('foodhunt_the_custom_logo')) {
			/**
			 * Displays the optional custom logo.
			 */
			function foodhunt_the_custom_logo()
			{
				if (function_exists('the_custom_logo')) {
					the_custom_logo();
				}
			}
		}

		/**
		 * Migrate any existing theme CSS codes added in Customize Options to the core option added in WordPress 4.7
		 */
		function foodhunt_custom_css_migrate()
		{

			if (function_exists('wp_update_custom_css_post')) {
				$custom_css = get_theme_mod('foodhunt_custom_css');
				if ($custom_css) {
					$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
					$return   = wp_update_custom_css_post($core_css . $custom_css);
					if (!is_wp_error($return)) {
						// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
						remove_theme_mod('foodhunt_custom_css');
					}
				}
			}
		}

		add_action('after_setup_theme', 'foodhunt_custom_css_migrate');

		if (!function_exists('foodhunt_related_posts_function')) {

			/**
			 * Display the related posts.
			 */
			function foodhunt_related_posts_function()
			{
				wp_reset_postdata();
				global $post;

				// Define shared post arguments.
				$args = array(
					'no_found_rows'          => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
					'ignore_sticky_posts'    => 1,
					'orderby'                => 'rand',
					'post__not_in'           => array($post->ID),
					'posts_per_page'         => 3,
				);

				// Related by categories.
				if (get_theme_mod('foodhunt_related_posts_display', 'categories') == 'categories') {
					$cats                 = wp_get_post_categories($post->ID, array('fields' => 'ids'));
					$args['category__in'] = $cats;
				}

				// Related by tags.
				if (get_theme_mod('foodhunt_related_posts_display', 'categories') == 'tags') {
					$tags            = wp_get_post_tags($post->ID, array('fields' => 'ids'));
					$args['tag__in'] = $tags;

					// If no tags added, return
					if (!$tags) {
						$break = true;
					}
				}

				$query = !isset($break) ? new WP_Query($args) : new WP_Query;

				return $query;
			}
		}

		if (!function_exists('foodhunt_pingback_header')) :

			/**
			 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
			 */
			function foodhunt_pingback_header()
			{
				if (is_singular() && pings_open()) {
					printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
				}
			}

		endif;

		add_action('wp_head', 'foodhunt_pingback_header');

		/**
		 * Compare user's current version of plugin.
		 */
		if (!function_exists('foodhunt_plugin_version_compare')) {
			function foodhunt_plugin_version_compare($plugin_slug, $version_to_compare)
			{
				if (!function_exists('get_plugins')) {
					require_once ABSPATH . 'wp-admin/includes/plugin.php';
				}

				$installed_plugins = get_plugins();

				// Plugin not installed.
				if (!isset($installed_plugins[$plugin_slug])) {
					return false;
				}

				$tdi_user_version = $installed_plugins[$plugin_slug]['Version'];

				return version_compare($tdi_user_version, $version_to_compare, '<');
			}
		}
