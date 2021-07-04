<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * After setup theme hook
 */
function yummy_recipe_theme_setup(){
    /*
     * Make child theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'yummy-recipe', get_stylesheet_directory() . '/languages' );
    
    add_image_size( 'yummy-recipe-slider', 730, 600, true );
    add_image_size( 'yummy-recipe-blog-three', 420, 502, true );
    add_image_size( 'yummy-recipe-blog-four', 573, 685, true );
}
add_action( 'after_setup_theme', 'yummy_recipe_theme_setup' );

function yummy_recipe_styles() {
    $my_theme = wp_get_theme();
	$version = $my_theme['Version'];

    if( vilva_is_woocommerce_activated() ){
        $dependencies = array( 'vilva-woocommerce', 'owl-carousel', 'vilva-google-fonts' );  
    }else{
        $dependencies = array( 'owl-carousel', 'vilva-google-fonts' );
    }

    wp_enqueue_style( 'yummy-recipe-parent-style', get_template_directory_uri() . '/style.css', $dependencies );

	wp_enqueue_script( 'yummy-recipe', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery', 'owl-carousel' ), $version, true );
    
    $array = array( 
        'rtl'           => is_rtl(),
        'auto'          => (bool)get_theme_mod( 'slider_auto', true ),
        'loop'          => (bool)get_theme_mod( 'slider_loop', true ),
    ); 
    wp_localize_script( 'yummy-recipe', 'yummy_recipe_data', $array );
    
}
add_action( 'wp_enqueue_scripts', 'yummy_recipe_styles', 10 );

//Remove a function from the parent theme
function yummy_recipe_remove_parent_filters(){ //Have to do it after theme setup, because child theme functions are loaded first
    remove_action( 'tgmpa_register', 'vilva_register_required_plugins' );
    remove_action( 'customize_register', 'vilva_customizer_theme_info' );
    remove_action( 'customize_register', 'vilva_customize_register_appearance' );
    remove_action( 'wp_head', 'vilva_dynamic_css', 99 );
}
add_action( 'init', 'yummy_recipe_remove_parent_filters' );

function yummy_recipe_customize_register( $wp_customize ) {
    
    $wp_customize->add_section( 'theme_info', array(
        'title'       => __( 'Demo & Documentation' , 'yummy-recipe' ),
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
    $theme_info .= sprintf( __( 'Demo Link: %1$sClick here.%2$s', 'yummy-recipe' ),  '<a href="' . esc_url( 'https://blossomthemes.com/theme-demo/?theme=yummy-recipe' ) . '" target="_blank">', '</a>' ); 
    $theme_info .= '</p><p>';
    $theme_info .= sprintf( __( 'Documentation Link: %1$sClick here.%2$s', 'yummy-recipe' ),  '<a href="' . esc_url( 'https://docs.blossomthemes.com/yummy-recipe/' ) . '" target="_blank">', '</a>' ); 
    $theme_info .= '</p>';

    $wp_customize->add_control( new Vilva_Note_Control( $wp_customize,
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
            'title'       => __( 'Appearance Settings', 'yummy-recipe' ),
            'description' => __( 'Customize Typography, Header Image & Background Image', 'yummy-recipe' ),
        ) 
    );

     /** Primary Color*/
    $wp_customize->add_setting( 
        'primary_color', 
        array(
            'default'           => '#80b784',
            'sanitize_callback' => 'sanitize_hex_color',
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            'primary_color', 
            array(
                'label'       => __( 'Primary Color', 'yummy-recipe' ),
                'description' => __( 'Primary color of the theme.', 'yummy-recipe' ),
                'section'     => 'colors',
                'priority'    => 5,
            )
        )
    );

    /** Typography Settings */
    $wp_customize->add_section(
        'typography_settings',
        array(
            'title'    => __( 'Typography Settings', 'yummy-recipe' ),
            'priority' => 20,
            'panel'    => 'appearance_settings'
        )
    );
    
    /** Primary Font */
    $wp_customize->add_setting(
        'primary_font',
        array(
            'default'           => 'Bitter',
            'sanitize_callback' => 'vilva_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Vilva_Select_Control(
            $wp_customize,
            'primary_font',
            array(
                'label'       => __( 'Primary Font', 'yummy-recipe' ),
                'description' => __( 'Primary font of the site.', 'yummy-recipe' ),
                'section'     => 'typography_settings',
                'choices'     => vilva_get_all_fonts(),   
            )
        )
    );
    
    /** Secondary Font */
    $wp_customize->add_setting(
        'secondary_font',
        array(
            'default'           => 'Playfair Display',
            'sanitize_callback' => 'vilva_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Vilva_Select_Control(
            $wp_customize,
            'secondary_font',
            array(
                'label'       => __( 'Secondary Font', 'yummy-recipe' ),
                'description' => __( 'Secondary font of the site.', 'yummy-recipe' ),
                'section'     => 'typography_settings',
                'choices'     => vilva_get_all_fonts(),   
            )
        )
    );  

    /** Font Size*/
    $wp_customize->add_setting( 
        'font_size', 
        array(
            'default'           => 17,
            'sanitize_callback' => 'vilva_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Vilva_Slider_Control( 
            $wp_customize,
            'font_size',
            array(
                'section'     => 'typography_settings',
                'label'       => __( 'Font Size', 'yummy-recipe' ),
                'description' => __( 'Change the font size of your site.', 'yummy-recipe' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 50,
                    'step'  => 1,
                )                 
            )
        )
    );

    /** Move Background Image section to appearance panel */
    $wp_customize->get_section( 'colors' )->panel              = 'appearance_settings';
    $wp_customize->get_section( 'colors' )->priority           = 10;
    $wp_customize->get_section( 'background_image' )->panel    = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->priority = 15;

    $wp_customize->add_panel(
        'layout_settings',
        array(
            'priority'    => 45,
            'capability'  => 'edit_theme_options',
            'title'    => __( 'Layout Settings', 'yummy-recipe' ),
        )
    );

    /** Header Layout */
    $wp_customize->add_section(
        'header_layout',
        array(
            'title'    => __( 'Header Layout', 'yummy-recipe' ),
            'panel'    => 'layout_settings',
            'priority' => 10,
        )
    );
    
    $wp_customize->add_setting( 
        'header_layout_option', 
        array(
            'default'           => 'two',
            'sanitize_callback' => 'vilva_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Vilva_Radio_Image_Control(
            $wp_customize,
            'header_layout_option',
            array(
                'section'     => 'header_layout',
                'label'       => __( 'Header Layout', 'yummy-recipe' ),
                'description' => __( 'This is the layout for header.', 'yummy-recipe' ),
                'choices'     => array(                 
                    'one'   => get_stylesheet_directory_uri() . '/images/header/one.jpg',
                    'two'   => get_stylesheet_directory_uri() . '/images/header/two.jpg',
                )
            )
        )
    );

      /** Home Layout Settings */
    $wp_customize->add_section(
        'home_layout_settings',
        array(
            'title'    => __( 'Home Page Layout', 'yummy-recipe' ),
            'priority' => 20,
            'panel'    => 'layout_settings',
        )
    );
    
    $wp_customize->add_setting( 
        'homepage_layout', 
        array(
            'default'           => 'two',
            'sanitize_callback' => 'vilva_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Vilva_Radio_Image_Control(
            $wp_customize,
            'homepage_layout',
            array(
                'section'     => 'home_layout_settings',
                'label'       => __( 'Homepage Layout', 'yummy-recipe' ),
                'description' => __( 'Choose the layout of the homepage for your site.', 'yummy-recipe' ),
                'choices'     => array(
                    'one'   => get_stylesheet_directory_uri() . '/images/home/one.jpg',
                    'two'   => get_stylesheet_directory_uri() . '/images/home/two.jpg',
                )
            )
        )
    );

    /** Slider Layout Settings */
    $wp_customize->add_section(
        'slider_layout_settings',
        array(
            'title'    => __( 'Slider Layout', 'yummy-recipe' ),
            'priority' => 20,
            'panel'    => 'layout_settings',
        )
    );
    
    $wp_customize->add_setting( 
        'slider_layout', 
        array(
            'default'           => 'two',
            'sanitize_callback' => 'vilva_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Vilva_Radio_Image_Control(
            $wp_customize,
            'slider_layout',
            array(
                'section'     => 'slider_layout_settings',
                'label'       => __( 'Slider Layout', 'yummy-recipe' ),
                'description' => __( 'Choose the layout of the slider for your site.', 'yummy-recipe' ),
                'choices'     => array(
                    'one'   => get_stylesheet_directory_uri() . '/images/slider/one.jpg',
                    'two'   => get_stylesheet_directory_uri() . '/images/slider/two.jpg',
                )
            )
        )
    );

    /** General Sidebar Layout Settings */
    $wp_customize->add_section(
        'general_layout_settings',
        array(
            'title'    => __( 'General Sidebar Layout', 'yummy-recipe' ),
            'panel'    => 'layout_settings'
        )
    );
    
    /** Page Sidebar layout */
    $wp_customize->add_setting( 
        'page_sidebar_layout', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'vilva_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Vilva_Radio_Image_Control(
            $wp_customize,
            'page_sidebar_layout',
            array(
                'section'     => 'general_layout_settings',
                'label'       => __( 'Page Sidebar Layout', 'yummy-recipe' ),
                'description' => __( 'This is the general sidebar layout for pages. You can override the sidebar layout for individual page in respective page.', 'yummy-recipe' ),
                'choices'     => array(
                    'no-sidebar'    => esc_url( get_template_directory_uri() . '/images/1c.jpg' ),
                    'centered'      => esc_url( get_template_directory_uri() . '/images/1cc.jpg' ),
                    'left-sidebar'  => esc_url( get_template_directory_uri() . '/images/2cl.jpg' ),
                    'right-sidebar' => esc_url( get_template_directory_uri() . '/images/2cr.jpg' ),
                )
            )
        )
    );
    
    /** Post Sidebar layout */
    $wp_customize->add_setting( 
        'post_sidebar_layout', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'vilva_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Vilva_Radio_Image_Control(
            $wp_customize,
            'post_sidebar_layout',
            array(
                'section'     => 'general_layout_settings',
                'label'       => __( 'Post Sidebar Layout', 'yummy-recipe' ),
                'description' => __( 'This is the general sidebar layout for posts & custom post. You can override the sidebar layout for individual post in respective post.', 'yummy-recipe' ),
                'choices'     => array(
                    'no-sidebar'    => esc_url( get_template_directory_uri() . '/images/1c.jpg' ),
                    'centered'      => esc_url( get_template_directory_uri() . '/images/1cc.jpg' ),
                    'left-sidebar'  => esc_url( get_template_directory_uri() . '/images/2cl.jpg' ),
                    'right-sidebar' => esc_url( get_template_directory_uri() . '/images/2cr.jpg' ),
                )
            )
        )
    );
    
    /** Post Sidebar layout */
    $wp_customize->add_setting( 
        'layout_style', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'vilva_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Vilva_Radio_Image_Control(
            $wp_customize,
            'layout_style',
            array(
                'section'     => 'general_layout_settings',
                'label'       => __( 'Default Sidebar Layout', 'yummy-recipe' ),
                'description' => __( 'This is the general sidebar layout for whole site.', 'yummy-recipe' ),
                'choices'     => array(
                    'no-sidebar'    => esc_url( get_template_directory_uri() . '/images/1c.jpg' ),
                    'left-sidebar'  => esc_url( get_template_directory_uri() . '/images/2cl.jpg' ),
                    'right-sidebar' => esc_url( get_template_directory_uri() . '/images/2cr.jpg' ),
                )
            )
        )
    );
}
add_action( 'customize_register', 'yummy_recipe_customize_register', 99 );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function vilva_body_classes( $classes ) {

    $blog_layout = get_theme_mod( 'homepage_layout', 'two' );
    $editor_options = get_option( 'classic-editor-replace' );
    $allow_users_options = get_option( 'classic-editor-allow-users' );
    
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color';
    }   

    if ( ( is_archive() && !( vilva_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() ) ) && !( vilva_is_delicious_recipe_activated() && ( is_post_type_archive( 'recipe' ) || is_tax( 'recipe-course' ) || is_tax( 'recipe-cuisine' ) || is_tax( 'recipe-cooking-method' ) || is_tax( 'recipe-key' ) || is_tax( 'recipe-tag' ) ) ) ) || is_search() || is_home() ) {
        $classes[] = 'post-layout-' . $blog_layout ;
    }

    if ( !vilva_is_classic_editor_activated() || ( vilva_is_classic_editor_activated() && $editor_options == 'block' ) || ( vilva_is_classic_editor_activated() && $allow_users_options == 'allow' && has_blocks() ) ) {
        $classes[] = 'vilva-has-blocks';
    }

    if( is_singular( 'post' ) ){        
        $classes[] = 'single-style-four';
    }

    $classes[] = vilva_sidebar( true );
    
    return $classes;
}

