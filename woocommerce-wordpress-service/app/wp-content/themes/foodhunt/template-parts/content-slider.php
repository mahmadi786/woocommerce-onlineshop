<?php
/**
 * Contains all the fucntions and components related to slider part.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */
?>

<div id="home-slider">
	<ul class="bxslider">
	<?php
        $page_array = array();
        for( $i=1; $i<=4; $i++ ) {
            $page_id = get_theme_mod( 'foodhunt_slide'.$i, '' );
            if ( !empty ($page_id ) )
            	array_push( $page_array, $page_id );
        }

		$get_featured_posts = new WP_Query( array(
            'posts_per_page'        => -1,
            'post_type'             =>  array( 'page' ),
            'post__in'              => $page_array,
			'orderby'               => 'post__in'
		) );

		if ( !empty ( $page_array ) ) :
        while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
	        $foodhunt_slider_title       = get_the_title();
	        $foodhunt_slider_icon        = get_theme_mod( 'foodhunt_slider_icon', 'fa-cutlery' );
	        $foodhunt_slider_description = get_the_excerpt();
	        $title_attribute             = the_title_attribute( 'echo=0' );
	        $thumb_id                    = get_post_thumbnail_id( get_the_ID() );
	        $img_altr                    = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
	        $img_alt                     = ! empty( $img_altr ) ? $img_altr : $title_attribute;
            $foodhunt_slider_image = get_the_post_thumbnail($post->ID, '', array( 'title' => $title_attribute, 'alt' => $img_alt )); ?>

            <li class="slide">
				<div class="slider-overlay"> </div>

               <figure class="slider-img">
                  <?php echo $foodhunt_slider_image; ?>
               </figure>

                <div class="slider-content-wrapper">
					<h3 class="slider-title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php echo esc_html( $foodhunt_slider_title ) ?></a> </h3>
					<?php if( !empty( $foodhunt_slider_icon ) ) { ?>
						<div class="slider-icon"> <i class="fa <?php echo esc_attr( $foodhunt_slider_icon ); ?>"></i> </div>
					<?php } ?>
					<div class="slider-content"> <?php echo esc_html( $foodhunt_slider_description ); ?> </div>
					<a class="slider-btn" href="<?php the_permalink(); ?>"  title="<?php the_title_attribute();?>"> <?php esc_html_e( 'Read more', 'foodhunt'); ?> </a>
				</div>
			</li>
			<?php $i++;
		endwhile;
		// Reset Post Data
		wp_reset_query();
		endif; ?>
	</ul>
</div> <!-- home slider -->
