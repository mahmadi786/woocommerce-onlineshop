<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

$options = food_restro_get_theme_options();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'large' ); ?>');">
            <a href="<?php the_permalink(); ?>"></a>
            <?php food_restro_posted_on(); ?> 
        </div><!-- .featured-image -->
    <?php endif; ?>

    <div class="entry-container">
        <?php echo food_restro_article_footer_meta(); ?>

        <header class="entry-header">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </header>

        <div class="entry-content">
            <?php the_excerpt(); ?>
        </div><!-- .entry-content -->
    </div><!-- .entry-container -->

</article><!-- #post-## -->
