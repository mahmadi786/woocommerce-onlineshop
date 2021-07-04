<?php
/**
 * The Site Theme Footer Class 
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Diet_Shop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class Diet_Shop_Site_Footer{
	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function __construct() {
		
		add_action('diet_shop_load_footer', array( $this, 'site_footer_container_render' ), 10 );
		add_action('diet_shop_load_footer', array( $this, 'site_scroll_up' ), 20 );
	}
	
	/**
	* diet_shop foter conteinr before
	*
	* @return $html
	*/
	public function site_footer_container_before (){
		
		$html = '<footer class="theme-footer">';
						
		$html = apply_filters( 'diet_shop_footer_container_before',$html);		
				
		echo wp_kses( $html, $this->alowed_tags() );
		
						
	}
	/**
	* diet_shop render the site footer
	*
	* @return $html
	*/
	public function site_footer_container_render (){
		
		$this->site_footer_container_before();
		
		if ( is_active_sidebar( 'footer' ) ) 
		{
			echo '<div class="container"><div class="top-footer"><div class="row">';
			
				dynamic_sidebar( 'footer' ); 
			
			echo '</div></div></div>';			
		}
		
		$this->site_copywrite_text();
		
		$this->site_footer_container_after();
		
	}
	
	/**
	* diet_shop foter conteinr after
	*
	* @return $html
	*/
	public function site_footer_container_after (){
		
		$html = '</footer>';
						
		$html = apply_filters( 'diet_shop_footer_container_after',$html);		
				
		echo wp_kses( $html, $this->alowed_tags() );
	
	}
	
	/**
	* diet_shop foter conteinr after
	*
	* @return $html
	*/
	public function site_copywrite_text (){
		$text = '';
		$html = '<div class="bottom-footer">';
		if( get_theme_mod('copyright_text') != '' ) 
		{
			$text .= esc_html(  get_theme_mod('copyright_text') );
		}else
		{
			/* translators: 1: Current Year, 2: Blog Name  */
			$text = sprintf( esc_html__( 'Copyright &copy; %1$s %2$s All Right Reserved.', 'diet-shop' ), date_i18n( __( 'Y' , 'diet-shop' ) ), esc_html( get_bloginfo( 'name' ) ) );;
		}
		
		$html  .= apply_filters( 'diet_shop_footer_copywrite_text', $text ).'<br/>';	
		/* translators: 1: plugin name(s). */
		$html  .= sprintf( esc_html__( ' %1$s  By aThemeArt - Proudly powered by WordPress.', 'diet-shop' ), '<a href="'. esc_url( 'https://www.athemeart.com/downloads/dietshop-wordpress-gym-theme/' ) .'" target="_blank" rel="nofollow">'.esc_html_x( 'Diet Shop Theme ', 'credit text - theme', 'diet-shop' ).'</a>' );
		
	
		
		$html .= '</div>';
		
		
				
		echo wp_kses( $html, $this->alowed_tags() );
	
	}
	
	/**
	* diet_shop foter conteinr after
	*
	* @return $html
	*/
	public function site_scroll_up (){
		
		$html = '<button class="scroll-top">
				<i class="fas fa-long-arrow-alt-up"></i>
				</button>';
				
		$filters_html  = apply_filters( 'diet_shop_scroll_up', $html );
		
		echo wp_kses( $filters_html, $this->alowed_tags() );		
	}
	
	
	private function alowed_tags(){
		
		if( function_exists('diet_shop_alowed_tags') ){ 
			return diet_shop_alowed_tags(); 
		}else{
			return array();	
		}
		
	}
}

new Diet_Shop_Site_Footer();