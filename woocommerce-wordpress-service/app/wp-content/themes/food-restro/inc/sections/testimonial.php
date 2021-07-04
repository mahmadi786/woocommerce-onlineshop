<?php
/**
 * Testimonial section
 *
 * This is the template for the content of testimonial section
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */
if ( ! function_exists( 'food_restro_add_testimonial_section' ) ) :
    /**
    * Add testimonial section
    *
    *@since Food Restro 1.0.0
    */
    function food_restro_add_testimonial_section() {
    	$options = food_restro_get_theme_options();
        // Check if testimonial is enabled on frontpage
        $testimonial_enable = apply_filters( 'food_restro_section_status', true, 'testimonial_section_enable' );

        if ( true !== $testimonial_enable ) {
            return false;
        }
        // Get testimonial section details
        $section_details = array();
        $section_details = apply_filters( 'food_restro_filter_testimonial_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render testimonial section now.
        food_restro_render_testimonial_section( $section_details );
    }
endif;

if ( ! function_exists( 'food_restro_get_testimonial_section_details' ) ) :
    /**
    * testimonial section details.
    *
    * @since Food Restro 1.0.0
    * @param array $input testimonial section details.
    */
    function food_restro_get_testimonial_section_details( $input ) {
        $options = food_restro_get_theme_options();

        $content = array();
        $cat_id = ! empty( $options['testimonial_content_category'] ) ? $options['testimonial_content_category'] : '';
        $args = array(
            'post_type'         => 'post',
            'posts_per_page'    => 4,
            'cat'               => absint( $cat_id ),
            'ignore_sticky_posts'   => true,
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        $i = 0;
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = food_restro_trim_content( 40 );
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'thumbnail' ) : '';

                // Push to the main array.
                array_push( $content, $page_post );
                $i++;
            endwhile;
        endif;
        wp_reset_postdata();
            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// testimonial section content details.
add_filter( 'food_restro_filter_testimonial_section_details', 'food_restro_get_testimonial_section_details' );


if ( ! function_exists( 'food_restro_render_testimonial_section' ) ) :
  /**
   * Start testimonial section
   *
   * @return string testimonial content
   * @since Food Restro 1.0.0
   *
   */
   function food_restro_render_testimonial_section( $content_details = array() ) {
        $options = food_restro_get_theme_options();
        $class = ( empty( $options['testimonial_title'] ) && empty( $options['testimonial_subtitle'] ) ) ? 'title-disabled' : '';
        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="client-testimonial" class="relative page-section">
                <div class="wrapper">
                    <?php if ( ! empty( $options['testimonial_title'] ) ) : ?>
                        <div class="section-header">
                            <h2 class="section-title"><?php echo esc_html( $options['testimonial_title'] ); ?></h2>
                        </div><!-- .section-header -->
                    <?php endif; ?>

                    <div class="testimonial-content">
                        <?php foreach ( $content_details as $content ) : ?>
                            <div id="<?php echo absint( $content['id'] ); ?>" class="slick-content">
                                <div class="quote-image">
                                    <img src="<?php echo esc_url( get_template_directory_uri(). '/assets/uploads/quote.png' ); ?>">
                                </div><!-- .quote-image -->

                                <?php if ( ! empty( $content['excerpt'] ) ) : ?>
                                    <div class="entry-content">
                                        <p><?php echo wp_kses_post( $content['excerpt'] ); ?></p>
                                    </div><!-- .entry-content -->
                                <?php endif; ?>
                            </div><!-- .slick-content -->
                        <?php endforeach; ?>
                    </div><!-- .testimonial-content -->


                    <div class="testimonial-slider" data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "speed": 1500, "dots": false, "arrows":true, "autoplay": true, "draggable": true, "fade": false }'>
                        <?php foreach ( $content_details as $content ) : ?>
                            <article class="slick-item" data-current="<?php echo absint( $content['id'] ); ?>">
                                <div class="featured-image">
                                    <div class="overlay"></div>
                                    <?php if ( ! empty( $content['image'] ) ) : ?>
                                        <img src="<?php echo esc_url( $content['image'] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>">
                                    <?php endif; ?>
                                    <header class="entry-header">
                                        <?php if ( ! empty( $content['title'] ) ) : ?>
                                            <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                        <?php endif; ?>
                                    </header>
                                </div><!-- .featured-image -->
                            </article>
                        <?php endforeach; ?>
                    </div><!-- .testimonial-slider -->
                </div><!-- .wrapper -->
            </div><!-- #client-testimonial -->

    <?php }
endif;