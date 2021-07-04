<?php
/**
 * The Site Theme Header Class 
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Diet_Shop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class Diet_Shop_Site_Container_layout{
	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function __construct() {
		
		add_action('diet_shop_container_before', array( $this, 'diet_shop_container_wrap_start' ), 5 );
		add_action('diet_shop_container_before', array( $this, 'diet_shop_content_column_start' ), 10 );
		
		add_action('diet_shop_container_after', array( $this, 'diet_shop_content_column_end' ), 5 );
		add_action('diet_shop_container_after', array( $this, 'diet_shop_get_sidebar' ), 10 );
		add_action('diet_shop_container_after', array( $this, 'diet_shop_container_wrap_end' ), 999 );
		
	
		
		
	}
	/**
	* Container before
	*
	* @return $html
	*/
	function diet_shop_container_wrap_start (){
	
    	$html  = '<div id="primary" class="content-area content-area-wrap">
    				<div class="container">
        				<div class="row">';
   		$html  = apply_filters( 'diet_shop_container_wrap_start', $html );	
		
		echo wp_kses( $html, $this->alowed_tags() );
	}
	
	/**
	* Container after
	*
	* return $html;
	*/
	function diet_shop_container_wrap_end (){
		
		$html = '</div>
			</div>
	   </div>';
	   
	   $html  = apply_filters( 'diet_shop_container_wrap_end', $html );	
		
		echo wp_kses( $html, $this->alowed_tags() );
	   
	}
	
	/**
	* Main Content Column before
	*
	* return $html
	*/
	function diet_shop_content_column_start (  $layout = NULL ){
		
		switch ( $layout ) {
			case 'sidebar-content':
				$layout = 'col-xl-9 col-lg-8 col-12 order-2 dp-main-content';
				break;
			case 'no-sidebar':
				$layout = 'col-md-12 bcf-main-content';
				break;
			default:
				$layout = 'col-xl-9 col-lg-8 col-12 order-1 dp--main-content';
		} 
	
		$html = '<div class="'. esc_attr( $layout ) .'"><main id="main" class="site-main our-blog blog-list">';
	   
	    $html  = apply_filters( 'diet_shop_content_column_start', $html );	
		
		echo wp_kses( $html, $this->alowed_tags() );
   	
	}
	
	/**
	* Main Content Column after
	*
	* return $html
	*/
	function diet_shop_content_column_end (){
	
		$html = '</main></div>';
	   
	   $html  = apply_filters( 'diet_shop_content_column_end', $html );	
		
		echo wp_kses( $html, $this->alowed_tags() );
   	
	}
	
	
	/**
	* Main Content Column after
	*
	* return $html
	*/
	function diet_shop_get_sidebar (  $layout = NULL ){
		switch ( $layout ) {
				case 'sidebar-content':
					$layout = 'col-xl-3 col-lg-4 col-12 order-1 dp-sidebar';
					break;
				case 'no-sidebar':
					return false;
					break;
				default:
					$layout = 'col-xl-3 col-lg-4 col-12 order-2 dp-sidebar';
			}  
		$sidebar  = apply_filters( 'diet_shop_get_sidebar', '' );	
		if( !empty( $sidebar ) ) { return $sidebar; }	
		?>
		<div class="<?php echo esc_attr( $layout );?>">
			<?php get_sidebar();?>
		</div>
		<?php
   	
	}
	
	
	private function alowed_tags(){
		
		if( function_exists('diet_shop_alowed_tags') ){ 
			return diet_shop_alowed_tags(); 
		}else{
			return array();	
		}
		
	}
}

new Diet_Shop_Site_Container_layout();