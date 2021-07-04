<?php
/**
 * Gallery section
 *
 * This is the template for the content of gallery section
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */
if ( ! function_exists( 'food_restro_add_gallery_section' ) ) :
    /**
    * Add gallery section
    *
    *@since Food Restro 1.0.0
    */
    function food_restro_add_gallery_section() {
    	$options = food_restro_get_theme_options();
        // Check if gallery is enabled on frontpage
        $gallery_enable = apply_filters( 'food_restro_section_status', true, 'gallery_section_enable' );

        if ( true !== $gallery_enable ) {
            return false;
        }
        // Get gallery section details
        $section_details = array();
        $section_details = apply_filters( 'food_restro_filter_gallery_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render gallery section now.
        food_restro_render_gallery_section( $section_details );
    }
endif;

if ( ! function_exists( 'food_restro_get_gallery_section_details' ) ) :
    /**
    * gallery section details.
    *
    * @since Food Restro 1.0.0
    * @param array $input gallery section details.
    */
    function food_restro_get_gallery_section_details( $input ) {
        $options = food_restro_get_theme_options();

        $content = array();
        $cat_id = ! empty( $options['gallery_content_category'] ) ? $options['gallery_content_category'] : '';
        $args = array(
            'post_type'         => 'post',
            'posts_per_page'    => 8,
            'cat'               => absint( $cat_id ),
            'ignore_sticky_posts'   => true,
            );                    


        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnail' ) : get_template_directory_uri() . '/assets/uploads/no-featured-image-590x650.jpg';
                $page_post['large_image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : '';

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
        endif;
        wp_reset_postdata();

            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// gallery section content details.
add_filter( 'food_restro_filter_gallery_section_details', 'food_restro_get_gallery_section_details' );


if ( ! function_exists( 'food_restro_render_gallery_section' ) ) :
  /**
   * Start gallery section
   *
   * @return string gallery content
   * @since Food Restro 1.0.0
   *
   */
   function food_restro_render_gallery_section( $content_details = array() ) {
        $options = food_restro_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="gallery" class="relative page-section">
            <div class="section-content gallery-popup col-4">
                <?php foreach ( $content_details as $content ) : ?>
                    <article>
                        <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');"></div>
                        <div class="overlay"></div>
                        <header class="entry-header">
                            <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                            <a href="<?php echo esc_url( $content['large_image'] ); ?>" class="popup"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/uploads/plus-circle.png' ); ?>"></a>
                        </header>
                    </article>
                <?php endforeach; ?>
            </div><!-- .section-content -->
        </div><!-- #gallery -->
        
    <?php }
endif;