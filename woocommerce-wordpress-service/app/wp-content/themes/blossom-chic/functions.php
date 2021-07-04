<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * After setup theme hook
 */
function blossom_chic_theme_setup(){
    /*
     * Make chile theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'blossom-chic', get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'blossom_chic_theme_setup' );

if ( !function_exists( 'blossom_chic_styles' ) ):
    function blossom_chic_styles() {
    	$my_theme = wp_get_theme();
    	$version = $my_theme['Version'];
        
        wp_enqueue_style( 'blossom-feminine-style', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'animate' ) );
        
        wp_enqueue_style( 'blossom-chic', get_stylesheet_directory_uri() . '/style.css', array( 'blossom-feminine-style' ), $version );
        
        wp_enqueue_script( 'blossom-chic', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), $version, true );
        
        $array = array( 
            'rtl'       => is_rtl(),
            'animation' => get_theme_mod( 'slider_animation' ),
            'auto' => (bool)get_theme_mod( 'slider_auto', true ),
        ); 
        wp_localize_script( 'blossom-chic', 'blossom_chic_data', $array );
    }
endif;
add_action( 'wp_enqueue_scripts', 'blossom_chic_styles', 10 );

//Remove a function from the parent theme
function remove_parent_filters(){ //Have to do it after theme setup, because child theme functions are loaded first
    remove_action( 'customize_register', 'blossom_feminine_customizer_theme_info' );
    remove_action( 'customize_register', 'blossom_feminine_customize_register_color' );
    remove_action( 'customize_register', 'blossom_feminine_customize_register_appearance' );

}
add_action( 'init', 'remove_parent_filters' );

function blossom_feminine_body_classes( $classes ) {
    global $wp_query;
    $blog_layout_option = get_theme_mod( 'blog_layout_option', 'home-two' );
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }
    
    if ( $wp_query->found_posts == 0 ) {
        $classes[] = 'no-post';
    }
    
    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image custom-background';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color custom-background';
    }
    
    if( is_search() && ! is_post_type_archive( 'product' ) ){
        $classes[] = 'search-result-page';   
    }
    
    $classes[] = blossom_feminine_sidebar_layout();
    
    if( $blog_layout_option == 'home-two' ){
        $classes[] = 'blog-layout-two';
    }

    return $classes;
}

function blossom_chic_customizer_register( $wp_customize ) {

    $wp_customize->add_section( 'theme_info', array(
        'title'       => __( 'Demo & Documentation' , 'blossom-chic' ),
        'priority'    => 6,
    ) );
    
    /** Important Links */
    $wp_customize->add_setting( 'theme_info_theme',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $theme_info = '<p>';
    $theme_info .= sprintf( __( 'Demo Link: %1$sClick here.%2$s', 'blossom-chic' ),  '<a href="' . esc_url( 'https://blossomthemes.com/theme-demo/?theme=blossom-chic' ) . '" target="_blank">', '</a>' );
    $theme_info .= '</p><p>';
    $theme_info .= sprintf( __( 'Documentation Link: %1$sClick here.%2$s', 'blossom-chic' ),  '<a href="' . esc_url( 'https://docs.blossomthemes.com/docs/blossom-chic/' ) . '" target="_blank">', '</a>' );
    $theme_info .= '</p>';

    $wp_customize->add_control( new Blossom_Feminine_Note_Control( $wp_customize,
        'theme_info_theme', 
            array(
                'section'     => 'theme_info',
                'description' => $theme_info
            )
        )
    );

    /** Appearance Settings */
    $wp_customize->add_panel( 
        'appearance_settings',
         array(
            'priority'    => 50,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Appearance Settings', 'blossom-chic' ),
            'description' => __( 'Customize Typography, Header Image & Background Image', 'blossom-chic' ),
        ) 
    );
    
    /** Typography */
    $wp_customize->add_section(
        'typography_settings',
        array(
            'title'    => __( 'Typography', 'blossom-chic' ),
            'priority' => 10,
            'panel'    => 'appearance_settings',
        )
    );
    
    /** Primary Font */
    $wp_customize->add_setting(
        'primary_font',
        array(
            'default'           => 'Nunito Sans',
            'sanitize_callback' => 'blossom_feminine_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Feminine_Select_Control(
            $wp_customize,
            'primary_font',
            array(
                'label'       => __( 'Primary Font', 'blossom-chic' ),
                'description' => __( 'Primary font of the site.', 'blossom-chic' ),
                'section'     => 'typography_settings',
                'choices'     => blossom_feminine_get_all_fonts(),  
            )
        )
    );
    
    /** Secondary Font */
    $wp_customize->add_setting(
        'secondary_font',
        array(
            'default'           => 'Cormorant',
            'sanitize_callback' => 'blossom_feminine_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Feminine_Select_Control(
            $wp_customize,
            'secondary_font',
            array(
                'label'       => __( 'Secondary Font', 'blossom-chic' ),
                'description' => __( 'Secondary font of the site.', 'blossom-chic' ),
                'section'     => 'typography_settings',
                'choices'     => blossom_feminine_get_all_fonts(),  
            )
        )
    );
    
    /** Font Size*/
    $wp_customize->add_setting( 
        'font_size', 
        array(
            'default'           => 16,
            'sanitize_callback' => 'blossom_feminine_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Feminine_Slider_Control( 
            $wp_customize,
            'font_size',
            array(
                'section'     => 'typography_settings',
                'label'       => __( 'Font Size', 'blossom-chic' ),
                'description' => __( 'Change the font size of your site.', 'blossom-chic' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 50,
                    'step'  => 1,
                )                 
            )
        )
    );
    
    /** Move Header Image section to appearance panel */
    $wp_customize->get_section( 'header_image' )->panel    = 'appearance_settings';
    $wp_customize->get_section( 'header_image' )->priority = 20;
    $wp_customize->remove_control( 'header_textcolor' );
    
    /** Move Background Image section to appearance panel */
    $wp_customize->get_section( 'background_image' )->panel    = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->priority = 30;

    /** Primary Color*/
    $wp_customize->add_setting( 
        'primary_color', array(
            'default'           => '#f69581',
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            'primary_color', 
            array(
                'label'       => __( 'Primary Color', 'blossom-chic' ),
                'description' => __( 'Primary color of the theme.', 'blossom-chic' ),
                'section'     => 'colors',
                'priority'    => 5,                
            )
        )
    );
    
    /** Secondary Color*/
    $wp_customize->add_setting( 
        'secondary_color', array(
            'default'           => '#feeae3',
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            'secondary_color', 
            array(
                'label'       => __( 'Secondary Color', 'blossom-chic' ),
                'description' => __( 'Secondary color of the theme.', 'blossom-chic' ),
                'section'     => 'colors',
                'priority'    => 5,                
            )
        )
    );

    /** Layout Settings */
    $wp_customize->add_panel(
        'layout_settings',
        array(
            'title'    => __( 'Layout Settings', 'blossom-chic' ),
            'priority' => 55,
        )
    );

    /** Blog Layout */
    $wp_customize->add_section(
        'header_layout',
        array(
            'title'    => __( 'Header Layout', 'blossom-chic' ),
            'panel'    => 'layout_settings',
            'priority' => 10,
        )
    );
    
    /** Blog Page layout */
    $wp_customize->add_setting( 
        'header_layout_option', 
        array(
            'default'           => 'two',
            'sanitize_callback' => 'esc_attr'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Feminine_Radio_Image_Control(
            $wp_customize,
            'header_layout_option',
            array(
                'section'     => 'header_layout',
                'label'       => __( 'Header Layout', 'blossom-chic' ),
                'description' => __( 'This is the layout for header.', 'blossom-chic' ),
                'choices'     => array(                 
                    'one'   => get_stylesheet_directory_uri() . '/images/header/header-one.png',
                    'two'   => get_stylesheet_directory_uri() . '/images/header/header-two.png',
                )
            )
        )
    );
    
    /** Blog Layout */
    $wp_customize->add_section(
        'blog_layout',
        array(
            'title'    => __( 'Home Page Layout', 'blossom-chic' ),
            'panel'    => 'layout_settings',
            'priority' => 10,
        )
    );
    
    /** Blog Page layout */
    $wp_customize->add_setting( 
        'blog_layout_option', 
        array(
            'default'           => 'home-two',
            'sanitize_callback' => 'esc_attr'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Feminine_Radio_Image_Control(
            $wp_customize,
            'blog_layout_option',
            array(
                'section'     => 'blog_layout',
                'label'       => __( 'Home Page Layout', 'blossom-chic' ),
                'description' => __( 'This is the layout for blog index page.', 'blossom-chic' ),
                'choices'     => array(                 
                    'home-one'   => get_stylesheet_directory_uri() . '/images/home/one-right.jpg',
                    'home-two'   => get_stylesheet_directory_uri() . '/images/home/two-right.jpg',
                )
            )
        )
    );

    /** Slider Layout Settings */
    $wp_customize->add_section(
        'slider_layout_settings',
        array(
            'title'    => __( 'Slider Layout', 'blossom-chic' ),
            'priority' => 20,
            'panel'    => 'layout_settings',
        )
    );
    
    /** Page Sidebar layout */
    $wp_customize->add_setting( 
        'slider_layout', 
        array(
            'default'           => 'two',
            'sanitize_callback' => 'esc_attr'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Feminine_Radio_Image_Control(
            $wp_customize,
            'slider_layout',
            array(
                'section'     => 'slider_layout_settings',
                'label'       => __( 'Slider Layout', 'blossom-chic' ),
                'description' => __( 'Choose the layout of the slider for your site.', 'blossom-chic' ),
                'choices'     => array(
                    'one'   => get_stylesheet_directory_uri() . '/images/slider/one.jpg',
                    'two'   => get_stylesheet_directory_uri() . '/images/slider/two.jpg',
                )
            )
        )
    );
    
}
add_action( 'customize_register', 'blossom_chic_customizer_register', 40 );

function blossom_feminine_categories() {
    $ed_cat_single = get_theme_mod( 'ed_category', false );
    // Hide category and tag text for pages.
    if ( 'post' === get_post_type() && !$ed_cat_single ) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( ' ' );
        if ( $categories_list ) {
            echo '<span class="cat-links" itemprop="about">' . $categories_list . '</span>';
        }
    }       
}

function blossom_feminine_header(){ 
    $bg = get_header_image() ? ' style="background-image:url(' . esc_url( get_header_image() ) . ')"' : '';
    $header_layout = get_theme_mod( 'header_layout_option', 'two' ); ?>
    <header id="masthead" class="site-header wow fadeIn header-layout-<?php echo esc_attr( $header_layout ); ?>" data-wow-delay="0.1s" itemscope itemtype="http://schema.org/WPHeader">
        <?php if( $header_layout == 'one' ) : ?>
            <div class="header-t">
                <div class="container">                    
                    <?php if( has_nav_menu('secondary') ) { ?>
                        <button aria-label="<?php esc_attr_e( 'secondary menu toggle button', 'blossom-chic' ); ?>" id="secondary-toggle-button" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle"><i class="fa fa-bars"></i></button>  
                    <?php } ?>           
                    <nav id="secondary-navigation" class="secondary-nav" itemscope itemtype="http://schema.org/SiteNavigationElement">
                        <div class="secondary-menu-list menu-modal cover-modal" data-modal-target-string=".menu-modal">
                            <button class="close close-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".menu-modal">
                                <span class="toggle-bar"></span>
                                <span class="toggle-bar"></span>
                            </button>
                            <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'blossom-chic' ); ?>">
                                <?php
                                    wp_nav_menu( array(
                                        'theme_location' => 'secondary',
                                        'menu_id'        => 'secondary-menu',
                                        'menu_class'     => 'menu-modal',
                                        'fallback_cb'    => 'blossom_feminine_secondary_menu_fallback',
                                    ) );
                                ?>
                            </div>
                        </div>
                    
                    </nav><!-- #secondary-navigation -->                   
                    <div class="right">
                        <div class="tools">
                            <div class="form-section">
							<button aria-label="<?php esc_attr_e( 'search toggle button', 'blossom-chic' ); ?>" id="btn-search" class="search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                                <i class="fas fa-search"></i>
                            </button>
							<div class="form-holder search-modal cover-modal" data-modal-target-string=".search-modal">
								<div class="form-holder-inner">
                                    <?php get_search_form(); ?>                        
                                </div>
							</div>
						</div>
                            <?php if( blossom_feminine_is_woocommerce_activated() ) blossom_feminine_wc_cart_count(); ?>                    
                        </div>                        
                        <?php blossom_feminine_social_links(); ?>                        
                    </div>                    
                </div>
            </div><!-- .header-t -->
        <?php endif; ?>
        <div class="header-m<?php if( $header_layout == 'one' ) echo " site-branding"; ?>" <?php echo $bg; ?>>
            <div class="container" itemscope itemtype="http://schema.org/Organization">
                <?php 
                if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                    the_custom_logo();
                } 
                if( is_front_page() ){ ?>
                    <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php 
                }else{ ?>
                    <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                <?php
                }
                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ){ ?>
                    <p class="site-description" itemprop="description"><?php echo $description; ?></p>
                <?php

                }
                ?>
            </div>
        </div><!-- .header-m -->
        
        <div class="header-b">
            <div class="container">
                <button aria-label="<?php esc_attr_e( 'primary menu toggle button', 'blossom-chic' ); ?>" id="primary-toggle-button" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle"><i class="fa fa-bars"></i><?php esc_html_e( 'Navigation', 'blossom-chic' ); ?></button>
                <nav id="site-navigation" class="main-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
                    <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
                        <button class="close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal"><i class="fa fa-times"></i><?php esc_html_e( 'Close', 'blossom-chic' ); ?></button>
                        <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'blossom-chic' ); ?>">
                            <?php
                                wp_nav_menu( array(
                                    'theme_location' => 'primary',
                                    'menu_id'        => 'primary-menu',
                                    'menu_class'     => 'main-menu-modal',
                                    'fallback_cb'    => 'blossom_feminine_primary_menu_fallback',
                                ) );
                            ?>
                        </div>
                    </div>
                </nav><!-- #site-navigation --> 
                <?php if( $header_layout == 'two' ) : ?>
                <div class="right">
                    <div class="tools">
                        <div class="form-section">
							<button aria-label="<?php esc_attr_e( 'search toggle button', 'blossom-chic' ); ?>" id="btn-search" class="search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                                <i class="fas fa-search"></i>
                            </button>
							<div class="form-holder search-modal cover-modal" data-modal-target-string=".search-modal">
								<div class="form-holder-inner">
                                    <?php get_search_form(); ?>                        
                                </div>
							</div>
						</div>
                        <?php if( blossom_feminine_is_woocommerce_activated() ) blossom_feminine_wc_cart_count(); ?>                    
                    </div>                        
                    <?php blossom_feminine_social_links(); ?>                        
                </div>
                <?php endif; ?>
            </div>
        </div><!-- .header-b -->
        
    </header><!-- #masthead -->
    <?php
}