/**
 * Header Start
*/
function vilva_header(){ 
    $ed_search = get_theme_mod( 'ed_header_search', true );
    $ed_cart   = get_theme_mod( 'ed_shopping_cart', true );
    $header_layout   = get_theme_mod( 'header_layout_option', 'two' );

    if( $header_layout == 'one' ) { ?>
        <header id="masthead" class="site-header style-one" itemscope itemtype="http://schema.org/WPHeader">
            <div class="header-t">
                <div class="container">
                    <?php vilva_secondary_navigation(); ?>
                    <div class="right">
                        <?php if( vilva_social_links( false ) ) : ?>
                            <div class="header-social">
                                <?php  vilva_social_links(); ?>
                            </div><!-- .header-social -->
                        <?php endif; ?>
                        <?php 
                        if ( $ed_search ) { ?>
                            <div class="header-search">                
                                <button class="search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                                    <i class="fas fa-search"></i>
                                </button>
                                <div class="header-search-wrap search-modal cover-modal" data-modal-target-string=".search-modal">
                                    <div class="header-search-inner-wrap">
                                        <?php get_search_form(); ?>
                                        <button class="close" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false"></button>
                                    </div>
                                </div>
                            </div><!-- .header-search -->
                        <?php }
                        if ( vilva_is_woocommerce_activated() && $ed_cart ) vilva_wc_cart_count(); ?>            
                    </div><!-- .right -->
                </div>
            </div><!-- .header-t -->

            <div class="header-mid">
                <div class="container">
                    <?php vilva_site_branding(); ?>
                </div>
            </div><!-- .header-mid -->

            <div class="header-bottom">
                <div class="container">
                    <?php vilva_primary_nagivation(); ?>
                </div>
            </div><!-- .header-bottom -->
        </header>
    <?php } else { ?>
        <header id="masthead" class="site-header style-two" itemscope itemtype="http://schema.org/WPHeader">
            <div class="header-mid">
                <div class="container">
                    <?php vilva_site_branding(); ?>
                </div>
            </div><!-- .header-mid -->
            <div class="header-bottom">
                <div class="container">
                    <?php vilva_primary_nagivation(); ?>
                    <div class="right">
                        <?php if( vilva_social_links( false ) ) : ?>
                            <div class="header-social">
                                <?php  vilva_social_links(); ?>
                            </div><!-- .header-social -->
                        <?php endif;
                        if ( $ed_search ) { ?>
                            <div class="header-search">                
                                <button class="search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                                    <i class="fas fa-search"></i>
                                </button>
                                <div class="header-search-wrap search-modal cover-modal" data-modal-target-string=".search-modal">
                                    <div class="header-search-inner-wrap">
                                        <?php get_search_form(); ?>
                                        <button class="close" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false"></button>
                                    </div>
                                </div>
                            </div><!-- .header-search -->
                        <?php }
                        if ( vilva_is_woocommerce_activated() && $ed_cart ) vilva_wc_cart_count(); ?>          
                    </div><!-- .right -->
                </div>
            </div><!-- .header-bottom -->
        </header>
    <?php }
}

