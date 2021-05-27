<?php
/**
 * Custom theme functions.
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package Restaurantz
 */

if ( ! function_exists( 'restaurantz_skip_to_content' ) ) :

	/**
	 * Add Skip to content.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_skip_to_content() {
	?><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'restaurantz' ); ?></a><?php
	}

endif;

add_action( 'restaurantz_action_before', 'restaurantz_skip_to_content', 15 );

if ( ! function_exists( 'restaurantz_site_branding' ) ) :

	/**
	 * Site branding.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_site_branding() {

	?>
    <div class="site-branding">
		<?php restaurantz_the_custom_logo(); ?>

		<?php $show_title = restaurantz_get_option( 'show_title' ); ?>
		<?php $show_tagline = restaurantz_get_option( 'show_tagline' ); ?>
		<?php if ( true === $show_title || true === $show_tagline ) : ?>
			<div id="site-identity">
				<?php if ( true === $show_title ) :  ?>
					<?php if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( true === $show_tagline ) : ?>
					<p class="site-description"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
			</div><!-- #site-identity -->
		<?php endif; ?>

    </div><!-- .site-branding -->

    <?php

	}

endif;

add_action( 'restaurantz_action_header', 'restaurantz_site_branding' );


if ( ! function_exists( 'restaurantz_add_primary_navigation' ) ) :

	/**
	 * Site branding.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_add_primary_navigation() {
	?>
    <div id="main-nav" class="clear-fix">
        <nav id="site-navigation" class="main-navigation" role="navigation">
            <div class="wrap-menu-content">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'fallback_cb'    => 'restaurantz_primary_navigation_fallback',
				) );
				?>
            </div><!-- .menu-content -->
        </nav><!-- #site-navigation -->
    </div> <!-- #main-nav -->
    <?php
	}

endif;
add_action( 'restaurantz_action_header', 'restaurantz_add_primary_navigation', 20 );

if ( ! function_exists( 'restaurantz_mobile_navigation' ) ) :

	/**
	 * Mobile navigation.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_mobile_navigation() {
	?>
	    <a id="mobile-trigger" href="#mob-menu"><i class="fa fa-bars"></i></a>
	    <div id="mob-menu">
			<?php
	        wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => '',
				'fallback_cb'    => 'restaurantz_primary_navigation_fallback',
	        ) );
			?>
	    </div><!-- #mob-menu -->
    <?php

	}

endif;
add_action( 'restaurantz_action_before', 'restaurantz_mobile_navigation', 20 );


if ( ! function_exists( 'restaurantz_footer_copyright' ) ) :

	/**
	 * Footer copyright
	 *
	 * @since 1.0.0
	 */
	function restaurantz_footer_copyright() {

		// Check if footer is disabled.
		$footer_status = apply_filters( 'restaurantz_filter_footer_status', true );
		if ( true !== $footer_status ) {
			return;
		}

		// Footer Menu.
		$footer_menu_content = wp_nav_menu( array(
			'theme_location' => 'footer',
			'container'      => 'div',
			'container_id'   => 'footer-navigation',
			'depth'          => 1,
			'fallback_cb'    => false,
			'echo'           => false,
		) );

		// Copyright content.
		$copyright_text = restaurantz_get_option( 'copyright_text' );
		$copyright_text = apply_filters( 'restaurantz_filter_copyright_text', $copyright_text );
		if ( ! empty( $copyright_text ) ) {
			$copyright_text = wp_kses_data( $copyright_text );
		}

	?>

    <?php if ( ! empty( $footer_menu_content ) ) :  ?>
		<?php echo $footer_menu_content; ?>
    <?php endif ?>
    <?php if ( ! empty( $copyright_text ) ) :  ?>
      <div class="copyright">
        <?php echo $copyright_text; ?>
      </div><!-- .copyright -->
    <?php endif; ?>
        <div class="site-info">
    	    <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'restaurantz' ) ); ?>"><?php printf( esc_html__( 'Powered by %s', 'restaurantz' ), 'WordPress' ); ?></a>
        	<span class="sep"> | </span>
        	<?php printf( esc_html__( '%1$s by %2$s', 'restaurantz' ), 'Restaurantz', '<a href="' . esc_url( 'https://wenthemes.com/' ) . '" rel="designer" target="_blank">WEN Themes</a>' ); ?>
        </div><!-- .site-info -->
    <?php
	}