function blossom_feminine_banner(){
    
    $ed_slider = get_theme_mod( 'ed_slider', true );
    $slider_layout  = get_theme_mod( 'slider_layout', 'two' );

    if( ( is_front_page() || is_home() ) && $ed_slider ){ 
        $slider_type    = get_theme_mod( 'slider_type', 'latest_posts' );
        $slider_cat     = get_theme_mod( 'slider_cat' );
        $posts_per_page = get_theme_mod( 'no_of_slides', 3 );
    
        $args = array(
            'post_type'           => 'post',
            'post_status'         => 'publish',            
            'ignore_sticky_posts' => true
        );
        
        if( $slider_type === 'cat' && $slider_cat ){
            $args['cat']            = $slider_cat; 
            $args['posts_per_page'] = -1;  
        }else{
            $args['posts_per_page'] = $posts_per_page;
        }
                
        $qry = new WP_Query( $args );
        
        if( $qry->have_posts() ){ ?>
            <div class="banner banner-layout-<?php echo esc_attr( $slider_layout ); ?>" data-wow-delay="0.1s">
                <div id="banner-slider" class="owl-carousel slider-layout-<?php echo esc_attr( $slider_layout ); ?>">
                    <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                    <div class="item">
                        <?php 
                        if( has_post_thumbnail() ){
                            the_post_thumbnail( 'blossom-feminine-slider' );    
                        }else{ 
                            blossom_feminine_get_fallback_svg( 'blossom-feminine-slider' );
                        }
                        ?>                    
                        <div class="banner-text">
                            <?php
                                blossom_feminine_categories();
                                the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
                            ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        <?php
        wp_reset_postdata();
        }
    
    }
}