/**
 * Banner Section 
*/
function vilva_banner(){
    if( is_front_page() || is_home() ) {
        $ed_banner      = get_theme_mod( 'ed_banner_section', 'slider_banner' );
        $slider_type    = get_theme_mod( 'slider_type', 'latest_posts' ); 
        $slider_cat     = get_theme_mod( 'slider_cat' );
        $posts_per_page = get_theme_mod( 'no_of_slides', 3 );
        $ed_caption     = get_theme_mod( 'slider_caption', true );
        $banner_title   = get_theme_mod( 'banner_title', __( 'Find Your Best Holiday', 'yummy-recipe' ) );
        $banner_subtitle = get_theme_mod( 'banner_subtitle' , __( 'Find great adventure holidays and activities around the planet.', 'yummy-recipe' ) ) ;
        $banner_button   = get_theme_mod( 'banner_button', __( 'Read More', 'yummy-recipe' ) );
        $banner_url      = get_theme_mod( 'banner_url', '#' );    
        $slider_layout   = get_theme_mod( 'slider_layout', 'two' );    
        
        if( $ed_banner == 'static_banner' && has_custom_header() ){ 

            if( $ed_banner == 'static_banner' ) {
                $banner_class = ' static-cta-banner';
            }

            ?>
            <div class="site-banner<?php if( has_header_video() ) echo esc_attr( ' video-banner' ); echo $banner_class; ?>">
                <?php 
                the_custom_header_markup();

                if( $ed_banner == 'static_banner' && ( $banner_title || $banner_subtitle || ( $banner_button && $banner_url ) )){ ?>
                    <div class="banner-caption">
                        <div class="container">
                            <?php 
                            if( $banner_title ) echo '<h2 class="banner-title">' . esc_html( $banner_title ) . '</h2>';
                            if( $banner_subtitle ) echo '<div class="banner-desc">' . wp_kses_post( $banner_subtitle ) . '</div>';
                            if( $banner_button && $banner_url ) echo '<a href="' . esc_url( $banner_url ) . '" class="btn btn-green"><span>' . esc_html( $banner_button ) . '</span></a>';
                            ?>
                        </div>
                    </div> <?php 
                } ?>
            </div>
            <?php
        }elseif( $ed_banner == 'slider_banner' ){

            if( $slider_type == 'latest_posts' || $slider_type == 'cat' || ( vilva_is_delicious_recipe_activated() && $slider_type == 'latest_dr_recipe' ) ){
            
                $args = array(
                    'post_status'         => 'publish',            
                    'ignore_sticky_posts' => true
                );
                
                if( vilva_is_delicious_recipe_activated() && $slider_type == 'latest_dr_recipe' ){
                    $args['post_type']      = DELICIOUS_RECIPE_POST_TYPE;
                    $args['posts_per_page'] = $posts_per_page;
                }elseif( $slider_type === 'cat' && $slider_cat ){
                    $args['post_type']      = 'post';
                    $args['cat']            = $slider_cat; 
                    $args['posts_per_page'] = -1;  
                }else{
                    $args['post_type']      = 'post';
                    $args['posts_per_page'] = $posts_per_page;
                }
                    
                $qry = new WP_Query( $args );

                $image_size = ( $slider_layout == 'two' ) ? 'yummy-recipe-slider' : 'vilva-slider-one';            
                if( $qry->have_posts() ){ ?>

                    <div id="banner_section" class="site-banner style-<?php echo esc_attr( $slider_layout ); ?>">
                        <?php if ( $slider_layout == 'two' ) echo '<div class="container">'; ?>
                        <div class="item-wrap owl-carousel">
                            <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                                <div class="item">
                                    <?php if ( $slider_layout == 'two' ) echo '<div class="banner-img-wrap">'; 
                                    if( has_post_thumbnail() ){
                                        the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
                                    }else{ 
                                        vilva_get_fallback_svg( $image_size );
                                    } 
                                    if ( $slider_layout == 'two' ) echo '</div>'; 
                                    if( $ed_caption || $slider_layout == 'two' ){ ?>
                                        <div class="banner-caption">
                                            <div class="container">
                                                <div class="cat-links">
                                                    <?php if( vilva_is_delicious_recipe_activated() && DELICIOUS_RECIPE_POST_TYPE == get_post_type() ) {
                                                        vilva_recipe_category(); 
                                                    }else{
                                                        vilva_category(); 
                                                    } ?>
                                                </div>
                                                <h2 class="banner-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h2>
                                                <?php 
                                                if ( $slider_layout == 'two' ) { 
                                                    echo '<div class="banner-desc">'; 
                                                        the_excerpt();
                                                    echo '</div>'; 
                                                } ?>                                            
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>                             
                        </div>
                        <?php if ( $slider_layout == 'two' ) echo '</div>'; ?>
                    </div>
                    <?php
                }
                wp_reset_postdata(); 
            }           
        } 
    }  
}

/**
 * Entry Header
*/
function vilva_entry_header(){ 
    global $wp_query;
    $home_layout         = get_theme_mod( 'homepage_layout', 'two' );

    if( ( $wp_query->current_post == 0 && $home_layout == 'one' ) || is_singular() ) return false;
    
    ?>
    <header class="entry-header">
        <?php                  
        if( 'post' === get_post_type() || 'blossom-portfolio' === get_post_type() ){

            echo '<div class="entry-meta">';
                vilva_posted_on(); 

                vilva_category();

            echo '</div>';
        }   

        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); 
        ?>
    </header> 
    <?php  
}

