<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Diet_Shop
 */

get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <div class="error-404">
        
            <h5><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'diet-shop' ); ?></h5>
            
            <?php get_search_form(); ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-submit normal-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i><?php esc_html_e( 'Back to home', 'diet-shop' ); ?></a>
        </div>
        
        
    </main><!-- #main -->
</div>
    
    
	<!-- #primary -->

<?php
get_footer();