endif;

add_action( 'restaurantz_action_footer', 'restaurantz_footer_copyright', 10 );


if ( ! function_exists( 'restaurantz_add_sidebar' ) ) :

	/**
	 * Add sidebar.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_add_sidebar() {

		global $post;

		$global_layout = restaurantz_get_option( 'global_layout' );
		$global_layout = apply_filters( 'restaurantz_filter_theme_global_layout', $global_layout );

		// Check if single.
		if ( $post && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'restaurantz_theme_settings', true );
			if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
				$global_layout = $post_options['post_layout'];
			}
		}

		// Include primary sidebar.
		if ( 'no-sidebar' !== $global_layout ) {
			get_sidebar();
		}
		// Include Secondary sidebar.
		switch ( $global_layout ) {
		  case 'three-columns':
		    get_sidebar( 'secondary' );
		    break;

		  default:
		    break;
		}

	}

endif;

add_action( 'restaurantz_action_sidebar', 'restaurantz_add_sidebar' );


if ( ! function_exists( 'restaurantz_custom_posts_navigation' ) ) :
	/**
	 * Posts navigation.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_custom_posts_navigation() {

		$pagination_type = restaurantz_get_option( 'pagination_type' );

		switch ( $pagination_type ) {

			case 'default':
				the_posts_navigation();
			break;

			case 'numeric':
				the_posts_pagination();
			break;

			default:
			break;
		}

	}
endif;

add_action( 'restaurantz_action_posts_navigation', 'restaurantz_custom_posts_navigation' );


if ( ! function_exists( 'restaurantz_add_image_in_single_display' ) ) :

	/**
	 * Add image in single post.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_add_image_in_single_display() {

		global $post;

		// Bail if current post is built with Page Builder.
        if ( true === restaurantz_content_is_pagebuilder() ) {
			return;
        }
		// Bail if checkbox Use Featured Image as Banner is enabled.
		$values = get_post_meta( $post->ID, 'restaurantz_theme_settings', true );
        if ( isset( $values['use_featured_image_as_banner'] ) && 1 === absint( $values['use_featured_image_as_banner'] ) ) {
			return;
        }
		if ( has_post_thumbnail() ) {

			$values = get_post_meta( $post->ID, 'restaurantz_theme_settings', true );
			$single_image = isset( $values['single_image'] ) ? esc_attr( $values['single_image'] ) : '';

			if ( ! $single_image ) {
				$single_image = restaurantz_get_option( 'single_image' );
			}

			if ( 'disable' !== $single_image ) {
				$args = array(
					'class' => 'aligncenter',
				);
				the_post_thumbnail( esc_attr( $single_image ), $args );
			}
		}

	}

endif;

add_action( 'restaurantz_single_image', 'restaurantz_add_image_in_single_display' );

if ( ! function_exists( 'restaurantz_add_breadcrumb' ) ) :

	/**
	 * Add breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_add_breadcrumb() {

		// Bail if Breadcrumb disabled.
		$breadcrumb_type = restaurantz_get_option( 'breadcrumb_type' );
		if ( 'disabled' === $breadcrumb_type ) {
			return;
		}

		// Bail if Home Page.
		if ( is_front_page() || is_home() ) {
			return;
		}

		// Check if breadcrumb is disabled in single.
		global $post;
		if ( is_singular() ) {
			$values = get_post_meta( $post->ID, 'restaurantz_theme_settings', true );
			$disable_breadcrumb = isset( $values['disable_breadcrumb'] ) ? absint( $values['disable_breadcrumb'] ) : 0;
			if ( 1 === $disable_breadcrumb ) {
				return;
			}
		}

		// Render breadcrumb.
		echo '<div id="breadcrumb"><div class="container">';
		switch ( $breadcrumb_type ) {
			case 'simple':
				restaurantz_simple_breadcrumb();
			break;

			case 'advanced':
				if ( function_exists( 'bcn_display' ) ) {
					bcn_display();
				}
			break;

			default:
			break;
		}
		echo '</div><!-- .container --></div><!-- #breadcrumb -->';
		return;

	}

endif;

add_action( 'restaurantz_action_before_content', 'restaurantz_add_breadcrumb' , 7 );


if ( ! function_exists( 'restaurantz_footer_goto_top' ) ) :

	/**
	 * Go to top.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_footer_goto_top() {

		echo '<a href="#page" class="scrollup" id="btn-scrollup"><i class="fa fa-level-up"></i></a>';

	}

endif;

add_action( 'restaurantz_action_after', 'restaurantz_footer_goto_top', 20 );


if( ! function_exists( 'restaurantz_check_custom_header_status' ) ) :

	/**
	 * Check status of custom header.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_check_custom_header_status( $input ) {

		global $post;

		if ( is_front_page() && 'posts' === get_option( 'show_on_front' ) ) {
			$input = false;
		}
		else if ( is_home() && ( $blog_page_id = restaurantz_get_index_page_id( 'blog' ) ) > 0 ) {
			$values = get_post_meta( $blog_page_id, 'restaurantz_theme_settings', true );
			$disable_banner_area = isset( $values['disable_banner_area'] ) ? absint( $values['disable_banner_area'] ) : 0;
			if ( 1 === $disable_banner_area ) {
				$input = false;
			}
		}
		else if ( $post ) {
			if ( is_singular() ) {
				$values = get_post_meta( $post->ID, 'restaurantz_theme_settings', true );
				$disable_banner_area = isset( $values['disable_banner_area'] ) ? absint( $values['disable_banner_area'] ) : 0;
				if ( 1 === $disable_banner_area ) {
					$input = false;
				}
			}
		}

		return $input;

	}

endif;

add_filter( 'restaurantz_filter_custom_header_status', 'restaurantz_check_custom_header_status' );


if ( ! function_exists( 'restaurantz_add_custom_header' ) ) :

	/**
	 * Add Custom Header.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_add_custom_header() {

		$flag_apply_custom_header = apply_filters( 'restaurantz_filter_custom_header_status', true );
		if ( true !== $flag_apply_custom_header ) {
			return;
		}
		$attribute = '';
		$attribute = apply_filters( 'restaurantz_filter_custom_header_style_attribute', $attribute );
		?>
		<div id="custom-header" <?php echo ( ! empty( $attribute ) ) ? ' style="' . esc_attr( $attribute ) . '" ' : ''; ?>>
			<div class="container">
				<?php
					/**
					 * Hook - restaurantz_action_custom_header.
					 */
					do_action( 'restaurantz_action_custom_header' );
				?>
			</div><!-- .container -->
		</div><!-- #custom-header -->
		<?php

	}