function blossom_feminine_fonts_url(){
    $fonts_url = '';
    
    $primary_font       = get_theme_mod( 'primary_font', 'Nunito Sans' );
    $ig_primary_font    = blossom_feminine_is_google_font( $primary_font );    
    $secondary_font     = get_theme_mod( 'secondary_font', 'Cormorant' );
    $ig_secondary_font  = blossom_feminine_is_google_font( $secondary_font );    
    $site_title_font    = get_theme_mod( 'site_title_font', array( 'font-family'=>'Playfair Display', 'variant'=>'700italic' ) );
    $ig_site_title_font = blossom_feminine_is_google_font( $site_title_font['font-family'] );
        
    /* Translators: If there are characters in your language that are not
    * supported by respective fonts, translate this to 'off'. Do not translate
    * into your own language.
    */
    $primary    = _x( 'on', 'Primary Font: on or off', 'blossom-chic' );
    $secondary  = _x( 'on', 'Secondary Font: on or off', 'blossom-chic' );
    $site_title = _x( 'on', 'Site Title Font: on or off', 'blossom-chic' );
    
    
    if ( 'off' !== $primary || 'off' !== $secondary || 'off' !== $site_title ) {
        
        $font_families = array();
     
        if ( 'off' !== $primary && $ig_primary_font ) {
            $primary_variant = blossom_feminine_check_varient( $primary_font, 'regular', true );
            if( $primary_variant ){
                $primary_var = ':' . $primary_variant;
            }else{
                $primary_var = '';    
            }            
            $font_families[] = $primary_font . $primary_var;
        }
         
        if ( 'off' !== $secondary && $ig_secondary_font ) {
            $secondary_variant = blossom_feminine_check_varient( $secondary_font, 'regular', true );
            if( $secondary_variant ){
                $secondary_var = ':' . $secondary_variant;    
            }else{
                $secondary_var = '';
            }
            $font_families[] = $secondary_font . $secondary_var;
        }
        
        if ( 'off' !== $site_title && $ig_site_title_font ) {
            
            if( ! empty( $site_title_font['variant'] ) ){
                $site_title_var = ':' . blossom_feminine_check_varient( $site_title_font['font-family'], $site_title_font['variant'] );    
            }else{
                $site_title_var = '';
            }
            $font_families[] = $site_title_font['font-family'] . $site_title_var;
        }
        
        $font_families = array_diff( array_unique( $font_families ), array('') );
        
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),            
        );
        
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
     
    return esc_url_raw( $fonts_url );
}

