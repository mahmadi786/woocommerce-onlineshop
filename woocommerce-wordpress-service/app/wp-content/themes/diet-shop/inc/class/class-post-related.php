<?php
/**
 * All POST Related Function 
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Diet_Shop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class Diet_Shop_Post_Related {
	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function __construct() {
		
		if( !is_admin()  )
		{
			add_action( 'diet_shop_site_content_type', array( $this,'site_loop_heading' ), 10 ); 
			add_action( 'diet_shop_site_content_type', array( $this,'site_content_type' ), 20 ); 
		}
		
		add_action( 'diet_shop_loop_navigation', array( $this,'site_loop_navigation' ) );
		add_action( 'diet_shop_single_post_navigation', array( $this,'single_post_navigation' ),10 ); 
		
		add_filter( 'the_content_more_link', array( $this,'content_read_more_link' ));
		add_filter( 'excerpt_more', array( $this,'excerpt_read_more_link' ) );
		
		add_filter( 'comment_form_fields', array( $this,'move_comment_field_to_bottom' ) );
	}
	
	/**
	 * Web Site heading
	 *
	 * @since 1.0.0
	 */
	public function site_loop_heading() {
		
		if( is_page() || is_singular() ){ return false; } 
		
		the_title( '<h3 class="blog-title entry-heading title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		
		
	}
	
	

    /**
     * @since  Blog Expert 1.0.0
     *
     * @param null
     */
    function site_content_type( ){
		
		$type = apply_filters( 'diet_shop_content_type', diet_shop_get_option('blog_loop_content_type') );
		
		echo '<div class="content-wrap">';
		
			if( ! is_single() && !is_page()):
			
				if ( $type == 'content' ) 
				{
					the_content();
					
				}else
				{
					echo wp_kses_post( get_the_excerpt() );
					
				}
				
			else:
			
				the_content();
				
			endif;
			
		echo '</div>';

    }
	
	
	
	/**
	* Adds custom Read More link the_content().
	* add_filter( 'the_content_more_link', array( $this,'content_read_more_link' ));
	* @param string $more "Read more" excerpt string.
	* @return string (Maybe) modified "read more" excerpt string.
	*/
	public function content_read_more_link( $more  ) {
		
		return sprintf( '<div class="more-link">
             <a href="%1$s" class="theme-btn theme-btn-line hvr-bounce-to-right">%2$s<i class="fa fa-fw fa-long-arrow-right"></i></a>
        </div>',
            get_permalink( get_the_ID() ),
            esc_html( diet_shop_get_option('read_more_text')  )
        );
		
	}
	
	/**
	* Filter the "read more" excerpt string link to the post.
	* //add_filter( 'excerpt_more', array( $this,'excerpt_read_more_link' ) );
	* @param string $more "Read more" excerpt string.
	* @return string (Maybe) modified "read more" excerpt string.
	*/
	public function excerpt_read_more_link( $more ) {
		if ( ! is_single() ) {
			$more = sprintf( '<div class="more-link">
				 <a href="%1$s" class="theme-btn theme-btn-line hvr-bounce-to-right">%2$s</a>
			</div>',
				get_permalink( get_the_ID() ),
				  esc_html( diet_shop_get_option('read_more_text')  )
			);
			
		}
		return $more;
	}

	
	/**
	 * Post Single Posts Navigation 
	 *
	 * @since 1.0.0
	 */
	function single_post_navigation( ) {
	?>
        <ul class="single-prev-next">
            <li><?php previous_post_link('%link', '<i class="fas fa-long-arrow-alt-left"></i> '.__('Prev Article','diet-shop')); ?></li>
            <li><?php next_post_link('%link', __('Next Article','diet-shop').' <i class="fas fa-long-arrow-alt-right"></i>'); ?></li>
        </ul>
    <?php
	} 
	
	
	/**
	 * Post Posts Loop Navigation
	 * add_action( 'diet_shop_loop_navigation', $array( $this,'site_loop_navigation' ) ); 
	 * @since 1.0.0
	 */
	function site_loop_navigation( $type = '' ) {
		
		if( $type == '' ){
			$type = get_theme_mod( 'loop_navigation_type', 'default' );
		}
		
		
		if( $type == 'default' ):
		
			the_posts_navigation(
				array(
					'prev_text' => '<i class="fa fa-arrow-left" aria-hidden="true"></i>'.esc_html__('Previous page', 'diet-shop'),
					'next_text' => esc_html__('Next page', 'diet-shop').'<i class="fa fa-arrow-right" aria-hidden="true"></i>',
					'screen_reader_text' => __('Posts navigation', 'diet-shop')
				)
		   );
		echo '<div class="clearfix"></div>';
		else:
		
			echo '<div class="pagination-custom">';
			the_posts_pagination( array(
				'format' => '/page/%#%',
				'type' => 'list',
				'mid_size' => 2,
				'prev_text' => esc_html__( 'Previous', 'diet-shop' ),
				'next_text' => esc_html__( 'Next', 'diet-shop' ),
				'screen_reader_text' => esc_html__( '&nbsp;', 'diet-shop' ),
			) );
		echo '</div>';
		endif;
		
		
	}
	
	
	/**
	 * Change Comment fields location
	 * @since 1.0.0
	 * @ add_filter( 'comment_form_fields', array( $this,'move_comment_field_to_bottom' ) );
	 */
	function move_comment_field_to_bottom( $fields ) {
		
		$comment_field = $fields['comment'];
		$cookies_field = $fields['cookies'];
		
		unset( $fields['comment'] );
		unset( $fields['cookies'] );
		
		$fields['comment'] = $comment_field;
		$fields['cookies'] = $cookies_field;
		
		return $fields;
	}

	
}

new Diet_Shop_Post_Related();