endif;

add_action( 'restaurantz_action_before_content', 'restaurantz_add_custom_header', 5 );

if ( ! function_exists( 'restaurantz_add_title_in_custom_header' ) ) :

	/**
	 * Add title in Custom Header.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_add_title_in_custom_header() {
		$tag = 'h1';
		if ( is_front_page() ) {
			$tag = 'h2';
		}
		$custom_page_title = apply_filters( 'restaurantz_filter_custom_page_title', '' );
		?>
		<div class="header-content">
			<?php if ( ! empty( $custom_page_title ) ) : ?>
				<?php echo '<' . $tag . ' class="page-title">'; ?>
				<?php echo esc_html( $custom_page_title ); ?>
				<?php echo '</' . $tag . '>'; ?>
			<?php endif ?>
	        <?php if ( is_singular( 'post' ) ) : ?>
		        <div class="header-meta">
	        	<?php restaurantz_posted_on_custom(); ?>
		        </div><!-- .entry-meta -->
	        <?php endif ?>
        </div><!-- .header-content -->
		<?php
	}

endif;

add_action( 'restaurantz_action_custom_header', 'restaurantz_add_title_in_custom_header' );

if ( ! function_exists( 'restaurantz_customize_page_title' ) ) :

	/**
	 * Add title in Custom Header.
	 *
	 * @since 1.0.0
	 *
	 * @param string $title Title.
	 * @return string Modified title.
	 */
	function restaurantz_customize_page_title( $title ) {

		if ( is_home() && ( $blog_page_id = restaurantz_get_index_page_id( 'blog' ) ) > 0 ) {
			$title = get_the_title( $blog_page_id );
		}
		elseif ( is_singular() ) {
			$title = get_the_title();
		}
		elseif ( is_archive() ) {
			$title = strip_tags( get_the_archive_title() );
		}
		elseif ( is_search() ) {
			$title = sprintf( __( 'Search Results for: %s', 'restaurantz' ),  get_search_query() );
		}
		elseif ( is_404() ) {
			$title = __( '404!', 'restaurantz' );
		}
		return $title;
	}
