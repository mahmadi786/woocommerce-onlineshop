<?php
/**
 * The header for our theme
 *
 * @subpackage lzrestaurant
 * @since 1.0
 * @version 1.4
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action( 'wp_body_open' );
}?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'lzrestaurant' ); ?></a>
	
	<header id="masthead" class="site-header" role="banner">

		<?php get_template_part( 'template-parts/header/header', 'image' ); ?>

		<div class="main-top">
			<div class="container">
				<div class="row m-0">
					<div class="col-lg-3 col-md-4 col-9">
						<div class="logo">        
					        <?php if ( has_custom_logo() ) : ?>
						        <div class="site-logo"><?php the_custom_logo(); ?></div>
						    <?php endif; ?>
				            <?php if (get_theme_mod('lzrestaurant_show_site_title',true)) {?>
						        <?php $blog_info = get_bloginfo( 'name' ); ?>
						        <?php if ( ! empty( $blog_info ) ) : ?>
						            <?php if ( is_front_page() && is_home() ) : ?>
							            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						        	<?php else : ?>
					            		<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						            <?php endif; ?>
						        <?php endif; ?>
						    <?php }?>
				        	<?php if (get_theme_mod('lzrestaurant_show_tagline',true)) {?>
						        <?php
						        $description = get_bloginfo( 'description', 'display' );
						        if ( $description || is_customize_preview() ) :
						          ?>
							        <p class="site-description">
							            <?php echo esc_html($description); ?>
							        </p>
						        <?php endif; ?>
						    <?php }?>
					    </div>
					</div>
					<div class="col-lg-6 col-md-4 col-3">
						<div id="header">
							<?php if (has_nav_menu('primary')){ ?>
								<div class="toggle-menu responsive-menu">
						            <button onclick="lzrestaurant_open()" role="tab" class="mobile-menu"><i class="fas fa-bars"></i><span class="screen-reader-text"><?php esc_html_e('Open Menu','lzrestaurant'); ?></span></button>
						        </div>
								<div id="sidelong-menu" class="nav sidenav">
					                <nav id="primary-site-navigation" class="nav-menu" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'lzrestaurant' ); ?>">
					                  <?php 
					                    wp_nav_menu( array( 
					                      'theme_location' => 'primary',
					                      'container_class' => 'main-menu-navigation clearfix' ,
					                      'menu_class' => 'clearfix',
					                      'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
					                      'fallback_cb' => 'wp_page_menu',
					                    ) ); 
					                  ?>
					                  <a href="javascript:void(0)" class="closebtn responsive-menu" onclick="lzrestaurant_close()"><i class="fas fa-times"></i><span class="screen-reader-text"><?php esc_html_e('Close Menu','lzrestaurant'); ?></span></a>
					                </nav>
					            </div>
					        <?php }?>
						</div>
					</div>
					<div class="col-lg-3 col-md-4">
						<div class="socialbox">
					        <?php if(esc_url( get_theme_mod( 'lzrestaurant_facebook' ) ) != '') { ?>
					          <a href="<?php echo esc_url( get_theme_mod( 'lzrestaurant_facebook','' ) ); ?>" ><i class="fab fa-facebook-f"></i><span class="screen-reader-text"><?php esc_html_e( 'Facebook','lzrestaurant' );?></span></a>
					        <?php } ?>
					        <?php if(esc_url( get_theme_mod( 'lzrestaurant_twitter' ) ) != '') { ?>
					          <a href="<?php echo esc_url( get_theme_mod( 'lzrestaurant_twitter','' ) ); ?>"><i class="fab fa-twitter"></i><span class="screen-reader-text"><?php esc_html_e( 'Twitter','lzrestaurant' );?></span></a>
					        <?php } ?>
					        <?php if(esc_url( get_theme_mod( 'lzrestaurant_instagram' ) ) != '') { ?>
					          <a href="<?php echo esc_url( get_theme_mod( 'lzrestaurant_instagram','' ) ); ?>"><i class="fab fa-instagram"></i><span class="screen-reader-text"><?php esc_html_e( 'Instagram','lzrestaurant' );?></span></a>
					        <?php } ?>
					        <?php if(esc_url( get_theme_mod( 'lzrestaurant_pinterest') ) != '') { ?>
					          <a href="<?php echo esc_url( get_theme_mod( 'lzrestaurant_pinterest','' ) ); ?>"><i class="fab fa-pinterest-p"></i><span class="screen-reader-text"><?php esc_html_e( 'Pinterest','lzrestaurant' );?></span></a>
					        <?php } ?>
					        <?php if(esc_url( get_theme_mod( 'lzrestaurant_tumblr' ) ) != '') { ?>
					          <a href="<?php echo esc_url( get_theme_mod( 'lzrestaurant_tumblr','' ) ); ?>"><i class="fab fa-tumblr"></i><span class="screen-reader-text"><?php esc_html_e( 'Tumblr','lzrestaurant' );?></span></a>
					        <?php } ?>
				      	</div>
					</div>
				</div>
			</div>
		</div>

	</header>
	
	<div class="site-content-contain">
		<div id="content" class="site-content">