function blossom_feminine_dynamic_css(){
    
    $primary_font    = get_theme_mod( 'primary_font', 'Nunito Sans' );
    $primary_fonts   = blossom_feminine_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Cormorant' );
    $secondary_fonts = blossom_feminine_get_fonts( $secondary_font, 'regular' );
    $font_size       = get_theme_mod( 'font_size', 16 );
    
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'Playfair Display', 'variant'=>'700italic' ) );
    $site_title_fonts     = blossom_feminine_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    $site_title_font_size = get_theme_mod( 'site_title_font_size', 60 );
    
    $primary_color = get_theme_mod( 'primary_color', '#f69581' );
    $secondary_color = get_theme_mod( 'secondary_color', '#feeae3' );
    
    $rgb = blossom_feminine_hex2rgb( blossom_feminine_sanitize_hex_color( $primary_color ) );
     
    echo "<style type='text/css' media='all'>"; ?>
     
    .content-newsletter .blossomthemes-email-newsletter-wrapper.bg-img:after,
    .widget_blossomthemes_email_newsletter_widget .blossomthemes-email-newsletter-wrapper:after{
        <?php echo 'background: rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.8);'; ?>
    }
    
    /* primary color */
    a{
        color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
    }
    
    a:hover,
    a:focus{
        color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
    }

    .secondary-nav ul li a:hover,
    .secondary-nav ul li a:focus,
    .secondary-nav ul li:hover > a,
    .secondary-nav ul li:focus > a,
    .secondary-nav .current_page_item > a,
    .secondary-nav .current-menu-item > a,
    .secondary-nav .current_page_ancestor > a,
    .secondary-nav .current-menu-ancestor > a,
    .header-t .social-networks li a:hover,
    .header-t .social-networks li a:focus,
    .main-navigation ul li a:hover,
    .main-navigation ul li a:focus,
    .main-navigation ul li:hover > a,
    .main-navigation ul li:focus > a,
    .main-navigation .current_page_item > a,
    .main-navigation .current-menu-item > a,
    .main-navigation .current_page_ancestor > a,
    .main-navigation .current-menu-ancestor > a,
    .banner .banner-text .cat-links a:hover,
    .banner .banner-text .cat-links a:focus,
    .banner .banner-text .title a:hover,
    .banner .banner-text .title a:focus,
    #primary .post .text-holder .entry-header .entry-title a:hover,
    #primary .post .text-holder .entry-header .entry-title a:focus,
    .widget ul li a:hover,
    .widget ul li a:focus,
    .site-footer .widget ul li a:hover,
    .site-footer .widget ul li a:focus,
    #crumbs a:hover,
    #crumbs a:focus,
    .related-post .post .text-holder .cat-links a:hover,
    .related-post .post .text-holder .cat-links a:focus,
    .related-post .post .text-holder .entry-title a:hover,
    .related-post .post .text-holder .entry-title a:focus,
    .comments-area .comment-body .comment-metadata a:hover,
    .comments-area .comment-body .comment-metadata a:focus,
    .search #primary .search-post .text-holder .entry-header .entry-title a:hover,
    .search #primary .search-post .text-holder .entry-header .entry-title a:focus,
    .site-title a:hover,
    .site-title a:focus,
    .widget_bttk_popular_post ul li .entry-header .entry-meta a:hover,
    .widget_bttk_popular_post ul li .entry-header .entry-meta a:focus,
    .widget_bttk_pro_recent_post ul li .entry-header .entry-meta a:hover,
    .widget_bttk_pro_recent_post ul li .entry-header .entry-meta a:focus,
    .widget_bttk_posts_category_slider_widget .carousel-title .title a:hover,
    .widget_bttk_posts_category_slider_widget .carousel-title .title a:focus,
    .site-footer .widget_bttk_posts_category_slider_widget .carousel-title .title a:hover,
    .site-footer .widget_bttk_posts_category_slider_widget .carousel-title .title a:focus,
    .portfolio-sorting .button:hover,
    .portfolio-sorting .button:focus,
    .portfolio-sorting .button.is-checked,
    .portfolio-item .portfolio-img-title a:hover,
    .portfolio-item .portfolio-img-title a:focus,
    .portfolio-item .portfolio-cat a:hover,
    .portfolio-item .portfolio-cat a:focus,
    .entry-header .portfolio-cat a:hover,
    .entry-header .portfolio-cat a:focus,
    .header-layout-two .header-b .social-networks li a:hover, 
    .header-layout-two .header-b .social-networks li a:focus,
    #primary .post .text-holder .entry-header .entry-meta a:hover{
        color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
    }

    <!-- .pagination a{
        border-color: <?php //echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
    } -->

    #primary .post .text-holder .entry-footer .btn-readmore:hover,
    #primary .post .text-holder .entry-footer .btn-readmore:focus,
    .pagination a:hover,
    .pagination a:focus,
    .widget_calendar caption,
    .widget_calendar table tbody td a,
    .widget_tag_cloud .tagcloud a:hover,
    .widget_tag_cloud .tagcloud a:focus,
    #blossom-top,
    .single #primary .post .entry-footer .tags a:hover,
    .single #primary .post .entry-footer .tags a:focus,
    .error-holder .page-content a:hover,
    .error-holder .page-content a:focus,
    .widget_bttk_author_bio .readmore:hover,
    .widget_bttk_author_bio .readmore:focus,
    .widget_bttk_social_links ul li a:hover,
    .widget_bttk_social_links ul li a:focus,
    .widget_bttk_image_text_widget ul li .btn-readmore:hover,
    .widget_bttk_image_text_widget ul li .btn-readmore:focus,
    .widget_bttk_custom_categories ul li a:hover .post-count,
    .widget_bttk_custom_categories ul li a:hover:focus .post-count,
    .content-instagram ul li .instagram-meta .like,
    .content-instagram ul li .instagram-meta .comment,
    #secondary .widget_blossomtheme_featured_page_widget .text-holder .btn-readmore:hover,
    #secondary .widget_blossomtheme_featured_page_widget .text-holder .btn-readmore:focus,
    #secondary .widget_blossomtheme_companion_cta_widget .btn-cta:hover,
    #secondary .widget_blossomtheme_companion_cta_widget .btn-cta:focus,
    #secondary .widget_bttk_icon_text_widget .text-holder .btn-readmore:hover,
    #secondary .widget_bttk_icon_text_widget .text-holder .btn-readmore:focus,
    .site-footer .widget_blossomtheme_companion_cta_widget .btn-cta:hover,
    .site-footer .widget_blossomtheme_companion_cta_widget .btn-cta:focus,
    .site-footer .widget_blossomtheme_featured_page_widget .text-holder .btn-readmore:hover,
    .site-footer .widget_blossomtheme_featured_page_widget .text-holder .btn-readmore:focus,
    .site-footer .widget_bttk_icon_text_widget .text-holder .btn-readmore:hover,
    .site-footer .widget_bttk_icon_text_widget .text-holder .btn-readmore:focus,
    .header-layout-two .header-b .tools .cart .count,
    #primary .post .text-holder .entry-header .cat-links a:hover,
    .widget_bttk_popular_post .style-two li .entry-header .cat-links a:hover, 
    .widget_bttk_pro_recent_post .style-two li .entry-header .cat-links a:hover, 
    .widget_bttk_popular_post .style-three li .entry-header .cat-links a:hover,
    .widget_bttk_pro_recent_post .style-three li .entry-header .cat-links a:hover, .widget_bttk_posts_category_slider_widget .carousel-title .cat-links a:hover,
    .widget_bttk_posts_category_slider_widget .owl-theme .owl-prev:hover, .widget_bttk_posts_category_slider_widget .owl-theme .owl-prev:focus, .widget_bttk_posts_category_slider_widget .owl-theme .owl-next:hover, .widget_bttk_posts_category_slider_widget .owl-theme .owl-next:focus,
    .banner .owl-nav .owl-prev:hover, 
    .banner .owl-nav .owl-next:hover,
    .banner .banner-text .cat-links a:hover,
    button:hover, input[type="button"]:hover, 
    input[type="reset"]:hover, input[type="submit"]:hover, 
    button:focus, input[type="button"]:focus, 
    input[type="reset"]:focus, 
    input[type="submit"]:focus,
    .category-section .col .img-holder:hover .text-holder span,
    #primary .post .entry-content .highlight,
    #primary .page .entry-content .highlight, 
    .widget_bttk_posts_category_slider_widget .owl-theme .owl-nav [class*="owl-"]:hover{
        background: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
    }

    #secondary .profile-link.customize-unpreviewable {
        background-color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
    }

    .pagination .current,
    .post-navigation .nav-links .nav-previous a:hover,
    .post-navigation .nav-links .nav-next a:hover,
    .post-navigation .nav-links .nav-previous a:focus,
    .post-navigation .nav-links .nav-next a:focus,
    .content-newsletter .blossomthemes-email-newsletter-wrapper form input[type="submit"]:hover, .content-newsletter .blossomthemes-email-newsletter-wrapper form input[type="submit"]:focus{
        background: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
        border-color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
    }
    .content-newsletter .blossomthemes-email-newsletter-wrapper form input[type="submit"]:hover, .content-newsletter .blossomthemes-email-newsletter-wrapper form input[type="submit"]:focus{
        color: #fff;
    }

    #primary .post .entry-content blockquote,
    #primary .page .entry-content blockquote{
        border-bottom-color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
        border-top-color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
    }

    #primary .post .entry-content .pull-left,
    #primary .page .entry-content .pull-left,
    #primary .post .entry-content .pull-right,
    #primary .page .entry-content .pull-right{border-left-color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;}

    .error-holder .page-content h2{
        text-shadow: 6px 6px 0 <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
    }

    .category-section .col .img-holder:hover .text-holder,
    .pagination a:hover, 
    .pagination a:focus{
        border-color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
    }

    .banner-text .cat-links a, 
    .category-section .col .img-holder .text-holder span, 
    #primary .post .text-holder .entry-header .cat-links a, 
    .pagination .current, 
    .widget_bttk_popular_post .style-two li .entry-header .cat-links a, 
    .widget_bttk_pro_recent_post .style-two li .entry-header .cat-links a, 
    .widget_bttk_popular_post .style-three li .entry-header .cat-links a, 
    .widget_bttk_pro_recent_post .style-three li .entry-header .cat-links a, 
    .widget_bttk_posts_category_slider_widget .carousel-title .cat-links a, 
    .content-newsletter .blossomthemes-email-newsletter-wrapper form input[type="submit"]:hover, 
    .content-newsletter .blossomthemes-email-newsletter-wrapper form input[type="submit"]:focus {
        background-color: <?php echo blossom_feminine_sanitize_hex_color( $secondary_color ); ?>;
    }

    .widget .widget-title {
        background: <?php echo blossom_feminine_sanitize_hex_color( $secondary_color ); ?>;
    }

    .category-section .col .img-holder .text-holder, 
    .pagination .current, 
    .pagination a, 
    .content-newsletter .blossomthemes-email-newsletter-wrapper form input[type="submit"]:hover, 
    .content-newsletter .blossomthemes-email-newsletter-wrapper form input[type="submit"]:focus {
        border-color: <?php echo blossom_feminine_sanitize_hex_color( $secondary_color ); ?>;;
    }
    
    body,
    button,
    input,
    select,
    optgroup,
    textarea{
        font-family : <?php echo esc_html( $primary_fonts['font'] ); ?>;
        font-size   : <?php echo absint( $font_size ); ?>px;
    }

    .widget_bttk_pro_recent_post ul li .entry-header .entry-title,
    .widget_bttk_posts_category_slider_widget .carousel-title .title,
    .content-newsletter .blossomthemes-email-newsletter-wrapper .text-holder h3,
    .widget_blossomthemes_email_newsletter_widget .blossomthemes-email-newsletter-wrapper .text-holder h3,
    #secondary .widget_bttk_testimonial_widget .text-holder .name,
    #secondary .widget_bttk_description_widget .text-holder .name,
    .site-footer .widget_bttk_description_widget .text-holder .name,
    .site-footer .widget_bttk_testimonial_widget .text-holder .name, 
    .widget_bttk_popular_post ul li .entry-header .entry-title, 
    .widget_bttk_author_bio .title-holder {
        font-family : <?php echo $primary_fonts['font']; ?>;
    }

    .banner .banner-text .title,
    #primary .sticky .text-holder .entry-header .entry-title,
    #primary .post .text-holder .entry-header .entry-title,
    .author-section .text-holder .title,
    .post-navigation .nav-links .nav-previous .post-title,
    .post-navigation .nav-links .nav-next .post-title,
    .related-post .post .text-holder .entry-title,
    .comments-area .comments-title,
    .comments-area .comment-body .fn,
    .comments-area .comment-reply-title,
    .page-header .page-title,
    #primary .post .entry-content blockquote,
    #primary .page .entry-content blockquote,
    #primary .post .entry-content .pull-left,
    #primary .page .entry-content .pull-left,
    #primary .post .entry-content .pull-right,
    #primary .page .entry-content .pull-right,
    #primary .post .entry-content h1,
    #primary .page .entry-content h1,
    #primary .post .entry-content h2,
    #primary .page .entry-content h2,
    #primary .post .entry-content h3,
    #primary .page .entry-content h3,
    #primary .post .entry-content h4,
    #primary .page .entry-content h4,
    #primary .post .entry-content h5,
    #primary .page .entry-content h5,
    #primary .post .entry-content h6,
    #primary .page .entry-content h6,
    .search #primary .search-post .text-holder .entry-header .entry-title,
    .error-holder .page-content h2,
    .portfolio-text-holder .portfolio-img-title,
    .portfolio-holder .entry-header .entry-title,
    .single-blossom-portfolio .post-navigation .nav-previous a,
    .single-blossom-portfolio .post-navigation .nav-next a,
    .related-portfolio-title{
        font-family: <?php echo esc_html( $secondary_fonts['font'] ); ?>;
    }

    .site-title{
        font-size   : <?php echo absint( $site_title_font_size ); ?>px;
        font-family : <?php echo esc_html( $site_title_fonts['font'] ); ?>;
        font-weight : <?php echo esc_attr( $site_title_fonts['weight'] ); ?>;
        font-style  : <?php echo esc_attr( $site_title_fonts['style'] ); ?>;
    }
    
    <?php if( blossom_feminine_is_woocommerce_activated() ) { ?>
        .woocommerce ul.products li.product .add_to_cart_button:hover,
        .woocommerce ul.products li.product .add_to_cart_button:focus,
        .woocommerce ul.products li.product .product_type_external:hover,
        .woocommerce ul.products li.product .product_type_external:focus,
        .woocommerce nav.woocommerce-pagination ul li a:hover,
        .woocommerce nav.woocommerce-pagination ul li a:focus,
        .woocommerce #secondary .widget_shopping_cart .buttons .button:hover,
        .woocommerce #secondary .widget_shopping_cart .buttons .button:focus,
        .woocommerce #secondary .widget_price_filter .price_slider_amount .button:hover,
        .woocommerce #secondary .widget_price_filter .price_slider_amount .button:focus,
        .woocommerce #secondary .widget_price_filter .ui-slider .ui-slider-range,
        .woocommerce div.product form.cart .single_add_to_cart_button:hover,
        .woocommerce div.product form.cart .single_add_to_cart_button:focus,
        .woocommerce div.product .cart .single_add_to_cart_button.alt:hover,
        .woocommerce div.product .cart .single_add_to_cart_button.alt:focus,
        .woocommerce .woocommerce-message .button:hover,
        .woocommerce .woocommerce-message .button:focus,
        .woocommerce-cart #primary .page .entry-content .cart_totals .checkout-button:hover,
        .woocommerce-cart #primary .page .entry-content .cart_totals .checkout-button:focus,
        .woocommerce-checkout .woocommerce .woocommerce-info{
            background: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
        }

        .woocommerce nav.woocommerce-pagination ul li a{
            border-color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
        }  

        .woocommerce nav.woocommerce-pagination ul li span.current{
            background: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
            border-color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
        }

        .woocommerce div.product .entry-summary .product_meta .posted_in a:hover,
        .woocommerce div.product .entry-summary .product_meta .posted_in a:focus,
        .woocommerce div.product .entry-summary .product_meta .tagged_as a:hover,
        .woocommerce div.product .entry-summary .product_meta .tagged_as a:focus{
            color: <?php echo blossom_feminine_sanitize_hex_color( $primary_color ); ?>;
        }
            
    <?php } ?>
           
    <?php echo "</style>";
}

function blossom_feminine_footer_bottom(){ ?>
    <div class="site-info">
        <div class="container">
            <?php
                blossom_feminine_get_footer_copyright();
                
                esc_html_e( ' Blossom Chic | Developed By ', 'blossom-chic' );
                echo '<a href="' . esc_url( 'https://blossomthemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Blossom Themes', 'blossom-chic' ) . '</a>.';
                
                printf( esc_html__( ' Powered by %s', 'blossom-chic' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'blossom-chic' ) ) .'" target="_blank">WordPress</a>.' );
                if ( function_exists( 'the_privacy_policy_link' ) ) {
                    the_privacy_policy_link();
                }
            ?>                    
        </div>
    </div>
    <?php
}