/**
* Entry Header
*/
function vilva_entry_header_first(){
    global $wp_query ;
    $home_layout         = get_theme_mod( 'homepage_layout', 'two' );

    if ( $wp_query->current_post == 0 && ! is_single() && ! is_page() && $home_layout == 'one' ) {
        ?>
        <header class="entry-header">
            <?php      
                if( 'post' === get_post_type() || 'blossom-portfolio' === get_post_type() ){
                    echo '<div class="entry-meta">';
                        vilva_posted_on(); 
                        vilva_category(); 
                    echo '</div>';
                }   

                if ( is_singular() ) :
                    the_title( '<h1 class="entry-title">', '</h1>' );
                else :
                    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                endif; ?>
        </header>    
        <?php
    }

    if ( is_single() ) { ?>
        <header class="entry-header">
            <div class="container">
                <div class="entry-meta">
                    <?php
                    vilva_posted_on();
                    vilva_category();
                    ?>
                </div>

                <h1 class="entry-title"><?php the_title(); ?></h1>     

            </div>
        </header> 
    <?php
    }elseif( is_page() ){
        ?>
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header> 
        <?php
    }

}

/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function vilva_post_thumbnail() {
    global $wp_query;
    $image_size     = 'thumbnail';
    $sidebar        = vilva_sidebar();
    $ed_crop_single = get_theme_mod( 'ed_crop_single', false ); 
    $home_layout = get_theme_mod( 'homepage_layout', 'two' ); 

    if( is_home() ){        
        echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
            if( $home_layout == 'one' ) {
                if( $wp_query->current_post == 0 ) :                
                    $image_size = ( $sidebar ) ? 'vilva-blog-one' : 'vilva-slider-one';
                else:
                    $image_size = ( $sidebar ) ? 'vilva-blog' : 'vilva-featured-four';
                endif;
            }else{
                $image_size = ( $sidebar ) ? 'yummy-recipe-blog-three' : 'yummy-recipe-blog-four';
            }

            if( has_post_thumbnail() ){                        
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
            }else{
                vilva_get_fallback_svg( $image_size );//fallback
            }         
        echo '</a></figure>';

    }elseif( is_archive() || is_search() ){
        echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
        if( $home_layout == 'one' ) {
            if( $wp_query->current_post == 0 ) :                
                $image_size = ( $sidebar ) ? 'vilva-blog-one' : 'vilva-slider-one';
            else:
                $image_size = ( $sidebar ) ? 'vilva-blog' : 'vilva-featured-four';
            endif;
        }else{
            $image_size = ( $sidebar ) ? 'yummy-recipe-blog-three' : 'yummy-recipe-blog-four';
        }

        if( has_post_thumbnail() ){
            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
        }else{
            vilva_get_fallback_svg( $image_size );//fallback
        }
        echo '</a></figure>';
    }elseif( is_page() ){
        
            $image_size = ( $sidebar ) ? 'vilva-sidebar' : 'vilva-slider-one';
            if( has_post_thumbnail() ){
                echo '<figure class="post-thumbnail">';
                    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                echo '</figure>';    
            }
        
    }elseif( is_single() ){
        if ( has_post_thumbnail() ) {
            echo '<figure class="post-thumbnail">';
                $image_size = ( $sidebar ) ? 'vilva-sidebar' : 'vilva-slider-one';
                if( ! $ed_crop_single ){
                    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
                }elseif( $ed_crop_single ){
                    the_post_thumbnail();    
                }
            echo '</figure>';
        }
    }
}