endif;

add_filter( 'restaurantz_filter_custom_page_title', 'restaurantz_customize_page_title' );


if ( ! function_exists( 'restaurantz_add_image_in_custom_header' ) ) :

	/**
	 * Add image in Custom Header.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_add_image_in_custom_header( $input ) {

		$image_details = array();

		// For is_home().
		if ( is_home() && ( $blog_page_id = restaurantz_get_index_page_id( 'blog' ) ) > 0 ) {
			$values = get_post_meta( $blog_page_id, 'restaurantz_theme_settings', true );
			$use_featured_image_as_banner = isset( $values['use_featured_image_as_banner'] ) ? absint( $values['use_featured_image_as_banner'] ) : 0;
			if ( 1 === $use_featured_image_as_banner ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $blog_page_id ), 'restaurantz-featured-banner' );
				if ( ! empty( $image ) ) {
					$image_details['url']    = $image[0];
					$image_details['width']  = $image[1];
					$image_details['height'] = $image[2];
				}
			}
		}
		// Fetch image info if singular.
		else if ( is_singular() ) {
			global $post;
			$values = get_post_meta( $post->ID, 'restaurantz_theme_settings', true );
			$use_featured_image_as_banner = isset( $values['use_featured_image_as_banner'] ) ? absint( $values['use_featured_image_as_banner'] ) : 0;
			if ( 1 === $use_featured_image_as_banner ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'restaurantz-featured-banner' );
				if ( ! empty( $image ) ) {
					$image_details['url']    = $image[0];
					$image_details['width']  = $image[1];
					$image_details['height'] = $image[2];
				}
			}

		}
		if ( empty( $image_details ) ) {
			// Fetch from Custom Header Image.
			$image = get_header_image();
			if ( ! empty( $image ) ) {
				$image_details['url']    = $image;
				$image_details['width']  =  get_custom_header()->width;
				$image_details['height'] =  get_custom_header()->height;
			}
		}

		if ( ! empty( $image_details ) ) {
			$input .= 'background-image:url(' . esc_url( $image_details['url'] ) . ');';
			$input .= 'background-size:cover;';
		}

		return $input;

	}

endif;

add_filter( 'restaurantz_filter_custom_header_style_attribute', 'restaurantz_add_image_in_custom_header' );


if ( ! function_exists( 'restaurantz_add_author_bio_in_single' ) ) :

	/**
	 * Display Author bio.
	 *
	 * @since 1.0.0
	 */
	function restaurantz_add_author_bio_in_single() {

		if ( is_singular( 'post' ) ) {
			global $post;
			if ( get_the_author_meta( 'description', $post->post_author ) ) {
				get_template_part( 'template-parts/author-bio', 'single' );
			}
		}

	}

endif;

add_action( 'restaurantz_author_bio', 'restaurantz_add_author_bio_in_single' );

if ( ! function_exists( 'restaurantz_add_background_image_in_footer' ) ) :

	/**
	 * Add background image in footer.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Footer args.
	 * @return array Modified array.
	 */
	function restaurantz_add_background_image_in_footer( $args ) {

		$footer_background_image_url = restaurantz_get_option( 'footer_background_image' );
		if ( ! empty( $footer_background_image_url ) ){
			$args['container_style'] = 'background-image: url(' . esc_url( $footer_background_image_url ) . ');background-size:cover;';
		}
		return $args;
	}

endif;

add_filter( 'restaurantz_filter_footer_widgets_args', 'restaurantz_add_background_image_in_footer');

if ( ! function_exists( 'restaurantz_primary_navigation_fallback' ) ) :

	/**
	 * Fallback for primary navigation.
	 *
	 * @since 1.1
	 */
	function restaurantz_primary_navigation_fallback() {
		echo '<ul>';
		echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home', 'restaurantz' ). '</a></li>';
		wp_list_pages( array(
			'title_li' => '',
			'depth'    => 1,
			'number'   => 7,
		) );
		echo '</ul>';

	}

endif;
