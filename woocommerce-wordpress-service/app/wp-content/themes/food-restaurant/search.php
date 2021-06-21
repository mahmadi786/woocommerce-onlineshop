<?php
/**
 * Displaying Search Results pages.
 * @package Food Restaurant
 * @subpackage food-restaurant
 * @since 1.0
 */

get_header(); ?>

<main id="main" role="main">
    <div class="container">
        <?php
        $food_restaurant_layout = get_theme_mod( 'food_restaurant_theme_options','Right Sidebar');
        if($food_restaurant_layout == 'Left Sidebar'){?>
            <div class="col-lg-4 col-md-4"><?php get_sidebar(); ?></div>
            <section id="postmainbox" class="postmain flipInX">
                <div class="col-lg-8 col-md-8">                
                    <h1 class="entry-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Results for: %s','food-restaurant'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                    <?php if ( have_posts() ) :
                        /* Start the Loop */
                        while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/content' ,get_post_format() ); 
                        endwhile;
                        else :
                            get_template_part( 'no-results' ); 
                        endif; 
                    ?>
                    <div class="navigation">
                        <?php
                            // Previous/next page navigation.
                            the_posts_pagination( array(
                                'prev_text'          => __( 'Previous page', 'food-restaurant' ),
                                'next_text'          => __( 'Next page', 'food-restaurant' ),
                                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'food-restaurant' ) . ' </span>',
                            ) );
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </section>
            <div class="clearfix"></div>
        <?php }else if($food_restaurant_layout == 'Right Sidebar'){?>
            <div class="row">
                <div id="postmainbox" class="col-lg-8 col-md-8 postmain">
                   <h1 class="entry-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Results for: %s','food-restaurant'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                    <?php if ( have_posts() ) :
                        /* Start the Loop */
                        while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/content', get_post_format()); 
                        endwhile;
                        else :
                            get_template_part( 'no-results' );
                        endif; 
                    ?>
                    <div class="navigation">
                        <?php
                            // Previous/next page navigation.
                            the_posts_pagination( array(
                                'prev_text'          => __( 'Previous page', 'food-restaurant' ),
                                'next_text'          => __( 'Next page', 'food-restaurant' ),
                                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'food-restaurant' ) . ' </span>',
                            ) );
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4"><?php get_sidebar(); ?></div>
            </div>
        <?php }else if($food_restaurant_layout == 'One Column'){?>
            <div id="postmainbox" class="postmain">
                <h1 class="entry-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Results for: %s','food-restaurant'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                <?php if ( have_posts() ) :
                    /* Start the Loop */
                    while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/content',get_post_format() ); 
                    endwhile;
                    else :
                        get_template_part( 'no-results' ); 
                    endif; 
                ?>
                <div class="navigation">
                    <?php
                        // Previous/next page navigation.
                        the_posts_pagination( array(
                            'prev_text'          => __( 'Previous page', 'food-restaurant' ),
                            'next_text'          => __( 'Next page', 'food-restaurant' ),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'food-restaurant' ) . ' </span>',
                        ) );
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        <?php }else if($food_restaurant_layout == 'Three Columns'){?>
            <div class="row">
                <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-1'); ?></div>
                <div id="postmainbox" class="col-lg-6 col-md-6 postmain">
                    <h1 class="entry-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Results for: %s','food-restaurant'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                    <?php if ( have_posts() ) :
                        /* Start the Loop */
                        while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/content', get_post_format()); 
                        endwhile;
                        else :
                            get_template_part( 'no-results' );
                        endif; 
                    ?>
                    <div class="navigation">
                        <?php
                            // Previous/next page navigation.
                            the_posts_pagination( array(
                                'prev_text'          => __( 'Previous page', 'food-restaurant' ),
                                'next_text'          => __( 'Next page', 'food-restaurant' ),
                                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'food-restaurant' ) . ' </span>',
                            ) );
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-2'); ?></div>
            </div>
        <?php }else if($food_restaurant_layout == 'Four Columns'){?>
            <div class="row">
                <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-1'); ?></div>
                <div id="postmainbox" class="col-lg-6 col-md-6 postmain">
                    <h1 class="entry-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Results for: %s','food-restaurant'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                    <?php if ( have_posts() ) :
                        /* Start the Loop */
                        while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/content',get_post_format() ); 
                        endwhile;
                        else :
                            get_template_part( 'no-results' ); 
                        endif; 
                    ?>
                    <div class="navigation">
                        <?php
                            // Previous/next page navigation.
                            the_posts_pagination( array(
                                'prev_text'          => __( 'Previous page', 'food-restaurant' ),
                                'next_text'          => __( 'Next page', 'food-restaurant' ),
                                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'food-restaurant' ) . ' </span>',
                            ) );
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-2'); ?></div>
                <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-3'); ?></div>
            </div>
        <?php }else if($food_restaurant_layout == 'Gird Layout'){?>
            <div class="row">
                <div id="postmainbox" class="postmain">
                    <div class="row">
                        <?php if ( have_posts() ) :
                            /* Start the Loop */
                            while ( have_posts() ) : the_post();
                                get_template_part( 'template-parts/grid-layout' ); 
                            endwhile;
                            else :
                                get_template_part( 'no-results' );
                            endif; 
                        ?>
                        <div class="navigation">
                            <?php
                                // Previous/next page navigation.
                                the_posts_pagination( array(
                                    'prev_text'          => __( 'Previous page', 'food-restaurant' ),
                                    'next_text'          => __( 'Next page', 'food-restaurant' ),
                                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'food-restaurant' ) . ' </span>',
                                ) );
                            ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4"><?php get_sidebar(); ?></div>
            </div>
        <?php }else {?>
           <div class="row">
                <div id="postmainbox" class="col-lg-8 col-md-8 postmain">
                   <h1 class="entry-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Results for: %s','food-restaurant'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                    <?php if ( have_posts() ) :
                        /* Start the Loop */
                        while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/content', get_post_format()); 
                        endwhile;
                        else :
                            get_template_part( 'no-results' );
                        endif; 
                    ?>
                    <div class="navigation">
                        <?php
                            // Previous/next page navigation.
                            the_posts_pagination( array(
                                'prev_text'          => __( 'Previous page', 'food-restaurant' ),
                                'next_text'          => __( 'Next page', 'food-restaurant' ),
                                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'food-restaurant' ) . ' </span>',
                            ) );
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4"><?php get_sidebar(); ?></div>
            </div> 
        <?php } ?>
    </div>
</main>  
  
<?php get_footer(); ?>