<?php
/**
 * Slider section
 *
 * This is the template for the content of slider section
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */
if ( ! function_exists( 'food_restro_add_slider_section' ) ) :
    /**
    * Add slider section
    *
    *@since Food Restro 1.0.0
    */
    function food_restro_add_slider_section() {
    	$options = food_restro_get_theme_options();
        // Check if slider is enabled on frontpage
        $slider_enable = apply_filters( 'food_restro_section_status', true, 'slider_section_enable' );

        if ( true !== $slider_enable ) {
            return false;
        }
        // Get slider section details
        $section_details = array();
        $section_details = apply_filters( 'food_restro_filter_slider_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render slider section now.
        food_restro_render_slider_section( $section_details );
    }
endif;

if ( ! function_exists( 'food_restro_get_slider_section_details' ) ) :
    /**
    * slider section details.
    *
    * @since Food Restro 1.0.0
    * @param array $input slider section details.
    */
    function food_restro_get_slider_section_details( $input ) {
        $options = food_restro_get_theme_options();
        $content = array();
        
        $page_ids = array();

        for ( $i = 1; $i <= 5; $i++ ) {
            if ( ! empty( $options['slider_content_page_' . $i] ) )
                $page_ids[] = $options['slider_content_page_' . $i];
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => 5,
            'orderby'           => 'post__in',
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = food_restro_trim_content( 5 );
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : '';

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
// slider section content details.
add_filter( 'food_restro_filter_slider_section_details', 'food_restro_get_slider_section_details' );


if ( ! function_exists( 'food_restro_render_slider_section' ) ) :
  /**
   * Start slider section
   *
   * @return string slider content
   * @since Food Restro 1.0.0
   *
   */
   function food_restro_render_slider_section( $content_details = array() ) {
        $options = food_restro_get_theme_options();
        $btn_label = ! empty( $options['slider_btn_label'] ) ? $options['slider_btn_label'] : esc_html__( 'Learn More', 'food-restro' );

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="featured-slider" data-effect="cubic-bezier(0.680, 0, 0.265, 1)" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": false, "arrows":true, "autoplay": true, "fade": true }'>
            <?php foreach ( $content_details as $content ) : ?>
                <article class="slick-item" data-title="<?php echo esc_attr( $content['title'] ); ?>" style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');">
                    <div class="overlay"></div>
                    <div class="wrapper">
                        <div class="featured-content-wrapper">
                            <header class="entry-header">
                                <h2 class="entry-title"><?php echo esc_html( $content['title'] ); ?></h2>
                            </header>

                            <div class="entry-content">
                                <p><?php echo esc_html( $content['excerpt'] ); ?></p>
                            </div><!-- .entry-content-->

                            <div class="read-more">
                                <a href="<?php echo esc_url( $content['url'] ); ?>" class="btn btn-fill">   <?php echo esc_html( $btn_label ); ?>
                                    <span class="more-icon">
                                        <?php echo food_restro_get_svg( array( 'icon' => 'more' ) ); ?>
                                        </svg>
                                    </span><!-- .more-icon -->
                                </a>
                            </div><!-- .read-more -->
                        </div><!-- .featured-content-wrapper -->
                    </div><!-- .wrapper -->
                </article>

            <?php endforeach; ?>
        </div><!-- .main-slider-wrapper -->
        
    <?php }
endif;