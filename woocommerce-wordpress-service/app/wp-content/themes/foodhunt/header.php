<?php
/**
 * The Header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package    ThemeGrill
 * @subpackage FoodHunt
 * @since      0.1
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>

<?php do_action( 'foodhunt_before' ); ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'foodhunt' ); ?></a>

	<?php
	foodhunt_the_custom_header_markup();

	if ( get_theme_mod( 'foodhunt_slider_activation', '0' ) == '1' && is_front_page() && ! is_home() ) {
		get_template_part( 'template-parts/content', 'slider' );
		foodhunt_pass_slider_parameters();
	}
	$foodhunt_logo_text = get_theme_mod( 'foodhunt_logo_placement', 'text-only' );
	?>


	<?php do_action( 'foodhunt_before_header' ); ?>

	<header id="masthead" class="site-header <?php echo esc_attr( $foodhunt_logo_text ); ?>" role="banner">
		<div class="header-wrapper clearfix">

			<?php if ( get_theme_mod( 'foodhunt_ticker_activation', '0' ) == '1' || has_nav_menu( 'social' ) ) { ?>
				<div class="top-header clearfix">
					<div class="tg-container">

						<?php
						if ( get_theme_mod( 'foodhunt_ticker_activation', '0' ) == '1' ) {
							foodhunt_header_news();
						}

						if ( has_nav_menu( 'social' ) ) {
							foodhunt_social_menu();
						}
						?>
					</div>
				</div> <!-- top-header wrapper end -->
			<?php } ?>

			<div class="mobile-menu-wrapper">
				<div class="tg-container">
					<div class="menu-toggle hide"><?php esc_html_e( 'Menu', 'foodhunt' ) ?></div>
					<ul id="menu-mobile" class="menu">

						<?php wp_nav_menu( array(
							'theme_location' => 'primary_one',
							'items_wrap'     => '%3$s',
							'container'      => 'false',
						) ); ?>

						<?php wp_nav_menu( array(
							'theme_location' => 'primary_two',
							'items_wrap'     => '%3$s',
							'container'      => 'false',
						) ); ?>
					</ul>
				</div>
			</div>

			<div class="bottom-header clearfix">
				<div class="tg-container">

					<div class="left-menu-wrapper">

						<nav id="site-navigation" class="main-navigation left-nav" role="navigation">
							<?php wp_nav_menu( array(
								'theme_location' => 'primary_one',
								'menu_id'        => 'menu-left',
								'menu_class'     => 'nav-menu'
							) ); ?>
						</nav><!-- #site-navigation -->
					</div>

					<div class="logo-text-wrapper">

						<?php $screen_reader = '';
						if ( $foodhunt_logo_text == 'logo-only' || $foodhunt_logo_text == 'header-none' ) {
							$screen_reader = 'screen-reader-text';
						} ?>

						<div id="header-text" class="<?php echo $screen_reader; ?>">

							<?php if ( is_front_page() && is_home() ) : ?>
								<h1 id="site-title">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
								</h1>
							<?php else : ?>
								<h3 id="site-title">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
								</h3>
							<?php endif;

							$description = get_bloginfo( 'description', 'display' );
							if ( $description || is_customize_preview() ) : ?>
								<p id="site-description"><?php echo esc_html( $description ); ?></p>
							<?php endif; ?>
						</div><!-- #header-text -->

						<?php if ( ( $foodhunt_logo_text == 'both' || $foodhunt_logo_text == 'logo-only' ) ) { ?>
							<div class="logo">

								<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo( $blog_id = 0 ) ) {
									foodhunt_the_custom_logo();
								} ?>

							</div>
						<?php } ?>
					</div>

					<div class="right-menu-wrapper">

						<div class="home-search">
							<div class="search-icon">
								<i class="fa fa-search"> </i>
							</div>
						</div><!-- home-search-end -->

						<nav id="site-navigation" class="main-navigation right-nav">
							<?php wp_nav_menu( array(
								'theme_location' => 'primary_two',
								'menu_id'        => 'menu-right',
								'menu_class'     => 'nav-menu'
							) ); ?>
						</nav> <!-- site-navigation end -->
					</div>
				</div>
			</div>
		</div><!-- header-wrapper end -->
	</header><!-- #masthead -->

	<?php do_action( 'foodhunt_after_header' ); ?>

	<div class="body-content-wrapper">

		<?php if ( ! is_front_page() && ( is_home() || is_archive() || is_page() ) ) {
			$foodhunt_header_title_bar = get_theme_mod( 'foodhunt_header_title_bar', '' );

			$foodhunt_no_header_image = '';
			if ( empty( $foodhunt_header_title_bar ) ) {
				$foodhunt_no_header_image = ' header-title-no-img';
			} ?>
			<div class="header-titlebar-wrapper<?php echo esc_attr( $foodhunt_no_header_image ) ?> clearfix">

				<?php if ( ! empty( $foodhunt_header_title_bar ) ) { ?>
					<div class="header-titlebar-overlay"></div>
					<img src="<?php echo esc_url( $foodhunt_header_title_bar ); ?>">
				<?php } ?>

				<div class="header-title-wrap">
					<?php foodhunt_header_title(); ?>
				</div>
			</div>
		<?php } ?>
