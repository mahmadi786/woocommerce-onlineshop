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
class Diet_Shop_Site_Header{
	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function __construct() {
		
		add_action('diet_shop_header', array( $this, 'diet_shop_header_logo_n_nav' ) );
		add_action('diet_shop_header', array( $this, 'diet_shop_get_hero_section' ), 20 );
		
	}
	/**
	* Logo and Navigation
	*
	* @return void
	*/
	public function diet_shop_header_logo_n_nav (){
	?>
    <header class="theme-main-header" id="sticky-header">
        <div class="container">
            <div class="inner-wrapper">
                <div class="d-flex align-items-center">
                    <!-- LOGO -->
                    <div class="logo mr-auto">
                   		<?php echo wp_kses( $this->get_the_site_logo(), $this->alowed_tags() );?>
                    
                    </div>
                    <!-- Navigation Menu -->
                    <nav class="navbar navbar-expand-lg">
                        <div class="position-relative">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo esc_attr__( 'Toggle navigation', 'diet-shop' );?>">
                                <i class="fa fa-bars iconbar"></i>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
								<?php
                                wp_nav_menu( array(
                                    'theme_location'    => 'menu-1',
                                    'depth'             => 3,
                                    'menu_class'  		=> 'navbar-nav mr-auto diet-shop-main-menu',
                                    'container'			=>'ul',
                                   'fallback_cb'       => 'diet_shop_fallback_nav',
                                ) );
                                ?>
                            </div>
                        </div><!-- container -->
                    </nav><!-- navigation -->
                   
                </div> <!-- /.d-flex -->
            </div> <!-- /.inner-wrapper -->
        </div> <!-- /.container -->
    </header>
    
    <?php
	}
	
	/**
	* Get the Site logo
	*
	* @return HTML
	*/
	public function get_the_site_logo (){
		
		$html = '';
		
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			
			$html .= get_custom_logo();
			
		}else{
			$html .= '<h4><a href="'.esc_url( home_url( '/' ) ).'" rel="home" class="site-title">';
			$html .= get_bloginfo( 'name' );
			$html .= '</a></h4>';
		}
		$description = get_bloginfo( 'description', 'display' );
		
		if ( $description ) :
		    $html .=  '<div class="site-description">'.esc_html($description).'</div>';
		endif;
		
		return apply_filters( 'diet_shop_get_site_logo', $html );
		
	}
	
	/**
	* Get the Site logo
	*
	* @return void
	*/
	
	
	public function diet_shop_get_hero_section(){
		
		if( ( is_home() || is_front_page() ) && is_active_sidebar( 'home_page_slider' )  ){
			
			dynamic_sidebar( 'home_page_slider' );
			
		}else {
			
	 	$css = ( get_header_image() != "" ) ? 'background:url( '.esc_url( get_header_image() ).' ) no-repeat center center; background-size:cover; ' : '';
		
		echo '<div class="inner-banner" style="'.esc_attr( $css ).'">
				<div class="container">';
				
		echo wp_kses( $this->site_main_heading(), $this->alowed_tags() );	
		
		if( is_singular('post') ){	
			do_action('diet_shop_meta_info', array('date','category','comments','edit'));
		}
		
		echo '</div>
			</div>';	
			
		}
			
	}
	/**
	 * Add Banner Title.
	 *
	 * @since 1.0.0
	 */
	function site_main_heading() {
		 $html  ='';
		
			if ( is_home() ) {
				
					$html  .= '<h1 class="page-title-text">';
					$html  .=  get_bloginfo( 'name' );
					$html  .=  '</h1>';
					$html  .=  '<p class="subtitle">';
					$html  .=  esc_html(get_bloginfo( 'description', 'display' ));
					$html  .=  '</p>';
					
			}else if ( function_exists('is_shop') && is_shop() ){
				
				if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					
					$html  .=  '<h1 class="page-title-text">';
					$html  .=  esc_html( woocommerce_page_title(false) );
					$html  .=  '</h1>';
				}
			}else if( function_exists('is_product_category') && is_product_category() ){
				
				$html  .= '<h1 class="page-title-text">';
				$html  .= esc_html( woocommerce_page_title() );
				$html  .= '</h1>';
				
				$html  .= '<p class="page-title-text">';
				do_action( 'woocommerce_archive_description' );
				$html  .= '</p>';
				
			}elseif ( is_singular() ) {
				
				$html  .= '<h1 class="page-title-text">';
				$html  .= single_post_title( '', false );
				$html  .= '</h1>';
				
			} elseif ( is_archive() ) {
				
				$html  .= '<h1 class="page-title-text">';
				$html  .= get_the_archive_title( '', false );
				$html  .= '</h1>';
				
				$html  .= '<p class="subtitle">';
				$html  .= get_the_archive_description();
				$html  .= '</p>';
				
			} elseif ( is_search() ) {
				
				$html  .= '<h1 class="page-title-text">';
				$html  .= sprintf( /* translators:straing */ esc_html__( 'Search Results for: %s', 'diet-shop' ),  get_search_query() );
				$html  .= '</h1>';
				
			} elseif ( is_404() ) {
				
				$html  .= '<h1 class="page-title-text">';
				$html  .= esc_html__( 'Oops! That page can&rsquo;t be found.', 'diet-shop' );
				$html  .= '</h1>';
				
			}
		
		return apply_filters( 'diet_shop_hero_heading', $html );
	}
	
	
	private function alowed_tags(){
		
		if( function_exists('diet_shop_alowed_tags') ){ 
			return diet_shop_alowed_tags(); 
		}else{
			return array();	
		}
		
	}
}

new Diet_Shop_Site_Header();