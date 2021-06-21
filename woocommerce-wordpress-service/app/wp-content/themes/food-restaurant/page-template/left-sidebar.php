<?php
/**
 * Template Name:Page with Left Sidebar
 */

get_header(); ?>

<main role="main" class="middle-align">
    <?php do_action( 'food_restaurant_pageleft_header' ); ?>
        <div class="container">
            <div class="row">
        		<div id="sidebar" class="col-lg-4 col-md-4">
        			<?php dynamic_sidebar('sidebar-2'); ?>
        		</div>
        		<div class="col-lg-8 col-md-8" id="content-lt" >
        			<?php 
                    while ( have_posts() ) : the_post(); ?>
                        <?php the_post_thumbnail(); ?>
                        <h1><?php the_title(); ?></h1>
                        <div class="entry-content"><?php the_content();?></div>
                    <?php endwhile; // end of the loop. ?>
                    <?php
                        //If comments are open or we have at least one comment, load up the comment template
                        if ( comments_open() || '0' != get_comments_number() )
                            comments_template();
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
   <?php do_action( 'food_restaurant_pageleft_footer' ); ?>
</main>
<?php get_footer(); ?>