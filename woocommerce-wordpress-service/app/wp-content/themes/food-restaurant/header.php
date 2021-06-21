<?php
/**
 * Display Header.
 *
 * @package Food Restaurant
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } else {
        do_action( 'wp_body_open' );
    }?>
    <header role="banner">
        <a class="screen-reader-text skip-link" href="#main"><?php esc_html_e('Skip to content', 'food-restaurant' ); ?></a>
        <div class="<?php if( get_theme_mod( 'food_restaurant_sticky_header', false) != '') { ?> sticky-menubox"<?php } else { ?>close-sticky <?php } ?>">
            <div class="header">
                <div class="container">
                    <div class="row m-0">
                        <div class="col-lg-3 col-md-6 col-9 p-0">
                            <div class="logo">
                                <?php if ( has_custom_logo() ) : ?>
                                    <div class="site-logo"><?php the_custom_logo(); ?></div>
                                <?php endif; ?>
                                <?php if( get_theme_mod('food_restaurant_site_title_tagline',true) != ''){ ?>
                                    <?php $blog_info = get_bloginfo( 'name' ); ?>
                                    <?php if ( ! empty( $blog_info ) ) : ?>
                                        <?php if ( is_front_page() && is_home() ) : ?>
                                            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                        <?php else : ?>
                                            <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
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
                        <div class="col-lg-9 col-md-6 col-3 p-0">
                            <div class="menubox">
                                <?php 
                                    if(has_nav_menu('primary')){ ?>
                                    <div class="toggle-menu responsive-menu">
                                        <button role="tab" class="resToggle" onclick="food_restaurant_resmenu_open()"><i class="fas fa-bars"></i><span class="screen-reader-text"><?php esc_html_e('Open Menu','food-restaurant'); ?></span></button>
                                    </div>
                                <?php }?>
                                <div id="menu-sidebar" class="nav sidebar">
                                    <nav id="primary-site-navigation" class="primary-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'food-restaurant' ); ?>">
                                        <?php 
                                            if(has_nav_menu('primary')){ 
                                                wp_nav_menu( array( 
                                                'theme_location' => 'primary',
                                                'container_class' => 'main-menu-navigation clearfix' ,
                                                'menu_class' => 'clearfix',
                                                'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
                                                'fallback_cb' => 'wp_page_menu',
                                                ) ); 
                                            }
                                        ?>
                                        <a href="javascript:void(0)" class="closebtn responsive-menu" onclick="food_restaurant_resmenu_close()"><i class="fas fa-times"></i><span class="screen-reader-text"><?php esc_html_e('Close Menu','food-restaurant'); ?></span></a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>