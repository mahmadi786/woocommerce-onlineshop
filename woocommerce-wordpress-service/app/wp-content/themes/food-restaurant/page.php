<?php
/**
 * Displaying all pages.
 *
 * @package Food Restaurant
 */

get_header(); ?>

<?php do_action( 'food_restaurant_page_header' ); ?>

<main id="main" role="main" class="main-content">
    <div class="content-lt container">
        <div class="middle-align">
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
            <div class="clear"></div>    
        </div>
    </div>
</main>

<?php do_action( 'food_restaurant_page_footer' ); ?>

<?php get_footer(); ?>