<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package finedine
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >
<?php do_action( 'wp_body_open' ); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'finedine' ); ?></a>

	<header id="masthead" class="site-header">
		<button class="slideout-menu-toggle<?php if ( is_front_page() ) { echo ' hide-on'; } ?>">
            <span class="screen-reader-text">Click to toggle navigation menu.</span>
			<div id="lines">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</button>
		<?php
		$finedine_header_left_text        = ( ( null !== finedine_get_option( 'testimonial_slider_count' ) ) ) ? finedine_get_option( 'finedine_header_left_text' ) : '';
		$finedine_header_middle_text      = ( ( null !== finedine_get_option( 'finedine_header_middle_text' ) ) ) ? finedine_get_option( 'finedine_header_middle_text' ) : '';
		$finedine_header_right_text       = ( ( null !== finedine_get_option( 'finedine_header_right_text' ) ) ) ? finedine_get_option( 'finedine_header_right_text' ) : '';
		$finedine_header_reservation_text = ( ( null !== finedine_get_option( 'finedine_header_reservation_text' ) ) ) ? finedine_get_option( 'finedine_header_reservation_text' ) : '';
		?>
		<div class="slide-out<?php if ( is_front_page() ) { echo ' open'; } ?>">
			<div class="contact-details-mobile">
				<?php if ( ! empty( $finedine_header_left_text ) ) { ?>
				<span class="address"><?php echo esc_html( $finedine_header_left_text );?></span>
				<?php } ?>
				<?php if ( ! empty( $finedine_header_middle_text ) ) { ?>
				<span class="phone"><?php echo esc_html( $finedine_header_middle_text );?></span>
				<?php } ?>
				<?php if ( ! empty( $finedine_header_right_text ) ) { ?>
				<span class="business-hours"><?php echo esc_html( $finedine_header_right_text );?></span>
				<?php } ?>
			</div>

			<div class="site-branding">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				endif;
				$finedine_description = get_bloginfo( 'description', 'display' );
				if ( $finedine_description || is_customize_preview() ) :
					?>
					<p class="site-description">
						<?php echo esc_html( $finedine_description ); ?>
					</p>
				<?php endif; ?>
				<span href="#" class="slideout-menu-toggle"></span>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation custom-scrollbar scrollbar-inner">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
				?>
			</nav><!-- #site-navigation -->

			<?php if (  finedine_get_option( 'finedine_socials_facebook' ) || finedine_get_option( 'finedine_socials_twitter' ) || finedine_get_option( 'finedine_socials_instagram' ) || finedine_get_option( 'finedine_socials_youtube' )
				  ) : ?>
				<div class="social-connect">
					<span><?php esc_html_e( 'Follow', 'finedine' ); ?></span>
					<?php finedine_social_media_icons(); ?>
				</div><!-- .social-connect -->
			<?php endif; ?>

			<span class="copyright">
				<?php
				$finedine_remove_copyright_text = ( ( null !== finedine_get_option( 'finedine_remove_copyright_text' ) ) ) ? finedine_get_option( 'finedine_remove_copyright_text' ) : '';
				$finedine_copyright_text        = ( ( null !== finedine_get_option( 'finedine_copyright_text' ) ) ) ? finedine_get_option( 'finedine_copyright_text' ) : '';
				if ( false !== $finedine_remove_copyright_text ) {
					if ( ! empty( $finedine_copyright_text ) ) {
						echo esc_html( $finedine_copyright_text );
					} else {
						if ( ! is_customize_preview() ) {
							?>
							<?php bloginfo( 'name' ); ?> &copy; <?php echo esc_html( date_i18n( __( 'Y', 'finedine' ) ) ); ?> .
							<?php /* translators: %s: Site name */ ?>
							<br><?php printf( esc_html__( 'Proudly powered by %s', 'finedine' ), 'WordPress' ); ?>
						<?php
						}
					}
					?>

					<?php
				} else {
					?>

					<?php bloginfo( 'name' ); ?> &copy; <?php echo esc_html( date_i18n(__('Y','finedine') ) ); ?>.
					<?php /* translators: %s: Site name */ ?>
					<br> <?php printf( esc_html__( 'Proudly powered by %s', 'finedine' ), 'WordPress' ); ?>
					<?php
				}
				?>
				<br/>
				<?php esc_html_e( 'A theme by ', 'finedine' ); ?>
				<a href="<?php echo esc_url( esc_html__( 'https://www.sampression.com', 'finedine' ) ); ?>">
					<?php esc_html_e( 'Sampression', 'finedine' ); ?>
				</a>
			</span>
			</div><!-- .slide-out -->

			<div class="header-bar">
				<div class="container-fluid">
					<div class="row">
						<?php if ( ! empty( $finedine_header_left_text ) ) { ?>
						<div class="col-md-3">
								<span class="left-text-block"><?php echo esc_html( $finedine_header_left_text ); ?></span>
						</div>
						<?php }
						if ( ! empty( $finedine_header_middle_text ) ) { ?>
						<div class="col-md-3">
								<span class="middle-text-block"><?php echo esc_html( $finedine_header_middle_text ); ?></span>
						</div>
						<?php }
						if ( ! empty( $finedine_header_right_text ) ) { ?>
						<div class="col-md-3">
								<span class="right-text-block"><?php echo esc_html( $finedine_header_right_text ); ?></span>
						</div>
						<?php }
						if ( $finedine_header_reservation_text ) { ?>
						<div class="col-md-3">
							<a href="<?php echo esc_url( finedine_get_option( 'finedine_header_reservation_url' ) ) ; ?>" class="smooth-scroll btn border-btn">
							<?php echo esc_html( $finedine_header_reservation_text ); ?></a>
						</div>
						<?php }
						?>
					</div><!-- .row -->
				</div><!-- .container-fluid -->
			</div><!-- .header-bar -->

	</header><!-- #masthead -->

