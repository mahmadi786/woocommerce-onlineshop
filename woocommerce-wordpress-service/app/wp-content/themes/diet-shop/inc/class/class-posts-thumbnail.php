<?php
/**
 * Choose post type thumbnail 
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Diet_Shop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class Diet_Shop_Post_Thumbnail {
	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function __construct() {
		
		add_action( 'diet_shop_posts_blog_media', array( $this, 'render_thumbnail' ) ); 
	}
	
	/**
	 * Render post type thumbnail.
	 *
	 * @param $formats = string.
	 */
	public function render_thumbnail( $formats = '') {
		
		if( empty( $formats ) ) { $formats = get_post_format( get_the_ID() ); }
		
		if( diet_shop_get_option('index_hide_thumb') == true ){ return false; }
		
		switch ( $formats ) {
			default:
				$this->get_image_thumbnail();
			break;
			case 'gallery':
				$this->get_gallery_thumbnail();
			break;
			case 'audio':
				$this->get_audio_thumbnail();
			break;
			case 'video':
				$this->get_video_thumbnail();
			break;
		} 
	
	}
	
	/**
	 * Post formats audio.
	 *
	 * @since 1.0.0
	 */
	public function get_gallery_thumbnail(){
		$html = '<div class="img-box">';
		global $post;
		
		if( has_block('gallery', $post->post_content) ): 
		
			$post_blocks = parse_blocks( $post->post_content );
			
			if( !empty( $post_blocks ) ):
				$html .= '<i class="far fa-images"></i>';
				$html .= '<div class="gallery-media wp-block-gallery">';
				foreach ( $post_blocks as $row  ):
					if( $row['blockName']=='core/gallery' )
					$html .= $row['innerHTML'];
				endforeach;
				$html .= '</div>';
			endif;
		
		elseif ( get_post_gallery() ) :
		
			$html .= '<i class="far fa-images"></i>';
			$html .= '<figure class="gallery-media owlGallery">';
			
				$gallery = get_post_gallery( $post, false );
				$ids     = explode( ",", $gallery['ids'] );
				
				foreach( $ids as $id ) {
				
				   $link   = wp_get_attachment_url( $id );
				
				   $html  .= '<div class="item"><img src="' . esc_url( $link ) . '"  class="img-responsive" alt="' .esc_attr( get_the_title() ). '" title="' .esc_attr( get_the_title() ). '"  /></div>';
				
				} 
				
			$html .= '</figure>';
			
		else: 
			
			$html .= $this->get_image_thumbnail();
			
		endif;	
		
		$html .= '</div>';
		
		$html =  apply_filters( 'diet_shop_gallery_thumbnail', $html );
		
		echo wp_kses( $html, $this->alowed_tags() );
	}
	/**
	 * Post formats audio.
	 *
	 * @since 1.0.0
	 */
	public function get_audio_thumbnail(){
		
		$content 		= apply_filters( 'the_content', get_the_content() );
		$audio			= false;
		$html			= '<div class="img-box">';
		$post_thumbnail_url 	= '';
	
		// Only get audio from the content if a playlist isn't present.
		if ( false === strpos( $content, 'wp-playlist-script' ) ) {
			$audio 		= get_media_embedded_in_content( $content, array( 'audio' ) );
		}
		
		if ( has_post_thumbnail() ) :
		
			$post_thumbnail_id 		= get_post_thumbnail_id( get_the_ID() );
			$post_thumbnail_url 	= wp_get_attachment_url( $post_thumbnail_id );
		
		endif;
			
			
		// If not a single post, highlight the audio file.
		if ( ! empty( $audio ) )
		{	 $i = 0;
		
			foreach ( $audio as $audio_html ) : $i++;
			
				if( $post_thumbnail_url != "" )
				{
					$html .= '<i class="fas fa-volume-down"></i><figure style="background: url(\''.esc_url( $post_thumbnail_url ).'\') no-repeat center center; background-size:cover;" class="entry-audio embed-responsive embed-responsive-16by9"><div class="audio-center">';
					
					$html .= wp_kses( $audio_html, $this->alowed_tags() );
					
					$html .= '</div></figure>';
					
				}else{
					
					$html .= wp_kses( $audio_html, $this->alowed_tags() );
					
				}
			
				if( $i == 1 ){ break; }
					
			endforeach;
			
		}else 
		{
			$html .= $this->get_image_thumbnail();
		}
		
		$html .= '</div>';
		
		
		$html =  apply_filters( 'diet_shop_audio_thumbnail', $html );
		
		echo wp_kses( $html, $this->alowed_tags() );
	}
	
	
	/**
	 * Post formats video.
	 *
	 * @since 1.0.0
	 */
	public function get_video_thumbnail(){
		
		$content	 = apply_filters( 'the_content', get_the_content(get_the_ID()) );
		$video 	  	 = false;
		$html 		 = '<div class="img-box">';
		
		// Only get video from the content if a playlist isn't present.
		if ( false === strpos( $content, 'wp-playlist-script' ) ) {
			$video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );
		}
        
		if ( ! empty( $video ) ) 
		{	
			$i = 0;
			foreach ( $video as $video_html ) {  $i++;
			
				$html  .=  '<i class="fas fa-video"></i><div class="entry-video embed-responsive embed-responsive-16by9">';
				$html .= wp_kses( $video_html, $this->alowed_tags() );
				$html  .=  '</div>';
				
				if( $i == 1 ){ break; }
			}
		}else
		{ 
			$html .= $this->get_image_thumbnail();
		}
		
		$html .= '</div>';
		
		$html =  apply_filters( 'diet_shop_video_thumbnail', $html );
		
		echo wp_kses( $html, $this->alowed_tags() );
	}
	
	
	/**
	 * Post formats thumbnail.
	 *
	 * @since 1.0.0
	 */
	public function get_image_thumbnail(){
		
		$html = '';
		
		if ( has_post_thumbnail() ) :
		
			$html .= '<div class="img-box">';
		
			$post_thumbnail_id  = get_post_thumbnail_id( get_the_ID() );
			$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
			$formats 			= get_post_format( get_the_ID() );
			$type				=  get_theme_mod( 'blog_content_type', 'excerpt' ) ;
			
			$html .= '<i class="fas fa-image"></i>';
			
			if ( is_singular() )
			{
				$html  .=  '<a href="'.esc_url( $post_thumbnail_url ).'" class="image-popup">';
			} else
			{
				$html  .= '<a href="'.esc_url( get_permalink() ).'" class="image-link">';
			}
			
        	$html .= get_the_post_thumbnail( get_the_ID(), 'full' );
			$html .='</a>';
			$html .= '</div>';
			
        endif;
		
      
		$html =  apply_filters( 'diet_shop_image_thumbnail', $html );
		
		echo wp_kses( $html, $this->alowed_tags() );
	}
	
	
	private function alowed_tags(){
		
		if( function_exists('diet_shop_alowed_tags') ){ 
			return diet_shop_alowed_tags(); 
		}else{
			return array();	
		}
		
	}
	
}

new Diet_Shop_Post_Thumbnail();