<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Diet_Shop
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array('single-blog-post') ); ?>>

 	 <?php
    /**
    * Hook - shopstore_posts_blog_media.
    *
    * @hooked shopstore_posts_formats_thumbnail - 10
    */
    do_action( 'diet_shop_posts_blog_media' );
    ?>
    <div class="post">
               
		<?php
        /**
        * Hook - inx_game_site_content_type.
        *
		* @hooked diet_shop_site_heading - 20
        * @hooked diet_shop_site_content_type - 20
        */
        do_action( 'diet_shop_site_content_type', array('date','category','comments','edit') );
        ?>
      
       
    </div>
    
</article><!-- #post-<?php the_ID(); ?> -->
