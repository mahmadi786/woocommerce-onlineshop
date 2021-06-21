<?php
/**
 * Displaying home page.
 *
 * This template display post by default.
 *
 * @package Food Restaurant
 */
get_header(); ?>

<?php do_action( 'food_restaurant_index_header' ); ?>

<?php /** post section **/ ?>
<div class="container">
  <main id="main" role="main" class="content-with-sidebar">
    <?php
    $food_restaurant_layout = get_theme_mod( 'food_restaurant_theme_options','Right Sidebar');
    if($food_restaurant_layout == 'Left Sidebar'){?>
      <div class="row">
        <div class="col-lg-4 col-md-4"><?php get_sidebar(); ?></div>
        <div id="postmainbox" class="col-lg-8 col-md-8 postmain">
          <?php if ( have_posts() ) :
            /* Start the Loop */
            while ( have_posts() ) : the_post();
              get_template_part( 'template-parts/content' , get_post_format() ); 
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
        <div class="clearfix"></div>
      </div>
    <?php }else if($food_restaurant_layout == 'Right Sidebar'){?>
      <div class="row">
        <div id="postmainbox" class="col-lg-8 col-md-8 postmain">
          <?php if ( have_posts() ) :
            /* Start the Loop */
            while ( have_posts() ) : the_post();
              get_template_part( 'template-parts/content' , get_post_format() ); 
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
        <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-2'); ?></div>
        <div id="postmainbox" class="col-lg-6 col-md-6 postmain">
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
      </div>
    <?php }else if($food_restaurant_layout == 'Four Columns'){?>
      <div class="row">
        <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-2'); ?></div>
        <div id="postmainbox" class="col-lg-3 col-md-3 postmain">
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
        <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-3'); ?></div>
      </div>
    <?php }else if($food_restaurant_layout == 'Grid Layout'){?>
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
    <?php }else {?>
      <div class="row">
        <div id="postmainbox" class="col-lg-8 col-md-8 postmain">
          <?php if ( have_posts() ) :
            /* Start the Loop */
            while ( have_posts() ) : the_post();
              get_template_part( 'template-parts/content' , get_post_format() ); 
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
  </main> 
</div>

<?php do_action( 'food_restaurant_index_footer' ); ?>

<?php get_footer(); ?>