function vilva_entry_content(){ 
    $ed_excerpt  = get_theme_mod( 'ed_excerpt', true );
    $home_layout = get_theme_mod( 'homepage_layout', 'two' );  

    if( ( is_home() || is_archive() || is_search() ) && $home_layout == 'one' ) echo '<div class="content-wrap">';

        if ( is_single() ) vilva_author_desc(); 

        echo '<div class="entry-content" itemprop="text">';
            if( is_singular() || ! $ed_excerpt || ( get_post_format() != false ) ){
                the_content();    
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'yummy-recipe' ),
                    'after'  => '</div>',
                ) );
            }else{
                the_excerpt();
            }
        echo '</div>';            

    if ( ( is_home() || is_archive() || is_search() ) && $home_layout == 'one' ) echo '</div>';
        
}

function vilva_fonts_url(){
    $fonts_url = '';
    
    $primary_font       = get_theme_mod( 'primary_font', 'Bitter' );
    $ig_primary_font    = vilva_is_google_font( $primary_font );    
    $secondary_font     = get_theme_mod( 'secondary_font', 'Playfair Display' );
    $ig_secondary_font  = vilva_is_google_font( $secondary_font );    
    $site_title_font    = get_theme_mod( 'site_title_font', array( 'font-family'=>'EB Garamond', 'variant'=>'regular' ) );
    $ig_site_title_font = vilva_is_google_font( $site_title_font['font-family'] );
            
    /* Translators: If there are characters in your language that are not
    * supported by respective fonts, translate this to 'off'. Do not translate
    * into your own language.
    */
    $primary    = _x( 'on', 'Primary Font: on or off', 'yummy-recipe' );
    $secondary  = _x( 'on', 'Secondary Font: on or off', 'yummy-recipe' );
    $site_title = _x( 'on', 'Site Title Font: on or off', 'yummy-recipe' );
        
    if ( 'off' !== $primary || 'off' !== $secondary || 'off' !== $site_title ) {
        
        $font_families = array();
     
        if ( 'off' !== $primary && $ig_primary_font ) {
            $primary_variant = vilva_check_varient( $primary_font, 'regular', true );
            if( $primary_variant ){
                $primary_var = ':' . $primary_variant;
            }else{
                $primary_var = '';    
            }            
            $font_families[] = $primary_font . $primary_var;
        }
         
        if ( 'off' !== $secondary && $ig_secondary_font ) {
            $secondary_variant = vilva_check_varient( $secondary_font, 'regular', true );
            if( $secondary_variant ){
                $secondary_var = ':' . $secondary_variant;    
            }else{
                $secondary_var = '';
            }
            $font_families[] = $secondary_font . $secondary_var;
        }
        
        if ( 'off' !== $site_title && $ig_site_title_font ) {
            
            if( ! empty( $site_title_font['variant'] ) ){
                $site_title_var = ':' . vilva_check_varient( $site_title_font['font-family'], $site_title_font['variant'] );    
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

/*
Dynamic CSS
*/
function yummy_recipe_dynamic_css(){
    
    $primary_font    = get_theme_mod( 'primary_font', 'Bitter' );
    $primary_fonts   = vilva_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Playfair Display' );
    $secondary_fonts = vilva_get_fonts( $secondary_font, 'regular' );
    $font_size       = get_theme_mod( 'font_size', 17 );
    
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'EB Garamond', 'variant'=>'regular' ) );
    $site_title_fonts     = vilva_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    $site_title_font_size = get_theme_mod( 'site_title_font_size', 30 );
    $site_logo_size       = get_theme_mod( 'site_logo_size', 70 );
        
    $primary_color    = get_theme_mod( 'primary_color', '#80b784' );
    $site_title_color = get_theme_mod( 'site_title_color', '#121212' ); 
    
    $rgb = vilva_hex2rgb( vilva_sanitize_hex_color( $primary_color ) );    
     
    echo "<style type='text/css' media='all'>"; ?>
     
    .content-newsletter .blossomthemes-email-newsletter-wrapper.bg-img:after,
    .widget_blossomthemes_email_newsletter_widget .blossomthemes-email-newsletter-wrapper:after{
        <?php echo 'background: rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.8);'; ?>
    }
    
    /*Typography*/

    body,
    button,
    input,
    select,
    optgroup,
    textarea{
        font-family : <?php echo wp_kses_post( $primary_fonts['font'] ); ?>;
        font-size   : <?php echo absint( $font_size ); ?>px;        
    }

    :root {
        --primary-font: <?php echo wp_kses_post( $primary_fonts['font'] ); ?>;
        --secondary-font: <?php echo wp_kses_post( $secondary_fonts['font'] ); ?>;
        --primary-color: <?php echo vilva_sanitize_hex_color( $primary_color ); ?>;
        --primary-color-rgb: <?php printf('%1$s, %2$s, %3$s', $rgb[0], $rgb[1], $rgb[2] ); ?>;
    }
    
    .site-branding .site-title-wrap .site-title{
        font-size   : <?php echo absint( $site_title_font_size ); ?>px;
        font-family : <?php echo wp_kses_post( $site_title_fonts['font'] ); ?>;
        font-weight : <?php echo esc_html( $site_title_fonts['weight'] ); ?>;
        font-style  : <?php echo esc_html( $site_title_fonts['style'] ); ?>;
    }
    
    .site-branding .site-title-wrap .site-title a{
        color: <?php echo vilva_sanitize_hex_color( $site_title_color ); ?>;
    }
    
    .custom-logo-link img{
        width: <?php echo absint( $site_logo_size ); ?>px;
        max-width: 100%;
    }

    .comment-body .reply .comment-reply-link:hover:before {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" width="18" height="15" viewBox="0 0 18 15"><path d="M934,147.2a11.941,11.941,0,0,1,7.5,3.7,16.063,16.063,0,0,1,3.5,7.3c-2.4-3.4-6.1-5.1-11-5.1v4.1l-7-7,7-7Z" transform="translate(-927 -143.2)" fill="<?php echo vilva_hash_to_percent23( vilva_sanitize_hex_color( $primary_color ) ); ?>"/></svg>');
    }

    .site-header.style-five .header-mid .search-form .search-submit:hover {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo vilva_hash_to_percent23( vilva_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
    }

    .site-header.style-seven .header-bottom .search-form .search-submit:hover {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo vilva_hash_to_percent23( vilva_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
    }

    .site-header.style-fourteen .search-form .search-submit:hover {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo vilva_hash_to_percent23( vilva_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
    }

    .search-results .content-area > .page-header .search-submit:hover {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo vilva_hash_to_percent23( vilva_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
    }
           
    <?php echo "</style>";
}
add_action( 'wp_head', 'yummy_recipe_dynamic_css', 99 );

/**
 * Footer Bottom
*/
function vilva_footer_bottom(){ ?>
    <div class="footer-b">
        <div class="container">
            <div class="copyright">
                <?php
                    vilva_get_footer_copyright();
                    echo esc_html__( ' Yummy Recipe | Developed By ', 'yummy-recipe' ); 
                    echo '<a href="' . esc_url( 'https://blossomthemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Blossom Themes', 'yummy-recipe' ) . '</a>.';                
                    printf( esc_html__( ' Powered by %s. ', 'yummy-recipe' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'yummy-recipe' ) ) .'" target="_blank">WordPress</a>' );
                    if( function_exists( 'the_privacy_policy_link' ) ){
                        the_privacy_policy_link();
                    }
                ?> 
            </div>
            <div class="footer-social">
                <?php vilva_social_links(); ?>
            </div>
            
        </div>
    </div> <!-- .footer-b -->
    <?php
}

function yummy_recipe_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        array(
            'name'      => __( 'Delicious Recipes – WordPress Recipe Plugin', 'yummy-recipe' ),
            'slug'      => 'delicious-recipes',
            'required'  => false,
        ),
        array(
            'name'      => __( 'BlossomThemes Toolkit', 'yummy-recipe' ),
            'slug'      => 'blossomthemes-toolkit',
            'required'  => false,
        ),
        array(
            'name'      => __( 'BlossomThemes Email Newsletter', 'yummy-recipe' ),
            'slug'      => 'blossomthemes-email-newsletter',
            'required'  => false,
        ),
        array(
            'name'      => __( 'BlossomThemes Social Feed', 'yummy-recipe' ),
            'slug'      => 'blossomthemes-instagram-feed',
            'required'  => false,
        ),
        array(
            'name'      => __( 'Regenerate Thumbnails', 'yummy-recipe' ),
            'slug'      => 'regenerate-thumbnails',
            'required'  => false,
        ),
    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id'           => 'vilva',      // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );

    tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'yummy_recipe_register_required_plugins' );